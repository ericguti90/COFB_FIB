//barra de progreso de html 4
var maxprogress = 100;   // total to reach
var actualprogress = 0;  // current value
var itv = 0;  // id to setinterval
function prog()
{
  if(actualprogress >= maxprogress) 
  {
    clearInterval(itv);   	
    return;
  }	
  var progressnum = document.getElementById("progressnum");
  var indicator = document.getElementById("indicator");
  actualprogress += 5;	
  indicator.style.width=actualprogress + "%";
  progressnum.innerHTML = actualprogress;
  if(actualprogress == maxprogress) clearInterval(itv);   
}


$(document).ready(function(){

			//barra de progeso de html 5
        var progressbar = $('#progressbar'), 
            max = progressbar.attr('max'), 
            time = (1000/max)*5,     
            value = progressbar.val(); 
     
        var loading = function() { 
            value += 1; 
            addValue = progressbar.val(value); 
             
            $('.progress-value').html(value + '%'); 
     
            if (value == max) { 
                clearInterval(animate);                     
            } 
        }; 
     
        var animate = setInterval(function() { 
            loading(); 
        }, time); 

     //barra de progreso de html 4

			itv = setInterval(prog, 100);

});