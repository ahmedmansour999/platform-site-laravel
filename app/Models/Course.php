<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [''];
    use SoftDeletes;


    public function Lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }


    // public function carts()
    // {
    //     return $this->belongsTo(Cart::class);
    // }


    public function contents()
    {
        return $this->hasMany(Course_Content::class)->orderBy('order');
    }
}
