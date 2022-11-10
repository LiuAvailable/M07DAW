<?php 
    /**
     * comprova si hi ha un error de login per GET
     */
    function login_error(){
        if(isset($_GET['login_error'])){
            if ($_GET['login_error']=='incorrect_user') {writeError("l'usuari no existeix");}
            if ($_GET['login_error']=='incorrect_pass') {writeError("la contrassenya no és correcte");}
            if ($_GET['login_error']=='data') {writeError("falten dades!!");}
        }
    }
    /**
     * comprova si hi ha un error de registre per GET
     */
    function reg_error(){
        if (isset($_GET['reg_error'])){
            if ($_GET['reg_error']=='user_exists') {writeError("l'usuari ja existeix");}
            if ($_GET['reg_error']=='data') {writeError("falten dades!!");}
            # js per mostrar la part de registre de la web
            ?><script type="text/javascript">
                document.querySelector('.container').classList.add("right-panel-active")
            </script>
            <?php
        }
    }
    /**
     * afegeix l'html de l'error rebut
     * 
     * @param string $error -> missatge d'error
     */
    function writeError($error){
        ?>  
        <div class="error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <p><?php echo $error ?></p>
        </div>
        <?php
    }
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/02053ec565.js"></script>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="process.php" method="post">
                <h1>Registra't</h1>
                <span>crea un compte d'usuari</span>
                <input type="hidden" name="method" value="signup"/>
                <input type="text" placeholder="Nom" name="nom"/>
                <input type="email" placeholder="Correu electronic" name="email"/>
                <input type="password" placeholder="Contrasenya" name="pass"/>
                <button>Registra't</button>
            </form>
            <?php reg_error(); ?>
        </div>
        <div class="form-container sign-in-container">
            <form action="process.php" method="post">
                <h1>Inicia la sessió</h1>
                <span  >introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin"/>
                <input type="email" placeholder="Correu electronic" name="email"/>
                <input type="password" placeholder="Contrasenya" name="pass"/>
                <button>Inicia la sessió</button>
            </form>
            <?php login_error(); ?>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Ja tens un compte?</h1>
                    <p>Introdueix les teves dades per connectar-nos de nou</p>
                    <button class="ghost" id="signIn">Inicia la sessió</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Primera vegada per aquí?</h1>
                    <p>Introdueix les teves dades i crea un nou compte d'usuari</p>
                    <button class="ghost" id="signUp">Registra't</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>
</html>