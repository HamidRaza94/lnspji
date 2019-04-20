<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/config/Database.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/models/Member.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/successHandler.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/errorHandler.php');

  // Get raw data
  $data = json_decode(file_get_contents("php://input"));

  // Initiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // instantiate blog member object
  $member = new Member($db);

  $member->name = $data->name;
  $member->fatherHusbandName = $data->fatherHusbandName;
  $member->sex = $data->sex;
  $member->maritalStatus = $data->maritalStatus;
  $member->religion = $data->religion;
  $member->category = $data->category;
  $member->dateOfBirth = $data->dateOfBirth;
  $member->placeOfBirth = $data->placeOfBirth;
  $member->occupation = $data->occupation;
  $member->email = $data->email;
  $member->contact = $data->contact;
  $member->address = $data->address;
  $member->state = $data->state;
  $member->pincode = $data->pincode;
  $member->amount = $data->amount;
  $member->isDocument = $data->isDocument;
  $member->policeStation = $data->policeStation;
  $member->physicalStatus = $data->physicalStatus;

  if($data->isDocument) {
    $member->aadhar = $data->aadhar;
    $member->pan = $data->pan;
  }

  if($member->createMember()) {
    echo successHandler('Member Created', 'OK', 200, $data);
  } else {
    echo errorHandler('BAD_REQUEST', 'Member Not Created', 400);
  }
?>