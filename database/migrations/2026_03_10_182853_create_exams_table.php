<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('year_id'); // Links to academic_years
            $table->string('name'); // e.g., Mid-Term Exam 2026
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:Inactive');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('year_id')->references('id')->on('academic_years')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
