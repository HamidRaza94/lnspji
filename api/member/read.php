<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require_once '../../config/Database.php';
  include_once '../../models/Member.php';
  include_once '../../libs/handler/successHandler.php';
  include_once '../../libs/handler/errorHandler.php';

  $id = isset($_GET['id']) ? $_GET['id'] : false;

  if($id) {
    $database = new Database();
    $db = $database->connect();

    $member = new Member($db);
    $member->id = $id;
    $isMember = $member->getMember();

    if($isMember) {
      $document;

      $data = array(
        'id' => $member->id,
        'Name' => $member->name,
        'Father/Husband Name' => $member->fatherHusbandName,
        'Sex' => $member->sex,
        'Marital Status' => $member->maritalStatus,
        'Religion' => $member->religion,
        'Category' => $member->category,
        'Date of Birth' => $member->dateOfBirth,
        'Place of Birth' => $member->placeOfBirth,
        'Occupation' => $member->occupation,
        'Email ID' => $member->email,
        'Contact' => $member->contact,
        'Address' => $member->address,
        'State' => $member->state,
        'Pincode' => $member->pincode,
        'Amount' => $member->amount,
        'Date' => $member->date,
        'Police Station' => $member->policeStation,
        'Physical Status' => $member->physicalStatus
      );

      if($member->isDocument) {
        $document = array(
          'Aadhaar ID' => $member->aadhar,
          'PAN ID' => $member->pan
        );
      } else {
        $document = array(
          'Document' => 'No Document Attached',
        );
      }
      
      $data = array_merge($data, $document);

      echo successHandler('Success', 'OK', 200, $data);
    } else {
      echo errorHandler('BAD_REQUEST', 'Please Check ID', 400);
    }
  } else {
    echo errorHandler('BAD_REQUEST', 'Please Enter ID', 400);
  }
?>