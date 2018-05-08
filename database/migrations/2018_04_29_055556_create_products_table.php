<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->boolean('recipe');
            $table->boolean('enabled');
            $table->double('price','10','2');
            $table->double('time','8')->nullable();
            $table->integer('menu_category_id')->unsigned()->index();
            $table->foreign('menu_category_id')->references('id')
                ->on('menu_categories')->onDelete('cascade');
            $table->integer('schedule_id')->nullable()->unsigned()->index();
            $table->foreign('schedule_id')->references('id')
                ->on('schedules')->onDelete('cascade');

            $table->integer('supply_id')->nullable()->unsigned()->index();
            $table->foreign('supply_id')->references('id')
                ->on('supplies')->onDelete('cascade');
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
}
