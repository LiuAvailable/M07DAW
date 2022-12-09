<?php
session_start();
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
function llegeix(string $file) : array | bool
{
    $var = [];
    if ( file_exists($file) ) {
        $var = json_decode(file_get_contents($file), true);
    }
    if ($var ==null) {
        $var[] = 1;
    }
    return $var;
}
/**
 * mostra els logs de cada usuari
 */
function showConnections() : void{
    $dades = llegeix("conexions.json");
    for ($i=1; $i < sizeof($dades) ; $i++) { 
        if ($dades[$i]["user"] == $_SESSION["email"]) {
            echo "{$dades[$i]["status"]}: From {$dades[$i]["ip"]} at {$dades[$i]["time"]}<br>";
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
        <form action="index.php" method="post">
            <button>Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
</html>