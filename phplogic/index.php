<?php
/**
 * declaro les sessions si no existeixen
 */
session_start();
$arr = get_defined_functions();
$_SESSION['totes']=$arr['internal'];
if(!isset($_SESSION['adivinades'])){$_SESSION['adivinades'] = [];}
if(!isset($_SESSION['funcions'])){$_SESSION['funcions'] = [];}
if(!isset($_SESSION['data'])){$_SESSION['data'] = [];}
if(!isset($_SESSION['error'])){$_SESSION['error'] = "";}


randomLettersFromDate();
if(isset($_GET['neteja'])){$_SESSION['adivinades']=[];}
if(isset($_GET['sol'])){print_r($_SESSION['funcions']);} # printo les solucions si les demana
/** 
 * retorna les paraules trobades
 */
function mostrarFuncionsTrobades(){
    if (sizeof($_SESSION['adivinades'])>0) {
        $trobades = "";
        for ($i=0; $i < sizeof($_SESSION['adivinades']); $i++) { 
            $trobades=$trobades.$_SESSION['adivinades'][$i].", ";
        }
        return " (".rtrim($trobades, ", ").")";
    } 
}
/**
 * donada una data crea una seed i retorna 7 lletres que formin minm 3 funcions
 */
function getLetters($data){
    $minParaules = null;
    srand($data);
    $funcions = get_defined_functions()['internal'];
    while ($minParaules == null) {
        $lletres = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz_"), 0,7); # Barreja les lletres
        $lletra = substr($lletres, 3,1);
        $_SESSION['lletra'] = $lletra;
        $pattern = "/^[".strval($lletres)."]*".$lletra."[".strval($lletres)."]*$/"; # Regex -> lletra central i no diferent a les 7 lletres 
        $minParaules = checkFunctions($pattern, $funcions);
    }
    return $lletres;
}
/**
 * Comprova si les lletres poden formar minim 3 paraules
 */
function checkFunctions($pattern, $funcions)
{
    $_SESSION['funcions'] = array();
    foreach ($funcions as $funcio) {
        if (preg_match($pattern, $funcio)) {
            $_SESSION['funcions'][] = $funcio;
        }
    }
    if (count($_SESSION['funcions']) >= 3) {
        return $_SESSION['funcions'];
    }
    return null;
}
/**
 * Si entren una data canvia les lletres
 * Sino agafa la del dia d'avui
 */
function randomLettersFromDate(){
    if(isset($_GET['data'])){
        $_SESSION['data'] = $_GET['data'];
        $_SESSION['lletres'] = getLetters($_SESSION['data']);
    }
    if($_SESSION['data'] != []){
        $_SESSION['lletres'] = getLetters($_SESSION['data']);
    }else{
        $_SESSION['lletres'] = getLetters(date("Ymd"));
    }
}

/**
 * Dibuixa les lletres en l'html
 */
function printLetters(){
    for ($i=0; $i < 7; $i++) { 
        ?>
        <li class="hex">
            <div class="hex-in">
                <a class="hex-link" <?php if ($i == 3) {echo "id = 'center-letter'";} ?>data-lletra='<?php echo $_SESSION['lletres'][$i]; ?>' draggable="false"><p><?php echo $_SESSION['lletres'][$i] ?></p></a>
            </div>
        </li>
        <?php
    }
}

function mostrarErrors(){
    if ($_SESSION['error']!="") {
        ?>
        <div class="container-notifications">
            <p class="hide" id="message" style=""><?php echo $_SESSION['error']; ?></p>
        </div>
        <?php
        $_SESSION['error']="";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body data-joc="2022-10-07">
<div class="main">
    <h1>
        <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
    </h1>

    <?php mostrarErrors();?>
    <form class="main" action="proces.php" method="POST">
        <div class="cursor-container">
            <p id="input-word"><span id="test-word"></span><span id="cursor">|</span></p>
        </div>

        <div class="container-hexgrid">
            <ul id="hex-grid">
                <?php printLetters(); ?>
            </ul>
        </div>

        <div class="button-container">
            <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
            <button id="shuffle-button" type="button" class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
                <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path fill="currentColor"
                          d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
                </svg>
            </button>

                <input type="text" id="secret_input" hidden="true" name='paraula'>
                <button id="submit-button" type="submit" title="Introdueix la paraula" value=>Introdueix</button>
    </form>
    </div>

    <div class="scoreboard">
        <div>Has trobat <span id="letters-found"><?php echo sizeof($_SESSION['adivinades'])?></span> <span id="found-suffix">funcions</span><span id="discovered-text"><?php echo mostrarFuncionsTrobades() ?>.</span>
        </div>
        <div id="score"></div>
        <div id="level"></div>
    </div>
</div>
<script>
    
    function amagaError(){
        if(document.getElementById("message"))
            document.getElementById("message").style.opacity = "0"
    }

    function afegeixLletra(lletra){
        document.getElementById("test-word").innerHTML += lletra
        saveWord()
    }

    function suprimeix(){
        document.getElementById("test-word").innerHTML = document.getElementById("test-word").innerHTML.slice(0, -1)
        saveWord()
    }

    function saveWord()
    {
        document.getElementById("secret_input").value = document.getElementById("test-word").textContent
    }

    window.onload = () => {
        // Afegeix funcionalitat al click de les lletres
        Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
            el.onclick = ()=>{afegeixLletra(el.getAttribute("data-lletra"));}
        })

        setTimeout(amagaError, 2000)

        //Anima el cursor
        let estat_cursor = true;
        setInterval(()=>{
            document.getElementById("cursor").style.opacity = estat_cursor ? "1": "0"
            estat_cursor = !estat_cursor
        }, 500)
    }

</script>
</body>
</html>