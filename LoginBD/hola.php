<?php
session_start();

function DBConnection(){
    $db = 'dwes_liuSantana_autpdo';
    $servername = "localhost";
    $username = "dwes_user";
    $password = "dwes_pass";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        echo ($conn->connect_error);
        header('Location: index.php?bd_error', true, 303);
    }
    return $conn;
}
/**
 * elimina la sessio al passar un 1 min
 */
if ($_SESSION['time']<time()-60) {
    session_unset();
    header('Location: index.php', true, 302);
}
#time();
if ($_SESSION['nom'] == null) {
    header('Location: index.php', true, 303);
}
/**
 * Llegeix les dades del fitxer. Si el document no existeix torna un array buit.
 *
 * @param string $file
 * @return array or bool
 */
function llegeix(string $sql){   
    $conn = DBConnection();
    return $conn->query($sql);
}
/**
 * mostra els logs de cada usuari
 */
function showConnections() : void{
    $dades = llegeix("select email, status, ip, date from connexions where email = '{$_SESSION["email"]}' and (status = 'signin' or status = 'signup')");
    if ($dades->num_rows>0) {
        while ($row = $dades->fetch_assoc()) {
            echo "{$row["status"]}: From {$row["ip"]} at {$row["date"]}<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Benvingut</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>
<div class="container noheight" id="container">
    <div class="welcome-container">
        <h1>Benvingut!</h1>
        <div>Hola <?php echo $_SESSION['nom']; ?>, les teves darreres connexions són:</div>
        <?php showConnections(); ?>
        <form action="process.php" method="post">
            <button name="method" value="logout">Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
</html>