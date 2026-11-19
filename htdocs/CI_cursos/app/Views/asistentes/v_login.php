<?php

echo "<h2>LOGIN</h2>";
echo form_open(site_url()."/Login");
    echo "<table>";
        echo "<tr>";
            echo "<td>".form_label("LOGIN")."</td>";
            echo "<td>".form_input("login")."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td>".form_label("PASSWORD")."</td>";
            echo "<td>".form_input(["name"=>"password", "type"=>"password"])."</td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td colspan=\"2\">".form_submit("submitLogin", "LOGIN")."</td>";
        echo "</tr>";
    echo "</table>";
echo form_close();