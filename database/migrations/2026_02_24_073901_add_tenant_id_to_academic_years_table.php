<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            // Adding tenant_id. Using nullable() just in case you already have dummy data in the table!
            $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });
    }
};
