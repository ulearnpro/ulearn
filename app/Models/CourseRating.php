<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class CourseRating extends Model
{
    protected $table = 'course_ratings';
    protected $guarded = array();

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
}
