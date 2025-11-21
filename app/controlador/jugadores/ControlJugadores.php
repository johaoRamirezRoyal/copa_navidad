<?php
date_default_timezone_set('America/Bogota');

require_once CONTROL_PATH . 'EnlacesControl.php';

require_once MODELO_PATH . 'jugadores' . DS . 'JugadoresModel.php';

class ControlJugadores
{
    private static $instancia;

    public static function singleton_jugadores()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function obtenerTodosLosJugadoresControl()
    {
        $mostrar = JugadoresModel::obtenerTodosLosJugadoresModel();
        return $mostrar;
    }

    public function obtenerJugadorPorIdControl($id)
    {
        $mostrar = JugadoresModel::obtenerJugadorPorIdModel($id);
        return $mostrar;
    }

    public function agregarJugadorControl()
    {
        if (isset($_POST['guardar_jugador'])) {

            $total_jugadores = count($_POST['nombre_jugador']);

            for ($i = 0; $i < $total_jugadores; $i++) {
                $datos = array(
                    'nombre' => $_POST['nombre_jugador'][$i],
                    'edad' => $_POST['edad_jugador'][$i],
                    'id_equipo' => $_POST['id_equipo'][$i]
                );

                $agregar = JugadoresModel::agregarJugadorModel($datos);

                if (!$agregar) {
                    echo '
                    <div class="alert alert-red" role="alert">
                        <strong>Error!</strong> No se pudo agregar el jugador '
                        . $_POST['nombre_jugador'][$i] .
                        '</div>
                ';
                    return;
                }
            }
            echo '
                    <div class="alert alert-green" role="alert">
                        <strong>Exito!</strong> Se ha agregado correctamente el jugador.
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
        }
    }

    public function desactivarParticipacionJugadorControl($id_jugador)
    {
        if (isset($_POST['desactivar_jugador'])) {
            $id_jugador = $_POST['id_jugador'];
            $desactivar = JugadoresModel::desactivarParticipacionJugador($id_jugador);

            if ($desactivar) {
                echo '             
                        <div class="alert alert-green" role="alert">
                            <strong>Exito!</strong> Se ha desactivado la participacion del jugador.
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
                        </script>';
            } else {
                echo '                     
                        <div class="alert alert-red" role="alert">
                            <strong>Error!</strong> No se ha podido desactivar la participacion del jugador.
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
                        </script>';
            }
        } else {
            echo '
                    <div class="alert alert-red" role="alert">
                            <strong>Error!</strong> No se ha podido desactivar la participacion del jugador, revisa el parametro.
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
                        </script>';
        }
    }
}
