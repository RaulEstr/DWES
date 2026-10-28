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
            $sql = "SELECT id, id_cat, id_user, nombre, preciopartida, descripcion, fechafin from items where id_cat = ?";
            $sql = "SELECT id, (SELECT count(*) from pujas where id_item = id) as cantidadPujas, id_cat";
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
            $sql = "SELECT id, id_cat, id_user, nombre, preciopartida, descripcion, fechafin from items";
            $st = $conexion->query($sql);
            $st -> setFetchMode(PDO::FETCH_ASSOC);
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }
?>