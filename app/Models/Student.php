<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [''] ;

    public function socials(){
        return $this->hasMany(Socail::class) ;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchased()
    {
        return $this->hasMany(PurchasedCourse::class);
    }


}
