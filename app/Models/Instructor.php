<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Instructor extends Model
{
    protected $table = 'instructors';
    protected $guarded = array();

    
    public function courses()
    {
        return $this->hasMany('App\Models\Course', 'instructor_id', 'id');
    }

    public static function metrics($instructor_id)
    {
        $metrics = array();
        $metrics['courses'] = \DB::table('courses')->where('instructor_id', $instructor_id)->count();
        $metrics['lectures'] = \DB::table('courses')
                                ->where('courses.instructor_id', $instructor_id)
                                ->leftJoin('curriculum_sections', 'curriculum_sections.course_id', '=', 'courses.id')                       
                                ->leftJoin('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                                ->count();
        $metrics['videos'] = \DB::table('courses')
                                ->where('courses.instructor_id', $instructor_id)
                                ->where('curriculum_lectures_quiz.media_type', 0)
                                ->leftJoin('curriculum_sections', 'curriculum_sections.course_id', '=', 'courses.id')                       
                                ->leftJoin('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                                ->count();
        return $metrics;
    }

    public static function admin_metrics()
    {
        $metrics = array();
        $metrics['courses'] = \DB::table('courses')->count();
        $metrics['students'] = \DB::table('users')
                                ->where('roles.name', 'student')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        $metrics['instructors'] = \DB::table('users')
                                ->where('roles.name', 'instructor')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        return $metrics;
    }
}
