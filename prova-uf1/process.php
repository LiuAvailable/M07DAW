<?php 
session_start();
if(isset($_POST['method'])){
    if ($_POST['method'] == "signup") {
        singup();
    }elseif ($_POST['method'] == "signin") {
        login();
    }
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
 * Guarda les dades a un fitxer
 *
 * @param array $dades
 * @param string $file
 */
function escriu(array $dades, string $file): void
{
    file_put_contents($file,json_encode($dades, JSON_PRETTY_PRINT));
}

/**
 * genera les sessions de l'usuari
 */
function create_sessions(string $email) : void{
    $_SESSION['email'] = $email;
    $data = llegeix("usuaris.json");
    if (isset($data[$_SESSION['email']])) {
        $_SESSION['nom'] = $data[$_SESSION['email']]['name'];
    }else{$_SESSION['nom'] = "";}
    
}
/**
 * funcio per registrar un usuari
 * afegeix les dades en cas de que no existeixin i redirigeix a hola.php
 */
function singup() : void{
    if (isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['pass'])) {
        if ($_POST['nom'] != "" && $_POST['email'] != "" && $_POST['pass'] != "" ) {
            $user_data['email'] = $_POST['email'];
            $user_data['password'] = $_POST['pass'];
            $user_data['name'] = $_POST['nom'];
            $data = checkIfUserExists($_POST['email']);
            if ($data!= false){
                $data[$_POST['email']]=$user_data;
                escriu($data, "usuaris.json");
                create_sessions($_POST['email']);
                header('Location: hola.php', true, 302);
            }else{ # else return error already registered
                $_SESSION['error'] = "L'usuari ja existeix";
                header('Location: index.php', true, 303);
            }
        }else{
            $_SESSION['error'] = "falten dades";
            header('Location: index.php', true, 303);
        }
    }

}
/**
 * comprova si l'usuari que fa el registre existeix
 *
 * @param string $user
 * @return null or array
 */
function checkIfUserExists(string $user) : null | array{
    $data = llegeix("usuaris.json");
    if(isset($data[$user])){
        return null; //si ja existeix retorna null
    }else{return $data;} //si no existeix retorna totes les dades del json
}
/**
 * logineja l'usuari
 */
function login() : void{
    if (isset($_POST['email']) && isset($_POST['pass']) ) {
        if ($_POST['email'] != "" && $_POST['pass'] != "") {
            $data = llegeix("usuaris.json");
            if (isset($data[$_POST['email']])) {
                if ($data[$_POST['email']]['password'] == $_POST['pass']) {
                    connectionLogs($_POST['email'], "login_success");
                    create_sessions($_POST['email']);
                    header('Location: hola.php', true, 302);
                }else{#incorrect pass
                connectionLogs($_POST['email'], "incorrect_password");
                header('Location: index.php', true, 302);
                }         
            }else{ #user dont exist
            connectionLogs($_POST['email'], "incorrect_user");
            header('Location: index.php', true, 302);
            }
        }else{ # falten dades
            header('Location: index.php', true, 303);
        }
    }
}
/**
 * insereix en el fitxer conexions.json els logs de les connexions
 */
function connectionLogs(string $user, string $status) : void{
    $data = llegeix("conexions.json");
    $connection_data['ip']=$_SERVER['REMOTE_ADDR'];
    $connection_data['user']=$user;
    $connection_data['time']=date("Y-m-d H:i:s");
    $connection_data['status']=$status;
    $data[] = $connection_data;
    escriu($data, "conexions.json");
}
?>