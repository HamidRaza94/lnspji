<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/config/Database.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/middlewares/PersonalDetailMiddleware.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/successHandler.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/errorHandler.php');

  $id = isset($_GET['id']) ? $_GET['id'] : false;

  if($id) {
    $database = new Database();
    $db = $database->connect();

    $middleware = new PersonalDetailMiddleware($db);
    $response = $middleware->getPersonalDetail($id);

    if($response['isSuccess']) {
      echo successHandler('Success', 'OK', 200, $middleware->data);
    } else {
      echo errorHandler($response['error'], $response['message'], $response['status']);
    }
  } else {
    echo errorHandler('BAD_REQUEST', 'Please Enter ID', 400);
  }
?>