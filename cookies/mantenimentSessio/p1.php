<?php 
$cookie_name = "sessio";
$session_name = "sessio1";
setcookie($cookie_name, $session_name, time()+3600);
header("Location: http://localhost:8080/helloworld/M07DAW/cookies/mantenimentSessio/p2.php");
?>