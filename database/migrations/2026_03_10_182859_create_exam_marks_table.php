<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('student_id');
            $table->decimal('total_marks', 5, 2)->default(100);
            $table->decimal('obtained_marks', 5, 2)->nullable();
            $table->string('grade', 10)->nullable(); // A+, B, etc.
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('exam_id')->references('id')->on('exams')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('student_registers')->cascadeOnDelete();

            // Prevent duplicate marks entry for the same student, exam, and subject
            $table->unique(['tenant_id', 'exam_id', 'subject_id', 'student_id'], 'unique_exam_marks');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_marks');
    }
};
