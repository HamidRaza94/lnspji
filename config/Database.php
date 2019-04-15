<?php
  class Database {
    // DB Params
    private $host = 'localhost';
    private $db_name = 'lnspji';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB Connection
    public function connect() {
      $this->conn = null;

      try {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $exception) {
        echo ('Connection Error: ' . $exception->getMessage());
      }

      return $this->conn;
    }
  }
?>