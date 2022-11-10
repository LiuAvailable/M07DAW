<?php 
session_start();
if(isset($_POST['method'])){
    if ($_POST['method'] == "signup") {
        signup();
    }elseif ($_POST['method'] == "signin") {
        login();
    }elseif($_POST['method'] == "logout") {
        logOut();
    }else{header('Location: index.php', true, 303);}
}else{header('Location: index.php', true, 303);}

function DBConnection(){
    $db = 'dwes_liuSantana_autpdo';
    $servername = "localhost";
    $username = "dwes_user";
    $password = "dwes_pass";

    // Create connection
    $pdo = new PDO ("mysql:host=$servername;dbname=$db","$username","$password");

    return $pdo;
}
function pdoConn($sql){
    $pdo = DBConnection();
    return $pdo->prepare($sql);
}
/**
 * genera les sessions de l'usuari
 */
function create_sessions($email, $nom) : void{
    $_SESSION['email'] = $email;
    $_SESSION['time'] = time();
    $_SESSION['nom'] = $nom;
}

function conexionsLog($email, $status){
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = date("Y-m-d H:i:s");
    $sql = "insert into connexions(email,status,ip,date) values(?,?,?,?)";
    $query = pdoConn($sql);
    $query->execute(array($email,$status,$ip,$data));
}

function login(){
    if (isset($_POST['email']) && isset($_POST['pass']) ) {
        if ($_POST['email'] != "" && $_POST['pass'] != "") {
            $data = pdoConn("select * from login where email = ?");
            $data->execute(array($_POST['email']));
            $row = $data->fetch();
            if ($row!=False) {
                if ($row['pass'] == md5($_POST['pass'])) {
                    create_sessions($_POST['email'], $row['nom']);
                    conexionsLog($_POST['email'],'signin');
                    header('Location: hola.php', true, 303);
                }else{
                    conexionsLog($_POST['email'],'incorrect_pass');
                    header('Location: index.php?login_error=incorrect_pass', true, 303);
                }
            }else{
                conexionsLog($_POST['email'],'incorrect_user');
                header('Location: index.php?login_error=incorrect_user', true, 303);
            }
        }else{ # falten dades
            conexionsLog($_POST['email'],'login_error');
            header('Location: index.php?login_error=data', true, 303);
        }
    }
}
function logOut(){
    conexionsLog($_SESSION['email'],'logout');
    session_unset();
    header('Location: index.php', true, 302);
}

function checkIfUserExists(string $user) : bool{
    $data = pdoConn("select * from login where email = ?");
    $data->execute(array($user));
    $result = $data->fetch();
    if ($result!=null) {
        return false;
    }else{return true;}
}

function signup() : void {
    if (isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['pass'])) {
        if ($_POST['nom'] != "" && $_POST['email'] != "" && $_POST['pass'] != "" ) {

            if(checkIfUserExists($_POST['email'])){
                $pass = md5($_POST['pass']);
                #$sql = "insert into login(email, nom, pass) values('{$_POST['email']}','{$_POST['nom']}','{$pass}')";
                $sql = "insert into login(email, nom, pass) values(?,?,?)";
                $query = pdoConn($sql);
                $query->execute(array($_POST['email'],$_POST['nom'],$pass));
                create_sessions($_POST['email'],$_POST['nom']);
                conexionsLog($_POST['email'],'signup');
                header('Location: hola.php', true, 302);

            }else{ # else return error already registered
                conexionsLog($_POST['email'],'user_exists');
                header('Location: index.php?reg_error=user_exists', true, 303);
            }
        }else{
            conexionsLog($_POST['email'],'reg_error');
            header('Location: index.php?reg_error=data', true, 303);
        }
    }

}
?>