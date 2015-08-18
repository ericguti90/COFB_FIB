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
<section class="listado-contenidos relative">
	<h5 class="celeste-oscuro">Respostes a la pregunta</h5>
	<div class="absolute pag-flechas">	
		<a onclick="list(-1,{{$respostes->lastPage()}})" class="pag-izq-celeste left"></a>
		<a onCLick="list(1, {{$respostes->lastPage()}})" class="pag-der-celeste left"></a>
	</div>	
	<ul class="lc-list">
		@foreach ($respostes as $res)
		<li>
			<a>
				<p><span class="fecha">{{$res->dataHora}}</span></p>
				<p>{{$res->resposta}}. <b>{{$res->usuari_id}}</b></p>	
			</a>	 
		</li>
		@endforeach
	</ul>
</section>



@if($respostes->lastPage()>1)
<section class="pag-revistas clearfix">
	<h3 class="left">Mostrar</h3>
	
	<ul class="paginador-results numerico right">
		<li style="display: inline-block;"><a href="?page=1">Primera</a></li>
		@for($i=1;$i<=$respostes->lastPage();++$i)
		<li style="display: inline-block;"><a href="?page={{$i}}">{{$i}}</a></li>
		@endfor
		<li style="display: inline-block;"><a href="?page={{$respostes->lastPage()}}">última</a></li>
	</ul>
</section>
@endif

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
	var posActual = 1;
	function list(pos, max) {
		alert(posActual);
		posActual += pos;
		alert(posActual);
		alert(max);
		if(posActual<1) posActual = max;
		else if(posActual > max) posActual = 1;
		window.location.replace("?page=".concat(posActual));
	}
</script>
@stop



