<?php 
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'disciplinas' . DS . 'DisciplinasModal.php';

class ControlDisciplinas
{
    private static $instancia; 

    public static function singleton_disciplinas(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosDisciplinasControl(){
        $mostrar = DisciplinasModel::obtenerTodasLasDisciplinasModel();
        return $mostrar;
    }

}