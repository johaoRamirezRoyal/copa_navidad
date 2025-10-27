<?php 
require_once MODELO_PATH . 'conexion.php';

class EquiposModel extends conexion {
    public static function obtenerTodosLosEquiposModel(){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los equipos: " . $e->getMessage();
        }
    }

    public static function obtenerEquipoCategoriaSubcategoriaColegioModel($datos){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT e.nombre as nombre_equipo, 
                    c.nombre as categoria, 
                    cp.nombre as colegio_nombre, 
                    d.nombre as deporte
                    FROM `equipos` e
                        left join categorias c ON e.categoria = c.id
                        left join colegios_participantes cp ON cp.id = e.colegio
                        left join subcategoria sc on sc.id = e.sub_categoria
                        left join disciplinas d ON d.id = e.diciplina
                    where cp.id = :colegio_id and c.id = :categoria_id and sc.id = :subcategoria_id;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":categoria_id", $datos['categoria_id'], PDO::PARAM_INT);
            $preparado->bindParam(":subcategoria_id", $datos['subcategoria_id'], PDO::PARAM_INT);
            $preparado->bindParam(":colegio_id", $datos['colegio_id'], PDO::PARAM_INT);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los equipos por filtro: " . $e->getMessage();
        }
    }

}