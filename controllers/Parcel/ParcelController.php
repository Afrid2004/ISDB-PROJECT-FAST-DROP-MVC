<?php

class ParcelController
{
  function index()
  {
    if (!isset($_SESSION['user']['email'])) {
      redirect("login");
      exit;
    };
    view("");
  }



  function submit()
  {
    if (isset($_POST['btn_submit'])) {
      global $db;
      // Logged in user
      $sender_user_id = $_SESSION['user']['id'];
      // Parcel Information
      $parcel_type = trim($_POST['parceltype'] ?? '');
      $parcel_name = trim($_POST['parcelname'] ?? '');
      $parcel_weight = floatval($_POST['parcelweight'] ?? 0);

      $sender_name = trim($_POST['sendername'] ?? '');
      $sender_phone = trim($_POST['senderphone'] ?? '');
      $sender_email = trim($_POST['senderemail'] ?? '');
      $sender_address = trim($_POST['senderaddress'] ?? '');
      $sender_district = intval($_POST['senderdistrict'] ?? 0);

      $receiver_name = trim($_POST['receivername'] ?? '');
      $receiver_phone = trim($_POST['receiverphone'] ?? '');
      $receiver_email = trim($_POST['receiveremail'] ?? '');
      $receiver_address = trim($_POST['receiveraddress'] ?? '');
      $receiver_district = intval($_POST['receiverdistrict'] ?? 0);

      $parcel_note = trim($_POST['parcelnote'] ?? '');

      //store old value
      $_SESSION['old'] = $_POST;

      // Validation
      $errors = [];
      // Parcel
      if (empty($parcel_type)) {
        $errors[] = "Please select parcel type.";
      }
      if (empty($parcel_name)) {
        $errors[] = "Parcel name is required.";
      }
      if ($parcel_weight <= 0) {
        $errors[] = "Parcel weight must be greater than 0.";
      }

      // Sender
      if (empty($sender_name)) {
        $errors[] = "Sender name is required.";
      }
      if (!preg_match('/^(01)[3-9]\d{8}$/', $sender_phone)) {
        $errors[] = "Invalid sender phone number.";
      }
      if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid sender email.";
      }
      if (empty($sender_address)) {
        $errors[] = "Sender address is required.";
      }
      if ($sender_district <= 0) {
        $errors[] = "Please select sender district.";
      }

      // Receiver
      if (empty($receiver_name)) {
        $errors[] = "Receiver name is required.";
      }
      if (!preg_match('/^(01)[3-9]\d{8}$/', $receiver_phone)) {
        $errors[] = "Invalid receiver phone number.";
      }
      if (!filter_var($receiver_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid receiver email.";
      }
      if (empty($receiver_address)) {
        $errors[] = "Receiver address is required.";
      }
      if ($receiver_district <= 0) {
        $errors[] = "Please select receiver district.";
      }

      // But same phone is not allowed
      if (
        !empty($sender_phone) &&
        !empty($receiver_phone) && $sender_phone == $receiver_phone
      ) {
        $errors[] = "Sender and receiver phone number cannot be the same.";
      }

      // Stop if validation fails
      if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect("parcel");
        exit;
      }


      $tracking_id     = Parcel::generateTrackingId();
      $delivery_charge = 0;
      $insideCharge = 60;
      $outsideCharge = 80;
      $extraPerKg = 40;
      if ($parcel_weight <= 3) {
        if ($sender_district == $receiver_district) {
          $delivery_charge = $insideCharge;
        } else {
          $delivery_charge = $outsideCharge;
        }
      } else {
        $extraWeight = ceil($parcel_weight - 3);
        if ($sender_district == $receiver_district) {
          $delivery_charge = $insideCharge + ($extraWeight * $extraPerKg);
        } else {
          $delivery_charge = $outsideCharge + ($extraWeight * $extraPerKg);
        }
      };

      //create parcel
      $parcel = new Parcel();
      $parcel->set($tracking_id, $parcel_type, $parcel_name, $parcel_weight, $sender_user_id, $sender_name, $sender_phone, $sender_email, $sender_address, $sender_district, $receiver_name, $receiver_phone, $receiver_email, $receiver_address, $receiver_district, $delivery_charge, $parcel_note);

      //create tackings
      $tracking = new Tracking();

      // transation for secure execute 
      // transaction start 
      $db->begin_transaction();
      try {
        $parcel_id = $parcel->create();
        if (!$parcel_id) {
          throw new Exception("Parcel creation failed!");
        }

        // create tracking 
        $tracking->set($parcel_id, "pending", $sender_district, "Parcel request created.");
        $trackingId = $tracking->create();
        if (!$trackingId) {
          throw new Exception("Tracking creation failed!");
        }

        // if all operation is ok then create 
        $db->commit();
        $_SESSION['success'] = "Parcel created successfully.";
        unset($_SESSION['old']);
        redirect("parcel");
        exit;
      } catch (Exception $e) {
        // if occured any error then rollback 
        $db->rollback();
        $_SESSION['errors'][] = $e->getMessage();
        redirect("parcel");
        exit;
      }
    }
  }

  function update()
  {
    if (isset($_POST['btn_submit'])) {
      global $db;
      // Logged in user
      $sender_user_id = $_SESSION['user']['id'];
      $id = intval($_POST['parcel_id']);
      // Parcel Information
      $parcel_type = trim($_POST['parceltype'] ?? '');
      $parcel_name = trim($_POST['parcelname'] ?? '');
      $parcel_weight = floatval($_POST['parcelweight'] ?? 0);

      $sender_name = trim($_POST['sendername'] ?? '');
      $sender_phone = trim($_POST['senderphone'] ?? '');
      $sender_email = trim($_POST['senderemail'] ?? '');
      $sender_address = trim($_POST['senderaddress'] ?? '');
      $sender_district = intval($_POST['senderdistrict'] ?? 0);

      $receiver_name = trim($_POST['receivername'] ?? '');
      $receiver_phone = trim($_POST['receiverphone'] ?? '');
      $receiver_email = trim($_POST['receiveremail'] ?? '');
      $receiver_address = trim($_POST['receiveraddress'] ?? '');
      $receiver_district = intval($_POST['receiverdistrict'] ?? 0);

      $parcel_note = trim($_POST['parcelnote'] ?? '');

      //store old value
      $_SESSION['old'] = $_POST;

      // Validation
      $errors = [];
      // Parcel
      if (empty($parcel_type)) {
        $errors[] = "Please select parcel type.";
      }
      if (empty($parcel_name)) {
        $errors[] = "Parcel name is required.";
      }
      if ($parcel_weight <= 0) {
        $errors[] = "Parcel weight must be greater than 0.";
      }

      // Sender
      if (empty($sender_name)) {
        $errors[] = "Sender name is required.";
      }
      if (!preg_match('/^(01)[3-9]\d{8}$/', $sender_phone)) {
        $errors[] = "Invalid sender phone number.";
      }
      if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid sender email.";
      }
      if (empty($sender_address)) {
        $errors[] = "Sender address is required.";
      }
      if ($sender_district <= 0) {
        $errors[] = "Please select sender district.";
      }

      // Receiver
      if (empty($receiver_name)) {
        $errors[] = "Receiver name is required.";
      }
      if (!preg_match('/^(01)[3-9]\d{8}$/', $receiver_phone)) {
        $errors[] = "Invalid receiver phone number.";
      }
      if (!filter_var($receiver_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid receiver email.";
      }
      if (empty($receiver_address)) {
        $errors[] = "Receiver address is required.";
      }
      if ($receiver_district <= 0) {
        $errors[] = "Please select receiver district.";
      }

      // But same phone is not allowed
      if (
        !empty($sender_phone) &&
        !empty($receiver_phone) && $sender_phone == $receiver_phone
      ) {
        $errors[] = "Sender and receiver phone number cannot be the same.";
      }

      // Stop if validation fails
      if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect("dashboard/editparcel?id=$id");
        exit;
      }

      $delivery_charge = 0;
      $insideCharge = 60;
      $outsideCharge = 80;
      $extraPerKg = 40;
      if ($parcel_weight <= 3) {
        if ($sender_district == $receiver_district) {
          $delivery_charge = $insideCharge;
        } else {
          $delivery_charge = $outsideCharge;
        }
      } else {
        $extraWeight = ceil($parcel_weight - 3);
        if ($sender_district == $receiver_district) {
          $delivery_charge = $insideCharge + ($extraWeight * $extraPerKg);
        } else {
          $delivery_charge = $outsideCharge + ($extraWeight * $extraPerKg);
        }
      };

      //update parcel
      $parcel = new Parcel();

      $parcel->set(
        $parcel->tracking_id ?? '',
        $parcel_type,
        $parcel_name,
        $parcel_weight,
        $sender_user_id,
        $sender_name,
        $sender_phone,
        $sender_email,
        $sender_address,
        $sender_district,
        $receiver_name,
        $receiver_phone,
        $receiver_email,
        $receiver_address,
        $receiver_district,
        $delivery_charge,
        $parcel_note
      );

      if ($parcel->update($id, $sender_user_id)) {
        $_SESSION['success'] = "Parcel updated successfully.";
        unset($_SESSION['old']);
      } else {
        $_SESSION['errors'][] = "Unable to update parcel.";
      }

      redirect("dashboard/editparcel?id=" . $id);
      exit;
    }
  }

  function delete()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 3) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    $sender_user_id = $_SESSION['user']['id'];
    if (Parcel::deleteParcelById($id, $sender_user_id)) {
      $_SESSION['success'] = "Parcel deleted successfully.";
    }
    redirect("dashboard/myparcels");
  }

  function pay()
  {
    global $db;
    if (!isset($_SESSION['user'])) {
      redirect("login");
      exit;
    }
    $parcel_id = intval($_GET['id']);
    $sender_user_id = $_SESSION['user']['id'];

    $parcel = Parcel::findParcelById($parcel_id);
    if (!$parcel || $parcel->sender_user_id != $sender_user_id) {
      $_SESSION['errors'][] = "Invalid parcel!";
      redirect("dashboard/myparcels");
      exit;
    }

    // transaction 
    $db->begin_transaction();
    try {
      // Payment Insert
      $payment = new Payment();
      $payment->set(
        $parcel->id,
        $parcel->delivery_charge,
        "cash",
        null,
        "paid",
        "BDT",
        date("Y-m-d H:i:s")
      );
      if (!$payment->create()) {
        throw new Exception("Payment insert failed!");
      }

      // Parcel Payment Status Update
      $success = Parcel::updatePaymentStatus($parcel->id, "paid");
      if (!$success) {
        throw new Exception("Parcel payment update failed!");
      }

      // Tracking Insert
      $tracking = new Tracking();
      $tracking->set(
        $parcel->id,
        "payment_paid",
        $parcel->sender_district_id,
        "Payment completed successfully."
      );
      if (!$tracking->create()) {
        throw new Exception("Tracking insert failed!");
      }

      $db->commit();
      $_SESSION['success'] = "Payment completed successfully.";
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
    }
    redirect("dashboard/myparcels");
  }
}
