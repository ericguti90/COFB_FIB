<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RespostesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resposta');
            $table->dateTime('dataHora');

            //protected $fillable = array('votacio_id','pregunta_id','usuari_id','resposta','dataHora');
            // Añadimos la clave foránea con Votacio. votacio_id
            $table->integer('votacio_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('votacio_id')->references('id')->on('votacions');

            // Añadimos la clave foránea con Pregunta. pregunta_id
            $table->integer('pregunta_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('pregunta_id')->references('id')->on('preguntes');

            // Añadimos la clave foránea con Esdeveniment. esdeveniment_id
            $table->string('usuari_id');
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('usuari_id')->references('usuari')->on('assistents');

            $table->timestamps();
            $table->unique(array('usuari_id','votacio_id','pregunta_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('respostes');
    }
}
