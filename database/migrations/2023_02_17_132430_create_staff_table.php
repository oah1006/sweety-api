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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('phone_number')->unique();
            $table->string('address')->index();
            $table->fullText(['first_name', 'last_name', 'phone_number', 'address']);
            $table->enum('position', ['employee', 'manager']);
            $table->enum('status', ['active', 'disable']);
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
        Schema::dropIfExists('staff');
    }
};
