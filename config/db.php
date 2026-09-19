<?php
$envFile = __DIR__ . '/../.env';

if (!is_file($envFile)) {
    throw new Exception('Database configuration file is missing. Create a .env file in the project root.');
}

$environment = parse_ini_file($envFile);

if ($environment === false) {
    throw new Exception('Database configuration file could not be read.');
}

define('DB_HOST', $environment['DB_HOST'] ?? '127.0.0.1');
define('DB_USER', $environment['DB_USER'] ?? 'root');
define('DB_PASSWORD', $environment['DB_PASSWORD'] ?? '');
define('DB_NAME', $environment['DB_NAME'] ?? 'campushub');

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