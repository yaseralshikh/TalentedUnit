<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded = ['id'];

    public function office()
    {
        return $this->belongsTo(Office::class);

    }//end fo office

    public function teachers()
    {
        return $this->hasMany(Teacher::class , 'school_id' , 'moe_id');
        
    }//end of teachers

    public function students()
    {
        return $this->hasMany(Student::class , 'school_id' , 'moe_id');
        
    }//end of students

    public function getPaginatedTeachersAttribute(){
        return $this->teachers()->paginate(20);

    }// end of Paginated Teachers

    public function getPaginatedStudentsAttribute(){
        return $this->students()->paginate(20);

    }// end of Paginated Students

}
