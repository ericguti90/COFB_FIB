<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PreguntesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titol');
            $table->string('opcions');
            $table->boolean('obligatoria');

            //protected $fillable = array('votacio_id','titol','opcions','obligatoria');
            // Añadimos la clave foránea con Votacio. votacio_id
            $table->integer('votacio_id')->unsigned();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('votacio_id')->references('id')->on('votacions');
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
        Schema::drop('preguntes');
    }
}
