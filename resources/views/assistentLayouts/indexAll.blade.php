@extends('layouts.masterCOFB')
 
@section('titulo') Llistat d'assistents @stop

@section('menu')
<h1>Assistents</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="/assistents">Llistat d'assistents</a></li>
</ul>
@stop



@section('contenido')

@if($ass)
<ul>
	@foreach($ass as $item)
	<div class="paso" style="height: 142px;">
		@if($item->assistit == 0) <h5 class="dos">{{$item->usuari}}</h5>
		@elseif ($item->assistit != $item->esd) <h5 class="uno">{{$item->usuari}}</h5>
		@else <h5 class="tres">{{$item->usuari}}</h5>
		@endif
			<div style="float:left;">			
			<p><b>Esdeveniment apuntats:</b>   {{$item->esd}}</p>
			<p><b>Esdeveniments assistits:</b>   {{$item->assistit}}</p>
			<p><b>percentatge d'assistència:</b> {{($item->assistit/$item->esd)*100}}%
			</div>
			<div style="padding-top: 13px; float: right;"><a class="btn btn-naranja ver_mas" href="/assistents/{{$item->id->id}}">VEURE MÉS</a></div>
	</div>
@endforeach
</ul>
@endif
@if($ass->lastPage()>1)
<section class="pag-revistas clearfix">
	<h3 class="left">Mostrar</h3>
	
	<ul class="paginador-results numerico right">
		<li style="display: inline-block;"><a href="?page=1">Primera</a></li>
		@for($i=1;$i<=$ass->lastPage();++$i)
		<li style="display: inline-block;"><a href="?page={{$i}}">{{$i}}</a></li>
		@endfor
		<li style="display: inline-block;"><a href="?page={{$ass->lastPage()}}">última</a></li>
	</ul>
</section>
@endif


@stop 