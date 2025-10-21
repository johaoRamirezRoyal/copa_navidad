<?php 
require_once MODELO_PATH . 'conexion.php';

class CategoriasModel extends conexion {
    public static function obtenerTodasLasCategoriasModel(){
        $tabla = "categorias";
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
            print "Error al traer las categorias: " . $e->getMessage();
        }
    }
}