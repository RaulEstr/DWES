<?php
    session_start();
    require_once "modelo.php";
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $conexion = conexion("restaurante", "root", "");
    if(!$conexion) {
        echo "Error de conexion a restaurante";
        exit();
    }

    $msg = "";
    if(isset($_POST["submit"])) {
        $cliente = login($conexion, $_POST["login"], $_POST["password"]);
        if(!$cliente) {
            $msg = "Login erroneo";
        }
        else {
            $_SESSION["cliente"] = $cliente;
            header("Location: pedido.php");
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, td, th {
            margin: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <form action="<?php echo $self ?>" method="post">
        <table>
            <tr>
                <td><label>Login:</label></td>
                <td><input type="email" name="login"></td>
            </tr>
            <tr>
                <td><label>Password:</label></td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="LOGIN"></td>
            </tr>
            <?php 
            
                if($msg != "") {
                    echo "<tr><td colspan=\"2\">$msg</td></tr>";
                }
            
            ?>
        </table>
    </form>
</body>
</html>