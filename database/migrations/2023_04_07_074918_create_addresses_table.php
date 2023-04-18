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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street_number');
            $table->string('street');
            $table->string('ward_code');
            $table->string('district_code');
            $table->string('province_code');
            $table->string('long');
            $table->string('lat');
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->boolean('is_default')->default(1);
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->fullText(['name']);
            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreign('district_code')->references('code')->on('districts');
            $table->foreign('ward_code')->references('code')->on('wards');
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
        Schema::dropIfExists('addresses');
    }
};
