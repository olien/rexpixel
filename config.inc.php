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

function rexpixel($params)
{
  global $REX;
  $output = $params['subject'];

  $scripts = PHP_EOL;
  $html = PHP_EOL;  
  if (!$REX['REDAXO'])
  {

	  	$html.='<!-- REXpixel -->'.PHP_EOL;
		$html.='<div id="rexpixel"></div>'.PHP_EOL;		
	    $html.='<div id="rpsetting">'.PHP_EOL;		
	  	$html.='	<span class="text">REX<i>pixel</i></span>'.PHP_EOL;	
		
		
	  	$html.='	<div id="slider_opacity"></div><div id="opacity_wert">50%</div> '.PHP_EOL;
	  	$html.='	<input id="cbox" type="checkbox" value="checked">'.PHP_EOL;
		$html.='	<span id="test">test</span>'.PHP_EOL;
		$html.='</div>'.PHP_EOL;
    	$html.='<!-- /REXpixel -->'.PHP_EOL;

    	$scripts.='<!-- REXpixel -->'.PHP_EOL;
		$scripts.='	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>'.PHP_EOL;
		$scripts.='	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>'.PHP_EOL;		
		$scripts.='	<script type="text/javascript" src="./files/addons/rexpixel/rexpixel.js"></script>'.PHP_EOL;
		$scripts.='	<link rel="stylesheet" type="text/css" href="./files/addons/rexpixel/rexpixel.css" />'.PHP_EOL;
		$scripts.='	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/dark-hive/jquery-ui.css" />'.PHP_EOL;		
		
		
    	$scripts.='<!-- /REXpixel -->'.PHP_EOL;
  }

	  $output = str_replace('</body>',$html.'</body>',$output);  
      $output = str_replace('</head>',$scripts.'</head>',$output);

	  return $output;
}





