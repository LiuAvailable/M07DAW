<?php 
$valor = onload();
/*
*  connecta amb les altres funcions
*  @return $valor
*/
function onload(){
    $valor = ""; # guardem els valors concatenats com a string
    $pantalla = ""; # valor de la pantalla actual
    setPantalla($pantalla);
    setValue($valor, $pantalla);
    return $valor;
}

/*
* si existeix, agafa el valor de la pantalla
* @arr $pantalla (per referencia) -> contingut pantalla
*/
function setPantalla(&$pantalla){
    if (isset($_REQUEST['pantalla'])) {
        if($_REQUEST['pantalla'] != ""){$pantalla = $_REQUEST['pantalla'];}
    }
}

/*
* si s'entra un nou valor el concatena a la pantalla
* si fa click a '=' envia a la funcio calcOperation
*
* @arr $valor (per referencia) -> contingut pantalla + valor entrat
* @arr $pantalla (per referencia) -> contingut pantalla
*
*  modifica la variable $valor (nou valor de la pantalla)
*/
function setValue(&$valor, &$pantalla){
    if (isset($_REQUEST['valor'])) {
        $valor = $pantalla.$_REQUEST['valor'];
    }elseif (isset($_REQUEST['equal'])) {calcOperation($valor,$pantalla);}
}

/*
* s'activa al fer click a '=' i calcula el resultat
*
* @arr $valor (per referencia) -> contingut pantalla + valor entrat
* @arr $pantalla (per referencia) -> contingut pantalla
*
*  modifica la variable $valor (nou valor de la pantalla)
*/
function calcOperation(&$valor, &$pantalla){
    $pantalla = ltrim($pantalla,0);
    $pattern = "/^[0-9()+-.*\/sinco]*$/"; # regex (numeros, +-*/() i les lletres sinco)
    if (preg_match($pattern, $pantalla)) {
        try{
            eval("\$pantalla = $pantalla;");
            $valor = round($pantalla,4); # arrodonim a màxim 4 decimals
        }catch(DivisionByZeroError $e){ # si dividim entre 0 posem infinit per pantalla
            $valor = "inf";
        }catch(\throwable $e){$valor = 'ERROR';} # resta d'errors posem error per pantalla
    }else{$valor = "ERROR";}  
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Calculadora</title>
</head>
<body>
    <div class="container">
        <form name="calc" class="calculator" action="index.php" method="get">
            <input type="text" class="value" name="pantalla" readonly value="<?php echo $valor;  ?>" />
            <span class="num"><input type ="submit" value="(" name="valor"></span>
            <span class="num"><input type ="submit" value=")" name="valor"></span>
            <span class="num"><input type ="submit" value="sin" name="valor"></span>
            <span class="num"><input type ="submit" value="cos" name="valor"></span>
            <span class="num clear"><input type ="submit" value="C"></span>
            <span class="num"><input type ="submit" value="/" name="valor"></span>
            <span class="num"><input type ="submit" value="*" name="valor"></span>
            <span class="num"><input type ="submit" value="7" name="valor"></span>
            <span class="num"><input type ="submit" value="8" name="valor"></span>
            <span class="num"><input type ="submit" value="9" name="valor"></span>
            <span class="num"><input type ="submit" value="-" name="valor"></span>
            <span class="num"><input type ="submit" value="4" name="valor"></span>
            <span class="num"><input type ="submit" value="5" name="valor"></span>
            <span class="num"><input type ="submit" value="6" name="valor"></span>
            <span class="num plus"><input type ="submit" value="+" name="valor"></span>
            <span class="num"><input type ="submit" value="1" name="valor"></span>
            <span class="num"><input type ="submit" value="2" name="valor"></span>
            <span class="num"><input type ="submit" value="3" name="valor"></span>
            <span class="num"><input type ="submit" value="0" name="valor"></span>
            <span class="num"><input type ="submit" value="00" name="valor"></span>
            <span class="num"><input type ="submit" value="." name="valor"></span>
            <span class="num equal"><input type ="submit" value="=" name="equal"></span>
        </form>
    </div>
</body>
<?php 


?>