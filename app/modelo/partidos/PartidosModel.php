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

    public static function obtenerPartidosFiltradosModel($datos)
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
                    WHERE p.equipo1 IS NOT NULL AND p.equipo2 IS NOT NULL

                    " . $datos['categoria'] . $datos['subcategoria'] . $datos['deporte'] . "

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

    public static function obtenerInformacionResultadoEnfrentamientos()
    {
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
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener la información de los resultados de los enfrentamientos: " . $e;
        }
    }

    public static function obtenerInformacionResultadoEnfrentamientosEnBaseAlDia($fecha)
    {
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
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener la información de los resultados de los enfrentamientos: " . $e;
        }
    }

    // =========== LÓGICA PARA LA TABLA DE POSICIONES ================== //

    // SUPONIENDO QUE TODOS SE ENFRENTAN CONTRA TODOS EN BASE A LA CATEGORIA, SUBCATEGORIA Y DISCIPLINA
    public static function obtenerTablaDePosiciones($id_grupo)
    {

        $grupo_info = GruposModel::obtenerGrupoPorIdModel($id_grupo);
        $array_futbol = [2, 8]; // IDs de disciplinas que son futbol
        $array_volley = [3]; // IDs de disciplinas que son volley
        $array_softball = [6]; // IDs de disciplinas que son softball
        $array_basket = [1]; // IDs de disciplinas que son basket

        if (in_array($grupo_info['disciplina'], $array_futbol)) {
            $pts_victoria = 3;
            $pts_derrota = 0;
            $pts_empate = 1;
        } else if (in_array($grupo_info['disciplina'], $array_basket)) {
            $pts_victoria = 2;
            $pts_derrota = 1;
            $pts_empate = 0;
        } else if (in_array($grupo_info['disciplina'], $array_softball)) {
            $pts_victoria = 2;
            $pts_derrota = 1;
            $pts_empate = 0;
        } else {
            $pts_victoria = 1;
            $pts_derrota = 0;
            $pts_empate = 0;
        }

        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT 
                        e.id,
                        e.nombre,
                        e.id_grupo,
                        COUNT(r.id) AS PJ,
                        SUM(CASE WHEN r.ganador = e.id THEN 1 ELSE 0 END) AS PARTIDOS_GANADOS,
                        SUM(CASE WHEN r.ganador != e.id AND r.ganador != 0 THEN 1 ELSE 0 END) AS PARTIDOS_PERDIDOS,
                        SUM(CASE WHEN r.ganador = 0 THEN 1 ELSE 0 END) AS PARTIDOS_EMPATADOS,
                        SUM(
                            CASE 
                                WHEN r.id_equipo1 = e.id THEN r.pts_equipo1
                                WHEN r.id_equipo2 = e.id THEN r.pts_equipo2
                                ELSE 0
                            END
                        ) AS PUNTOS_FAVOR,
                        SUM(
                            CASE 
                                WHEN r.id_equipo1 = e.id THEN r.pts_equipo2
                                WHEN r.id_equipo2 = e.id THEN r.pts_equipo1
                                ELSE 0
                            END
                        ) AS PUNTOS_CONTRA,
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
                        ) AS DIFERENCIA_PUNTOS,
                        SUM(
                            CASE 
                                /** SI ES VOLEY (DISCIPLINA = 3) SE CALCULAN PUNTOS **/
                                WHEN g.disciplina = 3 THEN 
                                    CASE 
                                        /** El equipo es id_equipo1 **/
                                        WHEN r.id_equipo1 = e.id THEN
                                            CASE 
                                                WHEN r.pts_equipo1 = 2 AND r.pts_equipo2 = 0 THEN 4
                                                WHEN r.pts_equipo1 = 2 AND r.pts_equipo2 = 1 THEN 3
                                                WHEN r.pts_equipo1 = 1 AND r.pts_equipo2 = 2 THEN 2
                                                WHEN r.pts_equipo1 = 0 AND r.pts_equipo2 = 2 THEN 1
                                                ELSE 0
                                            END
                                        /** El equipo es id_equipo2 **/
                                        WHEN r.id_equipo2 = e.id THEN
                                            CASE 
                                                WHEN r.pts_equipo2 = 2 AND r.pts_equipo1 = 0 THEN 4
                                                WHEN r.pts_equipo2 = 2 AND r.pts_equipo1 = 1 THEN 3
                                                WHEN r.pts_equipo2 = 1 AND r.pts_equipo1 = 2 THEN 2
                                                WHEN r.pts_equipo2 = 0 AND r.pts_equipo1 = 2 THEN 1
                                                ELSE 0
                                            END

                                    END
                                /** SI NO ES VOLEY USA TU LÓGICA NORMAL **/
                                    ELSE
                                        CASE
                                            WHEN r.ganador = e.id THEN $pts_victoria
                                            WHEN r.ganador = 0 THEN $pts_empate
                                            ELSE $pts_derrota
                                        END
                                END
                            ) AS PUNTOS
                        FROM equipos e
                        -- Trae los resultados donde participa el equipo
                        LEFT JOIN resultado_enfrentamiento r
                            ON e.id IN (r.id_equipo1, r.id_equipo2)
                        -- Obtener datos del grupo para conocer la disciplina
                        LEFT JOIN grupos g
                            ON g.id = e.id_grupo
                        -- Obtener rival para validar grupo
                        LEFT JOIN equipos rival
                            ON rival.id = 
                                CASE 
                                    WHEN r.id_equipo1 = e.id THEN r.id_equipo2
                                    ELSE r.id_equipo1
                                END
                        -- Solo partidos entre el mismo grupo
                        WHERE e.id_grupo = $id_grupo
                        AND (rival.id_grupo = e.id_grupo OR rival.id IS NULL)
                        GROUP BY e.id
                        ORDER BY PUNTOS DESC, DIFERENCIA_PUNTOS DESC, PUNTOS_FAVOR DESC;";

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

    public static function obtenerUltimoPartidoModel($id_equipo)
    {
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT  p.*, 
                            re.id AS resultado_id,
                            re.pts_equipo1,
                            re.pts_equipo2,
                            e1.id AS equipo1_id,
                            e1.nombre AS equipo1_nombre,
                            e2.id AS equipo2_id,
                            e2.nombre AS equipo2_nombre,
                            CASE 
                                WHEN p.equipo1 = $id_equipo THEN e2.nombre
                                WHEN p.equipo2 = $id_equipo THEN e1.nombre
                            END AS rival_nombre
                    FROM partidos p
                    INNER JOIN resultado_enfrentamiento re 
                            ON re.id_enfrentamiento = p.id
                    INNER JOIN equipos e1 ON e1.id = p.equipo1
                    INNER JOIN equipos e2 ON e2.id = p.equipo2
                    WHERE $id_equipo IN (p.equipo1, p.equipo2)
                    ORDER BY p.fecha DESC
                    LIMIT 2;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener el último partido y próximo enfrentamiento: " . $e;
        }
    }

    public static function obtenerProximoPartidoModel($id_equipo)
    {
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT  p.*, 
                            e1.id AS equipo1_id,
                            e1.nombre AS equipo1_nombre,
                            e2.id AS equipo2_id,
                            e2.nombre AS equipo2_nombre,
                            CASE 
                                WHEN p.equipo1 = $id_equipo THEN e2.nombre
                                WHEN p.equipo2 = $id_equipo THEN e1.nombre
                            END AS rival_nombre
                    FROM partidos p
                    LEFT JOIN resultado_enfrentamiento re 
                        ON re.id_enfrentamiento = p.id
                    INNER JOIN equipos e1 ON e1.id = p.equipo1
                    INNER JOIN equipos e2 ON e2.id = p.equipo2
                    WHERE $id_equipo IN (p.equipo1, p.equipo2)
                    AND re.id IS NULL
                    AND p.fecha >= CURDATE()
                    ORDER BY p.fecha ASC
                    LIMIT 1;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener el próximo enfrentamiento: " . $e;
        }
    }

    public static function agregarDatosPartidoJugadorModel($datos)
    {
        $tabla = "partido_jugador";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (id_partido, id_jugador, amonestacion_leve, amonestacion_grave, punto_conseguido) 
                    VALUES (:id_enfrentamiento, :id_jugador, :amonestacion_leve, :amonestacion_grave, :punto_conseguido)";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id_enfrentamiento", $datos['id_enfrentamiento']);
            $preparado->bindParam(":id_jugador", $datos['id_jugador']);
            $preparado->bindParam(":amonestacion_leve", $datos['amonestacion_leve']);
            $preparado->bindParam(":amonestacion_grave", $datos['amonestacion_grave']);
            $preparado->bindParam(":punto_conseguido", $datos['punto_conseguido']);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al agregar el registro del jugador en el partido: " . $e;
        }
    }

    public static function verDatosPartidoJugadorModel($id_enfrentamiento, $id_jugador)
    {
        $tabla = "partido_jugador";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id_partido = :id_partido AND id_jugador = :id_jugador";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':id_partido', $id_enfrentamiento, PDO::PARAM_INT);
            $preparado->bindParam(':id_jugador', $id_jugador, PDO::PARAM_INT);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener los datos del jugador en el partido: " . $e;
        }
    }

    public static function verDatosPartidoJugadorGeneralModel($id_jugador)
    {
        $tabla = "partido_jugador";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id_jugador = :id_jugador";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':id_jugador', $id_jugador, PDO::PARAM_INT);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al obtener los datos del jugador en el partido: " . $e;
        }
    }

    public static function eliminarDatosPartidoJugadorModel($id){
        $tabla = "partido_jugador";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "DELETE FROM $tabla WHERE id = $id";
        try{
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        }catch (PDOException $e) {
            print "Error al eliminar los datos del jugador en el partido: " . $e;
        }
    }
}
