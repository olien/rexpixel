<?php

error_reporting(E_ALL);

$mypage = "rexpixel";

$REX['ADDON']['rxid'][$mypage] = 'xxx';
$REX['ADDON']['name'][$mypage] = 'REXpixel';
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['version'][$mypage] = "0.05";
$REX['ADDON']['author'][$mypage] = "Oliver Kreischer";
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$mypage] = $mypage . "[]";
$REX['PERM'][] = $mypage . "[]";

$startbg = '';

// --- DYN
$REX['ADDON']['dev_tools']['bild'] = '';
// --- /DYN

rex_register_extension('OUTPUT_FILTER', 'rexpixel');

// Gucken ob mit der URL eine var mitgegeben wurde und dann auswerten
$opacitywert 	= rex_request('rexpixel_opacity', 'string', NULL);
$position_left 	= rex_request('rexpixel_position_left', 'string', NULL);
$position_top 	= rex_request('rexpixel_position_top', 'string', NULL);
$openclose 		= rex_request('rexpixel_status', 'string', NULL);

$zindex 		= rex_request('rexpixel_zindex', 'string', NULL);
$aktivesbild	= rex_request('rexpixel_bildaktiv', 'string', NULL);

$db_table = "rex_rexpixel";
	$sql = rex_sql::factory();
	$sql->setTable($db_table);
	$sql->setWhere('id = 1');

if ($zindex) {
	$sql->setValue('zindex', $zindex );
}

if ($position_left[0] <> 0) {
   $sql->setValue('posleft', $position_left);
   $sql->setValue('postop',  $position_top);	 
}
if ($openclose <> NULL) {
   $sql->setValue('openclose', $openclose);
}

if ($aktivesbild <> NULL) {
   $sql->setValue('aktivesbild', $aktivesbild);
}

if ($opacitywert <> null) {
    $sql->setValue('opacity', $opacitywert);
}

$sql->update();

function rexpixel($params)
{
  global $REX;

  // Werte holen
  $sql = rex_sql::factory();
	  $db_table = "rex_rexpixel";
	  $sql->setQuery("SELECT * FROM $db_table WHERE id=1");

	  $anaus			= $sql->getValue('anaus');
	  $sichtbarkeit		= $sql->getValue('sichtbarkeit');
	  $opacity 			= $sql->getValue('opacity');
	  $bilder 			= explode(',', $sql->getValue('images'));
  	  $aktivesbild 		= $sql->getValue('aktivesbild');
  	  $positionlinks 	= $sql->getValue('posleft');	  
  	  $positionoben 	= $sql->getValue('postop');
	  $openclose	 	= $sql->getValue('openclose');  
	  $zindex 			= $sql->getValue('zindex');
	  $layoutposition 	= $sql->getValue('layoutpos');	  


	$anzahlderbilder = count($bilder);

if ($anzahlderbilder == 1 AND $bilder[0] == "rex_pixel_default.jpg") {
	$startbg = 'background-image: url(./files/addons/rexpixel/'.$bilder[0].');';
} else if ($aktivesbild == "rex_pixel_default.jpg") {
	$startbg = 'background-image: url(./files/addons/rexpixel/'.$aktivesbild.');';	
} else if ($aktivesbild <> null AND $aktivesbild != "rex_pixel_default.jpg") {
	$startbg = 'background-image: url(./files/'.$aktivesbild.');';
} else {
	$startbg = 'background-image: url(./files/'.$bilder[0].');';
}


  $output = $params['subject'];

  $scripts = PHP_EOL;
  $html = PHP_EOL;  
  $css = PHP_EOL;    
  if (!$REX['REDAXO'])
  {

	  if ($opacity == 0) {
		 $opacity_str = 'opacity: 0;';
	  } else if ($opacity < 10) {
      	 $opacity_str = 'opacity: 0.0'.$opacity.';';
	  } else if ($opacity == 100) {
	  	 $opacity_str = 'opacity: 1;';
      } else {
      	 $opacity_str = 'opacity: 0.'.$opacity.';';
      }

	  $css.='
	  <style>
		#rpsetting {
		   position: absolute;
		   top: '.$positionoben.'px;
		   left: '.$positionlinks.'px;
		}

	  #rexpixel {
	    position: absolute;
		top: 0;
	    '.$opacity_str.'
	    width:100%;
	    min-height: 100%;
	    z-index: -1;
		'.$startbg.'
	    background-position: top '.$layoutposition.';
	    background-repeat: no-repeat;
	  }

		 '; 
		  
	//     background-image: url(./files/addons/rexpixel/rex_pixel_default.jpg); 	
	  	$html.='<!-- REXpixel -->'.PHP_EOL;
		$html.='<div id="rexpixel"></div>'.PHP_EOL;		
	    $html.='<div id="rpsetting">'.PHP_EOL;		
	  	$html.='	<div id="rpheader">REXpixel<div id="openclose">X</div></div>'.PHP_EOL;	
		$html.='	<div id="rpcontent">'.PHP_EOL;	
	  	$html.='	<div class="titel">Layout Vorlage</div>'.PHP_EOL;
	  	$html.='	<div class="links">Deckkraft (<span id="opacity_wert" >'.$opacity.'</span>%)</div>'.PHP_EOL;
	  	$html.='	<div id="slider_opacity"></div>'.PHP_EOL;
		$html.='	<div class="rechts"></div> '.PHP_EOL;
		$html.='	<div class="links">z-Index ändern</div>'.PHP_EOL;
	  	$html.='	<div class="rechts"><input id="zcheck" type="checkbox" checked="true"></div>'.PHP_EOL;



if ($anzahlderbilder > 1) {
	$html.='	<div class="links">Layoutbild</div>'.PHP_EOL;
	$html.='	<div class="rechts">'.PHP_EOL;
	$html.='<select name="change" id="backgrounds">'.PHP_EOL;

foreach($bilder as $bild) {

	if ($aktivesbild == $bild) {
		$html.='<option selected>'.$bild.'</option>'.PHP_EOL;
	} else {
		$html.='<option>'.$bild.'</option>'.PHP_EOL;	
	}

    
}

	$css.='	</style>';

	$html.='</select>'.PHP_EOL;



foreach($bilder as $bild) : 
	if ($bild == "rex_pixel_default.jpg") {
	$html.=  '<img src="./files/addons/rexpixel/'.$bild.'" width="20" >';
	} else {
	$html.=  '<img src="./files/'.$bild.'" width="20" height="20">';	
	}

endforeach;





	$html.='</div>'.PHP_EOL;
}

		$html.='	</div>'.PHP_EOL;	
		$html.='</div>'.PHP_EOL;
    	$html.='<!-- /REXpixel -->'.PHP_EOL;

    	$scripts.='<!-- REXpixel -->'.PHP_EOL;

		// jQuery + UI nur laden wenn nicht vorher schon jQuery geladen wurde
		$scripts.=' 
		<script type="text/javascript">

			if (!window.jQuery) {
				document.write("<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\">\x3C/script>");
				document.write("<script src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js\">\x3C/script>");
			}

		</script>';
		
		$scripts.='	<script src="./files/addons/rexpixel/rexpixel.js"></script>'.PHP_EOL;
		$scripts.='	<link rel="stylesheet" type="text/css" href="./files/addons/rexpixel/rexpixel.css" />'.PHP_EOL;
		$scripts.='	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/dark-hive/jquery-ui.css" />'.PHP_EOL;		
		
$scripts.='
<script>
	
$(function() {

	$( "#rexpixel" ).draggable();
	$( "#slider_opacity" ).slider({

	range: "max",
	min: 0,
	max: 100,
	value: '.$opacity.',
	slide: function( event, ui ) {
		$( "#opacity_wert" ).html(ui.value);
		$( "#rexpixel" ).css("opacity", ui.value/100  );
		},
    change: function(event, ui) {
           if (event.originalEvent) {
           //    alert(ui.value);
					
				slider_control_value = ui.value;
					
				$.ajax({
					type: "POST",
					url: "index.php?rexpixel_opacity="+slider_control_value,
					async: true
   			    });
        } }
	});
	
	$( "#rpsetting" ).draggable({ handle: "#rpheader",
	    stop: function(event, ui) {
			
			Stoppos = $(this).position();

			// alert("STOP: \nLeft: "+ Stoppos.left + "\nTop: " + Stoppos.top);
			
			$.ajax({
				type: "POST",
				url: "index.php?rexpixel_position_left="+Stoppos.left+"&rexpixel_position_top="+Stoppos.top,
				async: true
		    });
			
	    }
	});
';
	
if ($zindex == 'drunter') {

$scripts.=' 
	$("#zcheck").attr("checked", false);
	 $("#rexpixel").css("z-index", "-1")
';

} else {

$scripts.='

	$( "#rexpixel" ).draggable();

	$("#zcheck").attr("checked", true);

		$(function(){
   	     	var maxZ = Math.max.apply(null,$.map($("body > *"), function(e,n){
   	        	if($(e).css("position")=="absolute")
   	            	return parseInt($(e).css("z-index"))||1 ;
  	            })
   			);
   		      $("#rexpixel").css("z-index", maxZ)
   		      $("#rpsetting").css("z-index", maxZ+1)

		});
';

}
	
$scripts.='


	$("#zcheck").change(function() {
	   
	    if(this.checked) {
	
		z = "drueber";

   		 $(function(){
   	     	var maxZ = Math.max.apply(null,$.map($("body > *"), function(e,n){
   	        	if($(e).css("position")=="absolute")
   	            	return parseInt($(e).css("z-index"))||1 ;
   	            })
   			);
   			  // alert(maxZ);
   	          $("#rexpixel").css("z-index", maxZ)
   		      $("#rpsetting").css("z-index", maxZ+1)

   	 	 });


	    } else {

         $("#rexpixel").css("z-index", "-1")
	         z = "drunter";
		}

		$.ajax({
			type: "POST",
			url: "index.php?rexpixel_zindex="+z,
			async: true
		});

	});
';

if ($openclose == "close") {
$scripts.='
	 $("#rpheader").toggleClass("close");
       $("#rpcontent").toggleClass("close");	   
	   $("#openclose").text($("#openclose").text() == "X" ? "O" : "X");
';
}

$scripts.='
	
	$("#openclose").click(function() {

       $("#rpheader").toggleClass("close");
       $("#rpcontent").toggleClass("close");	   
	   $("#openclose").text($("#openclose").text() == "X" ? "O" : "X");

	   if ($("#rpheader").hasClass("close")) {
	   		status = "close";
	   } else {
	   		status = "open";
	   };


		$.ajax({
			type: "POST",
			url: "index.php?rexpixel_status="+status,
			async: true
		});


});

	$("#backgrounds").change(function() {
	   var background = $(this).find("option:selected").text();

	   if (background == "rex_pixel_default.jpg") {
	   		$("#rexpixel").css("background-image","url(./files/addons/rexpixel/"+background+")");

	   } else {
	        
					var img = new Image();
					img.src = "./files/"+background;
		            $("#rexpixel").css("min-height", img.height );
			   		$("#rexpixel").css("background-image","url(./files/"+background+")");
	   }

	alert(img.height);	



		$.ajax({
			type: "POST",
			url: "index.php?rexpixel_bildaktiv="+background,
			async: true
   		   });

	});


';

 if ($aktivesbild == null) {
	$scripts.='	$("#backgrounds option:first").attr("selected","selected");';
 }

$scripts.='


	
	
});
</script>
';

		
    	$scripts.='<!-- /REXpixel -->'.PHP_EOL;
  }




		$output = str_replace('</head>',$css.'</head>',$output);  
  		$output = str_replace('</body>',$html.'</body>',$output);  
   		$output = str_replace('</head>',$scripts.'</head>',$output);
  

	


  if ($anaus == "an") {
   	if ($sichtbarkeit == "alle") {
	  return $output;
  	} else if(is_object($REX['LOGIN']) AND is_object($REX['LOGIN']->USER)) {
  	  return $output;
	}
  } 
		

	  


}


