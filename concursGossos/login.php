<?php
function errorHTML(){
    if(isset($_GET['error'])){
        echo "<p style='color:red'>L'usuari no existeix</p>";
    }elseif(isset($_GET['empty'])){
        echo "<p style='color:red'>No es permeten camps buits</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper centrar">
        <h1>Inicia Sessió</h1>
        <?php errorHTML();?>
        <form action="process.php" method="post">
            <label>User:</label><input type="test" name="user">
            <br><label>Pass:</label><input type="password" name="pass">
            <br><input type="submit" value="ENTRAR" name="login">
    </div>

</body>
</html>