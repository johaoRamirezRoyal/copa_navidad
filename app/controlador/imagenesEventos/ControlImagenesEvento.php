<?php
require_once CONTROL_PATH . DS . 'EnlacesControl.php';
require_once MODELO_PATH . DS . 'imagenesEvento' . DS . 'imagenesEvento.php';
require_once CONTROL_PATH . DS . 'archivos.php';

class ControlImagenesEvento
{
    private static $instancia;

    public static function singleton_imagenes_evento()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function obtenerImagenesDeporteControl($deporte)
    {
        $mostrar = imagenesEvento::obtenerImagenesDeporteModel($deporte);
        return $mostrar;
    }

    public function guardarImagenEventoControl()
    {
        if(isset($_POST['subirImagenEvento'])){
            $deporte = $_POST['deporte'];
            $archivo = $_FILES['imagenEvento'];

            // Guardar el archivo usando el controlador de archivos
            $controlArchivos = ControlArchivos::singleton_archivos();
            $rutaImagen = $controlArchivos->guardarArchivo($archivo, 'imagenes_eventos');

            $datosModel = array(
                'deporte' => $deporte,
                'url_image' => $rutaImagen
            );
            
            $guardar = imagenesEvento::guardarImagenEventoModel($datosModel);

            if ($guardar) {
                echo '
                    <div class="alert alert-green" role="alert">
                        <strong>Éxito!</strong> La imagen del evento se ha subido correctamente.
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
                    <div class="alert alert-red" role="alert">
                        <strong>Error!</strong> Hubo un problema al subir la imagen del evento.
                    </div>
                ';
            }
        }
    }
}