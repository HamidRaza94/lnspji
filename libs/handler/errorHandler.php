<?php
  function errorHandler($error, $message, $status) {
    return json_encode(
      array(
        'error' => $error,
        'message' => $message,
        'status' => $status
      )
    );
  }
?>