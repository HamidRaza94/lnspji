<?php
  include_once '../models/PersonalDetail.php';

  class PersonalDetailMiddleware {
    private $personalDetail;

    public function __construct($db) {
      $this->personalDetail = new PersonalDetail($db);
    }

    public function getPersonalDetail($id) {
      $result = $this->personalDetail->get($id);
      $row = $result->fetch(PDO::FETCH_ASSOC);

      if($row > 0) {
        extract($row);

        $data = array(
          'Personal Detail ID' => $id,
          'Name' => $name,
          'Father/Husband Name' => $fatherHusbandName,
          'Sex' => $sex,
          'Marital Status' => $maritalStatus,
          'Religion' => $religion,
          'Category' => $category,
          'Date of Birth' => $dateOfBirth,
          'Place of Birth' => $placeOfBirth,
          'Occupation' => $occupation
        );

        return array(
          'isSuccess' => true,
          'data' => $data
        );
      } else {
        return array(
          'isSuccess' => false
        );
      }
    }
  }
?>