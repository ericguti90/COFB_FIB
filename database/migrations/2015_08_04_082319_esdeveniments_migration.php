<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EsdevenimentsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('esdeveniments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titol')->unique();
            $table->dateTime('dataHora');
            $table->string('lloc');
            $table->boolean('inscripcioOberta');
            $table->boolean('presencial');


            //protected $fillable = array('titol','dataHora','lloc','inscripcioOberta');
            // Para que también cree automáticamente los campos timestamps (created_at, updated_at)
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
        Schema::drop('esdeveniments');
    }
}
