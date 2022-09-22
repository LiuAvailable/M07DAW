<?php 

$array_num = [5,6,7,8,9,10];
print_r(factorialArray($array_num));

function factorialArray($array_num):array|bool{
	//si es un array procedeix a calcular el factorial
	//en cas contrari retorna fals
	if(is_array($array_num)){
		$array_factorials = [];
		foreach ($array_num as $num) {
			if(!is_numeric($num)){return false;}//si no es numeric, talla el programa i retorna fals
			else{			
				$factorial = $num;
				factorial($num, $factorial);
				$array_factorials[] = $factorial;
			}
		}
		return $array_factorials;
	}else{return false;}

}
/*
acció recursiva,
fins que no hagi multiplicat tots els numeros menors a l'inicial es cridara a ella mateixa
*/
function factorial($num, &$factorial){
	if ($num > 1) {
		$factorial = $factorial * ($num-1);
		factorial($num-1, $factorial);
	}
}

?>