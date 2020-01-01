<?php

class Database
{

    // specify your own database credentials
    private $host = "localhost";

    private $db_name = "gameApi";

    private $username = "root";

    private $password = "";

    public $conn;

    // get the database connection
    public function getConnection()
    {
        $this->conn = null;
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->test) && strcmp($data->test, "test123") == 0) {
            $this->db_name = "gameApiTest";
        }
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>