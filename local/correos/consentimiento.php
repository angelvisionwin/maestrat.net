<?php
// pillo el correo pasado por http://web/?correo=direccion de correo
$correo = $_GET['correo'];

// conecto con la base de datos SQL
$server ='www.visionwin.com';
$user   ='uvis2012';
$pass   ='ku32zs25p';
$bd     ='wvisionwin';
$sql = new mysqli($server,$user,$pass,$bd); 

$query = 'INSERT INTO wvisionwin.consentimientos (email,IP) values ("'.$correo.'","'.$_SERVER['REMOTE_ADDR'].'")';
$sql->query($query);
echo utf8_encode('Gracias, su petición ha sido aceptada.');
?>

