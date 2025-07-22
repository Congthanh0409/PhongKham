<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'pkdk';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            $this->conn->set_charset("utf8mb4");

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch(Exception $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            die("Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.");
        }

        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
