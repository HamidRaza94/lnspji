<?php
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/models/News.php');

  class NewsMiddleware {
    private $news;

    public function __construct($db) {
      $this->news = new News($db);
    }

    public function getAll() {
      $result = $this->news->getAll();
      $num = $result->rowCount();

      if($num > 0) {
        $data = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $item = array(
            'News ID' => $id,
            'News Type' => $type,
            'Headline' => $headline,
            'Description' => $description,
            'State' => $state,
            'URL' => $url,
            'Publish Date' => $publishDate,
            'Last Modified Date' => $lastModifiedDate
          );

          array_push($data, $item);
        }

        return array(
          'isSuccess' => true,
          'data' => $data
        );
      }

      return array(
        'isSuccess' => false,
        'error' => 'Not Found',
        'message' => 'No Data Found',
        'status' => 400
      );
    }

    public function create($data) {
      $result = $this->news->create($data);

      if($result) {
        return array(
          'isSuccess' => true,
          'data' => $data
        );
      }

      return array(
        'isSuccess' => false,
        'error' => 'Unsuccessful',
        'message' => 'Something is wrong',
        'status' => 400
      );
    }
  }
?>