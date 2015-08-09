
$(document).ready(function(){

		//cebra-1
		$('.cebra-1:nth-child(2n+1)').addClass('odd');
		//cebra-2
		$('.cebra-2:nth-child(2n+1)').addClass('odd');
		//cebra-3
		$('.cebra-3:nth-child(2n+1)').addClass('odd');
		//listado
		$('.listado-tipo-2 .list-2 li:nth-child(2n)').addClass('even');
		//noticias
		$('.noticias article:nth-child(even)').addClass('even');
		//proyectos
		$('.proyectos .proy-item:nth-child(even)').addClass('even');
		//columnas a 3
		$('.column-3:nth-child(3n+1)').addClass('tries');
		//tabla-cebra
		$('.table-basic tr:nth-child(2n)').addClass('even');

		// clase para los labels del input
//$('input[type="radio"],input[type="checkbox"]').each(function() {
//	var thislabelref = $(this).attr('id');
//	var thislabelitem = $('label[for="'+thislabelref+'"]');
//	thislabelitem.click(function(){
//		var thisref = $(this).attr('for');
//    if ($(this).hasClass('checked')) {
//        $(this).removeClass('checked');
//				$('#'+thisref).prop("checked",false);
//    }else{
//        $(this).addClass('checked');
//				$('#'+thisref).prop("checked",true);
//    }		
//	});
//
//});

});