<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/ContactDetail.php';

  $database = new Database();
  $db = $database->connect();

  $contactDetail = new ContactDetail($db);
  $result = $contactDetail->getAllContactDetails();
  $num = $result->rowCount();

  if($num > 0) {
    $contactDetails_arr = array();
    $contactDetails_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $contactDetail_item = array(
        'Contact Detail ID' => $id,
        'Email ID' => $email,
        'Contact' => $contact,
        'Address' => $address,
        'State' => $state,
        'Pincode' => $pincode
      );

      array_push($contactDetails_arr['data'], $contactDetail_item);
    }

    echo json_encode($contactDetails_arr);
  } else {
    echo json_encode(
      array('message' => 'No Contact Details Found')
    );
  }
?>