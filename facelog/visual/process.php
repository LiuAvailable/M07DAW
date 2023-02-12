<?php
require('../../../../wp-load.php');

$path = "../uploads/img/". basename($_FILES['file']['name']); 
if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
    echo "El archivo ".  basename( $_FILES['file']['name']). " ha sido subido";
} else{
    echo "El archivo no se ha subido correctamente";
}
global $wpdb;
$wpdb = $GLOBALS['wpdb'];


$table_name = $wpdb->prefix . "images";
$sql = "CREATE TABLE if not exists `{$table_name}` (
    nom varchar(255) NOT NULL,
    usuari varchar(255) NOT NULL,
    fecha date NOT NULL
  )";

$result = $wpdb->query($sql);
if ($result === false) {
    // handle the error
}

$file_name = basename($_FILES['file']['name']);
$wpdb->insert( 
	$table_name, 
	array( 
		'nom' => $file_name, 
		'usuari' => 'liu',
		'fecha' => '2023-02-02'
	) 
);

?>