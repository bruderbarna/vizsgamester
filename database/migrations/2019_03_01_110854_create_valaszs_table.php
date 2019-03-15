<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValaszsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valaszs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vizsgazas_id')->unsigned();
            $table->foreign('vizsgazas_id')->references('id')->on('vizsgazas');
            $table->integer('kerdes_id')->unsigned();
            $table->foreign('kerdes_id')->references('id')->on('kerdes');
            $table->integer('valasz_lehetoseg_id')->unsigned();
            $table->foreign('valasz_lehetoseg_id')->references('id')->on('valasz_lehetosegs');
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
        Schema::dropIfExists('valaszs');
    }
}
