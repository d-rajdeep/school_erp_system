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
        Schema::create('student_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')
                ->constrained('schools')
                ->cascadeOnDelete();
            $table->string('student_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password')->nullable();
            $table->longText('address')->nullable();
            $table->char('gender', 1)->comment('1:male, 2:female, 3:other')->nullable();
            $table->string('profile')->nullable();
            $table->string('fname')->nullable()->comment('father name');
            $table->string('mname')->nullable()->comment('mother name');
            $table->string('religion')->nullable();
            $table->string('dob')->nullable()->comment('date of birth');
            $table->string('register_date')->nullable();
            $table->string('year')->nullable();
            // $table->string('slno')->nullable();
            $table->string('transport')->nullable();
            $table->char('status')->comment('1:active,2:de-active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registers');
    }
};
