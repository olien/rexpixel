	$(function(){

		$('#rpsetting').draggable();
		
$('#openclose').click(function() {
       $('#rpheader').toggleClass('close');
       $('#rpcontent').toggleClass('close');	   
});


	
	$("#zcheck").change(function() {
	    if(this.checked) {
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
	});
 
 
	
		
});


