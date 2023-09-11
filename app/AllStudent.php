<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class AllStudent extends Model
{
    protected $guarded = ['id'];

    public function localStudent() {
        return $this->belongsTo(LocalStudent::class, 'local_student_id');
    }

    public function foreignStudent() {
        return $this->belongsTo(ForeignStudent::class, 'foreign_student_id');
    }
}
