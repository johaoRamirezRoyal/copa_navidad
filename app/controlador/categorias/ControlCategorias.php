<?php 
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'categorias' . DS . 'CategoriasModal.php';
//require_once MODELO_PATH . DS . 'subcategorias' . DS . 'CategoriasModal.php';

class ControlCategorias
{
    private static $instancia; 

    public static function singleton_categorias(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosCategoriasControl(){
        $mostrar = CategoriasModel::obtenerTodasLasCategoriasModel();
        return $mostrar;
    }

    public function obtenerTodosLosSubcategoriasControl(){
        $mostrar = SubcategoriasModel::obtenerTodasLasSubcategoriasModel();
        return $mostrar;
    }

}
