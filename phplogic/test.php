<?php 
session_start();
if (isset($_POST['paraula'])) {
	echo $_POST['paraula'];
	$arr = get_defined_functions();
	if (in_array($_POST['paraula'], $arr['internal']) and !in_array($_POST['paraula'], $_SESSION['adivinades'])) {
		$_SESSION['adivinades'][] = $_POST['paraula'];
		header('Location: index.php', true, 303);
	}
	else{header('Location: index.php', true, 303);}
}
?>