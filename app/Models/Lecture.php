<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecture extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [''] ;

    public function Lecturer(){
        return $this->belongsTo(Lecturer::class) ;
    }
    public function course(){
        return $this->belongsTo(Course::class) ;
    }


}
