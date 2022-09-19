<?php

//dades per encriptar
$key  = 'Una cadena, muy, muy larga para mejorar la encriptacion';
$method = 'aes-256-cbc';
$iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");


 $encriptar = function ($valor) use ($method, $key, $iv) {
     return openssl_encrypt ($valor, $method, $key, false, $iv);
 };


 $desencriptar = function ($valor) use ($method, $key, $iv) {
     $encrypted_data = base64_decode($valor);
     return openssl_decrypt($valor, $method, $key, false, $iv);
 };


 $getIV = function () use ($method) {
     return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)));
 };


$str = "es el alcalde el que quiere que sean los vecinos el alcalde. a veces lo mejor es no tomar decisiones, y eso en si, es una decision.";

$encriptat = $encriptar($str);
//Desencripta información:
$desencriptat = $desencriptar($encriptat);
echo 'Encriptat: '. $encriptat . '<br>';
echo 'Desencriptat: '. $desencriptat . '<br>';
echo "IV: " . $getIV();
?>