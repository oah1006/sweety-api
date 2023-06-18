<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->unsignedBigInteger('code')->unique()->primary();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('full_name')->nullable();
            $table->string('full_name_en')->nullable();
            $table->string('code_name')->nullable();
            $table->unsignedBigInteger('province_code');
            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreignId('administrative_unit_id')->nullable()->constrained('administrative_units');
            $table->fullText(['name', 'full_name']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
};
