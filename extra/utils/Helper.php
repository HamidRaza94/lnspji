<?php
  class Helper {    
    public function generateID($conn, $table) {
      $query = 'SELECT id FROM ' . $table . ' ORDER BY id DESC LIMIT 1';
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      return ($row['id'] + 1);
    }

    public function validateEmail($email) {
      $regex = '/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/';

      return preg_match($regex, $email);
    }

    public function validateID($id) {
      $regex = '/^[a-zA-Z0-9]+$/';

      return preg_match($regex, $id);
    }
  }
?>