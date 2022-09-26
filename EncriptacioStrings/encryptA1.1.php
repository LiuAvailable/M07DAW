<?php 
/*
funcions per encriptar una frase

passos:

	1-> separem la frase en un array de caracters
	2-> convertim cada caracter a ascii (a un numero)
	3-> sumem un numero de la ip a cada char ascii
	4-> passem l'array a string separant cada char ascii amb un char ("a")
*/
function toAscii($array_str){
	$array_str_ascii = [];
	foreach ($array_str as $char) {
		$array_str_ascii[] = ord($char);//ord; char -> valor asci
	}
	return $array_str_ascii;
}
function sumIP($array_str, $array_ip){
	$count = 0;
	for ($i = 0; $i < sizeof($array_str); $i++) {
		if ($count>=sizeof($array_ip)) {$count = 0;}//si s'han utilitzat tots els numeros de la ip, torna a començar
		$array_str[$i]=$array_str[$i]+$array_ip[$count];
		$count++;
	}	return $array_str;
}
?>