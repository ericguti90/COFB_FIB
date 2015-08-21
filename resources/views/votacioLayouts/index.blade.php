@extends('layouts.masterCOFB')
 
@section('titulo') Llistat de votacions @stop

@section('menu')
<h1>Votacions</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="/votacions">Llistat de votacions</a></li>
    <li><a href="/votacions/create">Crear nova votació</a></li>
</ul>
@stop



@section('contenido')

@if($vota)
<?php date_default_timezone_set('Europe/Madrid');
?>

<ul>
	@foreach($vota as $item)
	<div class="paso">
		<?php 
			$now = time();
			$diff =  strtotime($item->dataHoraIni) - $now;
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = ceil(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$diff2 =  strtotime($item->dataHoraFin) - $now;
			$years2 = floor($diff / (365*60*60*24));
			$months2 = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days2 = ceil(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		?>
		@if($diff>0 || $diff2<0) <h5 class="dos">{{$item->titol}}</h5>
		@elseif ($diff2 <= (60*60*24*5)) <h5 class="uno">{{$item->titol}}</h5>
		@else <h5 class="tres">{{$item->titol}}</h5>
		@endif
			<div style="float:left;">			
			<p><b>Esdeveniment:</b>   {{$item->esd->titol}}
			<p><b>Data i hora inici:</b>   {{$item->dataHoraIni}}@if($diff>0)   <i>(falten: {{$months}} mesos i {{$days}} dies)@endif</i></p>
			<p><b>Data i hora fin:</b>   {{$item->dataHoraIni}}@if($diff2>0 && $diff<0)   <i>(falten: {{$months}} mesos i {{$days}} dies)@endif</i></p>
			<p><b>Nombre de participants:</b>   {{$item->ass}}</p>
			</div>
			<div style="padding-top: 60px; float: right;"><a class="btn btn-naranja ver_mas" href="/votacions/{{$item->id}}">VEURE MÉS</a></div>
	</div>
@endforeach
</ul>
@endif
@if($vota->lastPage()>1)
<section class="pag-revistas clearfix">
	<h3 class="left">Mostrar</h3>
	
	<ul class="paginador-results numerico right">
		<li style="display: inline-block;"><a href="/votacions?page=1">Primera</a></li>
		@for($i=1;$i<=$vota->lastPage();++$i)
		<li style="display: inline-block;"><a href="/votacions?page={{$i}}">{{$i}}</a></li>
		@endfor
		<li style="display: inline-block;"><a href="/votacions?page={{$vota->lastPage()}}">última</a></li>
	</ul>
</section>
@endif


@stop 