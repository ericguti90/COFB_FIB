<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Votacio extends Model
{
    protected $table='votacions';
 
	// Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
	// Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
	//protected $primaryKey = 'serie';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('titol','esdeveniment_id','dataHoraIni','dataHoraFin');
 
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at']; 
 
	// Definimos a continuación la relación de esta tabla con otras.
	// Ejemplos de relaciones:
	// 1 usuario tiene 1 teléfono   ->hasOne()
	// 1 teléfono pertenece a 1 usuario   ->belongsTo()
	// 1 post tiene muchos comentarios  -> hasMany()
	// 1 comentario pertenece a 1 post ->belongsTo()
	// 1 usuario puede tener muchos roles  ->belongsToMany()
	//  etc..
 
 
	// Relación de Votació con Esdeveniment:
	public function esdeveniments()
	{
		// 1 Votació tiene 0..1 Esdeveniment
		// $this hace referencia al objeto que tengamos en ese momento de Votacio.
		return $this->belongsTo('App\Esdeveniment');
	}

	// Relación de Votacio con Pregunta:
	public function preguntes()
	{
		// 1 Votacio tiene muchas preguntes
		// $this hace referencia al objeto que tengamos en ese momento de Votacio.
		return $this->hasMany('App\Pregunta');
	}

	// Relación de Votacio con Resposta:
	public function respostes()
	{
		// 1 Votacio tiene muchas respostes
		// $this hace referencia al objeto que tengamos en ese momento de Votacio.
		return $this->hasMany('App\Resposta');
	}
}
