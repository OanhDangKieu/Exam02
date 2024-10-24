<?php
class Database {
    private $server;
    private $database = 'db_dang_kieu_oanh';
    private $username;
    private $password;
    public $conn;

    public function __construct($server, $username, $password) {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        try {
            // Sử dụng host và dbname trong chuỗi kết nối
            $this->conn = new PDO("mysql:host={$this->server};dbname={$this->database}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
            return false;
        }
    }
}
?>
