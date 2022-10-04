<?php
if (isset($_REQUEST['numero'])) {
	print_r(esPrimer($_REQUEST['numero']));
}else{
	?>
	<form action="numeroPrimer.php" method="post">
		<input type="number" name="numero" value="1" min="1" required>
		<input type="submit" name="">
	</form>
	<?php
}

function agafarDivisors(int $n)
{
	$arr_divisors = [];
	for ($i=1; $i <=$n ; $i++) { 
		if ($n % $i == 0) {
			$arr_divisors[] = $i;
		}
	}
	return $arr_divisors;
}
function esPrimer()

?>