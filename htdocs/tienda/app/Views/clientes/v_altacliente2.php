<?= $this->extend("plantillas/v_plantilla") ?>
<?= $this->section("principal") ?>
    <h2>Formulario alta cliente. Parte 2</h2>
    <?php 
        echo form_open();
            echo "<table>";
                echo "<tr>";
                    echo "<td>".form_label("Dirección: ")."</td>";
                    echo "<td>".form_input("direccion")."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>".form_label("Municipio: ")."</td>";
                    echo "<td>".form_input("municipio")."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>".form_label("Provincia: ")."</td>";
                    echo "<td>".form_input("provincia")."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>".form_label("Código postal: ")."</td>";
                    echo "<td>".form_input("cp")."</td>";
                echo "</tr>";
                echo "<tr><td colspan=\"2\">".form_submit("submit2", "Siguiente")."</td></tr>";
            echo "</table>";
        echo form_close();
    ?>
<?= $this->endSection() ?>