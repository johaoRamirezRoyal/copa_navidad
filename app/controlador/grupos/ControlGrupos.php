<?php 
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'grupos' . DS . 'GruposModel.php';

class ControlGrupos
{
    private static $instancia;

    public static function singleton_grupos(){
        if(!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase; 
        }
        return self::$instancia;
    }

    public function obtenerTodosLosGruposControl(){
        $mostrar = GruposModel::obtenerTodosLosGruposModel();
        return $mostrar;
    }

    public function obtenerGrupoPorIdControl($id){
        $mostrar = GruposModel::obtenerGrupoPorIdModel($id);
        return $mostrar;
    }

    public function crearGrupoControl(){
        if(isset($_POST['crear_grupo'])){
            $datos = array(
                'nombre' => $_POST['nombre'],
                'disciplina' => $_POST['disciplina'],
                'categoria' => $_POST['categoria'],
                'sub_categoria' => $_POST['sub_categoria']
            );
            
            $nuevo_grupo = GruposModel::crearGrupoModel($datos);

            if($nuevo_grupo){
                echo '                       
                <div class="alert alert-green" role="alert">
                    <strong>Exito!</strong> El grupo se ha creado correctamente.
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
                        <strong>Error!</strong> No se ha podido crear el grupo.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
            }
        }
    }

    public function eliminarGrupoControl(){
        if(isset($_POST['eliminar_grupo'])){
            $id = $_POST['id_grupo'];

            $eliminar_grupo = GruposModel::eliminarGrupoModel($id);

            if($eliminar_grupo){
                echo '                       
                <div class="alert alert-green" role="alert">
                    <strong>Exito!</strong> El grupo se ha eliminado correctamente.
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
                        <strong>Error!</strong> No se ha podido eliminar el grupo.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
            }
        }
    }
}