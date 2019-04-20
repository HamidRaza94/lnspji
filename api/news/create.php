<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/config/Database.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/middlewares/NewsMiddleware.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/successHandler.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/errorHandler.php');

  // Get raw data
  $data = json_decode(file_get_contents("php://input"));

  // Initiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  $middleware = new NewsMiddleware($db);
  $response = $middleware->create($data);

  if($response['isSuccess']) {
    echo successHandler('Success', 'OK', 200, $response['data']);
  } else {
    echo errorHandler($response['error'], $response['message'], $response['status']);
  }
?>