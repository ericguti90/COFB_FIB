<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Assistent;

class AssistentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>Assistent::all()], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $assistent=Assistent::find($id);
 
        // Si no existe ese assistent devolvemos un error.
        if (!$assistent)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un assistent con ese código.'])],404);
        }
 
        return response()->json(['status'=>'ok','data'=>$assistent],200);
    }
}
