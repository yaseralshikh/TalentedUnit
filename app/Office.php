<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = [];

    public function schools()
    {
        return $this->hasMany(School::class);
        
    }//end of schools

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
        
    }//end of teachers

    public function students()
    {
        return $this->hasMany(Student::class);
        
    }//end of students

    public function getPaginatedSchoolsAttribute(){
        return $this->schools()->paginate(20);

    }// end of Paginated Schools

}
