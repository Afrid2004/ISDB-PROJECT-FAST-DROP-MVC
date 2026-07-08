<?php


class RiderController
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
      $user_id = intval($_SESSION['user']['id']);
      $rider_name = trim($_POST['ridername']);
      $rider_email = trim($_POST['rideremail']);
      $rider_phone = trim($_POST['riderphone']);
      $license_no = trim($_POST['licenseno']);
      $vehicle_type = trim($_POST['vehicletype']);
      $vehicle_registration = trim($_POST['vehicleregistration']);
      $district_id = intval($_POST['riderdistrict']);
      $phonePattern = '/^(01)[3-9]\d{8}$/';

      // store old data from post
      $_SESSION['old'] = $_POST;

      // validate rider data 
      $errors = [];
      if (empty($user_id)) {
        $errors[] = "Invalid user account.";
      }
      if (empty($rider_name)) {
        $errors[] = "Rider name is required.";
      }
      if (strlen($rider_name) < 3) {
        $errors[] = "Rider name must be at least 3 characters long.";
      }
      if (!filter_var($rider_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
      }
      if ($rider_email != $_SESSION['user']['email']) {
        $errors[] = "The email address must match your account email.";
      }
      if (!preg_match($phonePattern, $rider_phone)) {
        $errors[] = "Please enter a valid Bangladeshi mobile number.";
      }
      if (empty($license_no)) {
        $errors[] = "License number is required.";
      }
      if (empty($vehicle_type)) {
        $errors[] = "Please select a vehicle type.";
      }
      if (empty($vehicle_registration)) {
        $errors[] = "Vehicle registration number is required.";
      }
      if (empty($district_id)) {
        $errors[] = "Please select your service district.";
      }

      // check if rider exist 
      $existRider = Rider::findRiderByUserId($user_id);
      if ($existRider) {
        $errors[] = "You have already submitted a rider application.";
      }

      if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        redirect("rider");
        exit;
      }

      // if all ok then send data to database 
      $rider = new Rider();
      $rider->set($user_id, $rider_name, $rider_email, $rider_phone, $license_no, $vehicle_type, $vehicle_registration, $district_id);
      $success = $rider->create();
      if ($success) {
        $_SESSION['success'] = "Your rider application has been submitted successfully. Our team will review it and contact you soon.";
        unset($_SESSION['old']);
      } else {
        $_SESSION['errors'] = [
          "Something went wrong. Please try again later."
        ];
      }
      redirect("rider");
      exit;
    }
  }
}