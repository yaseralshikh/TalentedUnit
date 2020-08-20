<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['image_path'];

    public function office()
    {
        return $this->belongsTo(Office::class);

    }//end fo office

    public function school()
    {
        return $this->belongsTo(School::class);

    }//end fo school

    public function students()
    {
        return $this->hasMany(Student::class);
        
    }//end of students

    public function getPaginatedStudentsAttribute(){
        return $this->students()->paginate(20);

    }// end of Paginated Students

    public function getImagePathAttribute()
    {
        return asset('uploads/teacher_images/' . $this->image);

    }//end of get image path
}
