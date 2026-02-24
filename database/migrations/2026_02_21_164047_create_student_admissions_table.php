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
        Schema::create('student_admissions', function (Blueprint $table) {
            $table->id();

            // Core Relationships
            // Assuming your tables are named 'student_registers', 'classes', 'sections', 'academic_years'
            $table->foreignId('student_id')->constrained('student_registers')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('year_id')->constrained('academic_years')->cascadeOnDelete();

            // Multi-tenant ERP requirement
            $table->unsignedBigInteger('tenant_id');

            // Admission Specific Data
            $table->string('admission_no')->nullable(); // e.g., ADM-2026-001
            $table->date('admission_date');
            $table->string('roll_number')->nullable(); // Roll number in that specific class/section
            $table->char('fees_pay', 1)->comment('0:not_paid, 1:paid')->default(0);

            // Status: 1 = Active/Admitted, 2 = Left/Passed Out, 0 = Suspended
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_admissions');
    }
};
