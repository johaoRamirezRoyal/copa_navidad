<?php 
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'equipos' . DS . 'EquiposModel.php';

class ControlEquipos
{
    private static $instancia; 

    public static function singleton_equipos(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosEquiposControl(){
        $mostrar = EquiposModel::obtenerTodosLosEquiposModel();
        return $mostrar;
    }

}



