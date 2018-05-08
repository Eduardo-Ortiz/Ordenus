<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->boolean('multiple');
            $table->boolean('touch');
            $table->integer('icon_id')->unsigned();
            $table->foreign('icon_id')->references('id')
                ->on('icons')->onDelete('cascade');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')
                ->on('areas')->onDelete('cascade');
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
        Schema::dropIfExists('areas');
    }
}
