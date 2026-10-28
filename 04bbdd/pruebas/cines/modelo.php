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

    function peliculas($conexion) {
        try {
            $st = $conexion->query("select idpelicula, titulo, categoria from peliculas");
            $st->setFetchMode(PDO::FETCH_OBJ);
            return $st->fetchAll();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function categorias(PDO $conexion) {
        try {
            $st = $conexion->query("select distinct(categoria) from peliculas order by categoria");
            $st->setFetchMode(PDO::FETCH_OBJ);
            return $st->fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function peliculasPorCategoria(PDO $conexion, $categoria) {
        try {
            $sql = "select idpelicula, titulo, categoria from peliculas where categoria = ?";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(1, $categoria);
            $st->execute();
            return $st->fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function funcionesPorPelicula(PDO $conexion, $idpelicula) {
        try {
            $sql = "select idfuncion, idcine, num_sala, fecha_hora, idpelicula, recaudacion, vendidos from funciones where idpelicula = ?";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(1, $idpelicula);
            $st->execute();
            return $st->fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function tituloPelicula(PDO $conexion, $idpelicula) {
        try {
            $sql = "select idpelicula, titulo from peliculas where idpelicula = ?";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(1, $idpelicula);
            $st->execute();
            return $st->fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function capacidadDeSala(PDO $conexion, $idcine, $num_sala) {
        try {
            $sql = "select idcine, numero, capacidad from salas where idcine = ? and numero = ?";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(1, $idcine);
            $st->bindParam(2, $num_sala);
            $st->execute();
            return $st->fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function imagenCine(PDO $conexion, $idcine) {
        try {
            $sql = "select idcine, imagen from cines where idcine = ?";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(1, $idcine);
            $st->execute();
            return $st->fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function datosReserva(PDO $conexion, $idfuncion) {
        try {
            $sql = "select funciones.idfuncion, funciones.num_sala, funciones.vendidos, funciones.recaudacion, cines.nombre, cines.precio_entrada, peliculas.titulo, (salas.capacidad - funciones.vendidos) as restantes 
            from funciones, cines, peliculas, salas 
            where cines.idcine = funciones.idcine 
            and peliculas.idpelicula = funciones.idpelicula 
            and funciones.idcine = salas.idcine 
            and funciones.num_sala = salas.numero 
            and funciones.idfuncion = ?";

            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_ASSOC);
            $st->bindParam(1, $idfuncion);
            $st->execute();
            return $st->fetchAll();         
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function aniadirVendidas(PDO $conexion, $cantidad, $recaudacion, $idfuncion) {
        try {
            $sql = "update funciones set vendidos = ?, recaudacion = ? where idfuncion = ?";
            $st = $conexion -> prepare($sql);
            $st -> bindParam(1, $cantidad);
            $st -> bindParam(2, $recaudacion);
            $st -> bindParam(3, $idfuncion);
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

    function peliculasRecaudacion(PDO $conexion, $recaudacion) {
        try {
            $sql = "SELECT sum(RECAUDACION) as total, idpelicula from funciones GROUP by IDPELICULA HAVING sum(RECAUDACION) > ?";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> bindParam(1, $recaudacion);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
?>