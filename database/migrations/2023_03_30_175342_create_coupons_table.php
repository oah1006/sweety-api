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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('name')->unique();
            $table->string('description');
            $table->unsignedBigInteger('stock')->default(0)->index();
            $table->unsignedBigInteger('is_percent_value');
            $table->unsignedBigInteger('min_order_total');
            $table->unsignedBigInteger('points')->default(0);
            $table->enum('status', ['active', 'expired', 'deactivate'])->default('active');
            $table->date('started_at');
            $table->date('expired_at');
            $table->boolean('is_deleted')->default(0);
            $table->fullText(['name', 'description']);
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
        Schema::dropIfExists('coupons');
    }
};
