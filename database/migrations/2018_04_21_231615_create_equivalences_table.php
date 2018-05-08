<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquivalencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equivalences', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();

            $table->integer('from_id')->unsigned()->index();
            $table->foreign('from_id')->references('id')
                ->on('units')->onDelete('cascade');

            $table->integer('to_id')->unsigned()->index();
            $table->foreign('to_id')->references('id')
                ->on('units')->onDelete('cascade');

            $table->double('ratio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equivalences');
    }
}
