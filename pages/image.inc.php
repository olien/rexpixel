<div class="rex-addon-output">

<h2 class="rex-hl2">Einstellungen Bild Overlay</h2>
	<div class="rex-area-content">
	</div>
	
		<?php
		

		if (rex_get('_msg', 'string')) {
			echo rex_info(rex_get('_msg', 'string'));
		}
		
		
			$form = rex_form::factory("rex_rexpixel", "Einstellungen", "id=1", 'post', false);

			$field = &$form->addTextField('posleft');
			$field->setLabel("Position von links");
		   $field->setAttribute('style','width: 50px');

			$field = &$form->addTextField('postop');
			$field->setLabel("Position von oben");
		   $field->setAttribute('style','width: 50px');


	 		$form->addFieldset('Einstellungen Layoutbild/er');

			$field =& $form->addMedialistField('images');
			$field->setLabel("Layoutbilder");


	   	$field = &$form->addSelectField('layoutpos');
			$field->setLabel("Position Layoutbild");
		 
			 $select = &$field->getSelect();
			   $select->setSize(1);
			   $select->addOption('zentriert','center');
			   $select->addOption('links','left');
			   $select->addOption('rechts','right');				
			   $select->setAttribute('style','width: 100px');


		
				$field = &$form->addTextField('opacity');
				$field->setLabel("Opacity");
			   $field->setAttribute('style','width: 50px');
			
			$form->show();
		
		
      ?>
	

</div>
