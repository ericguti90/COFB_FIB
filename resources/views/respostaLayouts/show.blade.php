@extends('layouts.masterCOFB')

@section('titulo') Respostes de {{$usuari}} @stop

@section('menu')
<h1>Respostes</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/votacions/{{$idVotacio}}">Veure votació</a></li>
    <li><a href="/assistents/{{$idAssistent}}">Veure assistent</a></li>
    <li class="selected"><a href="/votacions/{{$idVotacio}}/assistents/{{$idAssistent}}">Veure respostes</a></li>
    <li><a href="/esdeveniments/{{$idEsdeveniment}}/assistents/{{$idAssistent}}/edit">Editar assistent</a></li>

</ul>
@stop

@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	function verificar() {
		confirmar=confirm("Si acceptes , s'eliminarà l'assistent de la votació. Estàs segur?"); 
		if (confirmar) {
			$.ajax({
	      		url: '/votacions/{{$idVotacio}}/assistents/{{$idAssistent}}',
	      		type: "delete",
	      		success: function(data){
	      			window.location.replace('/votacions/{{$idVotacio}}');
	      	  }
        	});
		}
	};
</script>
<div class="caja-gris paso" style="border-radius: 14px;">
	@if($result == "[]")
	<div class="user-menu"><a onclick="verificar()" class="cierre" style="float:right;"></a></div>
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