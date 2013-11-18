<?php
$opacity = htmlspecialchars($_POST["slider_opacity_wert"]);

echo "ssdfdfsdf ".$opacity;

$sql = rex_sql::factory();
$db_table = "rex_rexpixel";
$sql->setTable($db_table);
$sql->setWhere('id = 1');
$sql->setValue('opacity','30');
$sql->update();


?>
dsfsdf