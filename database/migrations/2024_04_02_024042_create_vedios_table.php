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
        Schema::create('vedios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('vedio');
            $table->foreignId('lecturer_id')->constrained('lecturers')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vedios');
    }
};
