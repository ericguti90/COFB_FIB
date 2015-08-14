@extends('layouts.masterCOFB')
 
@section('titulo') Llistat de votacions @stop

@section('menu')
<h1>Esdeveniments</h1> <!-- Titulo de la home seleccionada -->
<ul>
    <li class="selected"><a href="#">Llistat d'esdeveniments</a></li>
    <li><a href="#">Crear nou esdeveniment</a></li>
</ul>
@stop



@section('contenido')

 <p>{{$vota}}</p>

@stop 