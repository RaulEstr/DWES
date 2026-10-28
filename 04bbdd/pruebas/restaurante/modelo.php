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

    function platos(PDO $conexion) {
        try {
            $stmt = $conexion->query("select idplato, nombre, precio, fecha, imagen from platos");
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function insertarPlato(PDO $conexion, $nombre, $precio, $fecha, $imagen) {
        try {
            $sql = "insert into platos(nombre, precio, fecha, imagen) values (?,?,?,?)";
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $nombre);
            $st->bindParam(2, $precio);
            $st->bindParam(3, $fecha);
            $st->bindParam(4, $imagen);
            $st->execute();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            echo $e;
        }
    }

    function subirPrecio(PDO $conexion, $plato, $porc) {
        try {
            $sql = "update platos set precio = precio + precio * :porc / 100 where idplato = :idplato";
            $st = $conexion->prepare($sql);
            $st->bindParam(":porc", $porc);
            $st->bindParam(":idplato", $plato);
            $st->execute();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            echo $e;
        }
    }

    function registrar(PDO $conexion, $dni, $login, $password, $nombre) {
        try {
            $sqlText = "select count(*) from clientes where dni = :dni or login = :login";
            $st = $conexion->prepare($sqlText);
            $st->execute([":dni"=>$dni, ":login"=>$login]);
            if($st->fetchColumn() > 0) {
                return [false, "No se ha registrado, el DNI o Login ya existe"];
            }

            $sqlInsert = "insert into clientes(dni, login, password, nombre) values(:dni, :login, :password, :nombre)";
            $st = $conexion->prepare($sqlInsert);
            $st->bindParam(":dni", $dni);
            $st->bindParam(":login", $login);
            $st->bindParam(":nombre", $nombre);

            $hash = password_hash($password, PASSWORD_DEFAULT, ["cost"=>12]);
            $st->bindParam(":password", $hash);

            $st->execute();

            if($st->rowCount() == 1) {
                return [true, "Usuario registrado con exito"];
            }
            else {
                return [false, "Ha habido un error al registrar el usuario"];
            }
        } catch(PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    function guardarImagenCliente(PDO $conexion, $dni, $imagen) {
        try {
            $contenido_imagen = file_get_contents($imagen);
            $sql = "update clientes set imagen = :imagen where dni = :dni";
            $st = $conexion->prepare($sql);
            $st->bindParam(":imagen", $contenido_imagen, PDO::PARAM_LOB);
            $st->bindParam(":dni", $dni);
            $st->execute();
            if($st->rowCount() == 1) {
                return [true, "Imagen registrada"];
            }
            else {
                return [false, "Ha habido un error al subir la imagen"];
            }
        }catch(PDOException $e) {
            return [false, $e->getMessage()];
        }
    }

    function login(PDO $conexion, $login, $password) {
        try {
            $sql = "select dni, login, password, nombre, imagen from clientes where login = :login";
            $st = $conexion->prepare($sql);
            $st->bindParam(":login", $login);
            $st->execute();
            $cliente = $st->fetch(PDO::FETCH_OBJ);
            if(!$cliente) {
                return false;
            }
            if(password_verify($password, $cliente->password)) {
                return $cliente;
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            return false;
        }
    }

    function guardarPedido(PDO $conexion, $cliente, $plato, $cant) {
        try {
            $sql = "insert into pedidos(fecha, cliente, plato, unidades) values(now(), :cliente, :plato, :unidades)";
            $st = $conexion->prepare($sql);

            $st->bindParam(":cliente", $cliente);
            $st->bindParam(":plato", $plato);
            $st->bindParam(":unidades", $cant);

            $st->execute();

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

    function platosMasPedidos(PDO $conexion) {
        try {
            $sql = "select idplato, nombre, precio, 
                    (select count(*) from pedidos where plato = idplato) as cantPedidos, 
                    (select sum(unidades) from pedidos where plato = idplato) as unidadesTotales 
                    from platos
                    order by unidadesTotales desc";

            $st = $conexion->query($sql);

            $st->setFetchMode(PDO::FETCH_OBJ);
            return $st->fetchAll();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function pedidosDePlato(PDO $conexion, $idPlato) {
        try {
            $sql = "select (select nombre from clientes where dni = cliente) as nombre, cliente, fecha, unidades from pedidos where plato = :idPlato order by fecha";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(":idPlato", $idPlato);
            $st->execute();
            return $st->fetchAll();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function ingredientesExtra(PDO $conexion, $idplato) {
        try {
            $sql = "select id, nombre from ingredientes where id not in (select idingrediente from composicion where idplato = ?)";
            $st = $conexion->prepare($sql);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->bindParam(1, $idplato);
            $st->execute();
            return $st->fetchAll();
        }catch(PDOException $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }

    function aniadirIngPlato(PDO $conexion, $idingrediente, $idplato, $cantidad) {
        try {
            $sql = "insert into composicion(idingrediente, idplato, cantidad) values(?,?,?)";
            $st=$conexion->prepare($sql);
            $st->execute([$idingrediente, $idplato, $cantidad]);
            if($st->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function composicionPlato(PDO $conexion, $idplato) {
        try {
            $sql = "select composicion.idingrediente, composicion.cantidad, ingredientes.nombre from ingredientes, composicion where idplato = ? and ingredientes.id=composicion.idingrediente";
            $st=$conexion->prepare($sql);
            $st->bindParam(1, $idplato);
            $st->setFetchMode(PDO::FETCH_OBJ);
            $st->execute();
            return $st->fetchAll();
        }catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    function quitarIngPlato(PDO $conexion, $idingrediente, $idplato) {
        try {
            $sql = "delete from composicion where idingrediente=? and idplato=?";
            $st=$conexion->prepare($sql);
            $st->execute([$idingrediente, $idplato]);
            if($st->rowCount() == 1) {
                return true;
            }
            else {
                return false;
            }
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }


?>