<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Transaction.php';

  $database = new Database();
  $db = $database->connect();

  $transaction = new Transaction($db);
  $result = $transaction->getAllTransactions();
  $num = $result->rowCount();

  if($num > 0) {
    $transactions_arr = array();
    $transactions_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $transaction_item = array(
        'Transaction ID' => $id,
        'Amount' => $amount,
        'Date' => $date
      );

      array_push($transactions_arr['data'], $transaction_item);
    }

    echo json_encode($transactions_arr);
  } else {
    echo json_encode(
      array('message' => 'No Transactions Found')
    );
  }
?>