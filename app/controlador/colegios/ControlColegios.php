<?php 
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'colegios' . DS . 'ColegiosModel.php';

class ControlColegios
{
    private static $instancia; 

    public static function singleton_colegios(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosColegiosControl(){
        $mostrar = ColegiosModel::obtenerTodosLosColegiosModel();
        return $mostrar;
    }

}