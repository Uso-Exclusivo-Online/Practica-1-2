<!-- /*app es el cerebro del sistema;*/
/*investigar PDO en php -->

<?php
    require_once realpath('../../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable('../../');
    $dotenv->load();
    define('SERVIDOR',$_ENV ['SERVIDOR']);
    define('USUARIO',$_ENV ['USUARIO']);
    define('PASSWORD',$_ENV ['PASSWORD']);
    define('PUERTO',$_ENV['PUERTO']);
    define('BD',$_ENV['BD']);

    class Conexion{
        private static $conexion;
        public static function abrir_conexion(){
            if(!isset(self:: $conexion)){
                try{
                    self::$conexion = new PDO('mysql:host='.SERVIDOR.';dbname='.BD,USUARIO,PASSWORD);
                    self::$conexion-> exec ('SET CHARACTER SET utf8');
                    return self::$conexion;
                }catch(PDOException $e){
                    echo "Error en la Conexion: ".$e;  
                    die();
                }    
            }else{
                return self::$conexion;
            }
         }
         public static function obtener_conexion(){
                $conexion = self::abrir_conexion();
                return $conexion;
            }
        public static function cerrar_conexion(){
            self:: $conexion = null;
        
        }
    }

        class CRUD{
            public static function consulta(){
            $consulta = Conexion :: obtener_conexion()->prepare ("SELECT *FROM tabla_prueba");
            if($consulta -> execute ()){
                $data = $consulta -> fetchAll (PDO::FETCH_ASSOC);
                echo print_r($data);
                echo"Consulta Completada";
            }else{
                echo "error al consultar";
            

        }
    

    }
}
CRUD::consulta();

echo print_r (Conexion::obtener_conexion());
?>

