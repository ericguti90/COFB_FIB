@extends('layouts.masterCOFB')

@section('titulo') {{$votacio->titol}} @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop

@section('contenido')
<section class="noticias">
<h3 class="titulo-contenido left no-bottom" style="width:100%;">{{$pregunta->titol}}</h3>
</section>
&nbsp;
@if(!$respostes->isEmpty())
<section class="listado-contenidos relative">
	<h5 class="celeste-oscuro titulo-icono premsa">Respostes a la pregunta</h5>
@else
<section class="lc-naranja listado-contenidos">
	<h5 class="orange titulo-icono legislacio"> <div class="user-menu"><a onclick="verificarPregunta({{$pregunta->id}})" class="cierre" style="float:right; margin: -2px -55px 2px 0;"></a></div>Respostes a la pregunta </h5>
@endif
	@if($respostes->lastPage()>1)
	<div class="absolute pag-flechas">	
		<a onclick="list(-1,{{$respostes->lastPage()}})" class="pag-izq-celeste left"></a>
		<a onCLick="list(1, {{$respostes->lastPage()}})" class="pag-der-celeste left"></a>
	</div>	
	@endif

	<ul class="lc-list">
		@forelse ($respostes as $res)
		<li>
		<div class="user-menu"><a onclick="verificar({{$res->id}})" class="cierre" style="float:right; margin-top: 12px;"></a></div>
			<a>
				<p><span class="fecha">{{$res->dataHora}}</span></p>
				<p>{{$res->resposta}}. <i><b>{{$res->usuari_id}}</b></i></p>	
			</a>	 
		</li>
		@empty
		<li>
			<a>
				<p><span class="naranja">Encara no hi ha cap resposta per aquesta pregunta.</span></p>	
			</a>	 
		</li>
		@endforelse
	</ul>
</section>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	var posActual = {{$respostes->currentPage()}};
	function list(pos, max) {
		posActual += pos;
		if(posActual<1) posActual = max;
		else if(posActual > max) posActual = 1;
		window.location.replace("?page=".concat(posActual));
	}

	function verificar(id) {
		confirmar=confirm("Si acceptes, s'esborrarà la resposta. Estàs segur?"); 
		if (confirmar) {
			$.ajax({
	      		url: '/votacions/'+ {{$votacio->id}} + '/preguntes/' + {{$pregunta->id}} + '/respostes/' + id,
	      		type: "delete",
	      		success: function(data){
	      			window.location.replace('/votacions/'+ {{$votacio->id}} + '/preguntes/' + {{$pregunta->id}} + '/respostes');
	      	  }
        	});
		}
	};
	function verificarPregunta(id) {
		confirmar=confirm("Si acceptes, s'esborrarà la pregunta. Estàs segur?"); 
		if (confirmar) {
			$.ajax({
	      		url: '/votacions/'+ {{$votacio->id}} + '/preguntes/' + id,
	      		type: "delete",
	      		success: function(data){
	      			window.location.replace('/votacions/'+ {{$votacio->id}});
	      	  }
        	});
		}
	};
</script>
@stop




