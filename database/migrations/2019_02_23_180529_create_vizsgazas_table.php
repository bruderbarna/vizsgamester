<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVizsgazasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vizsgazas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vizsga_id')->unsigned();
            $table->foreign('vizsga_id')->references('id')->on('vizsgas');
            $table->integer('current_kerdes');
            $table->boolean('vegzett')->default(0);
            $table->string('vizsga_secret')->unique();
            $table->string('name');
            $table->string('neptun');
            $table->dateTime('kezdet');
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
        Schema::dropIfExists('vizsgazas');
    }
}
