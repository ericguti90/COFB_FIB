@extends('layouts.masterCOFB')
 
@section('titulo') {{$esd->titol}} @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop



@section('contenido')
<a href="#">
	<h5 class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;" onclick="assistents(1)">SCS</h5>
	<h5 class="titulo-estrella has-sub" style= "background: url('../img/iconos/arrow-left.png') no-repeat 98% center;" onclick="assistents()">SCS</h5>
</a>



@stop 


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

function assistents() {
	

		if (!$('.titulo-estrella').hasClass("active")) {
	        $('.titulo-estrella').addClass("active");
	        $('.titulo-estrella').css = ("background-image", "url('../img/iconos/arrow-down-a.png')");
	        //$('.titulo-estrella').setAttribute = ('style',"background: url('../img/iconos/arrow-down-a.png') no-repeat 98% center;");
    		//$(this).children("ul").slideDown('normal', fakeCombo());
		} else {
	        $('.titulo-estrella').removeClass("active");
	        $('.titulo-estrella').css = ("background-image", "url('../img/iconos/arrow-left.png')");
	        $('.titulo-estrella').setAttribute = ('style',"background: url('../img/iconos/arrow-left.png')");
   			//$(this).children("ul").slideUp('normal', fakeCombo());
		}
}

</script>