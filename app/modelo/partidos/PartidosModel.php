<?php 
require_once MODELO_PATH . 'conexion.php'; 

class PartidosModel extends conexion {
    public static function obtenerTodosLosPartidosModel() {
        $tabla = 'partidos';
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT 
                        p.id,
                        p.fecha,
                        p.lugar,
                        d.nombre AS disciplina,
                        c.nombre AS categoria,
                        s.nombre AS subcategoria,
                        e1.nombre AS equipo1,
                        e2.nombre AS equipo2,
                        cp1.nombre AS colegio_equipo1, 
                        cp2.nombre AS colegio_equipo2
                    FROM $tabla p
                    LEFT JOIN disciplinas d ON p.disciplina = d.id
                    LEFT JOIN categorias c ON p.categoria = c.id
                    LEFT JOIN subcategoria s ON p.subcategoria = s.id
                    LEFT JOIN equipos e1 ON e1.id = p.equipo1
                    LEFT JOIN equipos e2 ON e2.id = p.equipo2
                    LEFT JOIN colegios_participantes cp1 ON cp1.id = e1.colegio
                    LEFT JOIN colegios_participantes cp2 ON cp2.id = e2.colegio 
                    ORDER BY p.fecha DESC;"; 
        try{
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print 'Error al consultar los enfrentamientos: ' . $e->getMessage();
        }
    }

    public static function obtenerPartidosEnBaseAlDiaModel($fecha){
        $tabla = "partidos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT 
                        p.id,
                        p.fecha,
                        p.lugar,
                        d.nombre AS disciplina,
                        c.nombre AS categoria,
                        s.nombre AS subcategoria,
                        e1.nombre AS equipo1,
                        e2.nombre AS equipo2,
                        cp1.nombre AS colegio_equipo1, 
                        cp2.nombre AS colegio_equipo2
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
        try{
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll();
            }else{
                return false;
            }
        }catch(PDOException $e){
            print 'Error al consultar los partidos en el día ' . $fecha . ': ' . $e->getMessage();
        }
    }

    public static function crearPartidoModel($datos){
        $tabla = "partidos"; 
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (fecha, lugar, disciplina, categoria, subcategoria, equipo1, equipo2) 
                    VALUES (:fecha, :lugar, :disciplina, :categoria, :subcategoria, :equipo1, :equipo2)";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':fecha', $datos['fecha']);
            $preparado->bindParam(':lugar', $datos['lugar']);
            $preparado->bindParam(':disciplina', $datos['disciplina']);
            $preparado->bindParam(':categoria', $datos['categoria']);
            $preparado->bindParam(':subcategoria', $datos['subcategoria']);
            $preparado->bindParam(':equipo1', $datos['equipo1']);
            $preparado->bindParam(':equipo2', $datos['equipo2']);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al crear el enfrentamiento: " . $e;
        }
    }
}