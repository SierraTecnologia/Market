<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'productables', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('product_id')->nullable();
                // $table->foreign('product_id')->references('id')->on('products');
                $table->unsignedInteger('productable_id');
                $table->string('productable_type');
                $table->float('price')->nullable();
                $table->float('real_price')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productables');
    }
}
