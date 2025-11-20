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
                'nombre' => trim($_POST['nombre']),
                'colegio' => trim($_POST['colegio']),
                'disciplina' => isset($_POST['disciplina']) ? trim($_POST['disciplina']) : ''
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
        $categoria = ''; // categoría eliminada del filtro
        $subcategoria = (isset($datos['subcategoria']) && $datos['subcategoria'] !== '' && is_numeric($datos['subcategoria'])) ? 'AND sc.id = ' . (int)$datos['subcategoria'] : '';
        $deporte = (isset($datos['deporte']) && $datos['deporte'] !== '' && is_numeric($datos['deporte'])) ? 'AND d.id = ' . (int)$datos['deporte'] : '';

        $equipos = EquiposModel::obtenerEquiposFiltradoModel($categoria, $subcategoria, $deporte);

        return $equipos; 
    }

    public function eliminarEquipoControl(){
        if(isset($_POST['eliminar_equipo'])){
            $id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0;

            if($id <= 0){
                echo '<div class="alert alert-red">ID inválido</div>';
                return;
            }

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
                'nombre' => trim($_POST['nombre']),
                'colegio' => trim($_POST['colegio']),
                'disciplina' => isset($_POST['disciplina']) ? trim($_POST['disciplina']) : '',
                'id' => isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : 0
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



