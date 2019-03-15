<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKerdesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerdes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('kerdesszam')->unsigned();
            $table->integer('vizsga_id')->unsigned();
            $table->foreign('vizsga_id')->references('id')->on('vizsgas');
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
        Schema::dropIfExists('kerdes');
    }
}
