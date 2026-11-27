<?= $this->extend("plantillas/v_plantilla") ?>
<?= $this->section("principal") ?>
    <h2>Formulario alta cliente. Parte 1</h2>
    <?php 

        if(session()->getFlashdata("finalaltacliente")) {
            echo "<p style=\"color: green\">".session()->getFlashdata("finalaltacliente")."</p>";
        }

        echo form_open();
            echo "<table>";
                echo "<tr>";
                    echo "<td>".form_label("Nombre: ")."</td>";
                    echo "<td>".form_input("nombre", set_value("nombre", ""))."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>".form_label("Apellido 1: ")."</td>";
                    echo "<td>".form_input("apellido1", set_value("apellido1", ""))."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>".form_label("Apellido 2: ")."</td>";
                    echo "<td>".form_input("apellido2", set_value("apellido2", ""))."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>".form_label("Sexo: ")."</td>";
                    echo "<td>".form_radio("sexo", "H", false).form_label("Hombre");
                    echo "<br>";
                    echo form_radio("sexo", "M", false).form_label("Mujer")."</td>";
                    if(session()->getFlashdata("errorsexo")) {
                        echo "<td style=\"color: red\">".session()->getFlashdata("errorsexo")."</td>";
                    }
                echo "</tr>";

                $datosInputFecha = ["name"=>"fecha_nac", "type"=>"date", "value"=>set_value("fecha_nac", date("Y-m-d"))];
                echo "<tr>";
                    echo "<td>".form_label("Fecha de nacimiento: ")."</td>";
                    echo "<td>".form_input($datosInputFecha)."</td>";
                echo "</tr>";
                echo "<tr><td colspan=\"2\">".form_submit("submit1", "Siguiente")."</td></tr>";
            echo "</table>";
        echo form_close();
    ?>
<?= $this->endSection() ?>