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

    public function crearPartidoControl(){
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
                        <div class="alert alert-success" role="alert">
                            <strong>Exito!</strong> El enfrentamiento se ha creado correctamente.
                        </div>
                        
                        <script>
                            setTimeout(()=> {
                                const alert = document.querySelector(".alert");
                                if(alert) {
                                    alert.classList.remove("show");
                                    alert.classList.add("fade");
                                }
                                setTimeout(() => window.location.replace("index"), 200);
                            }, 2050)
                        </script>
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

    public function eliminarPartidoControl(){
        if(isset($_POST['eliminar_partido'])){
            $id = $_POST['id'];

            $eliminar = PartidosModel::eliminarPartidoModel($id);

            if($eliminar){
                echo '
                        <div class="alert alert-success" role="alert">
                            <strong>Exito!</strong> El enfrentamiento se ha eliminado.
                        </div>
                        
                        <script>
                            setTimeout(()=> {
                                const alert = document.querySelector(".alert");
                                if(alert) {
                                    alert.classList.remove("show");
                                    alert.classList.add("fade");
                                }
                                setTimeout(() => window.location.replace("index"), 200);
                            }, 2050)
                        </script>
                    ';
            }else{
                echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido eliminar este enfrentamiento.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }

}