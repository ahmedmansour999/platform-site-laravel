<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecturer extends Model
{
    use HasFactory;
    protected $guarded = [''] ;

    public function socials(){
        return $this->hasMany(Socail::class) ;
    }

    public function lecture(){
        return $this->hasMany(Lecture::class) ;
    }
    public function vedios(){
        return $this->hasMany(Vedio::class) ;
    }
    public function course(){
        return $this->hasMany(Course::class) ;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
