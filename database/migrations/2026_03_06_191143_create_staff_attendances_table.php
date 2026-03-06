<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('teacher_id');
            $table->date('attendance_date');
            $table->tinyInteger('status')->comment('1:Present, 2:Absent, 3:Leave');
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();

            // Prevent duplicate attendance for the same staff on the same day
            $table->unique(['tenant_id', 'teacher_id', 'attendance_date'], 'unique_staff_attendance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_attendances');
    }
};
