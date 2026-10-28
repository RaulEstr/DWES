<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, td {
            margin: 5px;
            padding: 5px;
        }
    </style>

    <?php 

        if(isset($_GET["err"])) {
            echo "<p>Error login</p>";
        }

    ?>
</head>
<body>
    <form method="post" action="1checklogin.php">
        <table>
            <tr>
                <td><label>Usuario</label></td>
                <td><input type="text" name="login"></td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="LOGIN" name="submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>