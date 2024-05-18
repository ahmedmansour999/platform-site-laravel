<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [] ;
    protected $table = "carts" ;

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }


}
