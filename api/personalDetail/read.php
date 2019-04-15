<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../middlewares/PersonalDetailMiddleware.php';
  include_once '../../libs/handler/successHandler.php';
  include_once '../../libs/handler/errorHandler.php';

  $id = isset($_GET['id']) ? $_GET['id'] : false;

  if($id) {
    $database = new Database();
    $db = $database->connect();

    $middleware = new PersonalDetailMiddleware($db);
    $response = $middleware->getPersonalDetail($id);

    if($response->isSuccess) {
      echo successHandler('Success', 'OK', 200, $response->data);
    } else {
      echo errorHandler('BAD_REQUEST', 'Please Check ID', 400);
    }

    // 1st approach

    // $personalDetail = new PersonalDetail($db);
    // $result = $personalDetail->get($id);
    // $row = $result->fetch(PDO::FETCH_ASSOC);

    // if($row > 0) {
    //   extract($row);

    //   $data = array(
    //     'Personal Detail ID' => $id,
    //     'Name' => $name,
    //     'Father/Husband Name' => $fatherHusbandName,
    //     'Sex' => $sex,
    //     'Marital Status' => $maritalStatus,
    //     'Religion' => $religion,
    //     'Category' => $category,
    //     'Date of Birth' => $dateOfBirth,
    //     'Place of Birth' => $placeOfBirth,
    //     'Occupation' => $occupation
    //   );

    //   echo successHandler('Success', 'OK', 200, $data);
    // } else {
    //   echo errorHandler('BAD_REQUEST', 'Please Check ID', 400);
    // }




    // 2nd approach

    // $personalDetail->id = $id;
    // $isPersonalDetail = $personalDetail->getPersonalDetail();

    // if($isPersonalDetail) {
    //   $data = array(
    //     'Name' => $personalDetail->name,
    //     'Father/Husband Name' => $personalDetail->fatherHusbandName,
    //     'Sex' => $personalDetail->sex,
    //     'Marital Status' => $personalDetail->maritalStatus,
    //     'Religion' => $personalDetail->religion,
    //     'Category' => $personalDetail->category,
    //     'Date of Birth' => $personalDetail->dateOfBirth,
    //     'Place of Birth' => $personalDetail->placeOfBirth,
    //     'Occupation' => $personalDetail->occupation
    //   );

    //   echo successHandler('Success', 'OK', 200, $data);
    // } else {
    //   echo errorHandler('BAD_REQUEST', 'Please Check ID', 400);
    // }
  } else {
    echo errorHandler('BAD_REQUEST', 'Please Enter ID', 400);
  }
?>