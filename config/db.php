<?php
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Imesh#14681');
define('DB_NAME', 'campushub');

class Database{

    public static $connection;

    public static function setUpconnection(){
        if(!isset(self::$connection)){
            
            self::$connection = new mysqli(
               DB_HOST,
               DB_USER,
               DB_PASSWORD,
               DB_NAME
            );

            if (self::$connection->connect_error) {
                error_log("Database connection failed: " . self::$connection->connect_error);
                throw new Exception("Database connection failed. Please try again later.");
            }
            self::$connection->set_charset("utf8mb4");
        }
    }

    public static function iud($q){
        self::setUpconnection();
        return self::$connection->query($q);
    }

    public static function search($q){
        self::setUpconnection();
        $resultset=self::$connection->query($q);
        return $resultset;
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Database::setUpconnection();
$conn = Database::$connection;

?>