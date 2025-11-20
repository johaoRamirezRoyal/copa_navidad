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

    public function obtenerEquiposInformacionControl(){
        $mostrar = EquiposModel::obtenerEquiposInformacionModel();
        return $mostrar;
    }

    public function agregarNuevoEquipoControl(){
        if(isset($_POST['agregar_equipo'])){
            $datos = array(
                'nombre' => $_POST['nombre'],
                'categoria' => $_POST['categoria'],
                'sub_categoria' => $_POST['sub_categoria'],
                'colegio' => $_POST['colegio'],
                'diciplina' => $_POST['diciplina']
            );
            
            $nuevo_equipo = EquiposModel::agregarNuevoEquipoModel($datos);

            if($nuevo_equipo){
                echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El equipo se ha creado correctamente.
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
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido crear el equipo.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }

        }
    }

    public function obtenerEquiposFiltradoControl($datos){
        $categoria = (isset($datos['categoria'])) ? 'AND c.id = ' . $datos['categoria'] : '';
        $subcategoria = (isset($datos['subcategoria'])) ? 'AND sc.id = ' . $datos['subcategoria'] : '';
        $deporte = (isset($datos['deporte'])) ? 'AND d.id = ' . $datos['deporte'] : '';

        $equipos = EquiposModel::obtenerEquiposFiltradoModel($categoria, $subcategoria, $deporte);

        return $equipos; 
    }

    public function eliminarEquipoControl(){
        if(isset($_POST['eliminar_equipo'])){
            $id = $_POST['id'];

            $eliminar = EquiposModel::eliminarEquipoModel($id);

            if($eliminar){
                echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El equipo se ha eliminado correctamente.
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
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido eliminar el equipo.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }

    public function actualizarEquipoControl(){
        if(isset($_POST['actualizar_equipo'])){
            $datos = array(
                'nombre' => $_POST['nombre'],
                'categoria' => $_POST['categoria'],
                'sub_categoria' => $_POST['sub_categoria'],
                'colegio' => $_POST['colegio'],
                'diciplina' => $_POST['diciplina'],
                'id' => $_POST['id']
            ); 

            $actualizar = EquiposModel::actualizarEquipoModel($datos);

            if($actualizar){
                echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El equipo se ha actualizado correctamente.
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
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido editar el equipo.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }

}



