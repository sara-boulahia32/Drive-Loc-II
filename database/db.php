<?php
class dataBase {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'Sara123@';
    private $name = 'drive_loc';

    private function __construct() {
        $this->conn = new PDO("mysql:host={$this->host};dbname={$this->name}", $this->user, $this->pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new dataBase();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
