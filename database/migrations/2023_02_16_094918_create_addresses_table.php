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
            $table->unsignedBigInteger('ward_code');
            $table->unsignedBigInteger('district_code');
            $table->unsignedBigInteger('province_code');
            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreign('district_code')->references('code')->on('districts');
            $table->foreign('ward_code')->references('code')->on('wards');
            $table->float('long', 8, 5)->nullable();
            $table->float('lat', 8, 5)->nullable();
            $table->string('name')->nullable();
            $table->json('meta')->nullable();
            $table->string('phone_number')->nullable();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->fullText(['street_number', 'street']);
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
