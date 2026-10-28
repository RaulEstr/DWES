<?php
    // Funciones de accesos a bbdd
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

    function platosSinPedidos(PDO $conexion) {
        try {
            $sql = "select idplato, nombre, precio from platos where idplato not in (select plato from pedidos)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function platoPorId(PDO $conexion, $idplato) {
        try {
            $sql = "select idplato, nombre, precio from platos where idplato = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $idplato);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function cocineros(PDO $conexion) {
        try {
            $sql = "select id, nombre from cocineros";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function cocineroElaboraPlato(PDO $conexion, $idplato, $idcocinero) {
        try {
            $sql = "select id_plato, id_cocinero from elaboraciones where id_plato = ? and id_cocinero = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $idplato);
            $st -> bindParam(2, $idcocinero);
            $st -> execute();
            if($st -> rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    function actualizarPrecioPlato(PDO $conexion, $nuevoPrecio, $idplato) {
        try {
            $sql = "update platos set precio = ? where idplato = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $nuevoPrecio);
            $st -> bindParam(2, $idplato);
            $st -> execute();
            if($st -> rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    function actualizarNombrePlato(PDO $conexion, $nuevoNombre, $idplato) {
        try {
            $sql = "update platos set nombre = ? where idplato = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $nuevoNombre);
            $st -> bindParam(2, $idplato);
            $st -> execute();
            if($st -> rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    function existeElaboracion(PDO $conexion, $idplato, $idcocinero) {
        try {
            $sql = "select id_plato, id_cocinero from elaboraciones where id_plato = ? and id_cocinero = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $idplato);
            $st -> bindParam(2, $idcocinero);
            $st -> execute();
            if($st -> rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    function aniadirElaboracion(PDO $conexion, $idplato, $idcocinero) {
        try {
            $sql = "insert into elaboraciones(id_plato, id_cocinero) values (?, ?)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $idplato);
            $st -> bindParam(2, $idcocinero);
            $st -> execute();
            if($st -> rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }

    function eliminarElaboracion(PDO $conexion, $idplato, $idcocinero) {
        try {
            $sql = "delete from elaboraciones where id_plato = ? and id_cocinero = ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $idplato);
            $st -> bindParam(2, $idcocinero);
            $st -> execute();
            if($st -> rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return false;
        }
    }
?>