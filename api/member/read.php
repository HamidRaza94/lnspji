<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/config/Database.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/middlewares/MemberMiddleware.php');
  // include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/models/Member.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/successHandler.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/errorHandler.php');

  $id = isset($_GET['id']) ? $_GET['id'] : false;

  if($id) {
    $database = new Database();
    $db = $database->connect();

    $middleware = new MemberMiddleware($db);
    $response = $middleware->getMember($id);

    if($response['isSuccess']) {
      echo successHandler('Success', 'OK', 200, $response['data']);
    } else {
      echo errorHandler($response['error'], $response['message'], $response['status']);
    }

  //   $member = new Member($db);
  //   $member->id = $id;
  //   $isMember = $member->getMember();

  //   if($isMember) {
  //     $document;

  //     $data = array(
  //       'id' => $member->id,
  //       'Name' => $member->name,
  //       'Father/Husband Name' => $member->fatherHusbandName,
  //       'Sex' => $member->sex,
  //       'Marital Status' => $member->maritalStatus,
  //       'Religion' => $member->religion,
  //       'Category' => $member->category,
  //       'Date of Birth' => $member->dateOfBirth,
  //       'Place of Birth' => $member->placeOfBirth,
  //       'Occupation' => $member->occupation,
  //       'Email ID' => $member->email,
  //       'Contact' => $member->contact,
  //       'Address' => $member->address,
  //       'State' => $member->state,
  //       'Pincode' => $member->pincode,
  //       'Amount' => $member->amount,
  //       'Date' => $member->date,
  //       'Police Station' => $member->policeStation,
  //       'Physical Status' => $member->physicalStatus
  //     );

  //     if($member->isDocument) {
  //       $document = array(
  //         'Aadhaar ID' => $member->aadhar,
  //         'PAN ID' => $member->pan
  //       );
  //     } else {
  //       $document = array(
  //         'Document' => 'No Document Attached',
  //       );
  //     }
      
  //     $data = array_merge($data, $document);

  //     echo successHandler('Success', 'OK', 200, $data);
  //   } else {
  //     echo errorHandler('BAD_REQUEST', 'Please Check ID', 400);
  //   }
  } else {
    echo errorHandler('BAD_REQUEST', 'Please Enter ID', 400);
  }
?>