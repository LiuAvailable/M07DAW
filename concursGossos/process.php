<?php
session_start();
require_once('class/gos.php');
require_once('class/fase.php');

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

# checks the action to do
if (isset($_POST['newGos'])) {
    newParticipant();
}else if(isset($_POST['login'])) {
    login();
}else if(isset($_POST['signup'])) {
    signup();
}else if(isset($_POST['modifica'])) {
    modifyParticipant();
}else if(isset($_POST['fase'])) {
    modifyFase();
}else if(isset($_POST['esborrarFase'])){
    borrarFase();
}else if(isset($_POST['esborrarVots'])){
    borrarFases();
}else if(isset($_POST['vot'])){
    if(isset($_SESSION['freeVots'])){
        votar();
    }else{
        if(createSession()){votar();}
        else{cambiVot();}
    }
    pageReturn('index.php');
}else{header('Location: index.php', true, 303);}

#------------------
# GLOBAL FUNCTIONS
function pageReturn(string $place){header('Location:'.$place, true, 302);}
function pageReturn_error(string $place){header('Location:'.$place, true, 303);}

function checkInput_length(array $arr_post){
    global $conn;

    foreach ($arr_post as $name) {
        # get from DB the correct input format
        $sql = $conn->prepare("select * from checkInput where nom = ?");
        $sql->execute([$name]);
        $sql = $sql->fetch();
        if (strlen($_POST[$name])>$sql['length']){pageReturn_error('admin.php?newParticipant_error=length_'.$name);}
    }
}

function getData(){
    if(isset($_SESSION['date'])){
        return $_SESSION['date'];
    }else{return date("Y-m-d");}
}

function recoverFase(int $id){
    global $conn;

    $sql = $conn->prepare("select * from fase where num_fase = ?");
    $sql->execute([$id]);
    $sql = $sql->fetch();
    return new fase($sql['num_fase'], $sql['inici'],$sql['fi']);
}
# END GLOBAL FUNCTIONS
# -------------------

function login(){
    global $conn;
    if(isset($_POST['user']) && isset($_POST['pass'])){
        if($_POST['user']!=null && $_POST['pass']!=null){

            $sql = $conn->prepare("select * from login where user = ? and pass = ?");
            $sql->execute([$_POST['user'],$_POST['pass']]);
            $result = $sql->fetchAll();
            if ($result == null){pageReturn_error('login.php?error');}
            else{
                $_SESSION['user']=true;
                pageReturn('admin.php');
            }
        }else{pageReturn_error('login.php?empty');}
    }else{pageReturn_error('login.php?empty');}
}
function signup(){
    global $conn;
    if(isset($_POST['user']) && isset($_POST['pass'])){
        if($_POST['user']!=null && $_POST['pass']!=null){
            try{
                $sql = $conn->prepare("insert into login (user,pass) values(?,?)");
                $sql->execute([$_POST['user'],$_POST['pass']]);
                pageReturn('admin.php');
            }catch(Exception $e){
                pageReturn_error('admin.php?signup=retry');
            }

        }else{pageReturn_error('admin.php?signup=empty');}
    }else{pageReturn_error('admin.php?signup=empty');}
}

function checkNumberParticipants() : bool {
    global $conn;
    $sql = "select count(nom) as num from gos";
    $result = $conn->query($sql);
    $num = $result->fetch();
    if ($num>9) {
        return True;
    }else{return False;}
}

function newParticipant(){
    global $conn;
    if(checkNumberParticipants()){ # Si hi ha menys de 9 gossos inscrits:
        if ($_POST['nom']!=null and $_POST['img'] !=null and $_POST['amo'] != null and $_POST['raca']!=null) {
            checkInput_length(['nom','img','amo','raca']);
            $gos = new Gos($_POST['nom'],$_POST['amo'],$_POST['img'],$_POST['raca']);
            try{
                $gos->saveDB();
                pageReturn('admin.php');
            }
            catch (Exception $e){pageReturn_error('admin.php?newParticipant_error=primary');}
        }else{pageReturn_error('admin.php?newParticipant_error=null');};
    }else{pageReturn_error('admin.php?newParticipant_error=high');}
}

function modifyParticipant(){
    global $conn;
    if ($_POST['nom'] !=null and $_POST['img'] !=null and $_POST['amo'] != null and $_POST['raca']!=null) {
        checkInput_length(['nom','img','amo','raca']);
        $gos = new Gos($_POST['nom'],$_POST['amo'],$_POST['img'],$_POST['raca']);
        try{
            if($gos->updateDB($conn)){
                pageReturn('admin.php');  
            }else{pageReturn_error('admin.php?modifyParticipant_error');}
        }
        catch (Exception $e){pageReturn_error('admin.php?modifyParticipant_error');}
    }else{pageReturn_error('admin.php?newParticipant_error=null');};
}

function modifyFase(){
    global $conn;

    $data = getData();
    $fase = recoverFase(intval($_POST['id']));
    if($fase->inici <= $data){pageReturn_error('admin.php?faseEdit=started');}
    elseif($_POST['Inici']>=$_POST['Fi'] or $data>=$_POST['Inici']){pageReturn_error('admin.php?faseEdit=incorrectDates');}
    else{
        $fase->inici = $_POST['Inici'];
        $fase->fi = $_POST['Fi'];
        $fase->saveDB();
        pageReturn('admin.php');
    }
}
function createSession(){
    $user = $_SERVER['REMOTE_ADDR'];
    if(isset($_SESSION['vots'][$user])){
        return False;
    }else{
        $_SESSION['vots'][$user] = $_POST['vot'];
        return True;
    }
}
function votar(){
    global $conn;

    $sql = $conn->prepare("update gossos_fase set vots = vots + 1 where gos_name = ? and num_fase = ?");
    $sql->execute([$_POST['vot'], $_POST['fase_vots']]);
}
function cambiVot(){
    global $conn;

    $sql = $conn->prepare("update gossos_fase set vots = vots - 1 where gos_name = ? and num_fase = ?");
    $sql->execute([$_SESSION['vots'][$_SERVER['REMOTE_ADDR']], $_POST['fase_vots']]);
    $_SESSION['vots'][$_SERVER['REMOTE_ADDR']] = $_POST['vot'];
    votar();
}

function borrarFase(){
    global $conn;
    if ($_POST['esborrarFase'] != null && $_POST['esborrarFase']>0){
        $sql = $conn->prepare("update gossos_fase set vots = 0 where num_fase = ?");
        $sql->execute([$_POST['esborrarFase']]);  
        unset($_SESSION['vots']);
    }
    pageReturn('admin.php');
}
function borrarFases(){
    global $conn;
    $sql = $conn->prepare("update gossos_fase set vots = 0 where num_fase >0");
    $sql->execute();
    unset($_SESSION['vots']);
    pageReturn('admin.php');
}
?>