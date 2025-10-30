<?php
date_default_timezone_set('America/Bogota');
require_once MODELO_PATH . DS . 'colegios' . DS . 'ColegiosModel.php';
require_once CONTROL_PATH . DS . 'archivos.php';


class ControlColegios
{
    private static $instancia;

    public static function singleton_colegios()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function obtenerTodosLosColegiosControl()
    {
        $mostrar = ColegiosModel::obtenerTodosLosColegiosModel();
        return $mostrar;
    }
    public function obtenerTodosLosColegiosRegistrosControl()
    {
        $mostrar = ColegiosModel::obtenerTodosLosColegiosRegistrosModel();
        return $mostrar;
    }

    public function obtenerColegioPorIDControl($id)
    {
        $mostrar = ColegiosModel::obtenerColegioPorIDModel($id);
        return $mostrar;
    }

    public function eliminarColegioParticipanteControl()
    {
        if (isset($_POST['desactivar'])) {
            $id = $_POST['id'];

            $eliminar = ColegiosModel::eliminarColegioParticipanteModel($id);

            if ($eliminar) {
                echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El colegio se ha eliminado correctamente.
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
            } else {
                echo '
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido eliminar este colegio.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }

    public function eliminarRegistroColegioParticipanteControl()
    {
        if (isset($_POST['eliminar_colegio'])) {
            $id = $_POST['id'];
            $logo = $_POST['logo'];

            $controlArchivos = ControlArchivos::singleton_archivos();

            $eliminar_logo = $controlArchivos->eliminarArchivo($logo);

            if ($eliminar_logo['estado'] == true) {
                $eliminar_colegio = ColegiosModel::eliminarRegistroColegioParticipanteModel($id);
                if ($eliminar_colegio) {
                    echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El colegio se ha eliminado completamente.
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
                } else {
                    echo '
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido eliminar este colegio.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
            } else {
                echo '
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ' . $eliminar_logo['error'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }

    public function crearColegioParticipanteControl()
    {
        if (isset($_POST['crear_colegio'])) {
            $controlArchivos = ControlArchivos::singleton_archivos();

            $archivo = $controlArchivos->guardarArchivo($_FILES['archivo']);

            $datos = array(
                'nombre' => $_POST['nombre'],
                'logo' => $archivo
            );

            $nuevo_colegio = ColegiosModel::crearColegioParticipanteModel($datos);

            if ($nuevo_colegio) {
                echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El colegio se ha agregado correctamente.
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
            } else {
                echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido agregar este colegio.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }
}
