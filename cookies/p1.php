<?php
$cookie_name = "LiuSantana";
if(isset($_COOKIE[$cookie_name])) {
     setcookie($cookie_name, $_COOKIE[$cookie_name]+1);
} else{
	setcookie($cookie_name, 100, time() + (86400 * 30), "/");
}

?>