<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];

    public function office()
    {
        return $this->belongsTo(Office::class);

    }//end fo office

    public function school()
    {
        return $this->belongsTo(School::class , 'school_id' , 'moe_id');

    }//end fo school

    public function teacher()
    {
        return $this->belongsTo(Teacher::class , 'teacher_id' , 'idcard');

    }//end fo teacher

    public function programs()
    {
        return $this->belongsToMany('App\Program', 'program_student')->withTimestamps()->withPivot(['id', 'student_id','program_date','program_note','program_status'])->orderBy('program_date', 'desc');
    }

    public function getPrograsCountAttribute ()
    {
        return $this->programs->count();
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_student')->withTimestamps()->withPivot(['id','course_date','course_note','course_status'])->orderBy('course_date', 'desc');
    }

    public function getCoursesCountAttribute ()
    {
        return $this->courses->count();
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/student_images/' . $this->image);

    }//end of get image path
}
