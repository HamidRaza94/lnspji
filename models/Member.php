<?php
  // Including Classes
  include_once 'PersonalDetail.php';
  include_once 'ContactDetail.php';
  include_once 'Transaction.php';
  include_once 'Document.php';
  include_once ($_SERVER['DOCUMENT_ROOT'].'/lnspji/extra/utils/Helper.php');
  // include_once 'Helper.php';

  class Member {
    // DB Stuff
    private $conn;
    private $table = 'members';

    public $personalDetail;
    public $contactDetail;
    public $transaction;
    public $document;

    // Member Properties
    public $id;
    public $personalDetailID;
    public $contactDetailID;
    public $transactionID;
    public $isDocument;
    public $policeStation;
    public $physicalStatus;

    // Personal Detail Properties
    public $name;
    public $fatherHusbandName;
    public $sex;
    public $maritalStatus;
    public $religion;
    public $category;
    public $dateOfBirth;
    public $placeOfBirth;
    public $occupation;

    // Contact Detail Properties
    public $email;
    public $contact;
    public $address;
    public $state;
    public $pincode;

    // Transaction Properties
    public $amount;
    public $date;

    // Document Properties
    public $aadhar;
    public $pan;

    // Getting DB Connection in $conn
    public function __construct($db) {
      $this->conn = $db;
      $this->personalDetail = new PersonalDetail($db);
      $this->contactDetail = new ContactDetail($db);
      $this->transaction = new Transaction($db);
    }

    public function get($id) {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $id);
      $stmt->execute();

      return $stmt;
    }

    // Returns Member
    public function getMember() {
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if($row > 0) {
        // Member Table Fields
        $this->personalDetailID = $row['personalDetailID'];
        $this->contactDetailID = $row['contactDetailID'];
        $this->transactionID = $row['transactionID'];
        $this->isDocument = $row['isDocument'];
        $this->policeStation = $row['policeStation'];
        $this->physicalStatus = $row['physicalStatus'];

        // Getting Personal Detail
        $this->personalDetail->id = $this->personalDetailID;
        $this->personalDetail->getPersonalDetail();

        $this->name = $this->personalDetail->name;
        $this->fatherHusbandName = $this->personalDetail->fatherHusbandName;
        $this->sex = $this->personalDetail->sex;
        $this->maritalStatus = $this->personalDetail->maritalStatus;
        $this->religion = $this->personalDetail->religion;
        $this->category = $this->personalDetail->category;
        $this->dateOfBirth = $this->personalDetail->dateOfBirth;
        $this->placeOfBirth = $this->personalDetail->placeOfBirth;
        $this->occupation = $this->personalDetail->occupation;

        // Getting Contact Detail
        $this->contactDetail->id = $this->contactDetailID;
        $this->contactDetail->getContactDetail();

        $this->email = $this->contactDetail->email;
        $this->contact = $this->contactDetail->contact;
        $this->address = $this->contactDetail->address;
        $this->state = $this->contactDetail->state;
        $this->pincode = $this->contactDetail->pincode;

        // Getting Transaction
        $this->transaction->id = $this->transactionID;
        $this->transaction->getTransaction();

        $this->amount = $this->transaction->amount;
        $this->date = $this->transaction->date;

        // Getting Document If It Has
        if($this->isDocument) {
          $this->document = new Document($this->conn);
          $this->document->getDocument();

          $this->aadhar = $this->document->aadhar;
          $this->pan = $this->document->pan;
        }
        return true;
      }

      return false;
    }

    // Return All Members
    public function getAllMembers() {
      $query = '
        SELECT
          m.id,
          m.isDocument,
          m.policeStation,
          m.physicalStatus,
          p.name,
          p.fatherHusbandName,
          p.sex,
          p.maritalStatus,
          p.religion,
          p.category,
          p.dateOfBirth,
          p.placeOfBirth,
          p.occupation,
          c.email,
          c.contact,
          c.address,
          c.state,
          c.pincode,
          t.amount,
          t.date
        FROM
          ' . $this->table . ' m
        INNER JOIN
          personalDetails p ON m.personalDetailID = p.id
        INNER JOIN
          contactDetails c ON m.contactDetailID = c.id
        INNER JOIN
          transactions t ON m.transactionID = t.id
      ';

      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    // Create Member
    public function createMember() {
      // Query for member
      $query = '
        INSERT INTO ' .
          $this->table . '
        SET
          id = :id,
          personalDetailID= :personalDetailID,
          contactDetailID= :contactDetailID,
          transactionID= :transactionID,
          isDocument= :isDocument,
          policeStation= :policeStation,
          physicalStatus= :physicalStatus
      ';

      //Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Set Member Data
      $helper = new Helper();
      $this->id = $helper->generateID($this->conn, $this->table);
      $this->personalDetailID = $helper->generateID($this->conn, 'personalDetails');
      $this->contactDetailID = $helper->generateID($this->conn, 'contactDetails');
      $this->transactionID = $helper->generateID($this->conn, 'transactions');

      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->fatherHusbandName = htmlspecialchars(strip_tags($this->fatherHusbandName));
      $this->sex = htmlspecialchars(strip_tags($this->sex));
      $this->maritalStatus = htmlspecialchars(strip_tags($this->maritalStatus));
      $this->religion = htmlspecialchars(strip_tags($this->religion));
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->dateOfBirth = htmlspecialchars(strip_tags($this->dateOfBirth));
      $this->placeOfBirth = htmlspecialchars(strip_tags($this->placeOfBirth));
      $this->occupation = htmlspecialchars(strip_tags($this->occupation));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->contact = htmlspecialchars(strip_tags($this->contact));
      $this->address = htmlspecialchars(strip_tags($this->address));
      $this->state = htmlspecialchars(strip_tags($this->state));
      $this->pincode = htmlspecialchars(strip_tags($this->pincode));
      $this->amount = htmlspecialchars(strip_tags($this->amount));
      $this->isDocument = htmlspecialchars(strip_tags($this->isDocument));
      $this->policeStation = htmlspecialchars(strip_tags($this->policeStation));
      $this->physicalStatus = htmlspecialchars(strip_tags($this->physicalStatus));

      if($this->isDocument) {
        $this->aadhar = htmlspecialchars(strip_tags($this->aadhar));
        $this->pan = htmlspecialchars(strip_tags($this->pan));
      }

      // Set Personal Detail Data
      $this->personalDetail->id = $this->personalDetailID;
      $this->personalDetail->name = $this->name;
      $this->personalDetail->fatherHusbandName = $this->fatherHusbandName;
      $this->personalDetail->sex = $this->sex;
      $this->personalDetail->maritalStatus = $this->maritalStatus;
      $this->personalDetail->religion = $this->religion;
      $this->personalDetail->category = $this->category;
      $this->personalDetail->dateOfBirth = $this->dateOfBirth;
      $this->personalDetail->placeOfBirth = $this->placeOfBirth;
      $this->personalDetail->occupation = $this->occupation;
      $this->personalDetail->createPersonalDetail();

      // Set Contact Detail Data
      $this->contactDetail->id = $this->contactDetailID;
      $this->contactDetail->email = $this->email;
      $this->contactDetail->contact = $this->contact;
      $this->contactDetail->address = $this->address;
      $this->contactDetail->state = $this->state;
      $this->contactDetail->pincode = $this->pincode;
      $this->contactDetail->createContactDetail();

      //Set Transaction Data
      $this->transaction->id = $this->transactionID;
      $this->transaction->amount = $this->amount;
      $this->transaction->createTransaction();

      if($isDocument) {
        $this->document = new Document($this->conn);
        $this->document->id = $helper->generateID($this->conn, 'documents');
        $this->document->memberID = $this->id;
        $this->document->aadhar = $this->aadhar;
        $this->document->pan = $this->pan;
        $this->document->createDocument();
      }

      // Bind Data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':personalDetailID', $this->personalDetailID);
      $stmt->bindParam(':contactDetailID', $this->contactDetailID);
      $stmt->bindParam(':transactionID', $this->transactionID);
      $stmt->bindParam(':isDocument', $this->isDocument);
      $stmt->bindParam(':policeStation', $this->policeStation);
      $stmt->bindParam(':physicalStatus', $this->physicalStatus);

      if($stmt->execute()) {
        return true;
      }

      return false;
    }
  }
?>