<div class="rex-addon-output">

<h2 class="rex-hl2">Einstellungen Bild Overlay</h2>
	<div class="rex-area-content">
		- Bild verwalten<br/>
		- Position angeben (links,zentriert, rechts)<br/>
		- Opacity angeben (evtl. Slider im Frontend)
		<br/>
		- Grid anzeigen<br/>
		- Grid Einstellung<br/>
	
		<?PHP
		
		$form = rex_form::factory($table, 'Legende', 'id='. $id, 'post', false);

		if($func == 'edit')
		{
		   $form->addParam('id', $id);
		}
   
		$field =& $form->addMedialistField('field');
		$field->setLabel('Feldname');

		$form->show();
		?>
	
	</div>
	
</div>