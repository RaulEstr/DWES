<?php
    require_once __DIR__."/header.php";
    require "../../vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;  use PHPMailer\PHPMailer\Exception;

    $self = htmlentities($_SERVER["PHP_SELF"]);
    if(!isset($_SESSION["logedUser"]) || $_SESSION["logedUser"] != "admin") {
        header("Location: index.php");
        exit();
    }

    if(isset($_GET["enviar"])) {

        if(isset($_SESSION["web"])) {
            $f = fopen($carpetaArchivos."/".$archivo, "a");
            foreach ($_SESSION["web"] as $web) {
                $linea = $web[0].", ".$web[1]."\n"; 
                fputs($f, $linea);
            }
            fclose($f);
        }

        if(isset($_SESSION["email"])) {
            foreach($_SESSION["email"] as $email) {
                $mail=new PHPMailer();
                try{
                    $mail -> IsSMTP();
                    $mail -> SMTPAuth = false;    
                    $mail -> Host = "localhost";
                    $mail -> Port = 1025;

                    $mail -> From = "accounts@$dominio";
                    $mail -> FromName = $foro;
                    $mail -> AddAddress($email[0]);

                    $mail -> isHTML(true);
                    $mail -> Subject = "Subastas a punto de vencer";
                    $body = "<h1>¡Un item está a punto de vencer!</h1>";
                    $body .= "<h2>".$email[2]."</h2>";
                    $body .= "<a href=\"$host/itemdetalles.php?mailItemId=".$email[1]."\">Ir a pujar</a>";
                    $mail -> Body = $body;
                    
                    $mail -> send();
                    $registrado = true;
                    
                }catch(Exception $e){    
                    echo "<p>No se ha podido enviar un correo</p>";
                    echo "<p>".$e->getMessage()."</p>";
                }
            }
        }
        

        unset($_SESSION["web"]);
        unset($_SESSION["email"]);
    }

    if(isset($_POST["submit"])) {
        if(isset($_POST["tipo"])) {
            if($_POST["tipo"] == "web"){
                $_SESSION["web"][] = [$_POST["anunciante"], $_POST["descripcion"]];
            }
            else {
                $_SESSION["email"][] = [$_POST["anunciante"], $_POST["itemId"], $_POST["nombre"]];
            }
        }
    }
    
    $items = todosLosItems($conexion);

    $itemsAVencer = [];
    foreach ($items as $item) {
        $tiempoRestante = strtotime($item->fechafin) - date_timestamp_get(new DateTime());
        $tiempoRestante = (int)($tiempoRestante / 60 / 60);
        if($tiempoRestante <= 72) {
            if(cantidadPujasDeItem($conexion, $item->id) == 0) {
                $itemsAVencer[] = [$item, $tiempoRestante];
            }
            else {
                if($item->maxPuja < ($item->preciopartida + $item->preciopartida * 10 / 100)) {
                    $itemsAVencer[] = [$item, $tiempoRestante];
                }
            }
        }
    }

    if(count($itemsAVencer) == 0) {
        echo "<p>No hay subastas a punto de vencer</p>";
    }
    else {
        echo "<h1>Subastas a punto de vencer</h1>";
        echo "<table>";
            echo "<th>ITEM</th><th>VENCE EN</th><th>ANUNCIANTE</th><th>TIPO</th><th></th>";
            foreach($itemsAVencer as $row) {
                echo "<form action=\"$self\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"itemId\" value=\"".$row[0]->id."\">";
                echo "<input type=\"hidden\" name=\"nombre\" value=\"".$row[0]->nombre."\">";
                echo "<input type=\"hidden\" name=\"descripcion\" value=\"".$row[0]->descripcion."\">";
                    echo "<tr>";
                        echo "<td>".$row[0]->nombre."</td>";
                        echo "<td>".$row[1]." horas</td>";
                        echo "<td><input type=\"text\" name=\"anunciante\"></td>";
                        echo "<td>";
                            echo "<input type=\"radio\" name=\"tipo\" value=\"email\">Email";
                            echo "<input type=\"radio\" name=\"tipo\" value=\"web\">Web";
                        echo "</td>";
                        echo "<td><input type=\"submit\" name=\"submit\" value=\"Añadir\"></td>";
                    echo "</tr>";
                echo "</form>";
            }
        echo "</table>";

        if(isset($_SESSION["web"]) || isset($_SESSION["email"])) {
            echo "<a href=\"$self?enviar\">ENVIAR ANUNCIOS</a>";
        }
    }
    
    require_once __DIR__."/foot.php";
?>