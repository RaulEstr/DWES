<?= $this->extend("plantillas/v_plantilla") ?>
<?= $this->section("principal") ?>
    <h2>Formulario alta cliente. Parte 3</h2>
    <?php
        helper("gustos");
        echo form_open();
        echo "<table>";
            foreach(array_keys(gustos) as $gusto) {
                echo "<tr>";
                    echo "<td>".form_label($gusto)."</td>";
                    echo "<td>".form_input(["name"=>$gusto, "type"=>"range","min"=>0, "max"=>10, "step"=>1])."</td>";
                echo "</tr>";
            }
        echo "</table>";
        echo "<tr><td colspan=\"2\">".form_submit("submit3", "Siguiente")."</td></tr>";
        echo form_close();

    ?>
<?= $this->endSection() ?>