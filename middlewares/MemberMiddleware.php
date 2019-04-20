<?php
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/models/Member.php');
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/middlewares/PersonalDetailMiddleware.php');

  class MemberMiddleware extends PersonalDetailMiddleware {
    private $member;
    private $personalDetailMiddleware;

    public function __construct($db) {
      $this->member = new Member($db);
      parent::__construct($db);
    }

    public function getMember($id) {
      $response = array();

      $result = $this->member->get($id);
      $row = $result->fetch(PDO::FETCH_ASSOC);

      if($row > 0) {
        extract($row);

        $data = array(
          'Member ID' => $id,
          'Personal Detail ID' => $personalDetailID,
          'Contact Detail ID' => $contactDetailID,
          'Transaction Detail ID' => $transactionID,
          'isDocument' => $isDocument,
          'Police Station' => $policeStation,
          'Physical Status' => $physicalStatus
        );

        $response = $this->getPersonalDetail($personalDetailID);

        if($response['isSuccess']) {
          $data = array_merge($data, $response['data']);

          return array(
            'isSuccess' => true,
            'data' => $data
          );
        } else {
          return array(
            'isSuccess' => false,
            'error' => 'BAD_REQUEST',
            'message' => 'Please Check ID',
            'status' => 400
          );
        }
      } else {
        return array(
          'isSuccess' => false,
          'error' => 'BAD_REQUEST',
          'message' => 'Please Check ID',
          'status' => 400
        );
      }
    }
  }
?>