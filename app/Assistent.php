<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assistent extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table='assistents';
 
	// Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
	// Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
	//protected $primaryKey = 'serie';
 
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('esdeveniment_id','usuari','assistit','dataHora','delegat');
 
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
 
 
	// Relación de Assistent con Esdeveniment:
	public function esdeveniment()
	{
		// 1 Assistent pertenece a un Esdeveniment.
		// $this hace referencia al objeto que tengamos en ese momento de Assistent.
		return $this->belongsTo('App\Esdeveniment');
	}
}