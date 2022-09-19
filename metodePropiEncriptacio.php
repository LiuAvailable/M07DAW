<?php 
/*
Mètode d'encriptacio;

1 -> agafar la IP del servidor
2 -> agafar la llargada de cada paraula
*/
$frase = "patata";
//encrypt($frase);
//agafem la ip del client
function getClientIP(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if($ip == "::1"){$ip = "127.0.0.1";}
	return removeDotsIp($ip);
}
//eliminem els . de la ip (0.0.0.0 -> 0000)
function removeDotsIp($ip){
	$ip = str_replace('.', '', $ip);
	return str_split($ip,1);
}

function toAscii($array_str){
	$array_str_ascii = [];
	foreach ($array_str as $char) {
		$array_str_ascii[] = ord($char)."a";
	}
	return $array_str_ascii;
}

function encrypt($str){
	$array_str = str_split($str, 1);
	//print_r($array_str);
	$array_str_ascii = toAscii($array_str);
	print_r($array_str_ascii);


}
?>