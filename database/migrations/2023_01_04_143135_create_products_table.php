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
            $table->string('id_hash', 150)->nullable()->default('NULL');
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('price', 8, 2);
            $table->integer('quantity');
            $table->bigInteger('category_id')->unsigned()->default('1');
            $table->bigInteger('subcategory_id')->unsigned()->default('1');
            $table->string('status', 150)->default('1');
            $table->bigInteger('view')->default('0');
            $table->bigInteger('brand_id')->unsigned()->default('1');
            $table->timestamps();
            $table->softDeletes();
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
