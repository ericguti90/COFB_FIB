<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VotacioAssistentsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votacioAssistents', function (Blueprint $table) {
            $table->increments('id');
            // Añadimos la clave foránea con Votacio. votacio_id
            $table->integer('assistent_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('assistent_id')->references('id')->on('assistents');
            // Añadimos la clave foránea con Votacio. votacio_id
            $table->integer('votacio_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('votacio_id')->references('id')->on('votacions');
            $table->timestamps();
            $table->unique(array('assistent_id','votacio_id'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('votacioAssistents');
    }
}
