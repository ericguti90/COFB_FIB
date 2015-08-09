function isHTML(str) {
    var a = document.createElement('div');
    a.innerHTML = str;
    for (var c = a.childNodes, i = c.length; i--; ) {
        if (c[i].nodeType == 1) return true; 
    }
    return false;
}

findOnArray = function(array_search, arg) {
  
  var special_chars = {"Á":"A", "À":"A", "É":"E", "È":"E", "Í":"I", "Ì":"I", "Ó":"O", "Ò":"O", "Ú":"U", "Ù":"U"};

  return $.grep(array_search, function(e){ //return e.label == 'Ortopèdia'; 

    if(isHTML(e.label)){

      e.label = $(e.label).html();

    }

    var preprocessing_elem = e.label.toUpperCase().replace(/[^\w ]/g, function(char) {
                            return special_chars[char] || char;
                          });

    var preprocessing_arg = arg.toUpperCase().replace(/[^\w ]/g, function(char) {
                            return special_chars[char] || char;
                          });

    return preprocessing_elem.indexOf(preprocessing_arg) >= 0;

  });

};

ArrayFilter = function(array_search, filter){

  if(filter) {
    
    var results = findOnArray(array_search,filter);

    $('#list_search').prev().hide();
    $('#list_search').empty().show();
    $('#desplegable-search').addClass('search_done');

    $.each(results, function(){

        $('#list_search').append('<li><a href="'+this.link+'">'+this.label+'</a></li>');

    });
    

  } 
  else {
    $('#list_search').prev().show();
    $('#list_search').hide().empty();
    $('#desplegable-search').removeClass('search_done');

  }
  return false;

}

ArrayCreation = function(){

    var preprocessing = Array();

    $('<ul id="list_search"></ul>').insertAfter('#list');

    $('#list').find('a').each(function(){

      preprocessing.push({
        label: $(this).html(),
        link: $(this).attr('href')
      });

    });   

    return preprocessing;

}

$(document).ready(function(){

    var array_search = ArrayCreation();

    $('#desplegable-search').change( function () {
        
        var filter = $(this).val();

        ArrayFilter(array_search, filter);
       
    })
    .keyup( function () {
        // fire the above change event after every letter
        $(this).change();
    });

});