<?php

    // Recibe $salidos (arr strings)
    // Recibe $hot (string con la fecha de hoy)

    echo "<p>Hoy es $hoy</p>";

    echo "<ul>";
    foreach($saludos as $saludo) {
        echo "<li>$saludo</li>";
    }
    echo "</ul>";

?>