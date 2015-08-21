@extends('layouts.masterCOFB')

@section('titulo') Llistat d'usuaris @stop

@section('menu')
<h1>Usuaris</h1> <!-- Titulo de la home seleccionada -->
@stop


@section('contenido')
<div class="column-cajas" style="width:100%;">
@foreach($users as $user)
	<div class="caja-gris" >
		<p style="text-align: center;"><a>{{$user->username}}@cofb.net</a></p>
	</div>
@endforeach
</div>
@stop