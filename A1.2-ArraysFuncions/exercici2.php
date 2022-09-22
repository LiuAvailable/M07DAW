<?php 
$quadrat = creaMatriu(2);
echo mostraMatriu($quadrat);
echo mostraMatriu(transposaMatriu($quadrat));

function creaMatriu(int $n):array{
	$array_matriu= [];
	for($i=0;$i<$n;$i++){
		for($j=0;$j<$n;$j++){
			if ($i == $j) {
				$array_matriu[] = "*";
			}elseif ($i>$j) {
				$array_matriu[] = rand(10,20);
			}else{
				$array_matriu[] = $j+$i;
			}
		}
	}
	return $array_matriu;
}

function transposaMatriu(array $arr):array{
	$arr_reverse = [];
	$key = array_count_values($arr);
	$key = (int)$key['*'];
	for ($i=0; $i < $key ; $i++) { 
		for ($j=0; $j < $key; $j++) { 
			$arr_reverse[]= $arr[$key*$j+$i];
		}
	}
	return $arr_reverse;
}



function mostraMatriu(array $arr):string{
	$html = "<ul>";
	$key = array_count_values($arr);
	$key = (int)$key['*'];
	for ($i=0; $i < sizeof($arr); $i=$i+$key) {
		$li_html = "";
		for ($j=$i; $j < $i+$key; $j++) { 
			$li_html = $li_html."<div>". $arr[$j]."</div>";
		}
		$html=$html."<li>".$li_html."</li>";
	}
	return $html."</ul>";
}
?>



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