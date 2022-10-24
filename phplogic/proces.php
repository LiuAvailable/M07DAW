<?php 
session_start();
if (isset($_POST['paraula'])) {
	/**
	 * comprova si la paraula es valida i retorna la resposta a la pàgina principal a traves de gpr
	 */
	if (in_array($_POST['paraula'], $_SESSION['funcions'])){
		if(!in_array($_POST['paraula'], $_SESSION['adivinades'])) {
			$_SESSION['adivinades'][] = $_POST['paraula'];
		}else{
			$_SESSION['error']="Paraula repetida";
		}
	}else{
		$_SESSION['error']="No és una funció vàlida";
	}
	if (!str_contains($_POST['paraula'],$_SESSION['lletra'])) {
		$_SESSION['error'] = "No conte la lletra central";
	}
	header('Location: index.php', true, 303);
}
?>