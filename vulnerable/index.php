<?php
    $mysqli = new mysqli("localhost","root","patata","dwes_liuSantana_autpdo");

	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	}

	/* Query and get the results */
	$user = $_GET["user"] ?? "";
	echo $user.'<br>';
	echo $a. '<br>';
	$pass = $_GET["pass"] ?? "";
	$query = "SELECT * FROM login WHERE email='$user' AND pass='$pass'";
	echo $query;
	$result = $mysqli -> query($query);

	/* Check results */
	$row = $result -> fetch_array(MYSQLI_ASSOC);
	if (!$row){
		die("Error authenticating");
	}
?>