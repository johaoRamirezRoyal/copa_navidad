<?php



class conexion

{

    private static $instancia;

    private $cnx;

    protected $manejador = 'mysql';



    private static $hostip         = 'localhost';

    private static $username       = 'root';

<<<<<<< HEAD
    private static $passwordserver = 'Angel1413@.-+#';
=======
    private static $passwordserver = '12345678'; //'SlpapApue141305.-+@';
>>>>>>> 6e8db3a (añadido nuevas fotografias)

    protected $database            = 'copa_navidad';



    private function __construct()

    {

        try {

            $this->cnx = new PDO($this->manejador . ':host=' . self::$hostip . ';dbname=' . $this->database, self::$username, self::$passwordserver, array(PDO::ATTR_PERSISTENT => true));

            $this->cnx->exec("SET CHARACTER SET utf8");

        } catch (PDOException $e) {

            print "ERROR!: " . $e->getMessage();

            die();

        }

    }



    public static function singleton_conexion()

    {

        if (!isset(self::$instancia)) {

            $miclase         = __CLASS__;

            self::$instancia = new $miclase;

        }

        return self::$instancia;

    }



    public function preparar($sql)

    {

        return $this->cnx->prepare($sql);

    }



    public function ultimoIngreso($cp)

    {

        return $this->cnx->lastInsertId($cp);

    }

    //evita que el objeto se pueda clonar

    public function __clone()

    {

        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);

    }

    function getSQLDebug($sql, $params) {
        foreach ($params as $key => $value) {
            $sql = str_replace(":".$key, "'".$value."'", $sql);
        }
        return $sql;
    }

}

?>