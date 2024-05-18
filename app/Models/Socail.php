<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socail extends Model
{
    use HasFactory;
    
    protected $guarded = [''] ;

    public function lecturer(){
        return $this->belongsTo(Lecturer::class) ;
    }

    public function student(){
        return $this->belongsTo(Student::class) ;
    }

}

