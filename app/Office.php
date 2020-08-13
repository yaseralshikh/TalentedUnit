<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = [];

    public function schools()
    {
        return $this->hasMany(School::class);
        
    }//end of products

    public function getPaginatedSchoolsAttribute(){
        return $this->schools()->paginate(20);
    }// end of Paginated Products

}
