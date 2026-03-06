<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name'); // e.g., Mathematics
            $table->string('code')->nullable(); // e.g., MATH-101
            $table->tinyInteger('type')->default(1)->comment('1:Theory, 2:Practical');
            $table->tinyInteger('status')->default(1)->comment('1:Active, 0:De-active');
            $table->timestamps();

            // Linking to the 'schools' table based on your previous SQL dump structure
            $table->foreign('tenant_id')
                ->references('id')
                ->on('schools')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
