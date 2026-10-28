<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    $error_radio = "";
    if(isset($_GET["error_radio"])) {
        $error_radio = "Tienes que seleccionar un radio";
    }
    
    ?>

    <style>
        .error {
            color:red;
        }
    </style>
</head>
<body>
    <?php 
    
    if($error_radio != "") {
       echo "<p class=\"error\">$error_radio</p>";
    }
    
    ?>
    
    <form method="POST" action="5_concurso_reenvio.php">
        <table>
            <tr>
                <td><input type="radio" name="tipo" value="geo">Geografia</td>
            </tr>
            <tr>
                <td><input type="radio" name="tipo" value="mat">Matematicas</td>
            </tr>
            <tr>
                <td><input type="radio" name="tipo" value="his">Historia</td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="ENTRAR"></td>
            </tr>
        </table>
    </form>
</body>
</html>