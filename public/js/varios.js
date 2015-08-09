//Toggle Buscador General
function hidefloating(current){
		if(current!='usuario' && $("#wrapper").width()<670){
			$(".usuario").slideUp(0); 
		}
		if(current!='submenu' && $("#wrapper").width()<670){
			$(".submenu").slideUp(0); 
		}
		if(current!='buscador') $(".buscador").slideUp(0); 
		if(current!='pagina_inici') $(".pagina_inici").slideUp(0); 

		if(current!='menu_desp') $('body').removeClass('menu_showed').addClass('menu_hidden');
}


$(document).ready(function(){

	$("#search-m").click(function(e){
		e.preventDefault();
		if ( $(".buscador-m").is (":visible") ) {

			 $(".buscador-m").slideUp(100)
		}	
		
		else {

			$(".buscador-m").slideDown(100); 
			$("#ip-search").focus(); 
		}			
	});

	$(".collapse").click(function(e){
		e.preventDefault();
		if ( $(".dropdown-mobile").is (":visible") ) {

			 $(".dropdown-mobile").toggle()
		}	
		
		else {

			$(".dropdown-mobile").toggle()
		}			
	});
	//Fin Toggle Buscador General		

	// PRUEBAS DE ORM //
	$("#itemconectados").click(function(e){
		e.preventDefault();
		if($("#wrapper").width()<670){
			hidefloating('usuario');
			$(".usuario").slideToggle(20); 
		}
	});

	$("#search").click(function(e){
		e.preventDefault();
		hidefloating('buscador');
		$(".buscador").slideToggle(20); 
		$("#ip-search").focus(); 
	});

	$("#inici").click(function(e){
		e.preventDefault();
		hidefloating('pagina_inici');
		$(".pagina_inici").slideToggle(20); 
	});

	$("#menu-inferior").click(function(e){
		e.preventDefault();
		if($("#wrapper").width()<670){
			hidefloating('submenu');
			$(".submenu").slideToggle(20); 
		}
	});
	$("#menu-inferior-mobile").click(function(e){
		e.preventDefault();
		if($("#wrapper").width()<670){
			hidefloating('submenu');
			$(".submenu").slideToggle(20); 
		}
	});
	// FIN PRUEBAS DE ORM //

	//Funcionalidad Menú Desplegable
	$(".menu-desplegable .menu_container > ul li:has(ul)").addClass("has-sub");

	$('.menu-desplegable').on("click", "li", function (e) {
		e.preventDefault();
		e.stopPropagation();
		fakeCombo();
	});

	$('.menu-desplegable').on("click", ".has-sub", function (e) {
		e.preventDefault();
		e.stopPropagation();

		// if the targets nested ul is not visible, display it
		if (!$(this).hasClass("active")) {
			$(this).addClass("active");
			$(this).parent().addClass("presente");
			$(this).children("div").slideDown('normal',fakeCombo());
		} else {
			$(this).removeClass("active");
			$(this).parent().removeClass("presente");
			$(this).children("div").slideUp('normal',fakeCombo());
		}
	});

	//Animación lateral//
	/*
	(function($) {
		$(document).ready(function() {
			var mySlidebars = new $.slidebars();
			$('.toggle-left').on('click', function() {
				mySlidebars.toggle('left');
			});
		});  
	}) (jQuery);
	*/
	//Fin Funcionalidad Menú Desplegable	

	$('#menu-lateral').on("click", function(){
		if($("#wrapper").width()>=670){
			hidefloating('menu_desp');
			if($('body').hasClass('menu_showed')){
				$('#wrapper').animate({left: '-=248'}, 600);
				$('.sb-slidebar').animate({width: 0}, 600, function(){
					$('body').removeClass('menu_showed').addClass('menu_hidden');
				});
			}else{
				$('#wrapper').animate({left: '+=248'}, 600);
				$('.sb-slidebar').animate({width: 248}, 600, function(){
					$('body').removeClass('menu_hidden').addClass('menu_showed');
				});
			}
		}else{
			if($('body').hasClass('menu_showed')){
					$('body').removeClass('menu_showed').addClass('menu_hidden');
			}else{
					$('body').removeClass('menu_hidden').addClass('menu_showed');
			}
		}
		fakeCombo();
	});

	//Acordeon
	$(".acordeon ul li:has(ul)").addClass("has-sub");

	$('.acordeon').on("click", "li", function (e) {
		//	e.preventDefault();
		e.stopPropagation();
	});

	$('.acordeon').on("click", ".has-sub", function (e) {
		e.preventDefault();
		e.stopPropagation();

		if (!$(this).hasClass("active")) {
	        $(this).addClass("active");
    		$(this).children("ul").slideDown('normal', fakeCombo());
		} else {
	        $(this).removeClass("active");
   			$(this).children("ul").slideUp('normal', fakeCombo());
		}
	});

	// listas desplegables 
  	$(".dropdown dt a").click(function(event) {
  		event.preventDefault();
		var dropID = $(this).closest("dl").attr("id");
		$("#"+dropID+" dd ul").slideToggle(200, fakeCombo());
	});

	$(".dropdown dd ul li a").click(function(event) {
		event.preventDefault();
		var dropID = $(this).closest("dl").attr("id");
		var text = $(this).html();
		var selVal = $(this).find(".dropdown_value").html();
		$("#"+dropID+" dt a").html(text);
		$("#"+dropID+" dd ul").hide();
		fakeCombo();
	});

	$("dl[class!=dropdown]").click(function(event) {
		event.preventDefault();
		$(".dropdown dd ul").hide();
		fakeCombo();
	});

	//tabs
	$(function() {
		if($( "#tabs" ).size()>0){
			$( "#tabs" ).tabs();
		}
	});

	// ocultar en caso de redimensionar para evitar fallos de comportamiento
	$(window).resize(function(){
		/* $(window).reload(); Quitado por IE8*/
		/*
		if($("#wrapper").width()>=670){
			hidefloating('menu_desp');
			if($('body').hasClass('menu_showed')){
				$('body').removeClass('menu_showed').addClass('menu_hidden');
				$('#wrapper').animate({left: '-=248'}, 0);
				$('.sb-slidebar').animate({width: 0}, 0);
			}
		}else{
			if($('body').hasClass('menu_showed')){
				$('body').removeClass('menu_showed').addClass('menu_hidden');
			}
		}
		*/
	});

	// código de múltiple scroll
	$(window).scroll(function(){
		//alert($(this).scrollTop());
		fakeScroll();
	});

	$('body').append('<div id="fakeHeighter" style="border:0px solid red; width:1px; position:absolute; right:0px; top:0px; height:100%;"></div>');

});

function fakeHeight(){
//	alert($('.menu_container').height());
	$('#fakeHeighter').height($('.menu_container').height()+180); // padding del menú
	$('.sb-slidebar').scroll();
}

function fakeScroll(){
	$('.sb-slidebar').scrollTop($(this).scrollTop());
}
function fakeCombo(){
//	alert('fakeCombo');
	fakeHeight();
	fakeScroll();
}