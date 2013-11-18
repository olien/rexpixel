/* $(function() {

		$( "#slider_opacity" ).slider({
	
		range: "max",
		min: 0,
		max: 100,
		value: 50,
		slide: function( event, ui ) {
			$( "#opacity_wert" ).html( ui.value+"%");
			$( "#rexpixel" ).css('opacity', ui.value/100  );
			},
	    change: function(event, ui) {
	           if (event.originalEvent) {
	               alert(ui.value);
	        } }
		});
	});
 
 
 
 
	*/
 
 

 
 $('#cbox').click(function(){
     if (this.checked) {
         $('#rexpixel').css('z-index', '-1')
     } else {
		 $(function(){
	     	var maxZ = Math.max.apply(null,$.map($('body > *'), function(e,n){
	        	if($(e).css('position')=='absolute')
	            	return parseInt($(e).css('z-index'))||1 ;
	            })
			);
// alert(maxZ);
	          $('#rexpixel').css('z-index', maxZ)
		      $('#rpsetting').css('z-index', maxZ+1)
	  });
	  
	  

  }
 })