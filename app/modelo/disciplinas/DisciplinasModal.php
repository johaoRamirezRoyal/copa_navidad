<?php 
require_once MODELO_PATH . 'conexion.php';

class DisciplinasModel extends conexion {
    public static function obtenerTodasLasDisciplinasModel(){
        $tabla = "disciplinas";
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
            print "Error al traer las disciplinas: " . $e->getMessage();
        }
    }
}