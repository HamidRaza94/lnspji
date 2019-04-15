<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/PersonalDetail.php';
  include_once '../../libs/handler/successHandler.php';
  include_once '../../libs/handler/errorHandler.php';

  $database = new Database();
  $db = $database->connect();

  $personalDetail = new PersonalDetail($db);
  $result = $personalDetail->getAllPersonalDetails();
  $num = $result->rowCount();

  if($num > 0) {
    $data = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $personal_item = array(
        'Personal Detail ID' => $id,
        'Name' => $name,
        'Father/Husband Name' => $fatherHusbandName,
        'Sex' => $sex,
        'Marital Status' => $maritalStatus,
        'Religion' => $religion,
        'Category' => $category,
        'Date of Birth' => $dateOfBirth,
        'Place of Birth' => $placeOfBirth,
        'Occupation' => $occupation
      );

      array_push($data, $personal_item);
    }

    echo successHandler('Success', 'OK', 200, $data);
  } else {
    echo errorHandler('Not Found', 'No Data Found', 404);
  }
?>