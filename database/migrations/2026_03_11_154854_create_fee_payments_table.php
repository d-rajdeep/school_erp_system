<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('fee_type_id');
            $table->decimal('paid_amount', 10, 2);
            $table->date('payment_date');
            $table->string('payment_method')->default('Cash'); // Cash, Cheque, Online Transfer
            $table->string('receipt_number')->unique();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('student_registers')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
