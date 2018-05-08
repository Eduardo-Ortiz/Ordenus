<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('stock')->default(0);

            $table->integer('unit_id')->unsigned()->index();
            $table->foreign('unit_id')->references('id')
                ->on('units')->onDelete('cascade');
            $table->integer('supplies_category_id')->unsigned()->index();
            $table->foreign('supplies_category_id')->references('id')
                ->on('supplies_categories')->onDelete('cascade');
            $table->boolean('ingredient');
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
        Schema::dropIfExists('supplies');
    }
}
