<?php
  class PersonalDetail {
    // DB Stuff
    private $conn;
    private $table = 'personalDetails';

    // Personal Detail Properties
    public $id;
    public $name;
    public $fatherHusbandName;
    public $sex;
    public $maritalStatus;
    public $religion;
    public $category;
    public $dateOfBirth;
    public $placeOfBirth;
    public $occupation;

    // Getting DB Connection in $conn
    public function __construct($db) {
      $this->conn = $db;
    }

    // Returns Personal Detail Of Member
    public function getPersonalDetail() {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if($row > 0) {
        $this->name = $row['name'];
        $this->fatherHusbandName = $row['fatherHusbandName'];
        $this->sex = $row['sex'];
        $this->maritalStatus = $row['maritalStatus'];
        $this->religion = $row['religion'];
        $this->category = $row['category'];
        $this->dateOfBirth = $row['dateOfBirth'];
        $this->placeOfBirth = $row['placeOfBirth'];
        $this->occupation = $row['occupation'];

        return true;
      } else {
        return false;
      }
    }

    public function get($id) {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $id);
      $stmt->execute();

      return $stmt;
    }

    // Returns Personal Detail Of All Member
    public function getAllPersonalDetails() {
      $query = 'SELECT * FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    // Create Personal Detail
    public function createPersonalDetail() {
      // Query for member
      $query = '
        INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          name = :name,
          fatherHusbandName = :fatherHusbandName,
          sex = :sex,
          maritalStatus = :maritalStatus,
          religion = :religion,
          category = :category,
          dateOfBirth = :dateOfBirth,
          placeOfBirth = :placeOfBirth,
          occupation = :occupation
      ';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':fatherHusbandName', $this->fatherHusbandName);
      $stmt->bindParam(':sex', $this->sex);
      $stmt->bindParam(':maritalStatus', $this->maritalStatus);
      $stmt->bindParam(':religion', $this->religion);
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':dateOfBirth', $this->dateOfBirth);
      $stmt->bindParam(':placeOfBirth', $this->placeOfBirth);
      $stmt->bindParam(':occupation', $this->occupation);

      if($stmt->execute()) {
        return true;
      }

      return false;
    }
  }
?>