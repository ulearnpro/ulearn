<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\CourseRating;
use App\Models\InstructionLevel;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;
use Crypt;
use App\Library\VideoHelpers;
use URL;
use App\Models\CourseVideos;
use App\Models\CourseFiles;
use Session;


class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Course();
    }

    public function myCourses(Request $request)
    {
        $user_id = \Auth::user()->id;
        $courses = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->join('course_taken', 'course_taken.course_id', '=', 'courses.id')
                    ->where('course_taken.user_id',$user_id)->get();
        
        return view('site.course.my-courses', compact('courses'));
    }

    public function courseRate(Request $request)
    {
        $rating_id = $request->input('rating_id');
        
        if($rating_id) {
            $rating = CourseRating::find($rating_id);
            $success_message = 'Your review have been updated successfully';
        } else {
            $rating = new CourseRating();
            $success_message = 'Your review have been added successfully';
        }
        
        $rating->user_id = \Auth::user()->id;
        $rating->course_id = $request->input('course_id');
        
        $rating_value = $request->input('rating');
        $rating_value = number_format($rating_value,1);
        $rating->rating = $rating_value;
        
        $rating->comments = $request->input('comments');
        // echo '<pre>';print_r($rating);exit;
        $rating->save();

        return $this->return_output('flash', 'success', $success_message, 'back', '200');
    }

    public function deleteRating($rating_id, Request $request)
    {
        CourseRating::where('id', $rating_id)->delete();
        return $this->return_output('flash', 'success', 'Your rating have been deleted successfully', 'back', '200');
    }

    public function courseView($course_slug = '', Request $request)
    {
        $course_breadcrumb = Session::get('course_breadcrumb');
        $course = Course::where('course_slug', $course_slug)->first();

        $curriculum = $this->model->getcurriculum($course->id, $course_slug);

        $curriculum_sections = $curriculum['sections'];
        $lectures_count = $curriculum['lectures_count'];
        $videos_count = $curriculum['videos_count'];
        $is_curriculum = $curriculum['is_curriculum'];
        $video = null;
        if($course->course_video)
        {
            $video = $this->model->getvideoinfoFirst($course->course_video); 
        }
        
        return view('site.course.view', compact('course', 'curriculum_sections', 'lectures_count', 'videos_count', 'video', 'course_breadcrumb', 'is_curriculum'));
    }

    public function courseLearn($course_slug = '', Request $request)
    {   
        $course_breadcrumb = Session::get('course_breadcrumb');
        $course = Course::where('course_slug', $course_slug)->first();

        $students_count = $this->model->students_count($course->id);
        $curriculum = $this->model->getcurriculum($course->id);
        $curriculum_sections = $curriculum['sections'];
        $lectures_count = $curriculum['lectures_count'];
        $videos_count = $curriculum['videos_count'];
        $is_curriculum = $curriculum['is_curriculum'];
        $video = null;
        if($course->course_video)
        {
            $video = $this->model->getvideoinfoFirst($course->course_video); 
        }
        $course_rating = CourseRating::where('course_id', $course->id)->where('user_id', \Auth::user()->id)->first();
        if(!$course_rating) {
            $course_rating = $this->getColumnTable('course_ratings');
        }
        return view('site.course.learn', compact('course', 'curriculum_sections', 'lectures_count', 'videos_count', 'video', 'course_breadcrumb', 'is_curriculum', 'course_rating', 'students_count'));
    }

    public function updateLectureStatus($course_id='', $lecture_id='', $status = '')
    {
        if($course_id && $lecture_id) {
            $this->model->updateLectureStatus($course_id,$lecture_id,$status);
        }
    }

    public function getDownloadResource($resource_id, $slug)
    {
        $file_details = \DB::table('course_files')->where('id',$resource_id)->first();
        $course = \DB::table('courses')->where('course_slug',$slug)->first();
        
        $file = public_path('storage/course/'.$course->id.'/'.$file_details->file_name.'.'.$file_details->file_extension);
        $headers = array(
              'Content-Type: application/pdf',
            );

        return \Response::download($file, $file_details->file_title, $headers);
    }

    public function readPDF($file_id)
    {
        $file_id = SiteHelpers::encrypt_decrypt($file_id, 'd');
        $file_details = $this->model->getFileDetails($file_id);
        if($file_details){
            $file = Storage::url('course/'.$file_details->course_id.'/'.$file_details->file_name.'.'.$file_details->file_extension);

            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename=document.pdf');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($file);
        }
    }

    public function courseEnrollAPI($course_slug = '', $lecture_slug = '', $is_sidebar = 'true', Request $request)
    {
        $course = Course::where('course_slug', $course_slug)->first();
        $lecture_id = SiteHelpers::encrypt_decrypt($lecture_slug,'d');


        if($is_sidebar == 'true')
        {
            $curriculum = $this->model->getcurriculumArray($course->id, $course_slug);    
        }
        $curriculum['lecture_details'] = $this->model->getlecturedetails($lecture_id);

        // course previous and next
        $lectures_all  =  $this->model->getalllecture($course->id);
        $next = $prev = false;
        if(count($lectures_all)>0){
            for($lec=0;$lec < count($lectures_all);$lec++){
              if($lectures_all[$lec]->lecture_quiz_id == $lecture_id){
                if($lec-1 >= 0)
                  $prev = $lectures_all[$lec-1]->lecture_quiz_id;
                else
                  $prev = false;

                if($lec+1 <count($lectures_all))
                  $next = $lectures_all[$lec+1]->lecture_quiz_id;
                else
                  $next = false;

                break;
              }
            }
        }
        if($this->model->getCoursecompletedStatus($lecture_id))
            $curriculum['lecture_details']->completion_status = true;
        else
            $curriculum['lecture_details']->completion_status = false;
        
        $curriculum['lecture_details']->media = SiteHelpers::encrypt_decrypt($curriculum['lecture_details']->media);
        $curriculum['lecture_details']->next = SiteHelpers::encrypt_decrypt($next);
        $curriculum['lecture_details']->prev = SiteHelpers::encrypt_decrypt($prev);
        
        //get resources
        $curriculum['lecture_details']->resources = $this->model->getResources($curriculum['lecture_details']->resources);

        // echo '<pre>';print_r($curriculum);exit;
        return response()->json($curriculum);
        
    }

    public function courseList($course_slug = '', Request $request)
    {
        $paginate_count = 9;
        $categories = Category::where('is_active', 1)->get();
        $instruction_levels = InstructionLevel::get();

        $category_search = $request->input('category_id');
        $instruction_level_id = $request->input('instruction_level_id');
        $prices = $request->input('price_id');
        $sort_price = $request->input('sort_price');
        $keyword = $request->input('keyword');
        
        $query = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
                    ->selectRaw('AVG(course_ratings.rating) AS average_rating')
                    ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->where('courses.is_active',1);
        //filter categories as per user selected                
        if($category_search) {
            $query->whereIn('courses.category_id', $category_search);
        }
        //filter courses as per keyword
        if($keyword) {
            $query->where('courses.course_title', 'LIKE', '%' . $keyword . '%');
        }

        //filter instruction levels as per user selected                
        if($instruction_level_id) {
            $query->whereIn('courses.instruction_level_id', $instruction_level_id);
        }
        
        //filter price as per user selected
        if($prices)
        {
            $price_count = count($prices);
            $is_greater_500 = false;
            // echo $price_count;exit;
            foreach ($prices as $p => $price) {
                $p++;
                $price_split = explode('-', $price);
                
                if($price_count == 1)
                {
                    $from = $price_split[0];
                    if($price == 500)
                    {
                        $is_greater_500 = true;
                    }
                    else
                    {
                        $to = $price_split[1];
                    }
                    
                }
                elseif($p==1)
                {
                    $from = $price_split[0];
                }
                elseif($p==$price_count)
                {
                    
                    if($price == 500)
                    {
                        $is_greater_500 = true;
                    }
                    else
                    {
                        $to = $price_split[1];
                    }
                    
                }
                
            }
            $query->where('courses.price', '>=', $from);
            if(!$is_greater_500)
            {
                $query->where('courses.price', '<=', $to);
            }
        }                
        

        //filter categories as per user selected                
        if($sort_price) {
            $query->orderBy('courses.price', $sort_price);
        }                

        $courses = $query->groupBy('courses.id')->paginate($paginate_count);

        return view('site.course.list', compact('courses', 'categories', 'instruction_levels'));
    }

    public function checkout($course_slug = '', Request $request)
    {
        $course_breadcrumb = Session::get('course_breadcrumb');
        $course = Course::where('course_slug', $course_slug)->first();
        
        return view('site.course.checkout', compact('course', 'course_breadcrumb'));
    }

    public function saveBreadcrumb(Request $request)
    {
        $link = $request->input('link');
        Session::put('course_breadcrumb', $link);
        Session::save();
    }

    public function deletePhoto(Request $request)
    {
        // get inputs from ajax call
        $content = $request->input('data_content');

        //unserialize and decrypt the values
        $input = json_decode(Crypt::decryptString($content));
        // echo '<pre>';print_r($input);exit;
        //clear the value in DB
        DB::table($input->model)
            ->where($input->pid, $input->id)
            ->update([$input->field => '']);

        //delete the image from storage folder
        Storage::delete($input->photo);
    }

    public function instructorCourseList(Request $request)
    {
        $paginate_count = 10;

        
        $instructor_id = \Auth::user()->instructor->id;
        if($request->has('search')){
            $search = $request->input('search');

            $courses = DB::table('courses')
                        ->select('courses.*', 'categories.name as category_name')
                        ->leftJoin('categories', 'categories.id', '=', 'courses.category_id')
                        ->where('courses.instructor_id', $instructor_id)
                        ->where('courses.course_title', 'LIKE', '%' . $search . '%')
                        ->orWhere('courses.course_slug', 'LIKE', '%' . $search . '%')
                        ->orWhere('categories.name', 'LIKE', '%' . $search . '%')
                        ->paginate($paginate_count);
        }
        else {
            $courses = DB::table('courses')
                        ->select('courses.*', 'categories.name as category_name')
                        ->leftJoin('categories', 'categories.id', '=', 'courses.category_id')
                        ->where('courses.instructor_id', $instructor_id)
                        ->paginate($paginate_count);
        }
        // echo '<pre>';print_r($courses);exit;
        return view('instructor.course.list', compact('courses'));
    }

    public function instructorCourseInfo($course_id = '',Request $request)
    {   
        $categories = Category::where('is_active', 1)->get();
        $instruction_levels = InstructionLevel::get();
        if($course_id) {
            $course = Course::find($course_id);
        }else{
            $course = $this->getColumnTable('courses');
        }
        return view('instructor.course.create_info', compact('course', 'categories', 'instruction_levels'));
    }

    public function instructorCourseImage($course_id = '',Request $request)
    {   
        $course = Course::find($course_id);
        return view('instructor.course.create_image', compact('course'));
    }

    public function instructorCourseVideo($course_id = '',Request $request)
    {   
        $course = Course::find($course_id);
        $video = null;
        if($course->course_video)
        {
            $video = $this->model->getvideoinfoFirst($course->course_video); 
        }
        return view('instructor.course.create_video', compact('course', 'video'));
    }

    public function instructorCourseCurriculum($course_id = '',Request $request)
    {   
        $course = Course::find($course_id);

        $user_id = \Auth::user()->instructor->id;
        $coursecurriculum = $this->model->getcurriculuminfo($course_id,$user_id);
        // echo "<pre>";
        // print_r($coursecurriculum);
        // exit;

        $this->data['course'] = $course;
        $this->data['sections'] = $coursecurriculum['sections'];
        $this->data['lecturesquiz'] = $coursecurriculum['lecturesquiz'];
        $this->data['lecturesquizquestions'] = $coursecurriculum['lecturesquizquestions'];
        $this->data['lecturesmedia'] = $coursecurriculum['lecturesmedia'];
        $this->data['lecturesresources'] = $coursecurriculum['lecturesresources'];
        $this->data['uservideos'] = $coursecurriculum['uservideos'];
        $this->data['useraudios'] = $coursecurriculum['useraudios'];
        $this->data['userpresentation'] = $coursecurriculum['userpresentation'];
        $this->data['userdocuments'] = $coursecurriculum['userdocuments'];
        $this->data['userresources'] = $coursecurriculum['userresources'];

        return view('instructor.course.create_curriculum', $this->data);
    }

    public function instructorCourseImageSave(Request $request)
    {
        /**
        * Image upload start
        */
        $course_id = $request->input('course_id');
        $input = $request->all();
        if (Input::hasFile('course_image') && Input::has('course_image_base64')) {
            //delete old file
            if (Storage::exists($input['old_course_image'])) {
                Storage::delete($input['old_course_image']);
            }

            if (Storage::exists($input['old_thumb_image'])) {
                Storage::delete($input['old_thumb_image']);
            }

            //get filename
            $file_name   = $request->file('course_image')->getClientOriginalName();

            // returns Intervention\Image\Image
            $image_make = Image::make($request->input('course_image_base64'))->encode('jpg');

            // create path
            $path = "course/".$course_id;
            
            //check if the file name is already exists
            $new_file_name = SiteHelpers::checkFileName($path, $file_name);

            //save the image using storage
            Storage::put($path."/".$new_file_name, $image_make->__toString(), 'public');

            //resize image for thumbnail
            $thumb_image = "thumb_".$new_file_name;
            $resize = Image::make($request->input('course_image_base64'))->resize(258, 172)->encode('jpg');
            Storage::put($path."/".$thumb_image, $resize->__toString(), 'public');
            
            $course = Course::find($course_id);
            $course->course_image = $path."/".$new_file_name;
            $course->thumb_image = $path."/".$thumb_image;

            $course->save();
        }

        return $this->return_output('flash', 'success', 'Course image updated successfully', 'instructor-course-image/'.$course_id, '200');
    }

    public function instructorCourseInfoSave(Request $request)
    {
        $course_id = $request->input('course_id');
        // echo '<pre>';print_r($_POST);exit;
        $validation_rules = [
            'course_title' => 'required|string|max:50',
            'category_id' => 'required',
            'instruction_level_id' => 'required',
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        if ($course_id) {
            $course = Course::find($course_id);
            $success_message = 'Course updated successfully';
        } else {
            $course = new Course();
            $success_message = 'Course added successfully';

            //create slug only while add
            $slug = $request->input('course_title');
            $slug = str_slug($slug, '-');

            $results = DB::select(DB::raw("SELECT count(*) as total from courses where course_slug REGEXP '^{$slug}(-[0-9]+)?$' "));

            $finalSlug = ($results['0']->total > 0) ? "{$slug}-{$results['0']->total}" : $slug;
            $course->course_slug = $finalSlug;
        }

        $course->course_title = $request->input('course_title');
        $course->instructor_id = \Auth::user()->instructor->id;
        $course->category_id = $request->input('category_id');
        $course->instruction_level_id = $request->input('instruction_level_id');
        $course->keywords = $request->input('keywords');
        $course->overview = $request->input('overview');

        $course->duration = $request->input('duration');
        $course->price = $request->input('price');
        $course->strike_out_price = $request->input('strike_out_price');
        
        $course->is_active = $request->input('is_active');
        $course->save();

        $course_id = $course->id;

        return $this->return_output('flash', 'success', $success_message, 'instructor-course-info/'.$course_id, '200');
    }

    public function instructorCourseVideoSave(Request $request)
    {
        $course_id = $request->input('course_id');
        
        $video = $request->file('course_video');
        
        $file_tmp_name = $video->getPathName();
        $file_name = explode('.',$video->getClientOriginalName());
        $file_name = $file_name[0].'_'.time().rand(4,9999);
        $file_type = $video->getClientMimeType();
        $extension = $video->getClientOriginalExtension();
        $file_title = $video->getClientOriginalName();
        $file_name = str_slug($file_name, "-");
        // ffmpeg.exe file path
        $file_name = str_slug($file_name, "-");
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { $ffmpeg_path = base_path().'\resources\assets\ffmpeg\ffmpeg_win\ffmpeg';} else { $ffmpeg_path = base_path().'/resources/assets/ffmpeg/ffmpeg_lin/ffmpeg.exe';}

        $ffmpeg = new VideoHelpers($ffmpeg_path , $file_tmp_name, $file_name);
        
        //$ffmpeg->convertVideos($file_type);
        $duration = $ffmpeg->getDuration();
        $duration = explode('.',$duration);
        $duration = $duration[0];
        $created_at=time();
        $path = 'course/'.$course_id;
        $video_name = 'raw_'.$created_at.'_'.$file_name.'.'.$extension;
        
        $video_path = $path.'/'.$video_name;

        $video_image_name = 'raw_'.$created_at.'_'.$file_name.'.jpg';
        $video_image_path = storage_path('app/public/'.$path.'/'.$video_image_name);
        $ffmpeg->convertImages($video_image_path);

        $request->file('course_video')->storeAs($path, $video_name);
   
        $courseVideos = new CourseVideos;
        $courseVideos->video_title = 'raw_'.$created_at.'_'.$file_name;
        $courseVideos->video_name = $file_title;
        $courseVideos->video_type = $extension;
        $courseVideos->duration = $duration;
        $courseVideos->image_name = $video_image_name;
        $courseVideos->video_tag = 'curriculum';
        $courseVideos->uploader_id = \Auth::user()->instructor->id;
        $courseVideos->course_id = $course_id;
        $courseVideos->processed = '1';
        $courseVideos->created_at = $created_at;
        $courseVideos->updated_at = $created_at;
        if($courseVideos->save()){
            $course = Course::find($course_id);

            //delete old video
            $old_video = $this->model->getvideoinfoFirst($course->course_video);

            if($old_video)
            {
                $old_file_name = 'course/'.$old_video->course_id.'/'.$old_video->video_title.'.'.$old_video->video_type;
                $old_file_image_name = 'course/'.$old_video->course_id.'/'.$old_video->video_title.'.jpg';
                if (Storage::exists($old_file_name)) {
                    Storage::delete($old_file_name);
                }

                if (Storage::exists($old_file_image_name)) {
                    Storage::delete($old_file_image_name);
                }
            }

            $course->course_video = $courseVideos->id;
            $course->save();

            $return_data = array(
                'status'    => true,
                'duration'  => $duration,
                'file_title'=> $file_title,
                'file_link'=> Storage::url($video_path),
            );
        }else{
            $return_data = array(
                'status'=>false,
            );
        }
        echo json_encode($return_data);
        exit;
    }

    /* Curriculum start */
    public function postSectionSave(Request $request)
    {   
        $data['course_id'] = $request->input('courseid');
        $data['title'] = $request->input('section');
        $data['sort_order'] = $request->input('position');
        $now_date = date("Y-m-d H:i:s");
        $data['createdOn'] = $now_date;
        $data['updatedOn'] = $now_date;
        
        if($request->input('sid') == 0){
            $newID = $this->model->insertSectionRow($data , '');
        } else {
            $newID = $this->model->insertSectionRow($data , $request->input('sid'));
        }
        echo $newID;
    }
    
    public function postLectureSave(Request $request)
    {   
        $data['section_id'] = $request->input('sectionid');
        $data['title'] = $request->input('lecture');
        $data['sort_order'] = $request->input('position');
        $data['type'] = '0';
        $now_date = date("Y-m-d H:i:s");
        $data['createdOn'] = $now_date;
        $data['updatedOn'] = $now_date;
        
        if($request->input('lid') == 0){
            $newID = $this->model->insertLectureQuizRow($data , '');
        } else {
            $newID = $this->model->insertLectureQuizRow($data , $request->input('lid'));
        }
        echo $newID;
    }
    
        
    public function postCurriculumSort(Request $request)
    {   
        if($request->input('type') == 'section') {
            $sections = $request->input('sectiondata');
            if(!empty($sections)){
                foreach($sections as $section){
                    $data['sort_order'] = $section['position'];
                    $newID = $this->model->insertSectionRow($data , $section['id']);
                }
            }
        } else if($request->input('type') == 'lecturequiz') {
            $lecturequiz = $request->input('lecturequizdata');
            if(!empty($lecturequiz)){
                foreach($lecturequiz as $lq){
                    $data['section_id'] = $lq['sectionid'];
                    $data['sort_order'] = $lq['position'];
                    $newID = $this->model->insertLectureQuizRow($data , $lq['id']);
                }
            }
        }
    }
        
    
    
    public function postSectionDelete(Request $request){
        $this->model->postSectionDelete($request->input('sid'));
        echo '1';
    }
    
    public function postLectureQuizDelete(Request $request){
        $this->model->postLectureQuizDelete($request->input('lid'));
        echo '1';
    }
    
    public function postLectureResourceDelete(Request $request){
        $this->model->postLectureResourceDelete($request->input('lid'),$request->input('rid'));
        echo '1';
    }
    
    public function postLectureDescSave(Request $request)
    {   
        $data['description'] = $request->input('lecturedescription');
        $now_date = date("Y-m-d H:i:s");
        $data['updatedOn'] = $now_date;
        
        if($request->input('lid') == 0){
            $newID = $this->model->insertLectureQuizRow($data , '');
        } else {
            $newID = $this->model->insertLectureQuizRow($data , $request->input('lid'));
        }
        echo $newID;
    }
    
    public function postLectureVideoSave($lid,Request $request)
    {
        $course_id = $request->input('course_id');
        $video = $request->file('lecturevideo');
        $file = array('video' => $video);
        $rules = array('video' => 'required|mimes:mp4,mov,avi,flv');
        $validator = Validator::make($file, $rules);

            $file_tmp_name = $video->getPathName();
            $file_name = explode('.',$video->getClientOriginalName());
            $file_name = $file_name[0].'_'.time().rand(4,9999);
            $file_type = $video->getClientMimeType();
            $extension = $video->getClientOriginalExtension();
            $file_title = $video->getClientOriginalName();
            $file_name = str_slug($file_name, "-");
            // ffmpeg.exe file path
            $file_name = str_slug($file_name, "-");
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {               $ffmpeg_path = base_path().'\resources\assets\ffmpeg\ffmpeg_win\ffmpeg';            } else {                $ffmpeg_path = base_path().'/resources/assets/ffmpeg/ffmpeg_lin/ffmpeg.exe';            }

            $ffmpeg = new VideoHelpers($ffmpeg_path , $file_tmp_name, $file_name);
            $ffmpeg->convertImages();
            //$ffmpeg->convertVideos($file_type);
            $duration = $ffmpeg->getDuration();
            $duration = explode('.',$duration);
            $duration = $duration[0];
            $created_at=time();
            $path = 'course/'.$course_id;
            $video_name = 'raw_'.$created_at.'_'.$file_name.'.'.$extension;
            $video_path = $path.'/'.$video_name;

            $request->file('lecturevideo')->storeAs($path, $video_name);
       
            $courseVideos = new CourseVideos;
            $courseVideos->video_title = 'raw_'.$created_at.'_'.$file_name;
            $courseVideos->video_name = $file_title;
            $courseVideos->video_type = $extension;
            $courseVideos->duration = $duration;
            $courseVideos->image_name = $file_name.'.jpg';
            $courseVideos->video_tag = 'curriculum';
            $courseVideos->uploader_id = \Auth::user()->instructor->id;
            $courseVideos->course_id = $course_id;
            $courseVideos->processed = '1';
            $courseVideos->created_at = $created_at;
            $courseVideos->updated_at = $created_at;
            if($courseVideos->save()){
                if(!empty($lid)){
                    $this->model->checkDeletePreviousFiles($lid);
                    $data['media'] = $courseVideos->id;
                    $data['media_type'] = '0';
                    $data['publish'] = '0';
                    $newID = $this->model->insertLectureQuizRow($data , $lid);
                }
                $return_data = array(
                    'status'    => true,
                    'duration'  => $duration,
                    'file_title'=> $file_title,
                    'file_link'=> Storage::url($video_path),
                );
            }else{
                $return_data = array(
                    'status'=>false,
                );
            }
        echo json_encode($return_data);
        exit;
    }
            
    public function postLectureAudioSave($lid,Request $request)
    {
        $course_id = $request->input('course_id');
        $audio = $request->file('lectureaudio');
        $file = array('audio' => $audio);
        $rules = array('audio' => 'required|mimes:mp3,wav');
        $validator = Validator::make($file, $rules);
        $file_tmp_name = $audio->getPathName();
        $file_name = explode('.',$audio->getClientOriginalName());
        $file_name = $file_name[0].'_'.time().rand(4,9999);
        $file_type = $audio->getClientOriginalExtension();
            $file_title = $audio->getClientOriginalName();
            $file_size = $audio->getSize();
        $file_title = str_slug($file_title, "-");
        $file_name = str_slug($file_name, "-");
           if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
            {               
              $ffmpeg_path = base_path().'\resources\assets\ffmpeg\ffmpeg_win\ffmpeg';          } else {                $ffmpeg_path = base_path().'/resources/assets/ffmpeg/ffmpeg_lin/ffmpeg.exe';        
            }
            
            $ffmpeg = new VideoHelpers($ffmpeg_path , $file_tmp_name, $file_name);
            $duration = $ffmpeg->getDuration();
            $duration = explode('.',$duration);
            $duration = $duration[0];
            
            $request->file('lectureaudio')->storeAs('course/'.$course_id, $file_name.'.'.$file_type);
       
            $courseFiles = new CourseFiles;
            $courseFiles->file_title = $file_title;
            $courseFiles->file_name = $file_name;
            $courseFiles->file_type = $file_type;
            $courseFiles->file_extension = $file_type;
            $courseFiles->file_size = $file_size;
            $courseFiles->duration = $duration;
            if($file_type!='mp3'){
              $courseFiles->processed = 0;
            }
            $courseFiles->file_tag = 'curriculum';
            $courseFiles->uploader_id = \Auth::user()->instructor->id;
            $courseFiles->created_at = time();
            $courseFiles->updated_at = time();
            if($courseFiles->save()){
                if(!empty($lid)){
                    $data['media'] = $courseFiles->id;
                    $data['media_type'] = '1';
                    $data['publish'] = '0';
                    $newID = $this->model->insertLectureQuizRow($data , $lid);
                }
                $return_data = array(
                    'status'=>true,
                    'duration'  => $duration,
                    'file_title'=> $file_title,
                    'file_type' => $file_type,
                    'file_link'=> Storage::url('course/'.$course_id.'/'.$file_name.'.'.$file_type),
                );
            }else{
                $return_data = array(
                    'status'=>false,
                );
            }
        echo json_encode($return_data);
        exit;
    }
        
    public function postLecturePresentationSave($lid,Request $request)
    {
        $course_id = $request->input('course_id');
        $document = $request->file('lecturepre');
        $file = array('document' => $document);
        $rules = array('document' => 'required|mimes:pdf');
        $validator = Validator::make($file, $rules);

        if( $validator->fails() )
        {
            $return_data[] = array(
                'status'=>false,
            );
        } else {
            $pdftext = file_get_contents($document);
            $pdfPages = preg_match_all("/\/Page\W/", $pdftext, $dummy);
            $file_tmp_name = $document->getPathName();
            $file_name = explode('.',$document->getClientOriginalName());
            $file_name = $file_name[0].'_'.time().rand(4,9999);
            $file_type = $document->getClientOriginalExtension();
            $file_title = $document->getClientOriginalName();
            $file_size = $document->getSize();
            
            $request->file('lecturepre')->storeAs('course/'.$course_id, $file_name.'.'.$file_type);
       
            $courseFiles = new CourseFiles;
            $courseFiles->file_name = $file_name;
            $courseFiles->file_title = $file_title;
            $courseFiles->file_type = $file_type;
            $courseFiles->file_extension = $file_type;
            $courseFiles->file_size = $file_size;
            $courseFiles->duration = $pdfPages;
            $courseFiles->file_tag = 'curriculum_presentation';
            $courseFiles->uploader_id = \Auth::user()->instructor->id;
            $courseFiles->created_at = time();
            $courseFiles->updated_at = time();
            if($courseFiles->save()){
                if(!empty($lid)){
                    $data['media'] = $courseFiles->id;
                    $data['media_type'] = '5';
                    $data['publish'] = '0';
                    $newID = $this->model->insertLectureQuizRow($data , $lid);
                }
                if($pdfPages == 1){ 
                    $pdfPage = $pdfPages.' Page'; 
                } else { 
                    $pdfPage = $pdfPages.' Pages';
                }
                $return_data = array(
                    'status'=>true,
                    'file_title'=> $file_title,
                    'duration'=> $pdfPage
                );
            }else{
                $return_data = array(
                    'status'=>false,
                );
            }
        }
        echo json_encode($return_data);
        exit;
    }
        
    public function postLectureDocumentSave($lid,Request $request)
    {
        $course_id = $request->input('course_id');
        $document = $request->file('lecturedoc');
        $file = array('document' => $document);
        $rules = array('document' => 'required|mimes:pdf');
        $validator = Validator::make($file, $rules);

        if( $validator->fails() )
        {
            $return_data[] = array(
                'status'=>false,
            );
        } else {
            $pdftext = file_get_contents($document);
            $pdfPages = preg_match_all("/\/Page\W/", $pdftext, $dummy);
            $file_tmp_name = $document->getPathName();
            $file_name = explode('.',$document->getClientOriginalName());
            $file_name = $file_name[0].'_'.time().rand(4,9999);
            $file_type = $document->getClientOriginalExtension();
            $file_title = $document->getClientOriginalName();
            $file_size = $document->getSize();
            
            $request->file('lecturedoc')->storeAs('course/'.$course_id, $file_name.'.'.$file_type);
       
            $courseFiles = new CourseFiles;
            $courseFiles->file_name = $file_name;
            $courseFiles->file_title = $file_title;
            $courseFiles->file_type = $file_type;
            $courseFiles->file_extension = $file_type;
            $courseFiles->file_size = $file_size;
            $courseFiles->duration = $pdfPages;
            $courseFiles->file_tag = 'curriculum';
            $courseFiles->uploader_id = \Auth::user()->instructor->id;
            $courseFiles->created_at = time();
            $courseFiles->updated_at = time();
            if($courseFiles->save()){
                if(!empty($lid)){
                    $data['media'] = $courseFiles->id;
                    $data['media_type'] = '2';
                    $data['publish'] = '0';
                    $newID = $this->model->insertLectureQuizRow($data , $lid);
                }
                if($pdfPages == 1){ 
                    $pdfPage = $pdfPages.' Page'; 
                } else { 
                    $pdfPage = $pdfPages.' Pages';
                }
                $return_data = array(
                    'status'=>true,
                    'file_title'=> $file_title,
                    'duration'=> $pdfPage
                );
            }else{
                $return_data = array(
                    'status'=>false,
                );
            }
        }
        echo json_encode($return_data);
        exit;
    }
        
    public function postLectureResourceSave($lid,Request $request)
    {
            $course_id = $request->input('course_id');
            $document = $request->file('lectureres');
        
            $file_tmp_name = $document->getPathName();
            $file_name = explode('.',$document->getClientOriginalName());
            $file_name = $file_name[0].'_'.time().rand(4,9999);
            $file_type = $document->getClientOriginalExtension();
            $file_title = $document->getClientOriginalName();
            $file_size = $document->getSize();
            
            if($file_type == 'pdf'){
                $pdftext = file_get_contents($document);
                $pdfPages = preg_match_all("/\/Page\W/", $pdftext, $dummy);
            } else {
                $pdfPages = '';
            }
            
            $request->file('lectureres')->storeAs('course/'.$course_id, $file_name.'.'.$file_type);
       
            $courseFiles = new CourseFiles;
            $courseFiles->file_name = $file_name;
            $courseFiles->file_title = $file_title;
            $courseFiles->file_type = $file_type;
            $courseFiles->file_extension = $file_type;
            $courseFiles->file_size = $file_size;
            $courseFiles->duration = $pdfPages;
            $courseFiles->file_tag = 'curriculum_resource';
            $courseFiles->uploader_id = \Auth::user()->instructor->id;
            $courseFiles->created_at = time();
            $courseFiles->updated_at = time();
            if($courseFiles->save()){
                if(!empty($lid)){
                    $data['resources'] = $courseFiles->id;
                    $newID = $this->model->insertLectureQuizResourceRow($data , $lid);
                }
                $return_data = array(
                    'status'=>true,
                    'file_id'=> $courseFiles->id,
                    'file_title'=> $file_title,
                    'file_size'=> \ulearnHelpers::HumanFileSize($file_size)
                );
            }else{
                $return_data = array(
                    'status'=>false,
                );
            }
        
        echo json_encode($return_data);
        exit;
    }

    public function postLectureTextSave(Request $request)
    {
        $document = $request->input('lecturedescription');
        $lid = $request->input('lid');        
        if(!empty($lid)){
            $data['contenttext'] = $document;
            $data['media_type'] = '3';
            $data['publish'] = '0';
            $newID = $this->model->insertLectureQuizRow($data , $lid);
        }
        $return_data = array(
            'status'=>true,
            'file_title'=> 'Text'
        );
        
        echo json_encode($return_data);
        exit;
    }

    public function postLectureLibrarySave(Request $request)
    {
        $course_id = $request->input('course_id');
        $data['media'] = $request->input('lib');
        $data['media_type'] = $request->input('type');
        $newID = $this->model->insertLectureQuizRow($data , $request->input('lid'));
                    
        if($request->input('type') == 0){
        
            $libraryDetails = $this->model->getvideoinfo($request->input('lib'));
            $file_title = $libraryDetails['0']->video_name;
            $duration = $libraryDetails['0']->duration;
            $processed = $libraryDetails['0']->processed;
            if($processed == 1)
                $file_link = Storage::url('course/'.$course_id.'/'.$libraryDetails['0']->video_title.'.webm');
            else 
                $file_link = '';
            
        } else if($request->input('type') == 1){
        
            $libraryDetails = $this->model->getfileinfo($request->input('lib'));
            $file_title = $libraryDetails['0']->file_title;
            $duration = $libraryDetails['0']->duration;
            $file_link = Storage::url('course/'.$course_id.'/'.$libraryDetails['0']->file_name.'.'.$libraryDetails['0']->file_extension);
            
        }else if($request->input('type') == 2 || $request->input('type') == 5){
        
            $libraryDetails = $this->model->getfileinfo($request->input('lib'));
            $file_title = $libraryDetails['0']->file_title;
            if($libraryDetails['0']->duration <= 1){ 
                $pdfPage = $libraryDetails['0']->duration.' Page';
            } else { 
                $pdfPage = $libraryDetails['0']->duration.' Pages';
            }
            $duration = $pdfPage;
            $file_link = '';
            
        }
        
        $return_data = array(
            'status'=>true,
            'duration'  => $duration,
            'file_title'=> $file_title,
            'file_link'=> $file_link
        );
        
        echo json_encode($return_data);
        exit;
    }


    public function postLectureLibraryResourceSave(Request $request)
    {
        $data['resources'] = $request->input('lib');
        $newID = $this->model->insertLectureQuizResourceRow($data , $request->input('lid'));
        $return_data = array(
            'status'=>true,
            'file_id'=> $request->input('lib')
        ); 
        echo json_encode($return_data);
        exit;
    }

    public function postLectureExternalResourceSave(Request $request)
    {
        $lid = $request->input('lid');
        $courseFiles = new CourseFiles;
        $courseFiles->file_name = $request->input('link');
        $courseFiles->file_title = $request->input('title');
        $courseFiles->file_type = 'link';
        $courseFiles->file_extension = 'link';
        $courseFiles->file_tag = 'curriculum_resource_link';
        $courseFiles->uploader_id = \Auth::user()->instructor->id;
        $courseFiles->created_at = time();
        $courseFiles->updated_at = time();
        if($courseFiles->save()){
            if(!empty($lid)){
                $data['resources'] = $courseFiles->id;
                $newID = $this->model->insertLectureQuizResourceRow($data , $lid);
            }
            $return_data = array(
                'status'=>true,
                'file_id'=> $courseFiles->id,
                'file_title'=> $request->input('title'),
                'file_size'=> ''
            );
        }else{
            $return_data = array(
                'status'=>false,
            );
        }
        echo json_encode($return_data);
        exit;
    }

    public function postLecturePublishSave(Request $request)
    {
        $data['publish'] = $request->input('publish');
        if($request->input('lid') == 0){
            $newID = $this->model->insertLectureQuizRow($data , '');
        } else {
            $newID = $this->model->insertLectureQuizRow($data , $request->input('lid'));
        }
    $publish = $request->input('publish');
    $lid     = $request->input('lid');
    if($publish=='1' && $lid!='0'){
        $getcourseid              = $this->model->getcourseid($lid);
        if(count($getcourseid)>0){
          $cid                      = $getcourseid['0']->course_id;
          $courseinfo               = $this->model->getcourseinfo($cid);
          
        }
    }
        echo $newID;
        exit;
    }

     public function postVideo(){
      $video_id = $_POST['vid'];
        $vidoes = $this->model->getVideobyid($video_id);
        echo $vidoes->video_title;exit();
    }
    /* Curriculum end */
}
