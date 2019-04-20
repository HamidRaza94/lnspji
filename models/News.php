<?php
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/extra/utils/Helper.php');

  class News {
    // DB Stuff
    private $conn;
    private $table = 'news';

    public function __construct($db) {
      $this->conn = $db;
    }

    // returns all news
    public function getAll() {
      $query = 'SELECT * FROM ' . $this->table;
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    // create a news
    public function create($data) {
      $query = '
        INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          type= :type,
          headline= :headline,
          description= :description,
          state= :state,
          url= :url
      ';

      $stmt = $this->conn->prepare($query);

      $helper = new Helper();
      $id = $helper->generateID($this->conn, $this->table);

      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':type', $data->type);
      $stmt->bindParam(':headline', $data->headline);
      $stmt->bindParam(':description', $data->description);
      $stmt->bindParam(':state', $data->state);
      $stmt->bindParam(':url', $data->url);

      if($stmt->execute()) {
        return true;
      }

      return false;
    }
  }
?>