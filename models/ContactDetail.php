<?php
  class ContactDetail {
    // DB Stuff
    private $conn;
    private $table = 'contactDetails';

    // Contact Detail Properties
    public $id;
    public $email;
    public $contact;
    public $address;
    public $state;
    public $pincode;

    // Getting DB Connection in $conn
    public function __construct($db) {
      $this->conn = $db;
    }

    // Returns Contact Detail Of Member
    public function getContactDetail() {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->email = $row['email'];
      $this->contact = $row['contact'];
      $this->address = $row['address'];
      $this->address = $row['address'];
      $this->state = $row['state'];
      $this->pincode = $row['pincode'];
    }

    // Returns Contact Details of All Member
    public function getAllContactDetails() {
      $query = 'SELECT * FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    // Create Contact Detail
    public function createContactDetail() {
      // Query for member
      $query = '
        INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          email = :email,
          contact = :contact,
          address = :address,
          state = :state,
          pincode = :pincode
      ';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':contact', $this->contact);
      $stmt->bindParam(':address', $this->address);
      $stmt->bindParam(':state', $this->state);
      $stmt->bindParam(':pincode', $this->pincode);

      if($stmt->execute()) {
        return true;
      }

      return false;
    }
  }
?>