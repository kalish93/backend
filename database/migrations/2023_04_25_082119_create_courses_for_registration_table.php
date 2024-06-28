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
        Schema::create('courses_for_registration', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('semester');
            $table->foreignId('course_id')->constrained('courses');
            $table->string('program');
            $table->string('department');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_for_registration');
    }
};
