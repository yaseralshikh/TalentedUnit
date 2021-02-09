<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function students()
    {
        return $this->belongsToMany('App\Student', 'course_student');
    }
}
