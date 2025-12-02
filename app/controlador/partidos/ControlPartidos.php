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

    public function obtenerPartidosFiltradosControl($datos)
    {
        $categoria = (isset($_POST['categoria'])) ? ' AND p.categoria = ' . $_POST['categoria'] : '';
        $subcategoria = (isset($_POST['subcategoria'])) ? ' AND p.subcategoria = ' . $_POST['subcategoria'] : '';
        $deporte = (isset($_POST['deporte'])) ? ' AND p.disciplina = ' . $_POST['deporte'] : '';

        if ($categoria == null && $subcategoria == null && $deporte == null) {
            $mostrar = PartidosModel::obtenerTodosLosPartidosModel();
            return $mostrar;
        }

        $datos = array(
            'categoria' => $categoria,
            'subcategoria' => $subcategoria,
            'deporte' => $deporte
        );

        $mostrar = PartidosModel::obtenerPartidosFiltradosModel($datos);
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

            foreach ($_POST['id_jugador'] as $i => $jugador_id) {

                $leve  = $_POST['amonestacion_leve'][$i];
                $grave = $_POST['amonestacion_grave'][$i];
                $punto = $_POST['punto_conseguido'][$i];

                // Verificar si tiene datos para guardar
                if ($leve == "" && $grave == "" && $punto == "") {
                    continue; // no guardar nada
                }

                $datos_jugador = array(
                    'id_enfrentamiento' => $_POST['id_enfrentamiento'],
                    'id_jugador' => $jugador_id,
                    'amonestacion_leve' => $leve,
                    'amonestacion_grave' => $grave,
                    'punto_conseguido' => $punto
                );

                $buscarDatosJugador = PartidosModel::verDatosPartidoJugadorModel($datos_jugador['id_enfrentamiento'], $datos_jugador['id_jugador']);

                if ($buscarDatosJugador) {

                    $eliminarDatosJugador = PartidosModel::eliminarDatosPartidoJugadorModel($buscarDatosJugador['id']);

                    if ($eliminarDatosJugador) {

                        $agregarDatosJugador = PartidosModel::agregarDatosPartidoJugadorModel($datos_jugador);

                    } else {

                        echo
                        '<div class="alert alert-red alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Ya existe un registro del jugador y no se pudo actualizar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        return;
                    }
                } else {

                    // Si llega aquí es porque sí tiene algo que registrar
                    $agregarDatosJugador = PartidosModel::agregarDatosPartidoJugadorModel($datos_jugador);
                }
            }

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
                                setTimeout(() => window.location.replace("index?enfrentamiento=' . $datos['id_enfrentamiento'] . '"), 200);
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

    public function obtenerInformacionResultadoEnfrentamientos()
    {
        $datos = PartidosModel::obtenerInformacionResultadoEnfrentamientos();
        return $datos;
    }

    public function obtenerInformacionResultadoEnfrentamientosEnBaseAlDia($fecha)
    {
        $datos = PartidosModel::obtenerInformacionResultadoEnfrentamientosEnBaseAlDia($fecha);
        return $datos;
    }

    public function obtenerUltimoPartidoControl($id_equipo)
    {
        $datos = PartidosModel::obtenerUltimoPartidoModel($id_equipo);
        return $datos;
    }

    public function obtenerProximoPartidoControl($id_equipo)
    {
        $datos = PartidosModel::obtenerProximoPartidoModel($id_equipo);
        return $datos;
    }

    public function obtenerTablaDePosicionesControl($grupo)
    {
        $datos = PartidosModel::obtenerTablaDePosiciones($grupo);
        return $datos;
    }

    public function verDatosPartidoJugadorGeneralControl($id_jugador)
    {
        $datos = PartidosModel::verDatosPartidoJugadorGeneralModel($id_jugador);
        return $datos;
    }

    public function verDatosPartidoJugadorControl($id_enfrentamiento, $id_jugador)
    {
        $datos = PartidosModel::verDatosPartidoJugadorModel($id_enfrentamiento, $id_jugador);
        return $datos;
    }

    public function editarPartidoControl()
    {
        if (isset($_POST['editar_enfrentamiento'])) {
            $datos = array(
                'id' => $_POST['id_enfrentamiento'],
                'fecha' => $_POST['fecha'],
                'lugar' => $_POST['lugar'],
                'disciplina' => $_POST['disciplina'],
                'categoria' => $_POST['categoria'],
                'subcategoria' => $_POST['subcategoria'],
                'equipo1' => $_POST['equipo1'],
                'equipo2' => $_POST['equipo2']
            );

            if (!in_array('', $datos, true) && !in_array(null, $datos, true)) {
                $editar_partido = PartidosModel::editarPartidoModel($datos);
                if ($editar_partido) {
                    echo '
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> El enfrentamiento se ha editado correctamente.
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
                            <strong>Error!</strong> No se ha podido editar este enfrentamiento.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                }
            } else {
                return "No se enviaron los suficientes datos al servidor";
            }
        }
    }
}
