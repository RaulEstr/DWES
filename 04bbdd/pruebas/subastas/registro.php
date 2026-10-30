<?php
    require_once __DIR__."/header.php";
    require "../../vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;  use PHPMailer\PHPMailer\Exception;
    $self = htmlentities($_SERVER["PHP_SELF"]);
    $msg = "";
    if(isset($_POST["botonSubmit"])) {
        $usuario = trim($_POST["usuario"]);
        $nombre = trim($_POST["nombre"]);
        $password = $_POST["password"];
        $email = trim($_POST["email"]);

        if(existeUsuario($conexion, $usuario)) {
            $msg = "Ya existe el usuario $usuario";
        }
        else {
            $id = registrarUsuario($conexion, $usuario, $nombre, $password, $email);
            if($id != 0){
                $registrado = datosUsuario($conexion, $id)[0];
                $mail=new PHPMailer();
                try{
                    $mail -> IsSMTP();
                    $mail -> SMTPAuth = false;    
                    $mail -> Host = "localhost";
                    $mail -> Port = 1025;

                    $mail -> From = "accounts@$dominio";
                    $mail -> FromName = $foro;
                    $mail -> AddAddress($registrado->email);

                    $mail -> isHTML(true);
                    $mail -> Subject = "Activa la cuenta";
                    $mail -> Body = "<a href=\"$host/verificacion.php?email=$registrado->email&cadena=$registrado->cadenaverificacion\">Pulsa aqui para activar tu cuenta</a>";
                    
                    $mail -> send();
                }catch(Exception $e){    
                    $msg = "No se ha podido mandar el correo para activar la cuenta";
                }
            }
            else {
                $msg = "No se ha podido registrar el usuario";
            }
        }
    }

    echo "<h2>REGISTRO</h2>";
    if($msg != ""){
        echo "<h3>$msg</h3>";
    }   
    echo "<p>Para registrate en $foro, rellena el siguiente formulario</p>";
    echo "<form action=\"$self\" method=\"post\" id=\"formu\">";
        echo "<table id=\"tabla\">";
            echo "<tr>";
                echo "<td>Usuario</td>";
                echo "<td><input type=\"text\" name=\"usuario\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Nombre completo</td>";
                echo "<td><input type=\"text\" name=\"nombre\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password</td>";
                echo "<td><input type=\"password\" name=\"password\" id=\"password1\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Password (de nuevo)</td>";
                echo "<td><input type=\"password\" id=\"password2\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td>Email</td>";
                echo "<td><input type=\"email\" name=\"email\"></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td></td>";
                echo "<td><input id=\"botonSubmit\" type=\"submit\" name=\"botonSubmit\" value=\"Registrate\"></td>";
            echo "</tr>";
        echo "</table>";
    echo "</form>";
    // echo "<script src=\"registro.js\" defer></script>";

    require_once __DIR__."/foot.php";
?>