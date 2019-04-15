<?php
  class Document {
    // DB Stuff
    private $conn;
    private $table = 'documents';

    // Document Properties
    public $id;
    public $memberID;
    public $aadhar;
    public $pan;

    // Getting DB Connection in $conn
    public function __construct($db) {
      $this->conn = $db;
    }

    // Returns Single Document
    public function getDocument() {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->amount = $row['amount'];
      $this->date = $row['date'];
      $this->date = $row['date'];
    }

    // Create Document
    public function createDocument() {
      $query = '
        INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          amount = :amount
      ';

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':amount', $this->amount);

      if($stmt->execute()) {
        return true;
      }

      return false;
    }
  }
?>