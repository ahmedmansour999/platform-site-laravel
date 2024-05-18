<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vedio extends Model
{
    use HasFactory;
    protected $guarded = [''] ;
    use SoftDeletes;

    public function Lecturer(){
        return $this->belongsTo(Lecturer::class) ;
    }
    
    public function course(){
        return $this->belongsTo(Course::class) ;
    }
}
