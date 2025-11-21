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

    
    public static function obtenerEquiposInformacionModel(){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                    e.id, e.categoria AS id_categoria, e.sub_categoria AS id_subcategoria, e.colegio AS id_colegio, e.diciplina AS id_deporte,
                    e.nombre as nombre_equipo,
                    e.id_grupo AS grupo,
                    c.nombre as categoria, 
                    cp.nombre as colegio_nombre, 
                    d.nombre as deporte,
                    sc.nombre as subcategoria
                    FROM `equipos` e
                        left join categorias c ON e.categoria = c.id
                        left join colegios_participantes cp ON cp.id = e.colegio
                        left join subcategoria sc on sc.id = e.sub_categoria
                        left join disciplinas d ON d.id = e.diciplina
                    WHERE e.activo = 1";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los equipos por filtro: " . $e->getMessage();
        }
    }

    public static function agregarNuevoEquipoModel($datos){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (nombre, categoria, sub_categoria, colegio, diciplina, id_grupo) 
                    VALUES (:nombre, :categoria, :sub_categoria, :colegio, :diciplina, :grupo)";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre']);
            $preparado->bindParam(":categoria", $datos['categoria']);
            $preparado->bindParam(":sub_categoria", $datos['sub_categoria']);
            $preparado->bindParam(":colegio", $datos['colegio']);
            $preparado->bindParam(":diciplina", $datos['diciplina']);
            $preparado->bindParam(":grupo", $datos['grupo']);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al agregar el equipo: " . $e->getMessage();
        }
    }

    public static function obtenerEquiposFiltradoModel($categoria, $subcategoria, $deporte){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                    e.id, e.categoria AS id_categoria, e.sub_categoria AS id_subcategoria, e.colegio AS id_colegio, e.diciplina AS id_deporte,
                    e.nombre as nombre_equipo, 
                    e.id_grupo AS grupo, 
                    c.nombre as categoria, 
                    cp.nombre as colegio_nombre, 
                    d.nombre as deporte,
                    sc.nombre as subcategoria
                    FROM `equipos` e
                        left join categorias c ON e.categoria = c.id
                        left join colegios_participantes cp ON cp.id = e.colegio
                        left join subcategoria sc on sc.id = e.sub_categoria
                        left join disciplinas d ON d.id = e.diciplina
                    WHERE e.activo = 1 
                    $categoria $subcategoria $deporte;";;
        try{
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los equipos por filtro: " . $e->getMessage();
        }
    }

    public static function eliminarEquipoModel($id){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla SET activo = 0 WHERE id = $id AND activo = 1";
        try{
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al eliminar el equipo: " . $e->getMessage();
        }
    }

    public static function actualizarEquipoModel($datos){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla SET nombre = :nombre, categoria = :categoria, sub_categoria = :sub_categoria, colegio = :colegio, diciplina = :diciplina, id_grupo = :grupo WHERE id = :id";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre']);
            $preparado->bindParam(":categoria", $datos['categoria']);
            $preparado->bindParam(":sub_categoria", $datos['sub_categoria']);
            $preparado->bindParam(":colegio", $datos['colegio']);
            $preparado->bindParam(":diciplina", $datos['diciplina']);
            $preparado->bindParam(":grupo", $datos['grupo']);
            $preparado->bindParam(":id", $datos['id']);
            if($preparado->execute()){
                return true;
            }else {
                return false;
            }
        }catch(PDOException $e){
            print "Error al actualizar el equipo: " . $e->getMessage();
        }
    }

    public static function obtenerEquiposColegioDeporte($id_colegio, $id_deporte){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE colegio = :id_colegio AND diciplina = :id_deporte AND activo = 1";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id_colegio", $id_colegio, PDO::PARAM_INT);
            $preparado->bindParam(":id_deporte", $id_deporte, PDO::PARAM_INT);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los equipos del colegio y deporte: " . $e->getMessage();
        }
    }

    public static function obtenerEquipoPorIdModel($id){
        $tabla = "equipos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT
                    e.id, e.categoria AS id_categoria, e.sub_categoria AS id_subcategoria, e.colegio AS id_colegio, e.diciplina AS id_deporte,
                    e.nombre as nombre_equipo, e.id_grupo AS grupo,  
                    c.nombre as categoria, 
                    cp.nombre as colegio_nombre, 
                    d.nombre as deporte,
                    sc.nombre as subcategoria
                    FROM `equipos` e
                        left join categorias c ON e.categoria = c.id
                        left join colegios_participantes cp ON cp.id = e.colegio
                        left join subcategoria sc on sc.id = e.sub_categoria
                        left join disciplinas d ON d.id = e.diciplina
                    WHERE e.activo = 1 AND e.id = :id";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id, PDO::PARAM_INT);
            if($preparado->execute()){
                return $preparado->fetch(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer el equipo por ID: " . $e->getMessage();
        }
    }
}