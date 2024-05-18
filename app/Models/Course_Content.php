<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course_Content extends Model
{
    use HasFactory;
    protected $guarded = [''] ;
    protected $table = 'course_contents';
    use SoftDeletes;



    public function lecture(){
        return $this->belongsTo(Lecture::class) ;
    }

    public function vedio(){
        return $this->belongsTo(Vedio::class) ;
    }

    public function course(){
        return $this->belongsTo(Course::class) ;
    }



}
