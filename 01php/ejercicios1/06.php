<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once("06funcs.php") ?>
</head>
<body>
    <?php

    $horario = [
        "dias" => ["Lun", "Mar","Mie", "Jue", "Vie", "Sab", "Dom"], 
        "horaIni" => "8:00",
         "horaFin" => "15:00", 
         "intervalo" => 60
    ];

    dibujarTabla($horario);

    ?>
</body>
<style>
    .gray{
        background-color: gray;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 5px;
    }
</style>
</html>