<?php
require_once MODELO_PATH . 'conexion.php';

class JugadoresModel extends conexion
{
    public static function obtenerTodosLosJugadoresModel()
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT j.*, e.nombre AS equipo_nombre
                    FROM $tabla j
                    LEFT JOIN equipos e ON j.id_equipo = e.id
                    LIMIT 25";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al traer los jugadores: " . $e->getMessage();
        }
    }

    public static function obtenerJugadorPorIdModel($id)
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id, PDO::PARAM_INT);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al traer el jugador por ID: " . $e->getMessage();
        }
    }

    public static function agregarJugadorModel($datos)
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (nombre, edad, id_equipo, activo, penalizacion) VALUES (:nombre, :edad, :id_equipo, 1, 0)";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
            $preparado->bindParam(":edad", $datos['edad'], PDO::PARAM_INT);
            $preparado->bindParam(":id_equipo", $datos['id_equipo'], PDO::PARAM_INT);
            if($preparado->execute()){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al agregar el jugador: " . $e->getMessage();
        }
    }

    public static function desactivarParticipacionJugador($id_jugador, $estado)
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla SET activo = :estado WHERE id = :id_jugador";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id_jugador", $id_jugador, PDO::PARAM_INT);
            $preparado->bindParam(":estado", $estado, PDO::PARAM_INT);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al desactivar la participación del jugador: " . $e->getMessage();
        }
    }

    public static function editarJugadorModel($datos)
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla SET nombre = :nombre, edad = :edad, id_equipo = :id_equipo WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
            $preparado->bindParam(":edad", $datos['edad'], PDO::PARAM_INT);
            $preparado->bindParam(":id_equipo", $datos['id_equipo'], PDO::PARAM_INT);
            $preparado->bindParam(":id", $datos['id'], PDO::PARAM_INT);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al editar el jugador: " . $e->getMessage();
        }
    }

    public static function filtrarJugadoresPorNombreModel($nombre)
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT j.*, e.nombre AS equipo_nombre
                    FROM $tabla j
                    LEFT JOIN equipos e ON j.id_equipo = e.id
                    WHERE j.nombre LIKE :nombre;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $like_nombre = "%" . $nombre . "%";
            $preparado->bindParam(":nombre", $like_nombre, PDO::PARAM_STR);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al filtrar los jugadores por nombre: " . $e->getMessage();
        }
    }

    public static function obtenerJugadoresPorEquipoModel($id_equipo)
    {
        $tabla = "jugadores";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT j.*, e.nombre AS equipo_nombre
                    FROM $tabla j
                    LEFT JOIN equipos e ON j.id_equipo = e.id
                    WHERE j.id_equipo = :id_equipo;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id_equipo", $id_equipo, PDO::PARAM_INT);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener los jugadores por equipo: " . $e->getMessage();
        }
    }
}
