<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForeignStudent extends Model
{
    protected $guarded = ['id'];
    
    public function foreign() {
        return $this->hasOne(AllStudent::class, 'foreign_student_id');
    }
}
