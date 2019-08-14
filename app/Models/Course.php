<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Support\Facades\Storage;
use SiteHelpers;

class Course extends Model
{
    protected $table = 'courses';
    protected $guarded = array();

    public static function is_subscribed($course_slug, $user_id)
    {
        $course = \DB::table('courses')->where('course_slug', $course_slug)->first();
        return \DB::table('course_taken')
          ->where('course_taken.course_id',$course->id)
          ->where('course_taken.user_id',$user_id)
          ->first();
    }

    public function students_count($course_id)
    {
        return \DB::table('course_taken')->where('course_id', $course_id)->count();
    }

    public function instructor()
    {
        return $this->belongsTo('App\Models\Instructor', 'instructor_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\CourseRating', 'course_id', 'id');
    }

    public function getcurriculumArray($id='', $course_slug='')
    {
        $lectures = \DB::table('curriculum_sections')
              ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
              ->leftJoin('course_videos', 'course_videos.id', '=', 'curriculum_lectures_quiz.media')
              ->leftJoin('course_files', 'course_files.id', '=', 'curriculum_lectures_quiz.media')
              ->select('curriculum_sections.section_id',
                'curriculum_lectures_quiz.lecture_quiz_id',
                'curriculum_sections.title as s_title', 
                'curriculum_lectures_quiz.title as l_title')
              ->where('curriculum_sections.course_id', '=', $id)
              ->where("curriculum_lectures_quiz.publish",'=','1')
              ->orderBy('curriculum_sections.sort_order', 'asc')
              ->orderBy('curriculum_lectures_quiz.sort_order', 'asc')
              ->get()->toArray();
        

        $lectures_array = array();
        $sections_array = array();
        $s_number = $l_number = 0;
        foreach ($lectures as $lecture) {
            $l_number++;
            if(!in_array($lecture->section_id, $sections_array))
            {
                $s_number++;
                $section['section_id'] = $lecture->section_id;
                $section['lecture_quiz_id'] = $lecture->lecture_quiz_id;
                $section['s_title'] = $lecture->s_title;
                $section['l_title'] = $lecture->l_title;
                $section['number'] = $s_number;
                $section['is_section'] = true;

                array_push($lectures_array, $section);    
            } 

            array_push($sections_array, $lecture->section_id);

            $lecture->is_section = false;
            $lecture->number = $l_number;
            $lecture->lecture_quiz_id = $lecture->lecture_quiz_id;
            
            $lecture->url = SiteHelpers::encrypt_decrypt($lecture->lecture_quiz_id);
            array_push($lectures_array, (array) $lecture);
        }
        $return['sections'] = $lectures_array;
        
        return $return;
    }

    public function getcurriculum($id='')
    {
        $lectures = \DB::table('curriculum_sections')
              ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
              ->leftJoin('course_videos', 'course_videos.id', '=', 'curriculum_lectures_quiz.media')
              ->leftJoin('course_files', 'course_files.id', '=', 'curriculum_lectures_quiz.media')
              ->select('curriculum_sections.section_id',
              	'curriculum_sections.title as s_title', 
                'curriculum_lectures_quiz.lecture_quiz_id',
              	'curriculum_lectures_quiz.title as l_title',
              	'curriculum_sections.sort_order as s_sort_order', 
              	'curriculum_lectures_quiz.sort_order as l_sort_order',
                'curriculum_lectures_quiz.media_type',
                'course_videos.duration as v_duration',
                'course_files.duration as f_duration')
              ->where('curriculum_sections.course_id', '=', $id)
              ->where("curriculum_lectures_quiz.publish",'=','1')
              ->orderBy('curriculum_sections.sort_order', 'asc')
              ->orderBy('curriculum_lectures_quiz.sort_order', 'asc')
              ->get(); 

        $return['sections'] = $sections = array();
        $is_curriculum = $videos_count = 0;

        foreach ($lectures as $lecture) {
            $is_curriculum = 1;
        	if($lecture->media_type == 0) {
        		$videos_count++;
        	}
        	$section_id_name = $lecture->section_id.'{#-#}'.$lecture->s_title;
        	if(!array_key_exists($section_id_name, $sections))
        	{
        		$sections[$section_id_name] = array();
        	}
        	array_push($sections[$section_id_name], $lecture);
        }
        $return['is_curriculum'] = $is_curriculum;
        $return['sections'] = $sections;
        $return['lectures_count'] = count($lectures);
        $return['videos_count'] = $videos_count;
        return $return;
    }

    public function getcurriculuminfo($id='',$user_id)
    {
		$result = array();
		$sections = array();
		$lecturesquiz = array();
		$lecturesquizquestions = array();
		$lecturesmedia = array();
		$lecturesresources = array();
		$uservideos = array();
		$useraudios = array();
		$userpresentation = array();
		$userdocuments = array();
		$userresources = array();
		$sections = \DB::table('curriculum_sections')->where('course_id', '=', $id)->get();
		
		if($sections->isEmpty()){	// IF EMPTY, CREATE DEFAULT SECTION AND LECTURE
			$data['course_id'] = $id;
			$data['title'] = 'Start Here';
			$data['sort_order'] = '1';
			
			$sectionId = $this->insertSectionRow($data , '');
			
			$ldata['section_id'] = $sectionId;
			$ldata['title'] = 'Introduction';
			$ldata['sort_order'] = '1';
			$ldata['type'] = '0';
			
			$lectureId = $this->insertLectureQuizRow($ldata , '');
			
			$sections = \DB::table('curriculum_sections')->where('course_id', '=', $id)->orderBy('sort_order', 'asc')->get();
			
		}
		
		
		foreach($sections as $section){
			$sectionid = $section->section_id;
			$lecturesquiz[$sectionid] = \DB::table('curriculum_lectures_quiz')->where('section_id', '=', $sectionid)->orderBy('sort_order', 'asc')->get();
			
			if($lecturesquiz[$sectionid]->isEmpty()){
				$ldata['section_id'] = $sectionid;
				$ldata['title'] = 'Introduction';
				$ldata['sort_order'] = '1';
				$ldata['type'] = '0';
				
				$lectureId = $this->insertLectureQuizRow($ldata , '');
				$lecturesquiz[$sectionid] = \DB::table('curriculum_lectures_quiz')->where('section_id', '=', $sectionid)->orderBy('sort_order', 'asc')->get();
			}
			
			foreach($lecturesquiz[$sectionid] as $lecture){
				$lecture_quiz_id = $lecture->lecture_quiz_id;
				if($lecture->type == 0){
					$mediaid = $lecture->media;
					if($lecture->media_type == 0) {
						$lecturesmedia[$sectionid][$lecture_quiz_id] = \DB::table('course_videos')->where('id', '=', $mediaid)->get();
					} else if($lecture->media_type == 1 || $lecture->media_type == 2 || $lecture->media_type == 5) {
						$lecturesmedia[$sectionid][$lecture_quiz_id] = \DB::table('course_files')->where('id', '=', $mediaid)->get();
					} else if($lecture->media_type == 3) {
						$lecturesmedia[$sectionid][$lecture_quiz_id] = $lecture->contenttext;
					}
				} else {
					$lecturesquizquestions[$sectionid][$lecture_quiz_id] = \DB::table('curriculum_quiz_questions')->where('quiz_id', '=', $lecture_quiz_id)->orderBy('sort_order', 'asc')->get();
				}
				
				if(!is_null($lecture->resources)){
					$resources = json_decode($lecture->resources,true);

					foreach($resources as $resource){	
						$lecturesresources[$sectionid][$lecture_quiz_id][] = \DB::table('course_files')->where('id', '=', $resource)->get();					
					}
				}
				
				
				$uservideos = \DB::table('course_videos')->where('uploader_id', '=', $user_id)->get();
				$useraudios = \DB::table('course_files')->where('uploader_id', '=', $user_id)->whereIn('file_extension', ['mp3', 'wav'])->get();
				$userpresentation = \DB::table('course_files')->where('uploader_id', '=', $user_id)->whereIn('file_extension', ['pdf'])->whereIn('file_tag', ['curriculum_presentation'])->get();
				$userdocuments = \DB::table('course_files')->where('uploader_id', '=', $user_id)->whereIn('file_extension', ['pdf'])->whereIn('file_tag', ['curriculum'])->get();
				$userresources = \DB::table('course_files')->where('uploader_id', '=', $user_id)->whereIn('file_extension', ['pdf', 'doc', 'docx'])->whereIn('file_tag', ['curriculum_resource'])->get();
				
			}
		}
		
		$result['sections'] = $sections;
		$result['lecturesquiz'] = $lecturesquiz;
		$result['lecturesquizquestions'] = $lecturesquizquestions;
		$result['lecturesmedia'] = $lecturesmedia;
		$result['lecturesresources'] = $lecturesresources;
		$result['uservideos'] = $uservideos;
		$result['useraudios'] = $useraudios;
		$result['userpresentation'] = $userpresentation;
		$result['userdocuments'] = $userdocuments;
		$result['userresources'] = $userresources;
		
		return $result;
		
    }
	
	
	public  function insertSectionRow($data,$id){
	
       
       $table = 'curriculum_sections';
	   $key = 'section_id';
	    if($id == NULL )
        {
			 $data['createdOn'] = date("Y-m-d H:i:s");	
			 $data['updatedOn'] = date("Y-m-d H:i:s");	
			 $id = \DB::table( $table)->insertGetId($data);
            
        } else {
            // Update here 
			// update created field if any
			if(isset($data['createdOn'])) unset($data['createdOn']);	
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");			
			 \DB::table($table)->where($key,$id)->update($data);
        }    
        return $id;    
	}	
	
	public  function insertLectureQuizRow($data,$id){
	
       $table = 'curriculum_lectures_quiz';
	   $key = 'lecture_quiz_id';
	    if($id == NULL )
        {
			 $data['createdOn'] = date("Y-m-d H:i:s");	
			 $data['updatedOn'] = date("Y-m-d H:i:s");	
			 $id = \DB::table( $table)->insertGetId($data);
            
        } else {
            // Update here 
			// update created field if any
			if(isset($data['createdOn'])) unset($data['createdOn']);	
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");			
			 \DB::table($table)->where($key,$id)->update($data);   
        }    
        return $id;    
	}
	
	public static function postSectionDelete($id){
		
		\DB::table('curriculum_sections')->where('section_id', '=', $id)->delete();
		
	}
	
	public static function postLectureQuizDelete($id){
		
		\DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', '=', $id)->delete();
		
	}
	
	public function insertLectureQuizResourceRow($data,$id){
	
		$lecturesquiz = \DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', '=', $id)->get();
		
		if(!$lecturesquiz->isEmpty() && !is_null($lecturesquiz['0']->resources)){
			$resources = json_decode($lecturesquiz['0']->resources,true);
			array_push($resources,$data['resources']);
		} else {
			$resources = array($data['resources']);
		}
		$data['resources'] = json_encode($resources);
		$this->insertLectureQuizRow($data,$id);
	}
	
	public function postLectureResourceDelete($lid,$rid){
		
		$resfiles = \DB::table('course_files')->where('id', '=', $rid)->get();
		
		if(!$resfiles->isEmpty()){
			
			\DB::table('course_files')->where('id', '=', $rid)->delete();
		
			$lecturesquiz = \DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', '=', $lid)->get();
			
			if(!$lecturesquiz->isEmpty() && !is_null($lecturesquiz['0']->resources)){
				$resources = json_decode($lecturesquiz['0']->resources,true);
				if(($key = array_search($rid, $resources)) !== false) {
					unset($resources[$key]);
				}
			}
			$data['resources'] = json_encode($resources);
			$this->insertLectureQuizRow($data,$lid);
		}
	}
	
	
	public function checkDeletePreviousFiles($id){
	
		$lecturesquiz = \DB::table('curriculum_lectures_quiz')->where('lecture_quiz_id', '=', $id)->get();
		
		if(!$lecturesquiz->isEmpty() && !is_null($lecturesquiz['0']->media)){
			
			$rid = $lecturesquiz['0']->media;			
			if($lecturesquiz['0']->media_type == 0){
				$resvideos = \DB::table('course_videos')->where('id', '=', $rid)->get();
				
				if(!$resvideos->isEmpty()){
					foreach($resvideos as $resfile) {
						$file_name = 'course/'.$resfile->course_id.'/'.$resfile->video_title.'.'.$resfile->video_type;
						if (Storage::exists($file_name)) {
			                Storage::delete($file_name);
			            }
					}
					\DB::table('course_videos')->where('id', '=', $rid)->delete();
				}
			} else {
				$resfiles = \DB::table('course_files')->where('id', '=', $rid)->get();
				if(!$resfiles->isEmpty()){
					foreach($resfiles as $resfile) {
						$file_name = 'course/'.$resfile->course_id.'/'.$resfile->file_name.'.'.$resfile->file_type;
						if (Storage::exists($file_name)) {
			                Storage::delete($file_name);
			            }
					}
					\DB::table('course_files')->where('id', '=', $rid)->delete();
				}
			}
		}
	}
  
  public function getcurriculumsection($id=''){

    return \DB::table('curriculum_sections')
                ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                ->select('curriculum_sections.section_id','curriculum_sections.course_id','curriculum_sections.title','curriculum_sections.sort_order')
                ->where('curriculum_sections.course_id', '=', $id)->where("curriculum_lectures_quiz.publish",'=','1')->orderBy('curriculum_sections.sort_order', 'asc')->groupBy('curriculum_sections.section_id')->get();

  }

  public function getResources($resources)
  {
    $resource_files = array();
    if($resources)
    {
        $resources = json_decode($resources);

        foreach ($resources as $resource) {
            $resource_file = \DB::table("course_files")->where("course_files.id",'=',$resource)->first();
            array_push($resource_files, $resource_file);
        }
    }
    return $resource_files;
  }

  public function getlecturedetails($lid='')
  {
     $getmediatype = \DB::table("curriculum_lectures_quiz")->where("lecture_quiz_id",'=',$lid)->get();
     if(count($getmediatype)>0){
          $mediaid = $getmediatype['0']->media;
          $lecture_quiz_id = $getmediatype['0']->lecture_quiz_id;
          if(isset($getmediatype['0']->media_type) && $getmediatype['0']->media_type=='0'){
              return \DB::table("curriculum_lectures_quiz")
                      ->select('curriculum_lectures_quiz.*', 'course_videos.*', 'curriculum_sections.title as section_title' )
                      ->leftJoin('curriculum_sections', 'curriculum_sections.section_id', '=', 'curriculum_lectures_quiz.section_id')
                      ->leftJoin('course_videos', 'course_videos.id', '=', 'curriculum_lectures_quiz.media')
                      ->where("curriculum_lectures_quiz.media",'=',$mediaid)
                      ->where("curriculum_lectures_quiz.lecture_quiz_id",'=',$lecture_quiz_id)->first();
          }elseif(isset($getmediatype['0']->media_type) && $getmediatype['0']->media_type=='3'){
              return \DB::table("curriculum_lectures_quiz")
                      ->select('curriculum_lectures_quiz.*', 'curriculum_sections.title as section_title' )
                      ->leftJoin('curriculum_sections', 'curriculum_sections.section_id', '=', 'curriculum_lectures_quiz.section_id')
                      ->where("curriculum_lectures_quiz.lecture_quiz_id",'=',$lecture_quiz_id)->first();
          }elseif(isset($getmediatype['0']->media_type) && ($getmediatype['0']->media_type=='2' || $getmediatype['0']->media_type=='1')){
             return \DB::table("curriculum_lectures_quiz")
                      ->select('curriculum_lectures_quiz.*', 'course_files.*', 'curriculum_sections.title as section_title', 'curriculum_sections.course_id' )
                      ->leftJoin('curriculum_sections', 'curriculum_sections.section_id', '=', 'curriculum_lectures_quiz.section_id')
                      ->leftJoin('course_files', 'course_files.id', '=', 'curriculum_lectures_quiz.media')
                      ->where("curriculum_lectures_quiz.media",'=',$mediaid)
                      ->where("curriculum_lectures_quiz.lecture_quiz_id",'=',$lecture_quiz_id)->first();

          } else {
				return $getmediatype;
			}
     }
  }

  public function getfirstlecturedetails($cid='')
  {    
    $getmediatype = \DB::table("curriculum_sections")
                      ->join('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                      ->where("curriculum_sections.course_id",'=',$cid)->get();

      if(count($getmediatype)>0){
          if(isset($getmediatype['0']->media_type) && $getmediatype['0']->media_type=='0'){
            $mediaid = $getmediatype['0']->media;
            return \DB::table("curriculum_lectures_quiz")
                      ->leftJoin('course_videos', 'course_videos.id', '=', 'curriculum_lectures_quiz.media')
                      ->where("curriculum_lectures_quiz.media",'=',$mediaid)->get();
          }elseif(isset($getmediatype['0']->media_type) && $getmediatype['0']->media_type=='3'){
            $mediaid = $getmediatype['0']->media;
            return \DB::table("curriculum_lectures_quiz")
                      ->where("curriculum_lectures_quiz.media",'=',$mediaid)->get();
          }else{
             $mediaid = $getmediatype['0']->media;
             return \DB::table("curriculum_lectures_quiz")
                      ->leftJoin('course_files', 'course_files.id', '=', 'curriculum_lectures_quiz.media')
                      ->where("curriculum_lectures_quiz.media",'=',$mediaid)->get();

          }
     }                      
    
  }
  public function getFileDetails($id='')
  {
     return \DB::table('course_files')
            ->select('course_files.*', 'curriculum_sections.course_id')
            ->leftJoin('curriculum_lectures_quiz', 'course_files.id', '=', 'curriculum_lectures_quiz.media')
            ->leftJoin('curriculum_sections', 'curriculum_sections.section_id', '=', 'curriculum_lectures_quiz.section_id')
            ->where('course_files.id','=', $id)
            ->first();
  }

  // get next and previous lecturer id's
  public function getalllecture($cid=''){
    $sections = \DB::table("curriculum_sections")->select('section_id')->where("course_id",'=',$cid)->get();
    $section_id = array();
    foreach ($sections as $value) {
       $section_id[] = $value->section_id;
    } 

    $lectures = \DB::table("curriculum_lectures_quiz")
                  ->select("lecture_quiz_id")
                  ->where("publish",'=',1)
                  ->whereIn('section_id',$section_id)
                  ->orderBy('section_id')
                  ->orderBy('sort_order')
                  ->get();
   
    return $lectures;

  }

  public static function getCoursecompletedStatus($lecture_id){
    return \DB::table('course_progress')->where('lecture_id', $lecture_id)->where('user_id',\Auth::user()->id)->where('status',1)->count();
  }

  public function getVideobyid($video_id=''){
    return \DB::table('curriculum_lectures_quiz')
                ->join('course_videos','course_videos.id','=','curriculum_lectures_quiz.media')
                ->where('curriculum_lectures_quiz.lecture_quiz_id',$video_id)->first();
  }

  public function getFilebyid($file_id=''){
    return \DB::table('curriculum_lectures_quiz')
                ->join('course_files','course_files.id','=','curriculum_lectures_quiz.media')
                ->where('curriculum_lectures_quiz.lecture_quiz_id',$file_id)->first();
  }

    public function getvideoinfo($id='')
	{
	   return \DB::table('course_videos')->where('id', '=', $id)->get(); 
	}

	public function getvideoinfoFirst($id='')
	{
	   return \DB::table('course_videos')->where('id', '=', $id)->first(); 
	}

	public function getcourseid($lid='')
	{
	    return \DB::table('curriculum_lectures_quiz')
	            ->join('curriculum_sections', 'curriculum_sections.section_id', '=', 'curriculum_lectures_quiz.section_id')
	            ->select('curriculum_sections.course_id')
	            ->where('curriculum_lectures_quiz.lecture_quiz_id','=', $lid)
	            ->get();
	}

	public function getcourseinfo($id='')
    {
        $course_get = \DB::table('courses')->where('id','=', $id)->first();
        return $course_get;
    }

    public function updateLectureStatus($course_id='', $lecture_id='', $status = '')
    {
        $user_id  = \Auth::user()->id;
        $lecture = \DB::table("course_progress")
             ->where("course_id",'=',$course_id)
             ->where("lecture_id",'=',$lecture_id)
             ->where("user_id",'=',$user_id)
             ->first();
         $status = $status == 'true' ? 1 : 0;
         $dataarray = array();
         if($lecture){
           $getid                           = $lecture->progress_id;
           $dataarray['status']             = $status;
           $dataarray['modified_at']        = date("Y-m-d H:i:s");
           \DB::table('course_progress')->where("progress_id",'=',$getid)->update($dataarray);
           return $getid;
         }else{
           $dataarray['course_id']          = $course_id;
           $dataarray['user_id']            = $user_id;
           $dataarray['lecture_id']         = $lecture_id;
           $dataarray['status']             = $status;
           $dataarray['created_at']         = date("Y-m-d H:i:s");
           $dataarray['modified_at']        = date("Y-m-d H:i:s");
           return \DB::table('course_progress')->insertGetId($dataarray);
         }
    }
    
}
