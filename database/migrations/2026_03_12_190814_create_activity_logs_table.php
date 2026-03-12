<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('user_id'); // Who performed the action
            $table->string('module'); // e.g., 'Fee Management', 'Student Admission'
            $table->string('action'); // e.g., 'Created', 'Updated', 'Deleted'
            $table->text('description'); // e.g., 'Collected ₹500 fee for Student SCH0001'
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
