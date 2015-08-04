<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssistentsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usuari');
            $table->boolean('assistit');
            $table->dateTime('dataHora');
            $table->boolean('delegat');

            //protected $fillable = array('esdeveniment_id','usuari','assistit','dataHora','delegat');
            // Añadimos la clave foránea con Esdeveniment. esdeveniment_id
            $table->integer('esdeveniment_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('esdeveniment_id')->references('id')->on('esdeveniments');
            $table->timestamps();
            $table->unique(array('usuari','esdeveniment_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assistents');
    }
}
