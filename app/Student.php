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
        return $this->belongsTo(School::class);

    }//end fo school

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);

    }//end fo teacher

    public function getImagePathAttribute()
    {
        return asset('uploads/student_images/' . $this->image);

    }//end of get image path
}