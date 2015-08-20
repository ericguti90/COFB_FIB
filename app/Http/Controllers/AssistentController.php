<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Assistent;
use Auth;
use Redirect;

class AssistentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api') {
            return response()->json(['status'=>'ok','data'=>Assistent::all()], 200);
        }
        else{
            //return Assistent::distinct()->select('usuari')->groupBy('usuari')->get();
            if (!Auth::check()) return Redirect::to('login');
            $assistents = Assistent::select('usuari')->distinct('usuari')->paginate(5);
            foreach ($assistents as $ass) {
                $ass->esd = Assistent::where('usuari','=',$ass->usuari)->count();
                $ass->assistit = Assistent::where('usuari','=',$ass->usuari)->where('assistit','=',true)->count();
                $ass->id = Assistent::select('id')->where('usuari','=',$ass->usuari)->first();
            }
            return view('assistentLayouts.indexAll')->with('ass', $assistents);
        }
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
        if ($this->getRouter()->getCurrentRoute()->getPrefix() == '/api') {
            // Si no existe ese assistent devolvemos un error.
            if (!$assistent)
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
                // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
                return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un assistent con ese código.'])],404);
            }
     
            return response()->json(['status'=>'ok','data'=>$assistent],200);
        }
        else {
            if (!Auth::check()) return Redirect::to('login');
            $assistents = Assistent::where('usuari','=',$assistent->usuari)->paginate(5);
            foreach ($assistents as $ass) {
                $ass->esd = $ass->esdeveniment()->select('titol','id')->first();
                $votacions = $ass->votacions()->get();
                $aux = array();
                foreach ($votacions as $vota) {
                    array_push($aux, $vota->votacio()->select('titol','id')->first());
                }
                $ass->vota = $aux;

            }
            return view('assistentLayouts.show')->with("ass", $assistents)->with("usuari",$assistent->usuari);
        }
    }
}
