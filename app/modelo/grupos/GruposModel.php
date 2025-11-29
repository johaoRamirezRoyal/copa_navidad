<?php
require_once MODELO_PATH . 'conexion.php';

class GruposModel extends conexion
{
    public static function obtenerTodosLosGruposModel()
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT g.*, d.nombre AS disciplina_nombre, c.nombre AS categoria_nombre, s.nombre AS subcategoria_nombre FROM $tabla g
                    LEFT JOIN disciplinas d ON g.disciplina = d.id
                    LEFT JOIN categorias c ON g.categoria = c.id
                    LEFT JOIN subcategoria s ON g.subcategoria = s.id
        ";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al traer los grupos: " . $e->getMessage();
        }
    }

    public static function obtenerGrupoPorIdModel($id)
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al traer el grupo por ID: " . $e->getMessage();
        }
    }

    public static function crearGrupoModel($datos)
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (nombre, disciplina, categoria, subcategoria) 
                    VALUES (:nombre, :disciplina, :categoria, :sub_categoria)";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre']);
            $preparado->bindParam(":disciplina", $datos['disciplina']);
            $preparado->bindParam(":categoria", $datos['categoria']);
            $preparado->bindParam(":sub_categoria", $datos['sub_categoria']);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al crear el grupo: " . $e->getMessage();
        }
    }

    public static function eliminarGrupoModel($id)
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "DELETE FROM $tabla WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al eliminar el grupo: " . $e->getMessage();
        }
    }

    public static function obtenerGruposFiltradoModel($categoria, $subcategoria, $deporte){
    $tabla = "grupos";
    $cnx = conexion::singleton_conexion();

    $cmdsql = "SELECT
                    g.id,
                    g.categoria AS id_categoria,
                    g.subcategoria AS id_subcategoria,
                    g.disciplina AS id_disciplina,
                    g.nombre AS nombre,

                    c.nombre AS categoria_nombre,
                    sc.nombre AS subcategoria_nombre,
                    d.nombre AS disciplina_nombre

                FROM grupos g
                LEFT JOIN categorias c ON g.categoria = c.id
                LEFT JOIN subcategoria sc ON g.subcategoria = sc.id
                LEFT JOIN disciplinas d ON g.disciplina = d.id 
                WHERE g.nombre IS NOT NULL
                $categoria $subcategoria $deporte;";

    try{
        $preparado = $cnx->preparar($cmdsql);
        if($preparado->execute()){
            return $preparado->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }catch(PDOException $e){
        print "Error al traer los grupos por filtro: " . $e->getMessage();
    }
}

    public static function editarGrupoModel($datos)
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla 
                    SET nombre = :nombre, disciplina = :disciplina, categoria = :categoria, subcategoria = :sub_categoria
                    WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre']);
            $preparado->bindParam(":disciplina", $datos['disciplina']);
            $preparado->bindParam(":categoria", $datos['categoria']);
            $preparado->bindParam(":sub_categoria", $datos['sub_categoria']);
            $preparado->bindParam(":id", $datos['id']);
            if ($preparado->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al editar el grupo: " . $e->getMessage();
        }
    }


    function puntosVolley($setsEquipo, $setsRival)
    {
        // Gana el equipo
        if ($setsEquipo > $setsRival) {
            if ($setsEquipo == 2 && $setsRival == 0) {
                return 4; // Gana 2-0
            } elseif ($setsEquipo == 2 && $setsRival == 1) {
                return 3; // Gana 2-1
            }
        }

        // Pierde el equipo
        if ($setsRival > $setsEquipo) {
            if ($setsRival == 2 && $setsEquipo == 1) {
                return 2; // Pierde 1-2
            } elseif ($setsRival == 2 && $setsEquipo == 0) {
                return 1; // Pierde 0-2
            }
        }

        return 0; // Por si acaso, aunque no debería pasar
    }

    public static function mostrarTablaDePosicionesGrupoModel($id_grupo)
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
        } else if(in_array($grupo_info['disciplina'], $array_basket)) {
            $pts_victoria = 2;
            $pts_derrota = 1;
            $pts_empate = 0;
        }else if(in_array($grupo_info['disciplina'], $array_softball)) {
            $pts_victoria = 2;
            $pts_derrota = 1;
            $pts_empate = 0;
        }else{
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

                        SUM(CASE WHEN r.ganador = e.id THEN 1 ELSE 0 END) AS PG,
                        SUM(CASE WHEN r.ganador != e.id AND r.ganador != 0 THEN 1 ELSE 0 END) AS PP,
                        SUM(CASE WHEN r.ganador = 0 THEN 1 ELSE 0 END) AS PE,

                        SUM(
                            CASE 
                                WHEN r.id_equipo1 = e.id THEN r.pts_equipo1
                                WHEN r.id_equipo2 = e.id THEN r.pts_equipo2
                                ELSE 0
                            END
                        ) AS GF,

                        SUM(
                            CASE 
                                WHEN r.id_equipo1 = e.id THEN r.pts_equipo2
                                WHEN r.id_equipo2 = e.id THEN r.pts_equipo1
                                ELSE 0
                            END
                        ) AS GC,

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

                        SUM(
                            CASE 
                            
                                ----------------------------------------------------
                                -- SI ES VOLEY (DISCIPLINA = 3) SE CALCULAN PUNTOS
                                ----------------------------------------------------
                                WHEN g.disciplina = 3 THEN 
                                    CASE 
                                        ------------------------------------------------
                                        -- El equipo es id_equipo1
                                        ------------------------------------------------
                                        WHEN r.id_equipo1 = e.id THEN
                                            CASE 
                                                WHEN r.sets_equipo1 = 2 AND r.sets_equipo2 = 0 THEN 4
                                                WHEN r.sets_equipo1 = 2 AND r.sets_equipo2 = 1 THEN 3
                                                WHEN r.sets_equipo1 = 1 AND r.sets_equipo2 = 2 THEN 2
                                                WHEN r.sets_equipo1 = 0 AND r.sets_equipo2 = 2 THEN 1
                                                ELSE 0
                                            END

                                        ------------------------------------------------
                                        -- El equipo es id_equipo2
                                        ------------------------------------------------
                                        WHEN r.id_equipo2 = e.id THEN
                                            CASE 
                                                WHEN r.sets_equipo2 = 2 AND r.sets_equipo1 = 0 THEN 4
                                                WHEN r.sets_equipo2 = 2 AND r.sets_equipo1 = 1 THEN 3
                                                WHEN r.sets_equipo2 = 1 AND r.sets_equipo1 = 2 THEN 2
                                                WHEN r.sets_equipo2 = 0 AND r.sets_equipo1 = 2 THEN 1
                                                ELSE 0
                                            END

                                    END

                                ----------------------------------------------------
                                -- SI NO ES VOLEY USA TU LÓGICA NORMAL
                                ----------------------------------------------------
                                ELSE
                                    CASE
                                        WHEN r.ganador = e.id THEN $pts_victoria
                                        WHEN r.ganador = 0 THEN $pts_empate
                                        ELSE $pts_derrota
                                    END
                            END
                        ) AS PTS

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
                    ORDER BY PTS DESC, DG DESC, GF DESC;
                    ";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al mostrar la tabla de posiciones del grupo: " . $e->getMessage();
        }
    }
}
