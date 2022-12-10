<?php
session_start();

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
function printHTML(){
    global $conn;
    # get last fase id
    $sql = $conn->prepare("select max(f.num_fase) as num from gossos_fase as g join fase as f on g.num_fase = f.num_fase where f.fi < ?");
    $sql->execute([getData()]);
    $result = $sql->fetch();
    $maxFase = $result['num'];
    if($maxFase == null){echo "<h3 style='color:red'>No ha acabat cap fase</h3>";}
    else{printFasesHTML($maxFase);}
}
function printFasesHTML($maxFase){
    for ($i=1; $i <= $maxFase; $i++) { 
        echo "<div class='fase'>";
        echo "<h1> Resultat fase ".strval($i)." </h1>";
        printFaseHTML($i);
        echo "</div>";
    }
}
function printFaseHTML($fase){
    global $conn;
    $allVots = getAllvots($fase);
    $sql = $conn->prepare("select f.*,img from gossos_fase as f join gos on gos_name = nom where num_fase = ?");
    $sql->execute([$fase]);
    $result = $sql->fetchAll();

    if ($result == null){echo "hi ha hagut un error";}
    else{
        foreach($result as $row){
            $title = $row['gos_name']." ".strval(round($row['vots']*100/$allVots,0)."%");
            echo "<img class='dog' alt=".$row['gos_name']." title='{$title}' src=".$row['img'].">";
        }
    }

}
function getAllvots($fase){
    global $conn;
    $sql = $conn->prepare("select sum(vots) as allVots from gossos_fase where num_fase = ?");
    $sql->execute([$fase]);
    $result = $sql->fetch();
    return $result['allVots'];
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat votació popular Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="wrapper large">
    <header>Resultat de la votació popular del Concurs Internacional de Gossos d'Atura 2023</header>
    <div class="results">
        <?php printHTML(); ?>
    </div>

</div>

</body>
<script>
    window.onload = () => {
        let fases = document.querySelectorAll('.fase');

        for (let i = 1; i <= fases.length; i++) {
            let gossos = document.querySelectorAll('.fase:nth-child('+i+')  img');
            let eliminat = [101,''];  
            gossos.forEach(img => {
                let vots = img.title.split(' ');
                vots = parseInt(vots[1].replace(/\D/g, ''))
                if(vots<=eliminat[0]){
                    eliminat[0] = vots;
                    eliminat[1] = img.alt;
                }
            });
            document.querySelector(".fase:nth-child("+i+")  img[alt='"+eliminat[1]+"']").classList.add('eliminat');
        }
    }
</script>
</html>