<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php 
    
    function reveseStr($str) {
        $r = "";
        for($i = 0; $i < strlen($str); $i++) {
            $car = $str[$i];
            $r = $car.$r;
        }

        return $r;
    }

    $errorLoginAdmin = "";
    if(isset($_POST["loginA"])) {
        // usuario "admin" | password "damocles"
        if($_POST["user"] == "admin" && $_POST["pass"] == "damocles") {
            header("location: ./gestionimg.php");
            exit();
        }
        else{
            $errorLoginAdmin = "Usuario o contraseña de admin incorrecto";
        }
    }

    $errorLoginGeneral ="";
    if(isset($_POST["loginG"])) {
        // usuario cualquiera | password usuario invertido
        // fe: pedro | ordep
        if($_POST["pass"] == reveseStr($_POST["user"])) {
            header("location: ./listaimg.php");
            exit();
        }
        else{
            $errorLoginGeneral = "Usuario o contraseña incorrecto";
        }
        
    }
    
    ?>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <table>
            <tr>
                <td><label>User</label></td>
                <td><input type="text" name="user" placeholder="Introduce tu nombre"></td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td><input type="submit" value="LOGIN ADMIN" name="loginA"></td>
                <td><input type="submit" value="LOGIN GENERAL" name="loginG"></td>
            </tr>
        </table>
    </form>
    <?php 
        echo $errorLoginAdmin;
        echo $errorLoginGeneral;
    ?>
</body>
</html>