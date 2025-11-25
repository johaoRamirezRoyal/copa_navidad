<?php 
include_once MODELO_PATH . 'conexion.php';

class imagenesEvento extends conexion {
    public static function obtenerImagenesDeporteModel($deporte){
        $tabla = "imagen_evento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id_deporte = :deporte ORDER BY id_imagen_evento DESC LIMIT 10";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":deporte", $deporte, PDO::PARAM_INT);
            if($preparado->execute()){
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "ERROR AL OBTENER IMAGENES DE EVENTO: " . $e->getMessage();
        }
    }

    public static function guardarImagenEventoModel($datosModel){
        $tabla = "imagen_evento";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (id_deporte, url_image) VALUES (:deporte, :url_image)";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":deporte", $datosModel['deporte'], PDO::PARAM_INT);
            $preparado->bindParam(":url_image", $datosModel['url_image'], PDO::PARAM_STR);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "ERROR AL GUARDAR IMAGEN DE EVENTO: " . $e->getMessage();
        }
    }
}