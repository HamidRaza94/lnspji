<?php
  class Transaction {
    // DB Stuff
    private $conn;
    private $table = 'transactions';

    // Transaction Properties
    public $id;
    public $amount;
    public $date;

    // Getting DB Connection in $conn
    public function __construct($db) {
      $this->conn = $db;
    }

    // Returns Single Transaction
    public function getTransaction() {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->amount = $row['amount'];
      $this->date = $row['date'];
    }

    // Returns All Transaction
    public function getAllTransactions() {
      $query = 'SELECT * FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    // Create Transaction
    public function createTransaction() {
      // Query for member
      $query = '
        INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          amount = :amount
      ';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':amount', $this->amount);
      // $stmt->bindParam(':contact', $this->date);

      if($stmt->execute()) {
        return true;
      }

      return false;
    }
  }
?>