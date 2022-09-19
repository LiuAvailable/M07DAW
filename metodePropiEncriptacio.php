<?php 
/*
Mètode d'encriptacio;

1 -> agafar la IP del servidor
2 -> agafar la llargada de cada paraula
*/
$frase = "Bon dia a tothom, això és una proba";


$ip = getClientIP();


function getClientIP(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if($ip == "::1"){$ip = "127.0.0.1";}
	return $ip;
}
function removeDotsIp($ip){
	
}
?>