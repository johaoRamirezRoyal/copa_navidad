<?php 
require_once MODELO_PATH . 'conexion.php';

class GruposModel extends conexion
{
    public static function obtenerTodosLosGruposModel()
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT g.*, d.nombre AS disciplina_nombre, c.nombre AS categoria_nombre, s.nombre AS subcategoria_nombre FROM $tabla g
                    LEFT JOIN disciplinas d ON g.disciplina = d.id
                    LEFT JOIN categorias c ON g.categoria = c.id
                    LEFT JOIN subcategoria s ON g.sub_categoria = s.id
        ";
        try {
            $preparado = $cnx->preparar($cmdsql);
            if ($preparado->execute()) {
                return $preparado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al traer los grupos: " . $e->getMessage();
        }
    }

    public static function obtenerGrupoPorIdModel($id)
    {
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "SELECT * FROM $tabla WHERE id = :id";
        try {
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id);
            if ($preparado->execute()) {
                return $preparado->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error al traer el grupo por ID: " . $e->getMessage();
        }
    }

    public static function crearGrupoModel($datos){
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "INSERT INTO $tabla (nombre, disciplina, categoria, sub_categoria) 
                    VALUES (:nombre, :disciplina, :categoria, :sub_categoria)";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":nombre", $datos['nombre']);
            $preparado->bindParam(":disciplina", $datos['disciplina']);
            $preparado->bindParam(":categoria", $datos['categoria']);
            $preparado->bindParam(":sub_categoria", $datos['sub_categoria']);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al crear el grupo: " . $e->getMessage();
        }
    }

    public static function eliminarGrupoModel($id){
        $tabla = "grupos";
        $cnx = conexion::singleton_conexion();
        $cmdsql = "DELETE FROM $tabla WHERE id = :id";
        try{
            $preparado = $cnx->preparar($cmdsql);
            $preparado->bindParam(":id", $id);
            if($preparado->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            print "Error al eliminar el grupo: " . $e->getMessage();
        }
    }
}