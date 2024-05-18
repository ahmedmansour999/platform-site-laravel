<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    use HasFactory;
    protected $guarded = [''] ;

    public function socials(){
        return $this->hasMany(Socail::class) ;
    }

    
}
