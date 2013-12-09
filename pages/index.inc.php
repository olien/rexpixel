<?php
error_reporting(E_ALL);
require $REX['INCLUDE_PATH'] . '/layout/top.php';

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');
$msg = '';

rex_title($REX['ADDON']['name'][$page].' <span class="addonversion">'.$REX['ADDON']['version'][$page].'</span>');
?>

<div class="rex-addon-output">
<!-- <h2 class="rex-hl2"></h2> -->
  <?php
    if (rex_get('_msg', 'string')) { 
      echo rex_info(rex_get('_msg', 'string'));
    }
    
    $form = rex_form::factory("rex_rexpixel", "Allgemeine Einstellungen für das Tool", "id=1", 'post', false);
      $field =& $form->addRawField('<br/>&nbsp;<br/>');
      
      $field = &$form->addSelectField('anaus');
      $field->setLabel("Anzeige");
        $select = &$field->getSelect();
         $select->setSize(1);
         $select->addOption('Eingeschaltet','an');
         $select->addOption('Ausgeschaltet','aus');  
      $field->setAttribute('style','padding: 1px 0 1px 5px');             


      $field = &$form->addSelectField('sichtbarkeit');
      $field->setLabel("Sichtbarkeit");
        $select = &$field->getSelect();
         $select->setSize(1);
         $select->addOption('Nur für im Redaxo Backend angemeldete Benutzer','eingeloggte');
         $select->addOption('Für alle Benutzer','alle');        
      $field->setAttribute('style','padding: 1px 0 1px 5px');   


/*

      $field = &$form->addTextField('posleft');
      $field->setLabel("Position von links");
      $field->setAttribute('style','width: 50px;');

      $field = &$form->addTextField('postop');
      $field->setLabel("Position von oben");
      $field->setAttribute('style','width: 50px');
*/

      $field =& $form->addRawField('<br/>&nbsp;<br/>&nbsp;<br/>');
      $form->addFieldset('Einstellungen für das/die Layoutbild/er');
      $field =& $form->addRawField('<br/>&nbsp;<br/>');

      $field =& $form->addMedialistField('images');
      $field->setLabel("Layoutbilder");

      $field = &$form->addSelectField('layoutpos');
      $field->setLabel("Position Layoutbild");
     
      $select = &$field->getSelect();
         $select->setSize(1);
         $select->addOption('zentriert','center');
         $select->addOption('links','left');
         $select->addOption('rechts','right');        
      $field->setAttribute('style','padding: 1px 0 1px 5px');

      $field = &$form->addTextField('opacity');
      $field->setLabel("Opacity");
      $field->setAttribute('style','width: 50px');
      
      $field =& $form->addRawField('<br/>&nbsp;<br/>&nbsp;<br/>');      
      $form->show();

?>
</div>

<?php require $REX['INCLUDE_PATH'] . '/layout/bottom.php'; ?>