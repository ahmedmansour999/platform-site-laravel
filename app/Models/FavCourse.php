<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavCourse extends Model
{
    use HasFactory;
    protected $table = 'fav_student_courses' ;

    public function students(){
        return $this->hasMany(Student::class) ;
    }
    public function courses(){
        return $this->hasMany(Course::class) ;
    }

}
