<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //protected $fillable = [];
    protected $guarded = [];

    public function students()
    {
        return $this->belongsToMany('App\Student', 'program_student');
    }

} // end of model
