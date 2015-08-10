@extends('layouts.masterCOFB')
 
@section('titulo') Titulo de la pagina @stop

@section('contenido')

@if($esd)
<ul>
	@foreach($esd as $item)
	<div class="paso">
		<h5 class="tres">{{$item->titol}}</h5>
			<div style="float:left;">
			<p><b>Data i hora:</b>   {{$item->dataHora}}</p>
			<p><b>Lloc:</b>   {{$item->lloc}}</p>
			@if($item->inscripcioOberta == 1)
			<p><b>Inscripció oberta:</b>   Sí</p>
			@else
			<p><b>Inscripció oberta:</b>   No</p>
			@endif
			<p><b>Número d'assistents:</b>   {{$item->num}}</p>
			</div>
			<div style="padding-top: 36px;"><a class="btn btn-naranja ver_mas" href="#">VER MÁS</a></div>
	</div>
@endforeach
</ul>
@endif

@stop 