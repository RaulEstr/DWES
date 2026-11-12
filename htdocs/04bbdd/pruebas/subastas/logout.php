<?php
    require_once __DIR__."/header.php";
    unset($_SESSION["logedUserId"]);
    unset($_SESSION["logedUser"]);

    header("Location: index.php");
    exit();
    require_once __DIR__."/foot.php";
?>