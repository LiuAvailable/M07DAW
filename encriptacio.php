<?php

$sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
$mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";


echo decrypt($sp);
echo "<br>";
echo decrypt($mr);


function decrypt($str){
	$abc = "abcdefghijklmnopqrstuvwxyz";
	$resultat = array();
	$count = 0;
	//convertir la cadena de caracters entrants en array de char
	$str_array = str_split($str);
	foreach($str_array as $char){
		if (ctype_alnum($char)) {
			$resultat[] = lletraContraria($char, $abc); 
		}else{$resultat[]=$char;}
	}
	$fase1 = implode("", $resultat);
	return girarLletres($fase1);
}

//pas 1
//funcio per convertir una lletra a la seva contraria a -> z, b -> y, ....
function lletraContraria($char, $abc){
	$array_abc = str_split($abc, 1);
	$position = array_search($char, $array_abc);
	return $array_abc[25-$position];
}

//pas 2
//funcio per agrupar lletres de 3 en 3 i girar-les
function girarLletres($str){
	$array_str = str_split($str, 3);
	$array_reverted = array();
	foreach($array_str as $block){
		$array_reverted[] = strrev($block);
	}
	return implode("", $array_reverted);
}
?>