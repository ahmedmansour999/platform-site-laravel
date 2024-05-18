<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchased_student_courses', function (Blueprint $table) {


            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade') ;
            $table->foreignId('course_id')->constrained('courses')->onUpdate('cascade') ;
            $table->timestamp('date')->default(now()) ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
