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

    function self() {
        return htmlentities($_SERVER["PHP_SELF"]);
    }

    function funcionesErrorVentas(PDO $conexion) {
        try {
            $sql = "SELECT funciones.idfuncion, funciones.idcine, funciones.num_sala, funciones.fecha_hora, 
            funciones.idpelicula, funciones.recaudacion, funciones.vendidos, salas.capacidad 
            from funciones, salas 
            where funciones.idcine = salas.idcine and funciones.num_sala = salas.numero and funciones.vendidos > salas.capacidad";
            // (select capacidad from salas where idcine=funciones.idcine and numero=funciones.num_sala)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function funcionesErrorRecaudacion(PDO $conexion) {
        try {
            $sql = "SELECT funciones.idfuncion, funciones.idcine, funciones.num_sala, funciones.fecha_hora, 
            funciones.idpelicula, funciones.recaudacion, funciones.vendidos, cines.precio_entrada 
            from funciones, cines 
            where funciones.idcine = cines.idcine and funciones.recaudacion <> funciones.vendidos * cines.precio_entrada 
            and funciones.idfuncion not in (select idfuncion from incidencias)";
            $st = $conexion -> prepare($sql);
            $st -> setFetchMode(PDO::FETCH_OBJ);
            $st -> execute();
            return $st -> fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    function borrarFunciones(PDO $conexion, $funciones) {
        try {
            $sql = "DELETE from funciones where idfuncion = ?";
            $st = $conexion -> prepare($sql);

            $conexion -> beginTransaction();
            foreach($funciones as $funcion) {
                $st -> bindParam(1, $funcion);
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

    function grabarIncidencia(PDO $conexion, $idfuncion, $exceso, $gestor) {
        try {
            $sql = "insert into incidencias(idfuncion, exceso, gestor) values (?,?,?)";
            $st = $conexion -> prepare($sql);
            $st -> bindParam(1, $idfuncion);
            $st -> bindParam(2, $exceso);
            $st -> bindParam(3, $gestor);
            $st -> execute();
            return $conexion -> lastInsertId();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>