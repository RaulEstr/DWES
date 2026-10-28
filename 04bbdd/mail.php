<?php
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;  use PHPMailer\PHPMailer\Exception;
    session_start();

    function envioMail($to, $from, $subject, $body) {  
        $mail=new PHPMailer();
        try{
            //Datos del servidor de correo saliente (MailHog)
            $mail -> IsSMTP();
            $mail -> SMTPAuth = false;    
            $mail -> Host = "localhost";
            $mail -> Port = 1025;

            //Configurar destinatario y origen
            $mail -> From = $from;
            $mail -> FromName = "Aplicacion Web PHP";
            $mail -> AddAddress($to);

            //Configurar contenido del correo
            $mail -> isHTML(true);
            $mail -> Subject = $subject;
            $mail -> Body = $body;
            $mail -> send();
            return true;
        }
            catch(Exception $e){    
            return false;
        }
    }

    if(!isset($_SESSION["from"])) {
        $_SESSION["from"] = "micorreo@gmail.com";
    }
    $self = htmlentities($_SERVER["PHP_SELF"]);

    $msg = "";
    if(isset($_POST["submit"])) {
        $to = $_POST["to"];
        $from = $_POST["from"];
        $subject = $_POST["subject"];
        $body = $_POST["body"];

        if(empty($to) || empty($from) || empty($subject) || empty($body)) {
            $msg = "Tienes que rellenear todos los campos";
        }
        else {
            if(!envioMail($to, $from, $subject, $body)) {
                $msg = "Error al enviar el correo";
            }
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
    <form method="post" action="<?php echo $self ?>">
        <table>
            <tr><th colspan="2">ENVIAR MAIL</th></tr>
            <tr>
                <td><label>To:</label></td>
                <td><input type="email" name="to" placeholder="correo@correo.com"></td>
            </tr>
            <tr>
                <td><label>From:</label></td>
                <td><input readonly type="email" name="from" value="<?php echo $_SESSION["from"] ?>"></td>
            </tr>
            <tr>
                <td><label>Titulo:</label></td>
                <td><input type="text" name="subject" placeholder="Escribe titulo"></td>
            </tr>
            <tr>
                <td><label>Mensaje:</label></td>
                <td><textarea name="body" rows="10" cols="40"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Enviar Correo"></td>
            </tr>
        </table>
    </form>
    <?php 
        if($msg != "") {
            echo "<p style=\"color: red\">$msg</p>";
        }
    ?>
</body>
</html>