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

class PreguntaRespostaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($idVotacio, $idPregunta)
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

        $pregunta=$votacio->preguntes()->find($idPregunta);
        if (! $pregunta)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra una pregunta con ese código.'])],404);
        }
        return response()->json(['status'=>'ok','data'=>$pregunta->respostes()->get()],200);
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
    public function store(Request $request, $idVotacio, $idPregunta)
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
