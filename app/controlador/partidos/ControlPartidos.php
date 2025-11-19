<?php
require_once MODELO_PATH . 'partidos' . DS . 'PartidosModel.php';

class ControlPartidos
{
    private static $instancia;

    public static function singleton_partidos()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function obtenerTodosLosPartidosControl()
    {
        $mostrar = PartidosModel::obtenerTodosLosPartidosModel();
        return $mostrar;
    }

    public function obtenerEnfrentamientoIDControl($id)
    {
        $mostrar = PartidosModel::obtenerEnfrentamientoID($id);
        return $mostrar;
    }

    public function obtenerPartidosEnBaseAlDiaControl($fecha)
    {
        $mostrar = PartidosModel::obtenerPartidosEnBaseAlDiaModel($fecha);
        return $mostrar;
    }

    public function crearPartidoControl()
    {
        if (isset($_POST['crear_enfrentamiento'])) {
            $datos = array(
                'fecha' => $_POST['fecha'],
                'lugar' => $_POST['lugar'],
                'disciplina' => $_POST['disciplina'],
                'categoria' => $_POST['categoria'],
                'subcategoria' => $_POST['subcategoria'],
                'equipo1' => $_POST['equipo1'],
                'equipo2' => $_POST['equipo2']
            );

            if (!in_array('', $datos, true) && !in_array(null, $datos, true)) {
                $crear_partido = PartidosModel::crearPartidoModel($datos);
                if ($crear_partido) {
                    echo '
                        <div class="alert alert-green" role="alert">
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
                } else {
                    echo '
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido generar este enfrentamiento.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
            } else {
                return "No se enviaron los suficientes datos al servidor";
            }
        }
    }

    public function eliminarPartidoControl()
    {
        if (isset($_POST['eliminar_partido'])) {
            $id = $_POST['id'];

            $eliminar = PartidosModel::eliminarPartidoModel($id);

            if ($eliminar) {
                echo '
                        <div class="alert alert-green" role="alert">
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
            } else {
                echo '
                        <div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se ha podido eliminar este enfrentamiento.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
            }
        }
    }

    // =========== LÓGICA PARA LOS RESULTADOS DE LOS ENFRENTAMIENTOS ================== // 

    public function definirResultadoDeEnfrentamientoControl()
    {
        if (
            isset($_POST['guardar'])
        ) {

            $datos = array(
                'id_equipo1' => $_POST['id_equipo1'],
                'id_equipo2' => $_POST['id_equipo2'],
                'pts_equipo1' => $_POST['pts_equipo1'],
                'pts_equipo2' => $_POST['pts_equipo2'],
                'ganador' => isset($_POST['ganador']) ? intval($_POST['ganador']) : 0,
                'id_enfrentamiento' => $_POST['id_enfrentamiento'],
                'id_deporte' => $_POST['id_deporte']
            );

            $busqueda = PartidosModel::obtenerResultadoDeEnfrentamiento($datos['id_enfrentamiento']);

            $agregar_resultado = false;

            if ($busqueda) {
                $eliminar = PartidosModel::eliminarResultadoDeEnfrentamientoModel($datos['id_enfrentamiento']);

                if ($eliminar) {
                    $agregar_resultado = PartidosModel::definirResultadoDeEnfrentamientoModel($datos);
                } else {
                    echo
                    '<div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Ya exite un registro de resultados de este enfrentamiento pero no se pudo sobreescribir.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            } else {
                $agregar_resultado = PartidosModel::definirResultadoDeEnfrentamientoModel($datos);
            }

            if ($agregar_resultado) {
                echo '<div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> Se ha definido el resultado con éxito.
                        </div>
                        
                        <script>
                            setTimeout(()=> {
                                const alert = document.querySelector(".alert");
                                if(alert) {
                                    alert.classList.remove("show");
                                    alert.classList.add("fade");
                                }
                                setTimeout(() => window.location.replace("index?enfrentamiento='. $datos['id_enfrentamiento'] .'"), 200);
                            }, 2050)
                        </script>';
            } else {
                echo
                '<div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> No se puedo agregar el resultado del enfrentamiento. Puede ser que falten datos o valores.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        }
    }

    public function obtenerResultadoDeEnfrentamiento($id_enfrentamiento)
    {
        $datos = PartidosModel::obtenerResultadoDeEnfrentamiento($id_enfrentamiento);
        return $datos;
    }

    public function obtenerInformacionResultadoEnfrentamientos(){
        $datos = PartidosModel::obtenerInformacionResultadoEnfrentamientos();
        return $datos;
    }

    public function obtenerInformacionResultadoEnfrentamientosEnBaseAlDia($fecha){
        $datos = PartidosModel::obtenerInformacionResultadoEnfrentamientosEnBaseAlDia($fecha);
        return $datos;
    }
}
