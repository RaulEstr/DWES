<?php 
    session_start();

    if(!isset($_POST["submit"])) {
        header("location:1login.php");
        exit();
    }

    $login = $_POST["login"];
    $pass = $_POST["pass"];

    if($login != $pass) {
        header("location:1login.php?err");
        exit();
    }

    $_SESSION["user"] = $login;
    header("location:1matricula.php");
    exit();
    

?>