<?= $this->extend("plantillas/v_plantilla") ?>
<?= $this->section("principal") ?>
    <?php
        /** 
        * @var object $cliente
            // Objeto MCliente
            // (int) id, (string) nombre, (string) apellido1, (string) apellido2, (char) sexo, (date) fecha_nac
            // (string) email, (string) direccion, (string) municipio, (string) provincia, (string) cp, (int), ranking
        * @var array $tarjetas
            // Array de objetos MTarjetas
            // (int) id, (string) numero, (string) cvc, (date) fecha_caducidad, (int) cliente
        **/

        if(session()->getFlashdata("cantTarjetas")) {
            echo "<p>".session()->getFlashdata("cantTarjetas")." tarjetas añadidas</p>";
        }
        echo "<h2>$cliente->nombre $cliente->apellido1 $cliente->apellido2</h2>";
        echo "<hr>";
        echo "<h2>TARJETAS EN BD</h2>";
        if(count($tarjetas) == 0) {
            echo "<p>No hay tarjetas</p>";
        }
        else {
            echo "<table>";
            echo "<tr><th>NUMERO</th><th>CVD</th><th>FECHA DE CADUCIDAD</th></tr>";
            foreach($tarjetas as $tarjeta) {
                echo "<tr>";
                    echo "<td>$tarjeta->numero</td>";
                    echo "<td>$tarjeta->cvc</td>";
                    echo "<td>$tarjeta->fecha_caducidad</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        echo "<hr>";
        echo "<h3>Añadiendo tarjetas</h3>";
        echo "<table>";
            echo "<tr><th>Numero</th><th>CVC</th><th>Fecha</th></tr>";
            echo form_open();
                echo "<tr>";
                    echo "<td>".form_input("numero", "", ["maxlength"=>20])."</td>";
                    echo "<td>".form_input("cvc", "", ["maxlength"=>3])."</td>";
                    echo "<td>".form_input(["name"=>"fecha_caducidad", "type"=>"date", "value"=>set_value("fecha_caducidad", date("Y-m-d"))])."</td>";
                    echo "<td>".form_submit("aniadirTarjeta", "AÑADIR TARJETA A SESION")."</td>";
                echo "</tr>";
            echo form_close();
        echo "</table>";

        if(session()->get("tarjetas")) {
            echo "<h2>TARJETAS NUEVAS</h2>";
            echo "<table>";
                echo "<tr><th>Numero</th><th>CVC</th><th>Fecha</th></tr>";
                foreach(session()->get("tarjetas") as $tarjeta) {
                    echo "<tr>";
                        echo "<td>$tarjeta->numero</td>";
                        echo "<td>$tarjeta->cvc</td>";
                        echo "<td>$tarjeta->fecha_caducidad</td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan=\"3\">".anchor("/tarjetas/grabar/$cliente->id", "GRABAR TARJETAS NUEVAS")."</td></tr>";
                echo "<tr><td colspan=\"3\">".anchor("/tarjetas/reset/$cliente->id", "RESET")."</td></tr>";
            echo "</table>";
        }
    
    ?>
<?= $this->endSection() ?>