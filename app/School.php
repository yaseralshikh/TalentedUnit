<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded = ['id'];

    public function office()
    {
        return $this->belongsTo(Office::class);

    }//end fo category

}
