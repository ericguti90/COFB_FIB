<?php namespace App\Http\Controllers;
use Auth;
use Redirect;
use Request;
use Input;
 
class AjaxController extends Controller {
 
 
	// Al recibir los datos del formulario de Login.
	public function postEsdeveniment()
	{
		$input = Input::all();

		if(array_get($input, 'lloc') == "") print_r("buit");die;
		print_r($input);die;
		$credenciales=array(
				'username'=>Request::input('username'),
				'password'=>Request::input('password')
				);
		// Getting all post data
    	if(Request::ajax()) {
	      	//$data = Input::all();
      		if (Auth::attempt($credenciales,1)) {

      			print_r('success');
      			//die;
      		}
			else {print_r('error');}
    		//print_r('error');die;
      		//if(array_get($data, 'username') === "ericguti") print_r(array_get($data, 'username'));
      		//else print_r(array_get($data, 'password'));
      		//print_r($data);die;     			
      	}
	}
}