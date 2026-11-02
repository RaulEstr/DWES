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
            $sql = "SELECT id, username, activo, password from usuarios where username = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $usuario);
            $st -> execute();
            $usuarios = $st -> fetchAll();
    
            if(password_verify($password, $usuarios[0]->password)) {
                return $usuarios;
            }
            return [];

        } catch(PDOException $e) {
            return [];
        }
    }

    function itemPorId(PDO $conexion, $itemId) {
        try {
            $sql = "SELECT id, id_cat, id_user, nombre, preciopartida, descripcion, fechafin, 
            (SELECT count(id) from pujas where id_item = items.id) as cantPujas, 
            (SELECT max(cantidad) from pujas where id_item = items.id) as precioActual 
            from items 
            where id = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function imagenesDeItem(PDO $conexion, $itemId) {
        try {
            $sql = "SELECT id, id_item, imagen from imagenes where id_item = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function pujasDeItem(PDO $conexion, $itemId) {
        try {
            $sql = "SELECT id, id_item, id_user, cantidad, fecha, 
            (SELECt username from usuarios where id_user = usuarios.id) as nomUsuario, 
            from pujas where id_item = ? order by fecha";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function cantidadUltimaPuja(PDO $conexion, $itemId) {
        try {
            $sql =  "SELECT max(cantidad) as precioActual from pujas where id_item = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function cantidadPujasHoy(PDO $conexion, $itemId, $usuarioId) {
        try {
            $sql =  "SELECT count(id) as cantidadHoy from pujas where id_item = ? and id_user = ? and fecha = CURRENT_DATE";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> bindParam(2, $usuarioId);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function aniadirPuja(PDO $conexion, $itemId, $usuarioId, $cantidad) {
        try {
            $sql = "INSERT into pujas(id_item, id_user, cantidad, fecha) values (?,?,?, CURRENT_DATE)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> bindParam(2, $usuarioId);
            $st -> bindParam(3, $cantidad);
            $st -> execute();
        } catch(PDOException $e) {
            return false;
        }
    }
?>