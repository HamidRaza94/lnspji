<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Document.php';

  $database = new Database();
  $db = $database->connect();

  $document = new Document($db);
  $id = 'hamid12345';
  $result = $document->getDocument($id);
  $num = $result->rowCount();

  if($num > 0) {
    $document_arr = array();
    $document_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $document_item = array(
        'Document ID' => $id,
        'Member ID' => $memberID,
        'Aadhaar ID' => $aadhar,
        'PAN ID' => $pan
      );

      array_push($document_arr['data'], $document_item);
    }

    echo json_encode($document_arr);
  } else {
    echo json_encode(
      array('message' => 'No Document Found')
    );
  }
?>