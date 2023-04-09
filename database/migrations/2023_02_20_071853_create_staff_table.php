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
            $table->string('code')->unique()->nullable();
            $table->string('full_name');
            $table->boolean('is_active')->default(true);
            $table->enum('role', ['administrator', 'manager', 'employee', 'shipper'])->default('employee');
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->fullText('full_name');
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
