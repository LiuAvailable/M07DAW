<?php
session_start();
require_once('class/fase.php');

# -----------------
# CONNECT TO DATA BASE
function connectDB(){
    try {
        $dsn = "mysql:host=localhost;dbname=gossos";
        $conn = new PDO($dsn, "king_Liu", "Bhkl55_piu");
    } catch (PDOException $e){echo $e->getMessage();}

    return $conn;
}
$conn = connectDB();
# END CONNETCION DB
# -----------------


if(isset($_GET['freevots'])){$_SESSION["freeVots"]=true;}
if(isset($_GET['nofreevots'])){unset($_SESSION["freeVots"]);}


/**
 * data -> crea una sessio amb la data rebuda per get
 * nodata -> elimina la sessio de la data
 */
function getData(){
    if(isset($_GET['data'])){
        $_SESSION['date']=$_GET['data'];
    }elseif(isset($_GET['nodata'])){unset($_SESSION["date"]);}
    if(isset($_SESSION['date'])){
        return $_SESSION['date'];
    }else{return date("Y-m-d");}
}
function actualFase(): null | Fase{
    global $conn;

    $data = getData();

    $sql = $conn->prepare("select * from fase where inici<= ? and fi >= ?");
    $sql->execute([$data, $data]);
    $result = $sql->fetch();
    if($result == null){
        return null;
    }else{
        createSessionFase($result['num_fase']);
        return new Fase($result['num_fase'], $result['inici'],$result['fi']);
    }
}
function createSessionFase($num){
    if(isset($_SESSION["fase"])){
        if($_SESSION["fase"]!=$num){
            $_SESSION["fase"]=$num;
            unset($_SESSION["vots"]);
        }
    }else{
        $_SESSION['fase']=$num;
    }
}
function printHTML(){
    global $conn;
    $fase = actualFase();

    if($fase == null){
        ?>
        <div class="wrapper">
            <header>No hi ha cap fase iniciada</header>
        </div>
        <?php
    }else{
        $fase->getGossosInscrits($conn);
        ?>
        <div class="wrapper">
            <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023-FASE <?php echo $fase->numFase;?></header>
            <p class="info"> Podeu votar fins el dia <?php echo $fase->fi;?></p>
            <?php warningHTML() ?>
            <!--<p class="warning"> Ja has votat al gos MUSCLO. Es modificarà la teva resposta</p>-->
            <div class="poll-area">
                <?php printGossosAVotarHTML($fase);?>
            </div>
            <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
        </div>
        <?php
    }
}
function printGossosAVotarHTML(Fase $fase){
    global $conn;

    $sql = $conn->prepare("select f.gos_name,f.num_fase,g.img from gossos_fase as f join gos as g on f.gos_name = g.nom where f.num_fase = ?");
    $sql->execute([$fase->numFase]);
    $result = $sql->fetchAll();
    if ($result == null){
        echo "<p>No s'ha votat en les fases anteriors<p>";
    }else{
        foreach($result as $row){
            ?>
            <label id="<?php echo  $row['gos_name']?>">
                <form class="votGos" method="post" action="process.php">
                    <input type="hidden" name="vot" value="<?php echo $row['gos_name']?>">
                    <input type="hidden" name="fase_vots" value="<?php echo $fase->numFase?>">
                    <input type=submit>
                </form>
                <div class="row">
                    <div class="column">
                        <div class="right">
                        <span class="circle"></span>
                        <span class="text"><?php echo  $row['gos_name']?></span>
                        </div>
                        <img class="dog"  alt="<?php echo  $row['gos_name']?>" src="<?php echo  $row['img']?>">
                    </div>
                </div>
            </label>
            <?php
        }
    }
}

function warningHTML(){
    if(isset($_SESSION['vots'][$_SERVER['REMOTE_ADDR']])){
        echo "<p class='warning'> Ja has votat al gos ".$_SESSION['vots'][$_SERVER['REMOTE_ADDR']].". Es modificarà la teva resposta</p>";
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
<?php printHTML();?>

</body>
</html>