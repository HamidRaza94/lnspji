<?php
  function successHandler($message, $success, $status, $data) {
    return json_encode(
      array(
        'message' => $message,
        'success' => $success,
        'status' => $status,
        'data' => $data
      )
    );
  }
?>