<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Necesitaremos el modelo Fabricante para ciertas tareas.
use App\Votacio;

// Necesitamos la clase Response para crear la respuesta especial con la cabecera de localización en el método Store()
use Response;
use DateTime;

class VotacioPreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($idVotacio)
    {
        // Devolverá todos las preguntas.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $votacio=Votacio::find($idVotacio);
 
        if (! $votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un votacio con ese código.'])],404);
        }
 
        return response()->json(['status'=>'ok','data'=>$votacio->preguntes()->get()],200);
        //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $idVotacio)
    {
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if ( !$request->input('titol') || !$request->input('obligatoria'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }
 
        // Buscamos la Votacio.
        $votacio= Votacio::find($idVotacio);
 
        // Si no existe la votacio que le hemos pasado mostramos otro código de error de no encontrado.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }
        
        //control de los booleanos (v1, en la v2 ira fuera)
        if ($request->input('obligatoria') == "true") $request->merge(array('obligatoria' => true));
        else $request->merge(array('obligatoria' => false));

        // Si la votacio existe entonces lo almacenamos.
        // Insertamos una fila en Preguntes con create pasándole todos los datos recibidos.
        $novaPregunta=$votacio->preguntes()->create($request->all());
 
        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        $response = Response::make(json_encode(['data'=>$novaPregunta]), 201)->header('Location', 'http://www.dominio.local/preguntas/'.$novaPregunta->id)->header('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($idVotacio, $idPregunta)
    {
        // Devolverá todos los assistents.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $votacio=Votacio::find($idVotacio);
 
        if (! $votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }
        $pregunta = $votacio->preguntes()->find($idPregunta);
        if (! $pregunta){
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','data'=>$pregunta],200);
        //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $idVotacio, $idPregunta)
    {
        // Comprobamos si la votacio que nos están pasando existe o no.
        $votacio=Votacio::find($idVotacio);
 
        // Si no existe ese votacio devolvemos un error.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }       
 
        // El votacio existe entonces buscamos el pregunta que queremos editar asociado a ese votacio.
        $pregunta = $votacio->preguntes()->find($idPregunta);
 
        // Si no existe ese pregunta devolvemos un error.
        if (!$pregunta)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código asociado al esdeveniment.'])],404);
        }   
 
 
        // Listado de campos recibidos teóricamente.
        $titol=$request->input('titol');
        $opcions=null;
        if ($request->has('opcions')){
            if($request->input('opcions') == "") $opcions = "null";
            else $opcions=$request->input('opcions');
        }
        if ($request->input('obligatoria') == "true") $obligatoria=true;
        else $obligatoria = false;
         
        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;
 
            // Actualización parcial de campos.
            if ($titol)
            {
                $pregunta->titol = $titol;
                $bandera=true;
            }
 
            if ($opcions)
            {
                if($opcions == "null") $pregunta->opcions = null;
                else $pregunta->opcions = $opcions;
                $bandera=true;
            }
 
            if ($obligatoria)
            {
                $pregunta->obligatoria = $obligatoria;
                $bandera=true;
            }
 
            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $pregunta->save();
                return response()->json(['status'=>'ok','data'=>$pregunta], 200);
            }
            else
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de la pregunta.'])],304);
            }
 
        }
 
        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$titol || !$obligatoria)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
        }
 
        $pregunta->titol = $titol;
        $pregunta->obligatoria = $obligatoria;
        $pregunta->opcions = $opcions;
 
        // Almacenamos en la base de datos el registro.
        $pregunta->save();
 
        return response()->json(['status'=>'ok','data'=>$pregunta], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($idVotacio, $idPregunta)
    {
        // Comprobamos si la votacio que nos están pasando existe o no.
        $votacio=Votacio::find($idVotacio);
 
        // Si no existe ese esdevenimentd evolvemos un error.
        if (!$votacio)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una votacio con ese código.'])],404);
        }       
 
        // El votacio existe entonces buscamos el pregunta que queremos borrar asociado a ese votacio.
        $pregunta = $votacio->preguntes()->find($idPregunta);
 
        // Si no existe ese pregunta devolvemos un error.
        if (!$pregunta)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código asociado a ese esdeveniment.'])],404);
        }
 
        // Procedemos por lo tanto a eliminar el assistent.
        $pregunta->delete();
 
        // Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
        // Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
        return response()->json(['code'=>204,'message'=>'Se ha eliminado la pregunta correctamente.'],204);
    }
}
