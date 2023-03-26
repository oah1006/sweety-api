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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->index();
            $table->unsignedBigInteger('stock')->default(0)->index();
            $table->unsignedBigInteger('price')->default(0)->index();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('published')->default(false)->index();
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
        Schema::dropIfExists('products');
    }
};
