@extends('layouts.masterCOFB')
 
@section('titulo') Informació sobre l'assistent {{$usuari}} @stop



@section('contenido')
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript">
	function verificar(esd,ass,cont) {
		confirmar=confirm("Si acceptes, s'esborrarà l'assistent'. Estàs segur?"); 
		if (confirmar) {
			$.ajax({
	      		url: '/esdeveniments/'+esd+'/assistents/'+ass,
	      		type: "delete",
	      		success: function(data){
	      			if (cont!=1) window.location.replace('/esdeveniments/'+esd+'/assistents/'+ass);
	      			else window.location.replace('/esdeveniments/'+esd+'/assistents');	
	      	  }
        	});
		}
	};
	</script>

	@foreach($ass as $item)
	<?php $id = $item->id ?>
	<div class="caja-gris-larga cebra-1" style="border-radius: 14px;">
	@if($item->delegat)
		<h5 class="uno"><span class="titulo-listado"><b>{{$item->esd->titol}}</b></span></h5>
	@elseif ($item->assistit)
		<h5 class="tres"><span class="titulo-listado"><b>{{$item->esd->titol}}</b></span></h5>
	@else
		<h5 class="dos"><span class="titulo-listado"><b>{{$item->esd->titol}}</b></span></h5>
	@endif
	@if(!$item->delegat && !$item->assistit && !$item->vota)
	<div class="user-menu" style="margin-top: -22px;
    margin-bottom: 38px;"><a onclick="verificar({{$item->esd->id}},{{$item->id}},{{$ass->count()}})" class="cierre" style="float:right;"></a></div>
    @else
    <div class="invalid help" title="No es pot eliminar">&nbsp;</div>
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

@section('menu')
<h1>Assistents</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li><a href="/assistents">Llistat d'assistents</a></li>
    <li class="selected"><a href="/assistents/{{$id}}">Veure Assistent</a></li>
</ul>
@stop