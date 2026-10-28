<?php
    require "vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;  use PHPMailer\PHPMailer\Exception;
    $mail=new PHPMailer();
    try{
        //Datos del servidor de correo saliente (MailHog)
        $mail -> IsSMTP();
        $mail -> SMTPAuth = false;    
        $mail -> Host = "localhost";
        $mail -> Port = 1025;

        //Configurar destinatario y origen
        $mail -> From = 'raul.gs@icjardin.com';
        $mail -> FromName = "Prueba envio de correo";
        $mail -> AddAddress('raul.gs@icjardin.com', "Raul Estrada");

        //Configurar contenido del correo
        $mail -> isHTML(true);
        $mail -> Subject = "Probando envio de correo desde PHP";
        $mail -> Body = "<b>Buenos dias Raul<b><hr/>Este es el contenido …<hr/>";
        $mail -> send();
        echo "<p>Email enviado</p>";
    }
        catch(Exception $e){    
        echo "<p>Email NO enviado  </p>";
    }
?>
