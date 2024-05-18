<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name') ;
            $table->integer('price');
            $table->string('image') ;
            $table->string('duration') ;
            $table->softDeletes() ;
            $table->foreignId('lecturer_id')->constrained('lecturers')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
