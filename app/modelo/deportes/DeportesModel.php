<?php 
require_once MODELO_PATH . 'conexion.php';

class DeportesModel extends conexion {
    public static function obtenerTodosLosDeportesModel(){
        $tabla = "disciplinas"; 
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE activo = 1";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los deportes: " . $e->getMessage();
        }
    }
}