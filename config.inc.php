<?php
$mypage = "rexpixel";

$REX['ADDON']['rxid'][$mypage] = 'xxx';
$REX['ADDON']['name'][$mypage] = 'REXpixel';
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['version'][$mypage] = "0.0";
$REX['ADDON']['author'][$mypage] = "Oliver Kreischer";
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$mypage] = $mypage . "[]";
$REX['PERM'][] = $mypage . "[]";

// --- DYN
$REX['ADDON']['dev_tools']['bild'] = '';
// --- /DYN

rex_register_extension('OUTPUT_FILTER', 'rexpixel');


// Gucken ob mit der URL eine var mitgegeben wurde und dann auswerten
$wert = rex_request('rexpixel_opacity', 'string', 0);

if ($wert <> 0) {
	
   $sql = rex_sql::factory();
     $db_table = "rex_rexpixel";
     $sql->setTable($db_table);
     $sql->setWhere('id = 1');
     $sql->setValue('opacity', $wert);
     $sql->update();
}


function rexpixel($params)
{
  global $REX;

  // Werte holen
  $sql = rex_sql::factory();
	  $db_table = "rex_rexpixel";
	  $sql->setQuery("SELECT * FROM $db_table WHERE id=1");
	  $opacity = $sql->getValue('opacity');
	  $bilder = $sql->getValue('images');	  
	  

  $output = $params['subject'];

  $scripts = PHP_EOL;
  $html = PHP_EOL;  
  if (!$REX['REDAXO'])
  {

	  if ($bilder == "default.jpg") {
		 // echo "default";
	  }


	  $css.='
	  <style>
	  #rexpixel {
	    position:fixed;
	    top: 0;
	    opacity:0.5;
	    width:100%;
	    height:100%;
	    z-index: -1;
	    background: url(./files/addons/rexpixel/default.jpg) top center no-repeat;
	  }
	</style>
		 '; 
		  

	  	$html.='<!-- REXpixel -->'.PHP_EOL;
		$html.='<div id="rexpixel"></div>'.PHP_EOL;		
	    $html.='<div id="rpsetting">'.PHP_EOL;		
	  	$html.='	<div id="rpheader">REXpixel<div id="openclose">x</div></div>'.PHP_EOL;	
		$html.='	<div id="rpcontent">'.PHP_EOL;	
	  	$html.='	<div id="slider_label">Deckkraft: </div>'.PHP_EOL;
	  	$html.='	<div id="slider_opacity"></div>'.PHP_EOL;
		$html.='	<div id="opacity_wert">'.$opacity.' %</div> '.PHP_EOL;
		$html.='	<label for="zcheck">Niedrigster z-Index: </label>'.PHP_EOL;
	  	$html.='	<input id="zcheck" type="checkbox" checked="true">'.PHP_EOL;
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
		$( "#opacity_wert" ).html( ui.value+"%");
		$( "#rexpixel" ).css("opacity", ui.value/100  );
		},
    change: function(event, ui) {
           if (event.originalEvent) {
           //    alert(ui.value);
					
				slider_control_value = ui.value;
					
					$.ajax({
					type: "POST",
					url: "index.php?rexpixel_opacity="+slider_control_value,
					async: true,
					data: "slider_control_value="+slider_control_value,

				  });
        } }
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


