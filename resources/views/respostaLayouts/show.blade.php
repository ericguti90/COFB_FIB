@extends('layouts.masterCOFB')

@section('titulo') Respostes de {{$usuari}} @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop

@section('contenido')
<div class="caja-gris paso" style="border-radius: 14px;">
	@if($result == "[]")
	<h5 class="dos">{{$votacio}}</h5>
	@elseif($total)
	<h5 class="tres">{{$votacio}}</h5>
	@else
	<h5 class="uno">{{$votacio}}</h5>
	@endif
	<ul class="lista-enlaces">
	@if($result != "[]")
		@foreach ($result as $res)
			<li><a>{{$res->pregunta}}</a>
				<ul>
					<li><a>{{$res->resposta}}</a></li>
				</ul>
			</li>	
		@endforeach
	@else
		<li><a>{{$usuari}} encara no ha fet la votació d'aquest esdeveniment.</a></li>
	@endif
	</ul>
</div>
@stop