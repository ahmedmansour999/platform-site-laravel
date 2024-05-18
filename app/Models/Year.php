<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function user(){
        return $this->BelongsToMany(User::class) ;
    }
}
