@extends('layouts.masterCOFB')
 
@section('titulo') Informació sobre l'assistent {{$usuari}} @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop

@section('contenido')
	@foreach($ass as $item)
	<div class="caja-gris-larga cebra-1" style="border-radius: 14px;">
	@if($item->delegat)
		<h5 class="uno"><span class="titulo-listado"><b>{{$item->esd->titol}}</b></span></h5>
	@elseif ($item->assistit)
		<h5 class="tres"><span class="titulo-listado"><b>{{$item->esd->titol}}</b></span></h5>
	@else
		<h5 class="dos"><span class="titulo-listado"><b>{{$item->esd->titol}}</b></span></h5>
	@endif
		<ul class="lista-enlaces">
			<li><a><b>Delegat:</b> @if($item->delegat) Sí @else No @endif</a></li>
			<li><a><b>Assistit:</b> @if($item->assistit) Sí @else No @endif</a></li>
			@if($item->assistit)<li><a><b>Dia i hora d'assistència:</b> {{$item->dataHora}}</a></li>@endif
			<li><a><b>Votacions accessibles:</b></a></li>
				<ul>
				@foreach($item->vota as $vota)
					<li><a href="/votacions/{{$vota->id}}">{{$vota->titol}}</a> 
						<div style="float:right;">
							<a href="/votacions/{{$vota->id}}/assistents/{{$item->id}}" class="ver-mas-enlace" style="font-size: 1em;">Veure respostes</a>
					</div></li>
				@endforeach
				</ul>
			
			
		</ul>
	</div>
	@endforeach
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