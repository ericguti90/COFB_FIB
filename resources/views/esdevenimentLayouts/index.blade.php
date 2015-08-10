@extends('layouts.masterCOFB')
 
@section('titulo') Llistat d'esdeveniments @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop



@section('contenido')

@if($esd)
<?php date_default_timezone_set('Europe/Madrid');
?>

<ul>
	@foreach($esd as $item)
	<div class="paso">
		<?php 
			$now = time();
			$diff =  strtotime($item->dataHora) - $now;
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		?>
		@if($diff<0) <h5 class="dos">{{$item->titol}}</h5>
		@elseif ($diff <= (60*60*24*5)) <h5 class="uno">{{$item->titol}}</h5>
		@else <h5 class="tres">{{$item->titol}}</h5>
		@endif
			<div style="float:left;">			
			<p><b>Data i hora:</b>   {{$item->dataHora}}@if($diff>0)   <i>(falten: {{$months}} mesos i {{$days}} dies)@endif</i></p>
			<p><b>Lloc:</b>   {{$item->lloc}}</p>
			@if($item->inscripcioOberta == 1)
			<p><b>Inscripció oberta:</b>   Sí</p>
			@else
			<p><b>Inscripció oberta:</b>   No</p>
			@endif
			@if($item->presencial == 1)
			<p><b>Presencial:</b>   Sí</p>
			<p><b>Número d'assistents:</b>   {{$item->num}}</p>
			@else
			<p><b>Presencial:</b>   No</p>
			<p><b>Nombre de participants:</b>   {{$item->num}}</p>
			@endif
			
			</div>
			<div style="padding-top: 60px; float: right;"><a class="btn btn-naranja ver_mas" href="/esdeveniments/{{$item->id}}">VEURE MÉS</a></div>
	</div>
@endforeach
</ul>
@endif
@if($esd->lastPage()>1)
<section class="pag-revistas clearfix">
	<h3 class="left">Mostrar</h3>
	
	<ul class="paginador-results numerico right">
		<li style="display: inline-block;"><a href="/esdeveniments?page=1">Primera</a></li>
		@for($i=1;$i<=$esd->lastPage();++$i)
		<li style="display: inline-block;"><a href="/esdeveniments?page={{$i}}">{{$i}}</a></li>
		@endfor
		<li style="display: inline-block;"><a href="/esdeveniments?page={{$esd->lastPage()}}">última</a></li>
	</ul>
</section>
@endif

@stop 

