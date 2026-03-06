<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('student_id'); // From student_registers
            $table->date('attendance_date');
            $table->tinyInteger('status')->comment('1:Present, 2:Absent, 3:Late, 4:Leave');
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('student_registers')->cascadeOnDelete();

            // Prevent duplicate attendance for the same student on the same day
            $table->unique(['tenant_id', 'student_id', 'attendance_date'], 'unique_student_attendance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
