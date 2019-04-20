<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/config/Database.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/models/Member.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/successHandler.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/errorHandler.php');

  $database = new Database();
  $db = $database->connect();

  $member = new Member($db);
  $result = $member->getAllMembers();
  $num = $result->rowCount();

  if($num > 0) {
    $data = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $document;

      $member_item = array(
        'id' => $id,
        'Name' => $name,
        'Father/Husband Name' => $fatherHusbandName,
        'Sex' => $sex,
        'Marital Status' => $maritalStatus,
        'Religion' => $religion,
        'Category' => $category,
        'Date of Birth' => $dateOfBirth,
        'Place of Birth' => $placeOfBirth,
        'Occupation' => $occupation,
        'Email ID' => $email,
        'Contact' => $contact,
        'Address' => $address,
        'State' => $state,
        'Pincode' => $pincode,
        'Amount' => $amount,
        'Date' => $date,
        'Police Station' => $policeStation,
        'Physical Status' => $physicalStatus
      );

      if($member->isDocument) {
        $document = array(
          'Document ID' => $member->documentID,
          'Aadhar ID' => $member->aadhar,
          'PAN ID' => $member->pan
        );
      } else {
        $document = array(
          'Document' => 'No Document Attached',
        );
      }
      
      $member_item = array_merge($member_item, $document);
      array_push($data, $member_item);
    }

    echo successHandler('Success', 'OK', 200, $data);
  } else {
    echo errorHandler('Not Found', 'No Data Found', 404);
  }
?>