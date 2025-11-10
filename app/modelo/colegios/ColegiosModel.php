<?php 
require_once MODELO_PATH . 'conexion.php';

class ColegiosModel extends conexion {
    public static function obtenerTodosLosColegiosModel(){
        $tabla = "colegios_participantes";
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
            print "Error al traer los colegios: " . $e->getMessage();
        }
    }

    public static function obtenerTodosLosColegiosRegistrosModel(){
        $tabla = "colegios_participantes";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla;";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al traer los colegios: " . $e->getMessage();
        }
    }

    public static function eliminarColegioParticipanteModel($id){
        $tabla = "colegios_participantes";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla SET activo = 0 WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':id', $id);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print 'Error al eliminar el colegio' . $e->getMessage();
        }
    }

    public static function activarColegioParticipanteModel($id){
        $tabla = "colegios_participantes";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "UPDATE $tabla SET activo = 1 WHERE id = :id AND activo = 0";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':id', $id);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print 'Error al eliminar el colegio' . $e->getMessage();
        }
    }

    public static function eliminarRegistroColegioParticipanteModel($id){
        $tabla = "colegios_participantes";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "DELETE FROM $tabla WHERE id = :id";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al eliminar completamente el registro del colegio: " . $e->getMessage();
        }
    }

    public static function obtenerColegioPorIDModel($id){
        $tabla = "colegios_participantes";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id = :id AND activo = 1";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':id', $id);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print 'Error al tratar de obtener el colegio: ' . $e->getMessage();
        }
    }

    public static function crearColegioParticipanteModel($datos){
        $tabla = "colegios_participantes";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (nombre, logo, activo) VALUES (:nombre, :logo, 1)";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(':nombre', $datos['nombre']);
            $preparado->bindParam(':logo', $datos['logo']);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print 'Error a crear el colegio: ' . $e->getMessage();
        }
    }

}