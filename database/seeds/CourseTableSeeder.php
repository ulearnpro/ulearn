<?php

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseRating;

use App\Models\CourseTaken;
use App\Models\Credit;
use App\Models\Transaction;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is_exist = Course::all();

        $course_names = array(
                    array('course_title'=>'Photography - Become a Better Photographer',
                      'instructor_id'=>9,
                      'category_id'=>9,
                      'instruction_level_id'=>4,
                      'duration'=>'2 days',
                      'price'=>0,
                      'strike_out_price'=>159.00,
                    )
            );

        if (!$is_exist->count()) {
            foreach ($course_names as $course_key => $course_name) {
                $course = new Course();
                $img_key = $course_key+1;
                $course->instructor_id = $course_name['instructor_id'];
                $course->category_id = $course_name['category_id'];
                $course->instruction_level_id = $course_name['instruction_level_id'];
                $course->course_title = $course_name['course_title'];
                $course->course_image = 'course/'.$img_key.'/'.$img_key.'.jpg';
                $course->thumb_image = 'course/'.$img_key.'/thumb_'.$img_key.'.jpg';
                $course->course_slug = str_slug($course_name['course_title'], '-');
                $course->keywords = 'Health,History,Coding,GK,Technology,Future,Space,IQ,IT & Software';
                $course->overview = '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using , making it look like readable English.</p>
                   <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don`t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn`t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>';
                $course->duration = $course_name['duration'];
                $course->price = $course_name['price'];
                $course->strike_out_price = $course_name['strike_out_price'];
                $course->is_active = 1;
                $course->save();


                $section_names = array(
                                    'Introduction',
                                    'Neque porro quisquam',
                                    'Dignissimos ducimus qui blanditiis praesentium',
                                    'Maxime placeat facere possimus',
                                    'Molestias excepturi sint occaecati cupiditate',
                                    'Reprehenderit qui in ea voluptate velit esse'
                                 );

                foreach ($section_names as $s_key => $section_name) {
                    $curriculum_sections['course_id'] = $course->id;
                    $curriculum_sections['title'] = $section_name;
                    $curriculum_sections['sort_order'] = $s_key;
                    $curriculum_sections['createdOn'] = date("Y-m-d H:i:s");   
                    $curriculum_sections['updatedOn'] = date("Y-m-d H:i:s");
                    $section_id = DB::table('curriculum_sections')->insertGetId($curriculum_sections);

                    $curriculum_lectures_quiz['section_id'] = $section_id;
                    $curriculum_lectures_quiz['title'] = 'Installing a text editor';
                    $curriculum_lectures_quiz['description'] = '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don`t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn`t anything embarrassing hidden in the middle of text.</p>';
                    $curriculum_lectures_quiz['contenttext'] = '';
                    $curriculum_lectures_quiz['media'] = 1;
                    $curriculum_lectures_quiz['media_type'] = 0;
                    $curriculum_lectures_quiz['sort_order'] = 1;
                    $curriculum_lectures_quiz['publish'] = 1;
                    $curriculum_lectures_quiz['resources'] = '[3]';
                    $curriculum_lectures_quiz['createdOn'] = date("Y-m-d H:i:s");   
                    $curriculum_lectures_quiz['updatedOn'] = date("Y-m-d H:i:s");
                    DB::table('curriculum_lectures_quiz')->insert($curriculum_lectures_quiz);

                    $curriculum_lectures_quiz['section_id'] = $section_id;
                    $curriculum_lectures_quiz['title'] = 'Adding real content';
                    $curriculum_lectures_quiz['description'] = '<p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn`t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>';
                    $curriculum_lectures_quiz['contenttext'] = '';
                    $curriculum_lectures_quiz['media'] = 1;
                    $curriculum_lectures_quiz['media_type'] = 1;
                    $curriculum_lectures_quiz['sort_order'] = 2;
                    $curriculum_lectures_quiz['publish'] = 1;
                    $curriculum_lectures_quiz['resources'] = '[3]';
                    $curriculum_lectures_quiz['createdOn'] = date("Y-m-d H:i:s");   
                    $curriculum_lectures_quiz['updatedOn'] = date("Y-m-d H:i:s");
                    DB::table('curriculum_lectures_quiz')->insert($curriculum_lectures_quiz);

                    $curriculum_lectures_quiz['section_id'] = $section_id;
                    $curriculum_lectures_quiz['title'] = 'Creating our index page';
                    $curriculum_lectures_quiz['description'] = '<p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>';
                    $curriculum_lectures_quiz['contenttext'] = '';
                    $curriculum_lectures_quiz['media'] = 2;
                    $curriculum_lectures_quiz['media_type'] = 2;
                    $curriculum_lectures_quiz['sort_order'] = 3;
                    $curriculum_lectures_quiz['publish'] = 1;
                    $curriculum_lectures_quiz['resources'] = '[4]';
                    $curriculum_lectures_quiz['createdOn'] = date("Y-m-d H:i:s");   
                    $curriculum_lectures_quiz['updatedOn'] = date("Y-m-d H:i:s");
                    DB::table('curriculum_lectures_quiz')->insert($curriculum_lectures_quiz);

                    $curriculum_lectures_quiz['section_id'] = $section_id;
                    $curriculum_lectures_quiz['title'] = 'Customizing the vendors';
                    $curriculum_lectures_quiz['description'] = '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content, making it look like readable English.</p>';
                    $curriculum_lectures_quiz['contenttext'] = '<p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content, making it look like readable English.</p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using content, making it look like readable English.</p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don`t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn`t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>';
                    $curriculum_lectures_quiz['media'] = NULL;
                    $curriculum_lectures_quiz['media_type'] = 3;
                    $curriculum_lectures_quiz['sort_order'] = 4;
                    $curriculum_lectures_quiz['publish'] = 1;
                    $curriculum_lectures_quiz['resources'] = '[5]';
                    $curriculum_lectures_quiz['createdOn'] = date("Y-m-d H:i:s");   
                    $curriculum_lectures_quiz['updatedOn'] = date("Y-m-d H:i:s");
                    DB::table('curriculum_lectures_quiz')->insert($curriculum_lectures_quiz);
                }

            }
            DB::table('course_files')->insert([
                'file_name'=>'sample-15568160485135',
                'file_title'=>'samplemp3',
                'file_type'=>'mp3',
                'file_extension'=>'mp3',
                'file_size'=>'4113874',
                'duration'=>'00:02:49',
                'file_tag'=>'curriculum',
                'uploader_id'=>1,
                'processed'=>1,
                'created_at'=>1556816050,
                'updated_at'=>1556816050
                ] );
                            
                DB::table('course_files')->insert([
                'file_name'=>'sample_15568166868011',
                'file_title'=>'sample.pdf',
                'file_type'=>'pdf',
                'file_extension'=>'pdf',
                'file_size'=>'164061',
                'duration'=>'11',
                'file_tag'=>'curriculum',
                'uploader_id'=>1,
                'processed'=>1,
                'created_at'=>1556816686,
                'updated_at'=>1556816686
                ] );
                            
                DB::table('course_files')->insert([
                'file_name'=>'sample_15568167745496',
                'file_title'=>'sample.pdf',
                'file_type'=>'pdf',
                'file_extension'=>'pdf',
                'file_size'=>'164061',
                'duration'=>'11',
                'file_tag'=>'curriculum_resource',
                'uploader_id'=>1,
                'processed'=>1,
                'created_at'=>1556816774,
                'updated_at'=>1556816774
                ] );
                            
                DB::table('course_files')->insert([
                'file_name'=>'http://www.google.com',
                'file_title'=>'Google Site',
                'file_type'=>'link',
                'file_extension'=>'link',
                'file_size'=>'',
                'duration'=>NULL,
                'file_tag'=>'curriculum_resource_link',
                'uploader_id'=>1,
                'processed'=>1,
                'created_at'=>1556816825,
                'updated_at'=>1556816825
                ] );
                            
                DB::table('course_files')->insert([
                'file_name'=>'http://www.facebook.com',
                'file_title'=>'Facebook Resource',
                'file_type'=>'link',
                'file_extension'=>'link',
                'file_size'=>'',
                'duration'=>NULL,
                'file_tag'=>'curriculum_resource_link',
                'uploader_id'=>1,
                'processed'=>1,
                'created_at'=>1556816856,
                'updated_at'=>1556816856
                ] );


                DB::table('course_videos')->insert([
                'video_title'=>'raw_1556815948_sample-15568159421897',
                'video_name'=>'sample.mp4',
                'video_type'=>'mp4',
                'duration'=>'00:02:24',
                'image_name'=>'sample-15568159421897.jpg',
                'video_tag'=>'curriculum',
                'uploader_id'=>1,
                'course_id'=>1,
                'processed'=>1,
                'created_at'=>1556816856,
                'updated_at'=>1556816856
                ] );

        }

        
        $user_id = $course_id = 1;
        $course = Course::find($course_id);
        $instructor_id = $course->instructor_id;

        $is_course_taken_exist = CourseTaken::all();
        if (!$is_course_taken_exist->count()) {
          $course_taken = new CourseTaken();
          $course_taken->user_id = $user_id;
          $course_taken->course_id = $course_id;
          $course_taken->save();
        }

        $is_transaction_taken_exist = Transaction::all();
        if (!$is_transaction_taken_exist->count()) {
          $transaction = new Transaction();
          $transaction->user_id = $user_id;
          $transaction->course_id = $course_id;
          $transaction->amount = 0.00;
          $transaction->status = 'completed';
          $transaction->payment_method = 'paypal_express_checkout';
          $transaction->order_details = '{"TOKEN":"success","status":"succeeded","Timestamp":1561787415,"ACK":"Success"}';
          $transaction->save();
        }

        $is_credits_taken_exist = Credit::all();
        if (!$is_credits_taken_exist->count()) {
          $credits = new Credit();
          $credits->transaction_id = $transaction->id;
          $credits->instructor_id = $instructor_id;
          $credits->user_id = $user_id;
          $credits->course_id = $course_id;
          $credits->credit = $course->price;
          $credits->credits_for = 1;
          $credits->is_admin = 0;

          $credits = new Credit();
          $credits->transaction_id = $transaction->id;
          $credits->instructor_id = 0;
          $credits->user_id = $user_id;
          $credits->course_id = $course_id;
          $credits->credit = $course->price;
          $credits->credits_for = 2;
          $credits->is_admin = 1;

          $credits->save();
        }
    }
}
