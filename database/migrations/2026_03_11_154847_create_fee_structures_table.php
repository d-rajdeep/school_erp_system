<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('fee_type_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->cascadeOnDelete();

            // A class shouldn't have the exact same fee type assigned twice in the same year
            $table->unique(['tenant_id', 'year_id', 'class_id', 'fee_type_id'], 'unique_fee_structure');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
