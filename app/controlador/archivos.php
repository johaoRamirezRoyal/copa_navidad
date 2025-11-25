<?php
date_default_timezone_set('America/Bogota');

class ControlArchivos
{
    private static $instancia;

    public static function singleton_archivos()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    function compressImage($source, $destination, $quality)
    {
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($source);
        $mime    = $imgInfo['mime'];
        // Creamos una imagen
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }
        // Guardamos la imagen
        imagejpeg($image, $destination, $quality);
        // Devolvemos la imagen comprimida
        return $destination;
    }

    function guardarArchivo($archivo, $nombre_directorio = "")
    {
        $nom_arch     = $archivo['name'];
        $ext_arch     = strtolower(pathinfo($nom_arch, PATHINFO_EXTENSION));
        $ext_arch     = ($ext_arch == 'jpg') ? 'jpeg' : $ext_arch;

        $fecha_arch   = date('YmdHis');
        $nombre_archivo = strtolower(md5(rand(5, 9999) . '_' . $fecha_arch)) . '.' . $ext_arch;
        $carp_destino = PUBLIC_PATH_ARCH . 'img' . DS . $nombre_directorio . DS;

        // Crear carpeta si no existe
        if (!file_exists($carp_destino)) {
            mkdir($carp_destino, 0777, true);
        }

        $ruta_img     = $carp_destino . $nombre_archivo;

        if ($ext_arch == 'png' || $ext_arch == 'jpeg') {
            $this->compressImage($archivo['tmp_name'], $ruta_img, 50);
        } else {
            move_uploaded_file($archivo['tmp_name'], $ruta_img);
        }

        return $nombre_archivo;
    }

    function eliminarArchivo($archivo, $dir = "")
    {
        $ruta = PUBLIC_PATH_ARCH . 'img' . DS . $dir . DS . $archivo;

        // Verifica si el archivo existe antes de intentar eliminarlo
        if (file_exists($ruta)) {
            if (unlink($ruta)) {
                return array(
                    'error' => '',
                    'estado' => true
                ); // El archivo se eliminó correctamente
            } else {
                return array(
                    'error' => 'Error al intentar eliminar el archivo',
                    'estado' => false
                ); // Hubo un error al intentar eliminar el archivo
            }
        } else {
            return array(
                'error' => 'Archivo no encontrado',
                'estado' => false
            ); // El archivo no existe
        }
    }

    function transformarImagenAWebp() {}
}
