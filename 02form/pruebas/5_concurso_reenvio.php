<?php 

if(!isset($_POST["submit"])) {
    header("location: 5_preguntas.php");
    exit();
}
else {
    if(!isset($_POST["tipo"])) {
        header("location: 5_preguntas.php?error_radio");
        exit();
    }
    else{
        $tipo = $_POST["tipo"];
        $ruta="5_".$tipo.".php";
        header("location: ".$ruta);
        exit();
    }
}

?>
