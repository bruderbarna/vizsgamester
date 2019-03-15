<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValaszLehetosegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valasz_lehetosegs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('helyes');
            $table->integer('kerdes_id')->unsigned();
            $table->foreign('kerdes_id')->references('id')->on('kerdes');
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
        Schema::dropIfExists('valasz_lehetosegs');
    }
}
