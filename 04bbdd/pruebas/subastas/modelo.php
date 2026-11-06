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

    // Tabla usuarios

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

    // Tabla categorias

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

    // Tabla items

    function itemsPorCategoria(PDO $conexion, $categoria) {
        try {
            $sql = "SELECT id, nombre, descripcion, 
            (SELECT imagen from imagenes where id_item = items.id limit 1) as imagen, 
            (SELECT count(*) from pujas where id_item = items.id) as cantidadPujas, 
            (SELECT max(cantidad) from pujas where id_item = items.id) as maxPuja, preciopartida, fechafin, id_cat, id_user 
            from items 
            where id_cat = ? and fechafin >= CURRENT_DATE";
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
            $sql = "SELECT id, nombre, descripcion, 
            (SELECT imagen from imagenes where id_item = items.id limit 1) as imagen, 
            (SELECT count(*) from pujas where id_item = items.id) as cantidadPujas, 
            (SELECT max(cantidad) from pujas where id_item = items.id) as maxPuja, preciopartida, fechafin, id_cat, id_user 
            from items 
            where fechafin >= CURRENT_DATE";
            $st = $conexion->query($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function itemsVencidos(PDO $conexion) {
        try {
            $sql = "SELECT id, nombre,  
            (SELECT max(cantidad) from pujas where id_item = items.id) as maxPuja, 
            (SELECT nombre from usuarios where usuarios.id = (SELECT id_user from pujas where cantidad = maxPuja)) as ganador, 
            preciopartida, descripcion, fechafin, id_cat, id_user 
            from items 
            where fechafin < CURRENT_DATE";
            $st = $conexion->query($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            return $st -> fetchAll();
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

    function aniadirItem(PDO $conexion, $id_cat, $id_user, $nombre, $preciopartida, $descripcion, $fechafin) {
        try {
            $sql = "INSERT into items(id_cat, id_user, nombre, preciopartida, descripcion, fechafin) values (?,?,?,?,?,?)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $id_cat);
            $st -> bindParam(2, $id_user);
            $st -> bindParam(3, $nombre);
            $st -> bindParam(4, $preciopartida);
            $st -> bindParam(5, $descripcion);
            $st -> bindParam(6, $fechafin);
            $st -> execute();
            return $conexion -> lastInsertId();
        } catch(PDOException $e) {
            return 0;
        }
    }

    function cambiarPrecio(PDO $conexion, $itemId, $nuevoPrecio) {
        try {
            $sql = "UPDATE items set preciopartida = ? where id = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $nuevoPrecio);
            $st -> bindParam(2, $itemId);
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

    function cambiarHora(PDO $conexion, $itemId, $nuevaHora) {
        try {
            $sql = "UPDATE items set fechafin = ? where id = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $nuevaHora);
            $st -> bindParam(2, $itemId);
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

    function borrarItems(PDO $conexion, $items) {
        try {
            $sql = "DELETE from items where id = ?";
            $st = $conexion -> prepare($sql);

            $conexion -> beginTransaction();
            foreach($items as $item) {
                $st -> bindParam(1, $item);
                $st -> execute();
            }

            $conexion -> commit();
            return true;
        } catch(PDOException $e) {
            echo "Error en el borrado ".$e->getMessage();
            $conexion -> rollBack();
            return false;
        }
    }


    // Tabla imagenes

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

    function imagenesDeItems(PDO $conexion, $items) {
        try {
            $sql = "SELECT id, id_item, imagen from imagenes where id_item in (?)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $items);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function aniadirImagen(PDO $conexion, $itemId, $imagen) {
        try {
            $sql = "INSERT into imagenes(id_item, imagen) values (?,?)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemId);
            $st -> bindParam(2, $imagen);
            $st -> execute();
            return $conexion -> lastInsertId();
        } catch(PDOException $e) {
            return 0;
        }
    }

    function existeImagen(PDO $conexion, $imagen) {
        try {
            $sql = "SELECT imagen from imagenes where imagen = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $imagen);
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
    function existeImagenPorId(PDO $conexion, $imagenId) {
        try {
            $sql = "SELECT imagen from imagenes where id = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $imagenId);
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

    function borrarImagen(PDO $conexion, $imagenId) {
        try {
            $sql = "DELETE from imagenes where id = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $imagenId);
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

    //  Tabla pujas

    function pujasDeItem(PDO $conexion, $itemId) {
        try {
            $sql = "SELECT id, id_item, id_user, cantidad, fecha, 
            (SELECT username from usuarios where id_user = usuarios.id) as nomUsuario 
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

    function cantidadPujasDeItem($conexion, $itemID) {
        try {
            $sql = "SELECT count(*) as cantPujas from pujas where id_item = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $itemID);
            $st -> execute();
            return $st -> fetchColumn();
        } catch(PDOException $e) {
            return -1;
        }
    }
?>