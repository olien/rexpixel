<?php

// Pfad zum default bild
// gewähltes Bild speichern
// openclose speichern
// 1. bild richtig angeben (css / pfad)

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
$zindex 		= rex_request('rexpixel_zindex', 'string', NULL);

if ($zindex) {
	$sql = rex_sql::factory();
	$db_table = "rex_rexpixel";
	$sql->setTable($db_table);
	$sql->setWhere('id = 1');
	$sql->setValue('zindex', $zindex );
	$sql->update();
}

if ($position_left[0] <> 0) {
   $sql = rex_sql::factory();
   $db_table = "rex_rexpixel";
   $sql->setTable($db_table);
   $sql->setWhere('id = 1');
   $sql->setValue('posleft', $position_left);
   $sql->setValue('postop',  $position_top);	 
   $sql->update();}

if ($opacitywert <> null) {
	$sql = rex_sql::factory();
    $db_table = "rex_rexpixel";
    $sql->setTable($db_table);
    $sql->setWhere('id = 1');
    $sql->setValue('opacity', $opacitywert);
    $sql->update();
}


function rexpixel($params)
{
  global $REX;

  // Werte holen
  $sql = rex_sql::factory();
	  $db_table = "rex_rexpixel";
	  $sql->setQuery("SELECT * FROM $db_table WHERE id=1");
	  $opacity 			= $sql->getValue('opacity');
	  $bilder 			= explode(',', $sql->getValue('images'));
  	  $positionlinks 	= $sql->getValue('posleft');	  
  	  $positionoben 	= $sql->getValue('postop');
	  $zindex 			= $sql->getValue('zindex');
	  $layoutposition 	= $sql->getValue('layoutpos');	  

$anzahlderbilder = count($bilder);



if ($anzahlderbilder == 1 AND $bilder[0] == "default.jpg") {
	$startbg = 'background-image: url(./files/addons/rexpixel/'.$bilder[0].');';
} else {
	$startbg = 'background-image: url(./files/'.$bilder[0].');';
}

// -image","url(./files/addons/rexpixel/"+background+")");




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
	    position:fixed;
		top: 0;
	    '.$opacity_str.'
	    width:100%;
	    height:100%;
	    z-index: -1;
		'.$startbg.'	
	    background-position: top center;
	    background-repeat: no-repeat;
	  }
	</style>
		 '; 
		  
	//     background-image: url(./files/addons/rexpixel/default.jpg); 	
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
    $html.='<option>'.$bild.'</option>'.PHP_EOL;
}
	$html.='</select>'.PHP_EOL;
	$html.='</div>'.PHP_EOL;
}






		$html.='	</div>'.PHP_EOL;	
		$html.='</div>'.PHP_EOL;
    	$html.='<!-- /REXpixel -->'.PHP_EOL;

    	$scripts.='<!-- REXpixel -->'.PHP_EOL;

		// jQuery + UI nur laden wenn nicht vorher schon jQuery geladen wurde
		$scripts.=' 
		<script type="text/javascript">
			document.write("<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\">\x3C/script>");
			document.write("<script src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.js\">\x3C/script>");
		</script>';
		
		$scripts.='	<script src="./files/addons/rexpixel/rexpixel.js"></script>'.PHP_EOL;
		$scripts.='	<link rel="stylesheet" type="text/css" href="./files/addons/rexpixel/rexpixel.css" />'.PHP_EOL;
		$scripts.='	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/dark-hive/jquery-ui.css" />'.PHP_EOL;		
		
$scripts.='
<script>
	
$(function() {

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




	
	
	$("#openclose").click(function() {

       $("#rpheader").toggleClass("close");
       $("#rpcontent").toggleClass("close");	   
	   $("#openclose").text($("#openclose").text() == "X" ? "O" : "X");

	

		$.ajax({
			type: "POST",
			url: "index.php?"+offen,
			async: true
		});


});

	$("#backgrounds").change(function() {
	   var background = $(this).find("option:selected").text();

	   if (background == "default.jpg") {
	   		$("#rexpixel").css("background-image","url(./files/addons/rexpixel/"+background+")");
	   } else {
	   		$("#rexpixel").css("background-image","url(./files/"+background+")");
	   }
  
	});
	
	
});
</script>
';

		
    	$scripts.='<!-- /REXpixel -->'.PHP_EOL;
  }

	  $output = str_replace('</head>',$css.'</head>',$output);  
	  $output = str_replace('</body>',$html.'</body>',$output);  
     $output = str_replace('</head>',$scripts.'</head>',$output);

	  return $output;
}


