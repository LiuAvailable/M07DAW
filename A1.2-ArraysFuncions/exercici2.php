<?php 
$quadrat = creaMatriu(4);
$rectangle = creaMatriu(4,6);
echo "<h3>Matriu Quadrada</h1>";
echo mostraMatriu($quadrat);
echo mostraMatriu(transposaMatriu($quadrat));
echo "<h3>Matriu Rectangular</h1>";
echo mostraMatriu($rectangle);
echo mostraMatriu(transposaMatriu($rectangle));

/*
* Ha d'entrar un int
* Si entren 2 ints permet fer rectangles 
*
* $n == files, $m == columnes
*/
function creaMatriu(int $n):array{
	if(func_num_args()>1) $m = func_get_arg(1);
	else $m = $n;
	$array_matriu = [];
	$fila = [];
	for($i=0;$i<$n;$i++){
		for($j=0;$j<$m;$j++){
			if ($i == $j) $fila[$j] = "*";
			elseif ($i>$j)	$fila[$j] = rand(10,20);
			else $fila[$j] = $j+$i;
		}
		$array_matriu[] = $fila;
	}
	return $array_matriu;
}

/*
* converteix les columnes de la matriu d'entrada en files
* i les files en columnes
*/
function transposaMatriu(array $arr):array{
	$arr_reverse = [];
	for ($i=0; $i < sizeof($arr[0]); $i++) { 
		$fila = [];
		for ($j=0; $j < sizeof($arr); $j++) { 
			$fila[] = $arr[$j][$i];
		}
		$arr_reverse[] = $fila;
	}
	return $arr_reverse;
}

/*
* retorna la matriu en format html(string)
*/
function mostraMatriu(array $arr):string{
	$html = "<ul>";
	for ($i=0; $i < sizeof($arr); $i++) { 
		$fila = "";
		for ($j=0; $j < sizeof($arr[$i]); $j++) { 
			$fila = $fila."<div>".$arr[$i][$j]."</div>";
		}
		$html = $html."<li>".$fila."</li>";
	}
	return $html."</ul>";
}
?>

<!-- CSS -->
<style type="text/css">
	li
	{
		position: relative;
		list-style: none;
		display: flex;
	}
	div
	{
		position: relative;
		border: 1px solid black;
		height: 25px;
		line-height: 25px;
		width: 25px;
		text-align: center;
	}
</style>