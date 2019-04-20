<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/config/Database.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/middlewares/NewsMiddleware.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/successHandler.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/libs/handler/errorHandler.php');

  $database = new Database();
  $db = $database->connect();

  $middleware = new NewsMiddleware($db);
  $response = $middleware->getAll();

  if($response['isSuccess']) {
    echo successHandler('Success', 'OK', 200, $response['data']);
  } else {
    echo errorHandler($response['error'], $response['message'], $response['status']);
  }
?>