<?php
session_start();
require_once('class/fase.php');

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
function actualFase(): null | fase{
    global $conn;

    $data = getData();

    $sql = $conn->prepare("select * from fase where inici<= ? and fi >= ?");
    $sql->execute([$data, $data]);
    $result = $sql->fetch();
    if($result == null){
        return null;
    }else{
        return new fase($result['num_fase'], $result['inici'],$result['fi']);
    }
}
function printHTML(){
    global $conn;
    $fase = actualFase();
    $fase->getGossosInscrits($conn);

    if($fase == null){
        ?>
        <div class="wrapper">
            <header>No hi ha cap fase iniciada</header>
        </div>
        <?php
    }else{
        ?>
        <div class="wrapper">
            <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023-FASE <?php echo $fase->numFase;?></header>
            <p class="info"> Podeu votar fins el dia <?php echo $fase->fi;?></p>

            <p class="warning"> Ja has votat al gos MUSCLO. Es modificarà la teva resposta</p>
            <div class="poll-area">
                <?php printGossosAVotarHTML($fase);?>
                <!--<label>
                    <div class="row">
                        <div class="column">
                            <div class="right">
                            <span class="circle"></span>
                            <span class="text">Musclo</span>
                            </div>
                            <img class="dog"  alt="Musclo" src="img/g1.png">
                        </div>
                    </div>
                </label>-->
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
<!--<div class="wrapper">
    <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023-FASE <?php echo $fase->numFase;?></header>
    <p class="info"> Podeu votar fins el dia <?php echo $fase->fi;?></p>

    <p class="warning"> Ja has votat al gos MUSCLO. Es modificarà la teva resposta</p>
    <div class="poll-area">
        <form>
        <input type="checkbox" name="poll" id="opt-1">
        <input type="checkbox" name="poll" id="opt-2">
        <input type="checkbox" name="poll" id="opt-3">
        <input type="checkbox" name="poll" id="opt-4">
        <input type="checkbox" name="poll" id="opt-5">
        <input type="checkbox" name="poll" id="opt-6">
        <input type="checkbox" name="poll" id="opt-7">
        <input type="checkbox" name="poll" id="opt-8">
        <input type="checkbox" name="poll" id="opt-9">
        <label for="opt-1" class="opt-1">
            <div class="row">
                <div class="column">
                    <div class="right">
                    <span class="circle"></span>
                    <span class="text">Musclo</span>
                    </div>
                    <img class="dog"  alt="Musclo" src="img/g1.png">
                </div>
            </div>
        </label>
        <label for="opt-2" class="opt-2">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Jingo</span>
                    </div>
                    <img class="dog"  alt="Jingo" src="img/g2.png">
                </div>
            </div>
        </label>
        <label for="opt-3" class="opt-3">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Xuia</span>
                    </div>
                    <img class="dog"  alt="Xuia" src="img/g3.png">
                </div>
            </div>
        </label>
        <label for="opt-4" class="opt-4">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Bruc</span>
                    </div>
                    <img class="dog"  alt="Bruc" src="img/g4.png">
                </div>
            </div>
        </label>
        <label for="opt-5" class="opt-5">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Mango</span>
                    </div>
                    <img class="dog"  alt="Mango" src="img/g5.png">
                </div>
            </div>
        </label>
        <label for="opt-6" class="opt-6">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Fluski</span>
                    </div>
                    <img class="dog"  alt="Fluski" src="img/g6.png">
                </div>
            </div>
        </label>
        <label for="opt-7" class="opt-7">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Fonoll</span>
                    </div>
                    <img class="dog"  alt="Fonoll" src="img/g7.png">
                </div>
            </div>
        </label>
        <label for="opt-8" class="opt-8">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Swing</span>
                    </div>
                    <img class="dog"  alt="Swing" src="img/g8.png">
                </div>
            </div>
        </label>
        <label for="opt-9" class="opt-9">
            <div class="row">
                <div class="column">
                    <div class="right">
                        <span class="circle"></span>
                        <span class="text">Coloma</span>
                    </div>
                    <img class="dog"  alt="Coloma" src="img/g9.png">
                </div>
            </div>
        </label>
        </form>
    </div>

    
</div>-->
    

</body>
</html>