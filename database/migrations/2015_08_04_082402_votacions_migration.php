<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VotacionsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votacions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titol');
            $table->dateTime('dataHoraIni');
            $table->dateTime('dataHoraFin');

            //protected $fillable = array('titol','esdeveniment_id','dataHoraIni','dataHoraFin');
            // Añadimos la clave foránea con Esdeveniment. esdeveniment_id
            $table->integer('esdeveniment_id')->unsigned()->nullable();
 
            // Indicamos cual es la clave foránea de esta tabla:
            $table->foreign('esdeveniment_id')->references('id')->on('esdeveniments');
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
        Schema::drop('votacions');
    }
}
