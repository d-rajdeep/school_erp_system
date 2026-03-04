<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('employee_register_id')->nullable();
            $table->string('fullname');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->tinyInteger('gender')->nullable()->comment('1:Male, 2:Female, 3:Other');
            $table->string('profile')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('religion')->nullable();
            $table->date('dob')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('register_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:De-active');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
