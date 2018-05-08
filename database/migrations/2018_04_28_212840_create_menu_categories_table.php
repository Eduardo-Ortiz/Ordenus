<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('fullname');
            $table->integer('schedule_id')->nullable()->unsigned()->index();
            $table->foreign('schedule_id')->references('id')
                ->on('schedules')->onDelete('cascade');
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->foreign('parent_id')->references('id')
                ->on('menu_categories')->onDelete('cascade');
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
        Schema::dropIfExists('menu_categories');
    }
}
