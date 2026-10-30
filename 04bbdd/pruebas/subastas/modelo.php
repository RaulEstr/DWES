<?php 
    function conexion($nombreBBDD, $usuario, $password) {
        try {
            $dsn = "mysql:host=localhost;dbname=$nombreBBDD;charset=utf8mb4";
            $conexion = new PDO($dsn, $usuario, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        }catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    function categorias(PDO $conexion) {
        try {
            $sql = "SELECT id, categoria from categorias";
            $st = $conexion->query($sql);
            $st -> setFetchMode(PDO::FETCH_ASSOC);
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function itemsPorCategoria(PDO $conexion, $categoria) {
        try {
            $sql = "SELECT id, nombre, 
            (SELECT imagen from imagenes where id_item = id) as imagen, 
            (SELECT count(*) from pujas where id_item = id) as cantidadPujas, 
            (SELECT max(cantidad) from pujas where id_item = id) as maxPuja, preciopartida, fechafin, id_cat 
            from items where id_cat = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $categoria);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function todosLosItems(PDO $conexion) {
        try {
            $sql = "SELECT id, nombre, 
            (SELECT imagen from imagenes where id_item = id) as imagen, 
            (SELECT count(*) from pujas where id_item = id) as cantidadPujas, 
            (SELECT max(cantidad) from pujas where id_item = id) as maxPuja, preciopartida, fechafin, id_cat 
            from items";
            $st = $conexion->query($sql);
            $st -> setFetchMode(PDO::FETCH_ASSOC);
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function existeUsuario(PDO $conexion, $usuario) {
        try {
            $sql = "SELECT id from usuarios where username = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $usuario);
            $st -> execute();
            if($st->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return true;
        }
    }

    function registrarUsuario(PDO $conexion, $usuario, $nombre, $password, $email) {
        try {
            $sql = "INSERT into usuarios(username, nombre, password, email, cadenaverificacion, activo) values (?,?,?,?,?,?)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $usuario);
            $st -> bindParam(2, $nombre);
            $hash = password_hash($password, PASSWORD_DEFAULT, ["cost"=>12]);
            $st -> bindParam(3, $hash);
            $st -> bindParam(4, $email);
            $cadena = generarCadena();
            $st -> bindParam(5, $cadena);
            $activo = 0;
            $st -> bindParam(6, $activo);
            $st -> execute();
            if($st->rowCount() == 1) {
                return $conexion -> lastInsertId();
            }
            else {
                return 0;
            }
        } catch(PDOException $e) {
            return 0;
        }
    }

    function generarCadena() {
        $chars = ["a","b","c","d","e","f","g","h","i","j","k","l","m",
        "n","o","p","q","r","s","t","u","v","w","x","y","z","1","2",
        "3","4","5","6","7","8","9","0","@","!","¿","¡","?","*","-"];
        $cadena = "";
        for($i = 1; $i <= 16; $i++) {
            $numRandom = random_int(0, count($chars) - 1);
            $cadena .= $chars[$numRandom];
        }

        return $cadena;
    }

    function datosUsuario(PDO $conexion, $idusuario) {
        try {
            $sql = "SELECT id, username, nombre, password, email, cadenaverificacion, activo, falso from usuarios where id = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $idusuario);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function activarCuenta(PDO $conexion, $email, $cadena) {
        try {
            $sql = "UPDATE usuarios set activo = 1 where email = ? and cadenaverificacion = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $email);
            $st -> bindParam(2, $cadena);
            $st -> execute();
            if($st->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    function login(PDO $conexion, $usuario, $password) {
        try {
            $sql = "SELECT id, username, activo from usuarios where username = ? and password = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $usuario);
            $st -> bindParam(2, $password);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
?>