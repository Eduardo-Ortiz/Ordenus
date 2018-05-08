<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_supply', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');

            $table->integer('supply_id')->unsigned();
            $table->foreign('supply_id')->references('id')
                ->on('supplies')->onDelete('cascade');

            $table->boolean('extra');
            $table->boolean('removable');
            $table->integer('quantity');

            $table->integer('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')
                ->on('units')->onDelete('cascade');

            $table->double('extra_price','10','2')->nullable();
            $table->double('extra_quantity','10','2')->nullable();

            $table->integer('extra_unit')->unsigned()->nullable();
            $table->foreign('extra_unit')->references('id')
                ->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_supply');
    }
}
