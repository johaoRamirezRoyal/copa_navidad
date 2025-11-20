<?php
require_once MODELO_PATH . 'conexion.php';

class PartidosModel extends conexion
{
    public static function obtenerTodosLosPartidosModel()
    {
        $tabla = 'partidos';
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                        p.*,
                        d.nombre AS disciplina_nom,
                        c.nombre AS categoria_nom,
                        s.nombre AS subcategoria_nom,
                        e1.nombre AS equipo1_nom,
                        e2.nombre AS equipo2_nom,
                        cp1.nombre AS colegio_equipo1_nom, 
                        cp2.nombre AS colegio_equipo2_nom
                    FROM $tabla p
                    LEFT JOIN disciplinas d ON p.disciplina = d.id
                    LEFT JOIN categorias c ON p.categoria = c.id
                    LEFT JOIN subcategoria s ON p.subcategoria = s.id
                    LEFT JOIN equipos e1 ON e1.id = p.equipo1
                    LEFT JOIN equipos e2 ON e2.id = p.equipo2
                    LEFT JOIN colegios_participantes cp1 ON cp1.id = e1.colegio
                    LEFT JOIN colegios_participantes cp2 ON cp2.id = e2.colegio 
                    ORDER BY p.fecha DESC;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print 'Error al consultar los enfrentamientos: ' . $e->getMessage();
        }
    }

    public static function obtenerEnfrentamientoID($id)
    {
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                        p.*,
                        d.nombre AS disciplina_nom,
                        c.nombre AS categoria_nom,
                        s.nombre AS subcategoria_nom,
                        e1.nombre AS equipo1_nom,
                        e2.nombre AS equipo2_nom,
                        cp1.nombre AS colegio_equipo1_nom, 
                        cp2.nombre AS colegio_equipo2_nom
                    FROM $tabla p
                    LEFT JOIN disciplinas d ON p.disciplina = d.id
                    LEFT JOIN categorias c ON p.categoria = c.id
                    LEFT JOIN subcategoria s ON p.subcategoria = s.id
                    LEFT JOIN equipos e1 ON e1.id = p.equipo1
                    LEFT JOIN equipos e2 ON e2.id = p.equipo2
                    LEFT JOIN colegios_participantes cp1 ON cp1.id = e1.colegio
                    LEFT JOIN colegios_participantes cp2 ON cp2.id = e2.colegio 
                    WHERE p.id = $id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener información del enfrentamiento: " . $e;
        }
    }

    public static function obtenerPartidosEnBaseAlDiaModel($fecha)
    {
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                        p.*,
                        d.nombre AS disciplina_nom,
                        c.nombre AS categoria_nom,
                        s.nombre AS subcategoria_nom,
                        e1.nombre AS equipo1_nom,
                        e2.nombre AS equipo2_nom,
                        cp1.nombre AS colegio_equipo1_nom, 
                        cp2.nombre AS colegio_equipo2_nom
                    FROM $tabla p
                    LEFT JOIN disciplinas d ON p.disciplina = d.id
                    LEFT JOIN categorias c ON p.categoria = c.id
                    LEFT JOIN subcategoria s ON p.subcategoria = s.id
                    LEFT JOIN equipos e1 ON e1.id = p.equipo1
                    LEFT JOIN equipos e2 ON e2.id = p.equipo2
                    LEFT JOIN colegios_participantes cp1 ON cp1.id = e1.colegio
                    LEFT JOIN colegios_participantes cp2 ON cp2.id = e2.colegio 
                    WHERE DATE(p.fecha) = '$fecha'
                    ORDER BY p.fecha DESC;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print 'Error al consultar los partidos en el día ' . $fecha . ': ' . $e->getMessage();
        }
    }

    public static function crearPartidoModel($datos)
    {
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (fecha, lugar, disciplina, categoria, subcategoria, equipo1, equipo2) 
                    VALUES (:fecha, :lugar, :disciplina, :categoria, :subcategoria, :equipo1, :equipo2)";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':fecha', $datos['fecha']);
            $preparado->bindParam(':lugar', $datos['lugar']);
            $preparado->bindParam(':disciplina', $datos['disciplina']);
            $preparado->bindParam(':categoria', $datos['categoria']);
            $preparado->bindParam(':subcategoria', $datos['subcategoria']);
            $preparado->bindParam(':equipo1', $datos['equipo1']);
            $preparado->bindParam(':equipo2', $datos['equipo2']);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al crear el enfrentamiento: " . $e;
        }
    }

    public static function eliminarPartidoModel($id)
    {
        $tabla = 'partidos';
        $cnx = conexion::singleton_conexion();
        $cmdsql = "DELETE FROM $tabla WHERE id = $id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print 'Error al eliminar el partido: ' . $e->getMessage();
        }
    }

    public static function actualizarPartidoModel($datos)
    {
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla 
                    SET fecha = :fecha, lugar = :lugar, disciplina = :disciplina, categoria = :categoria, subcategoria = :subcategoria, equipo1 = :equipo1, equipo2 = :equipo2) 
                    WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':fecha', $datos['fecha']);
            $preparado->bindParam(':lugar', $datos['lugar']);
            $preparado->bindParam(':disciplina', $datos['disciplina']);
            $preparado->bindParam(':categoria', $datos['categoria']);
            $preparado->bindParam(':subcategoria', $datos['subcategoria']);
            $preparado->bindParam(':equipo1', $datos['equipo1']);
            $preparado->bindParam(':equipo2', $datos['equipo2']);
            $preparado->bindParam(':id', $datos['id']);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al actualizar el enfrentamiento: " . $e->getMessage();
        }
    }
    // =========== LÓGICA PARA LOS RESULTADOS DE LOS ENFRENTAMIENTOS ================== // 
    public static function definirResultadoDeEnfrentamientoModel($datos)
    {
        $tabla = "resultado_enfrentamiento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (id_equipo1, id_equipo2, pts_equipo1, pts_equipo2, ganador, id_enfrentamiento, id_deporte) 
                    VALUES ( :id_equipo1, :id_equipo2, :pts_equipo1, :pts_equipo2, :ganador, :id_enfrentamiento, :id_deporte )";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id_equipo1", $datos['id_equipo1']);
            $preparado->bindParam(":id_equipo2", $datos['id_equipo2']);
            $preparado->bindParam(":pts_equipo1", $datos['pts_equipo1']);
            $preparado->bindParam(":pts_equipo2", $datos['pts_equipo2']);
            $preparado->bindParam(":ganador", $datos['ganador']);
            $preparado->bindParam(":id_enfrentamiento", $datos['id_enfrentamiento']);
            $preparado->bindParam(":id_deporte", $datos['id_deporte']);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al guardar el resultado del enfrentamiento" . $e;
        }
    }

    public static function eliminarResultadoDeEnfrentamientoModel($id_enfrentamiento)
    {
        $tabla = "resultado_enfrentamiento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "DELETE FROM $tabla WHERE id_enfrentamiento = $id_enfrentamiento";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al eliminar el resultado del enfrentamiento" . $e;
        }
    }

    public static function obtenerResultadoDeEnfrentamiento($id_enfrentamiento)
    {
        $tabla = "resultado_enfrentamiento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id_enfrentamiento = $id_enfrentamiento";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener el resultado del enfrentamiento" . $e;
        }
    }

    public static function obtenerInformacionResultadoEnfrentamientos(){
        $tabla = "resultado_enfrentamiento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                        re.*,
                        p.lugar AS lugar,
                        p.fecha AS fecha,
                        e1.nombre AS colegio_equipo1_nom,
                        e2.nombre AS colegio_equipo2_nom,
                        p.fecha AS fecha_enfrentamiento,
                        d.nombre AS disciplina_nom,
                        c.nombre AS categoria_nom,
                        s.nombre AS subcategoria_nom
                    FROM partidos p
                    LEFT JOIN resultado_enfrentamiento re ON re.id_enfrentamiento = p.id
                    LEFT JOIN equipos e1 ON p.equipo1 = e1.id
                    LEFT JOIN equipos e2 ON p.equipo2 = e2.id
                    LEFT JOIN categorias c ON p.categoria = c.id
                    LEFT JOIN subcategoria s ON p.subcategoria = s.id
                    LEFT JOIN disciplinas d ON p.disciplina = d.id
                    ORDER BY p.fecha DESC;";
        try{
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al obtener la información de los resultados de los enfrentamientos: " . $e;
        }
    }

        public static function obtenerInformacionResultadoEnfrentamientosEnBaseAlDia($fecha){
        $tabla = "resultado_enfrentamiento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                        re.*,
                        p.lugar AS lugar,
                        p.fecha AS fecha,
                        e1.nombre AS colegio_equipo1_nom,
                        e2.nombre AS colegio_equipo2_nom,
                        p.fecha AS fecha_enfrentamiento,
                        d.nombre AS disciplina_nom,
                        c.nombre AS categoria_nom,
                        s.nombre AS subcategoria_nom
                    FROM partidos p
                    LEFT JOIN resultado_enfrentamiento re ON re.id_enfrentamiento = p.id
                    LEFT JOIN equipos e1 ON p.equipo1 = e1.id
                    LEFT JOIN equipos e2 ON p.equipo2 = e2.id
                    LEFT JOIN categorias c ON p.categoria = c.id
                    LEFT JOIN subcategoria s ON p.subcategoria = s.id
                    LEFT JOIN disciplinas d ON p.disciplina = d.id
                    WHERE DATE(p.fecha) = '$fecha'
                    ORDER BY p.fecha DESC;";
        try{
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al obtener la información de los resultados de los enfrentamientos: " . $e;
        }
    }

    // =========== LÓGICA PARA LA TABLA DE POSICIONES ================== //

    // SUPONIENDO QUE TODOS SE ENFRENTAN CONTRA TODOS EN BASE A LA CATEGORIA, SUBCATEGORIA Y DISCIPLINA
    public static function obtenerTablaDePosiciones($categoria, $subcategoria, $disciplina)
    {
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT 
                        e.id,
                        e.nombre,

                        -- Partidos jugados
                        COUNT(r.id) AS PJ,

                        -- Partidos ganados
                        SUM(CASE WHEN r.ganador = e.id THEN 1 ELSE 0 END) AS PG,

                        -- Partidos perdidos
                        SUM(
                            CASE 
                                WHEN r.ganador != e.id AND r.ganador != 0 THEN 1 
                                ELSE 0 
                            END
                        ) AS PP,

                        -- Partidos empatados
                        SUM(CASE WHEN r.ganador = 0 THEN 1 ELSE 0 END) AS PE,

                        -- Puntos a favor
                        SUM(
                            CASE 
                                WHEN r.id_equipo1 = e.id THEN r.pts_equipo1
                                WHEN r.id_equipo2 = e.id THEN r.pts_equipo2 
                                ELSE 0 
                            END
                        ) AS GF,

                        -- Puntos en contra
                        SUM(
                            CASE 
                                WHEN r.id_equipo1 = e.id THEN r.pts_equipo2
                                WHEN r.id_equipo2 = e.id THEN r.pts_equipo1 
                                ELSE 0 
                            END
                        ) AS GC,

                        -- Diferencia de goles
                        (
                            SUM(
                                CASE 
                                    WHEN r.id_equipo1 = e.id THEN r.pts_equipo1
                                    WHEN r.id_equipo2 = e.id THEN r.pts_equipo2 
                                    ELSE 0 
                                END
                            )
                            -
                            SUM(
                                CASE 
                                    WHEN r.id_equipo1 = e.id THEN r.pts_equipo2
                                    WHEN r.id_equipo2 = e.id THEN r.pts_equipo1 
                                    ELSE 0 
                                END
                            )
                        ) AS DG,

                        -- Puntos totales: 3 victoria, 1 empate
                        SUM(
                            CASE 
                                WHEN r.ganador = e.id THEN 3
                                WHEN r.ganador = 0 THEN 1
                                ELSE 0 
                            END
                        ) AS PTS

                    FROM equipos e
                    LEFT JOIN resultado_enfrentamiento r 
                        ON e.id IN (r.id_equipo1, r.id_equipo2)

                    -- FILTROS OPCIONALES:
                    WHERE e.categoria       = $categoria
                        AND e.sub_categoria = $subcategoria
                        AND e.diciplina     = $disciplina

                    GROUP BY e.id
                    ORDER BY PTS DESC, DG DESC, GF DESC;";

        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener la tabla de posiciones: " . $e;
        }
    }
}
