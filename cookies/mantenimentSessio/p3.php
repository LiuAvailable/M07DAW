<?php 
$cookie_name = "sessio";
if(isset($_COOKIE[$cookie_name])) {
     setcookie($cookie_name, "", time()-3600);
} 
echo $cookie_name. " has been killed";
?>