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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sale_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->foreignId('delivery_staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->unsignedBigInteger('total')->default(0)->index();
            $table->unsignedBigInteger('sub_total')->default(0)->index();
            $table->unsignedBigInteger('shipping_fee')->default(20000)->index();
            $table->enum('status', ['pending', 'canceled', 'accepted', 'preparing', 'prepared', 'delivering', 'succeed' ,'failed'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
};
