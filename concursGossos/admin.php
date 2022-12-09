<?php 
session_start();
# eliminar els botons de modificar/afegir en cas de que estiguem a la fase 1


# -----------------
# CONNECT TO DATA BASE
function connectDB(){
    try {
        $dsn = "mysql:host=localhost;dbname=gossos";
        $conn = new PDO($dsn, "root", "patata");
    } catch (PDOException $e){echo $e->getMessage();}

    return $conn;
}
$conn = connectDB();
# END CONNETCION DB
# -----------------
 
function concursantsHTML(){
    global $conn;
    $sql = "select * from gos";
    foreach ($conn->query($sql) as $row) {
        ?>
        <form  method="post" action="process.php">
            <input type="text" placeholder="Nom" name="nom" value="<?php echo $row['nom'] ?>">
            <input type="text" placeholder="Imatge" name="img" value="<?php echo $row['img'] ?>">
            <input type="text" placeholder="Amo" name="amo" value="<?php echo $row['amo'] ?>">
            <input type="text" placeholder="Raça" name="raca" value="<?php echo $row['raca'] ?>">
            <input type="submit" value="Modifica" name="modifica">
        </form>
        <?php
    }
}

function fasesHTML(){
    echo "<h1> Fases: </h1>";
    global $conn;
    $sql = "select * from fase order by num_fase";
    foreach($conn->query($sql) as $row){
    ?>
        <form class="fase-row" method="post" action="process.php">
            Fase <input type="text" name="id" value="<?php echo $row["num_fase"] ?>" disabled style="width: 3em">
            <input type="text" name="id" value="<?php echo $row["num_fase"] ?>" hidden>
            del <input type="date" name="Inici" value="<?php echo $row["inici"] ?>">
            al <input type="date" name="Fi" value="<?php echo $row["fi"] ?>">
            <input type="submit" value="Modifica" name="fase">
        </form>
    <?php 
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="wrapper medium">
    <header>ADMINISTRADOR - Concurs Internacional de Gossos d'Atura</header>
    <div class="admin">
        <div class="admin-row">
            <h1> Resultat parcial: Fase 1 </h1>
            <div class="gossos">
            <img class="dog" alt="Musclo" title="Musclo 15%" src="img/g1.png">
            <img class="dog" alt="Jingo" title="Jingo 45%" src="img/g2.png">
            <img class="dog" alt="Xuia" title="Xuia 4%" src="img/g3.png">
            <img class="dog" alt="Bruc" title="Bruc 3%" src="img/g4.png">
            <img class="dog" alt="Mango" title="Mango 13%" src="img/g5.png">
            <img class="dog" alt="Fluski" title="Fluski 12 %" src="img/g6.png">
            <img class="dog" alt="Fonoll" title="Fonoll 5%" src="img/g7.png">
            <img class="dog" alt="Swing" title="Swing 2%" src="img/g8.png">
            <img class="dog eliminat" alt="Coloma" title="Coloma 1%" src="img/g9.png"></div>
        </div>
        <div class="admin-row">
            <h1> Nou usuari: </h1>
            <form>
                <input type="text" placeholder="Nom">
                <input type="password" placeholder="Contrassenya">
                <input type="button" value="Crea usuari">
            </form>
        </div>
        <div class="admin-row">
            <?php fasesHTML(); ?>

        </div>

        <div class="admin-row">
            <h1> Concursants: </h1>
            <?php concursantsHTML();?>
            <form method="post" action="process.php">
                <input type="text" placeholder="Nom" name="nom">
                <input type="text" placeholder="Imatge" name="img">
                <input type="text" placeholder="Amo" name="amo">
                <input type="text" placeholder="Raça" name="raca">
                <!--<input type="button" value="Afegeix">-->
                <input type="submit" value="afegeix" name="newGos">
            </form>
        </div>

        <div class="admin-row">
            <h1> Altres operacions: </h1>
            <form>
                Esborra els vots de la fase
                <input type="number" placeholder="Fase" value="">
                <input type="button" value="Esborra">
            </form>
            <form>
                Esborra tots els vots
                <input type="button" value="Esborra">
            </form>
        </div>
    </div>
</div>

</body>
</html>