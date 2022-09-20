<?php 
/*
funcions per desencriptar una frase

passos:

	1-> convertim l'string a un array separant pel char "a"
	2-> restem un numero de la ip a cada char ascii
	3-> convertim els chars ascii a chars normals

*/
function translateAscii($array_str_ascii){
	$array_str = [];
	foreach ($array_str_ascii as $char) {
		$array_str[] = chr($char);//chr, ascii -> char
	}
	return $array_str;
}
function restarIP($array_str, $array_ip){
	$count = 0;
	for ($i = 0; $i < sizeof($array_str); $i++) {
		if ($count>=sizeof($array_ip)) {$count = 0;}//si s'han utilitzat tots els numeros de la ip, torna a començar
		$array_str[$i]=$array_str[$i]-$array_ip[$count];
		$count++;
	}	return $array_str;
}
?>