    <?php
    
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Processar les dades
        echo "<h3>Dades processades </h3>";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        header("Refresh:1; http://localhost:8080/helloworld/M07DAW/Formularis/22-Formularis_treball_amb_POST.php");
    } else {
        header("Refresh:0; http://localhost:8080/helloworld/M07DAW/Formularis/22-Formularis_treball_amb_POST.php");
    }
        
    ?>