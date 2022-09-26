<?php 

include 'encryptA1.1.php';
include 'decryptA1.1.php';

$frase = "Buscando a Wally_@!❤";
$ip = "192.145.22.1";
$dec = "73a106a117a33a105a115a101a113a111a117a123a99a101a115a37a99a34a120a98a117a110a122";

?><h5>Encriptar:</h5><?php
echo $frase." = ".encrypt($frase, getClientIP())." --- <b>ip del client</b>";
echo "<br>";
echo $frase." = ".encrypt($frase, removeDotsIp($ip))." --- <b>".$ip."</b>";
echo "<br>";
?><h5>Desencriptar:</h5><?php
echo $dec." = ".decrypt($dec, removeDotsIp($ip))." --- <b>".$ip."</b>";

//TRACTAMENT IP

//agafem la ip del client
function getClientIP(){
	$ip = $_SERVER['REMOTE_ADDR'];
	if($ip == "::1"){$ip = "127.0.0.1";}
	return removeDotsIp($ip);
}
//eliminem els . de la ip (0.0.0.0 -> 0000)
function removeDotsIp($ip){
	$ip_temporal = explode('.',$ip);
	//print_r($ip_temporal);
	$ip = str_replace('.', '', $ip);
	return str_split($ip,1);
}
//FI TRACTAMENT IP

//funcio per encriptar
//crida funcions del fitxer encryptA1.1.php
function encrypt($str, $ip){
	$array_str = str_split($str, 1);
	$array_str_ascii = toAscii($array_str);
	return implode("a", sumIP($array_str_ascii, $ip));
}

//funcio per desencriptar
//crida funcions del fitxer decryptA1.1.php
function decrypt($str, $ip){
	$array_str_ascii= explode("a",$str);
	$array_str_ascii = restarIP($array_str_ascii, $ip);
	$array_str=translateAscii($array_str_ascii);
	return implode("",$array_str);
}
?>