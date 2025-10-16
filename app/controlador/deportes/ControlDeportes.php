<?php 
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'deportes' . DS . 'DeportesModel.php';

class ControlDeportes
{
    private static $instancia; 

    public static function singleton_deportes(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosDeportesControl(){
        $mostrar = DeportesModel::obtenerTodosLosDeportesModel();
        return $mostrar;
    }

}