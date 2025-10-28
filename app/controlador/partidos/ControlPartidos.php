<?php 
require_once MODELO_PATH . 'partidos' . DS . 'PartidosModel.php';

class ControlPartidos {
    private static $instancia; 

    public static function singleton_partidos(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosPartidosControl(){
        $mostrar = PartidosModel::obtenerTodosLosPartidosModel();
        return $mostrar;
    }

    public function obtenerPartidosEnBaseAlDiaControl($fecha){
        $mostrar = PartidosModel::obtenerPartidosEnBaseAlDiaModel($fecha);
        return $mostrar;
    }

    public function crearPartidoControl($datos){
        if(isset($_POST['crear_enfrentamiento'])){
            $datos = array(
                'fecha' => $_POST['fecha'],
                'lugar' => $_POST['lugar'],
                'disciplina' => $_POST['disciplina'],
                'categoria' => $_POST['categoria'],
                'subcategoria' => $_POST['subcategoria'],
                'equipo1' => $_POST['equipo1'],
                'equipo2' => $_POST['equipo2']
            ); 

            if(!in_array('', $datos, true) && !in_array(null, $datos, true)){
                $crear_partido = PartidosModel::crearPartidoModel($datos);
                if($crear_partido){
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Exito!</strong> El enfrentamiento se ha creado correctamente.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        setTimeout(recargarPagina,1050);
                        
                        function recargarPagina(){
                            window.location.replace("index");
                        }
                    ';
                }else{
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido generar este enfrentamiento.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
            }else{
                return "No se enviaron los suficientes datos al servidor"; 
            }
        }
    }

}