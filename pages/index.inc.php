<?php

require $REX['INCLUDE_PATH'] . '/layout/top.php';

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');
$msg = '';


$subpages = array(
  array('settings','Grundeinstellungen'),
  array('image','Image'),
  array('rulers','Rulers'),
  array('grid','Grid'),
);


// TITLE & SUBPAGE NAVIGATION
//////////////////////////////////////////////////////////////////////////////
rex_title($REX['ADDON']['name'][$page].' <span class="addonversion">'.$REX['ADDON']['version'][$page].'</span>',$subpages, $REX['ADDON'][$page]['SUBPAGES']);



// Include Current Page
switch($subpage)
{
  case 'image' :
  case 'grid' :
  case 'rulers' :
    break;

  default:
  {
    if ($msg != '')
     		echo rex_info($msg);
		 $subpage = 'settings';
  }
}

require dirname(__FILE__) .'/'.$subpage.'.inc.php';

require $REX['INCLUDE_PATH'] . '/layout/bottom.php';
 