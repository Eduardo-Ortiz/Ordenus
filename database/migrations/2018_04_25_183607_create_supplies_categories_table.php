<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplies_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('fullname');
            $table->integer('icon_id')->unsigned()->index();
            $table->foreign('icon_id')->references('id')
                ->on('icons')->onDelete('cascade');
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->foreign('parent_id')->references('id')
                ->on('supplies_categories')->onDelete('cascade');
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
        Schema::dropIfExists('supplies_categories');
    }
}
