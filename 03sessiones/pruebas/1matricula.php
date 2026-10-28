<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, td {
            margin: 5px;
            padding: 5px;
        }
    </style>
    <?php 
        session_start();

        function totalHoras() {
            $total = 0;
            foreach($_SESSION["modulos"] as $modulo => $horas) {
                $total += $horas;
            }
            return $total;
        }

        const TOTAL = 500;

        if(!isset($_SESSION["user"])) {
            header("location:1login.php?err");
            exit();
        }

        if(isset($_GET["finSesion"])) {
            unset($_SESSION["modulos"]);
            // session_destroy();
            // session_start();
            // header("location:1login.php");
            // exit();
        }

        if(!isset($_SESSION["modulos"])) {
            $_SESSION["modulos"] = [];
        }

        if(isset($_POST["submitModulo"])) {
            $_SESSION["modulos"][$_POST["modulo"]] = $_POST["horas"];
        }

    ?>
</head>
<body>
    <?php echo "<h2>Buenos días ".$_SESSION["user"]."</h2>" ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">    
        <table>
            <tr>
                <td><label>Modulo</label></td>
                <td><input type="text" name="modulo"></td>
            </tr>
            <tr>
                <td><label>Horas</label></td>
                <td><input type="number" name="horas"></td>
            </tr>
            <tr>
                <?php 
                
                    if(totalHoras() >= 500) {
                        echo "<td colspan=\"2\"><input type=\"submit\" name=\"submitModulo\" disabled value=\"Añadir\"></td>";
                    }
                    else {
                        echo "<td colspan=\"2\"><input type=\"submit\" name=\"submitModulo\" value=\"Añadir\"></td>";
                    }
                
                ?>
            </tr>
        </table>
    </form>

    <?php 
        if(totalHoras() >= 500) {
            $destino = $_SERVER["PHP_SELF"]."?finSesion";
            echo "<a href=\"$destino\">Restaurar sesion</a>";
        }

        if(count($_SESSION["modulos"]) != 0) {
            echo "<ul>";
            foreach($_SESSION["modulos"] as $modulo => $horas) {
                echo "<li>$modulo ($horas horas)</li>";
            }
            echo "</ul>";
        }
    ?>
</body>
</html>