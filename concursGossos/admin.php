<?php 
session_start();
# eliminar els botons de modificar/afegir en cas de que estiguem a la fase 1


# -----------------
# CONNECT TO DATA BASE
function connectDB(){
    try {
        $dsn = "mysql:host=localhost;dbname=gossos";
        #$conn = new PDO($dsn, "king_Liu", "Bhkl55_piu");
        $conn = new PDO($dsn, "root", "patata");
    } catch (PDOException $e){echo $e->getMessage();}

    return $conn;
}
$conn = connectDB();
# END CONNETCION DB
# -----------------

if(!isset($_SESSION['user'])){header('Location:login.php', true, 303);}
function concursantsHTML(){
    global $conn;
    $sql = "select * from gos";
    foreach ($conn->query($sql) as $row) {
        ?>
        <form>
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
function printVotsThisFaseHTML(){
    global $conn;
    $fase = actualFase();
    $allVots = getAllvots($fase);
    if($allVots == 0){$allVots=1;}
    $sql = $conn->prepare("select f.*,img from gossos_fase as f join gos on gos_name = nom where num_fase = ?");
    $sql->execute([$fase]);
    $result = $sql->fetchAll();

    if ($result == null){echo "No hi ha cap fase activa";}
    else{
        echo "<h1> Resultat parcial: Fase ".$fase."</h1>";
        echo "<div class='gossos'>";
        foreach($result as $row){
            $title = $row['gos_name']." ".strval(round($row['vots']*100/$allVots,0)."%");
            echo "<img class='dog' alt=".$row['gos_name']." title='{$title}' src=".$row['img'].">";
        }
        echo "</div>";
    }
}
function getAllvots($fase){
    global $conn;
    $sql = $conn->prepare("select sum(vots) as allVots from gossos_fase where num_fase = ?");
    $sql->execute([$fase]);
    $result = $sql->fetch();
    return $result['allVots'];
}
function getData(){
    if(isset($_GET['data'])){
        $_SESSION['date']=$_GET['data'];
    }elseif(isset($_GET['nodata'])){unset($_SESSION["date"]);}
    if(isset($_SESSION['date'])){
        return $_SESSION['date'];
    }else{return date("Y-m-d");}
}
function actualFase(){
    global $conn;

    $data = getData();

    $sql = $conn->prepare("select * from fase where inici<= ? and fi >= ?");
    $sql->execute([$data, $data]);
    $result = $sql->fetch();
    if($result == null){
        return null;
    }else{
        return $result['num_fase'];
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
            <?php printVotsThisFaseHTML(); ?>
        </div>
        <div class="admin-row">
            <h1> Nou usuari: </h1>
            <form action='process.php' method='post'>
                <input type="text" placeholder="Nom" name='user'>
                <input type="password" placeholder="Contrassenya" name='pass'>
                <input type="submit" name='signup' value="Crea usuari">
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
                <input type="submit" value="afegeix" name="newGos">
            </form>
        </div>

        <div class="admin-row">
            <h1> Altres operacions: </h1>
            <form  method="post" action="process.php">
                Esborra els vots de la fase
                <input type="number" placeholder="Fase" name="esborrarFase" value="">
                <input type="submit" value="Esborra">
            </form>
            <form  method="post" action="process.php">
                Esborra tots els vots
                <input type="hidden" name="esborrarVots">
                <input type="submit" value="Esborra">
            </form>
        </div>
    </div>
</div>

</body>
</html>