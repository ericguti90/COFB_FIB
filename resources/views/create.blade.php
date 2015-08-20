@extends('layouts.masterCOFB')

@section('titulo') Editar esdeveniment @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop


@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
function hello(){
	alert("hello");
};
</script>
@foreach($errors->all() as $error)
<p>{{$error}}</p>
@endforeach
 
<form method="POST" action="/users">
	<p><label for="username">Usuario*: <input type="text" name="username" value="{{ Input::old('username') }}"/></label></p>
	<p><label for="password">Contraseña*:<input type="password" name="password" value="{{ Input::old('password') }}"/></label></p>
	<p><label for="password-repeat">Repita Contraseña*:<input type="password" name="password-repeat" value="{{ Input::old('password-repeat') }}"/></label></p>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	<button class="btn btn-naranja" onclick="hello()">CONTINUAR</button>
</form>

@stop
