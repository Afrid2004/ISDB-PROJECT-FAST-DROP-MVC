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

  function submit(){
    if(isset($_POST['btn_submit'])){
      // Logged in user
      $sender_user_id = $_SESSION['user']['id'];
      // Parcel Information
      $parcel_type   = trim($_POST['parceltype']);
      $parcel_name   = trim($_POST['parcelname']);
      $parcel_weight = intval($_POST['parcelweight']);
      // Sender Information
      $sender_name      = trim($_POST['sendername']);
      $sender_phone     = trim($_POST['senderphone']);
      $sender_email     = trim($_POST['senderemail']);
      $sender_address   = trim($_POST['senderaddress']);
      $sender_district  = trim($_POST['senderdistrict']);
      // Receiver Information
      $receiver_name      = trim($_POST['receivername']);
      $receiver_phone     = trim($_POST['receiverphone']);
      $receiver_email     = trim($_POST['receiveremail']);
      $receiver_address   = trim($_POST['receiveraddress']);
      $receiver_district  = trim($_POST['receiverdistrict']);
      // Optional fields
      $parcel_note = $_POST['parcelnote'] ?? "";
      // These will be calculated automatically
      $tracking_id     = "";
      $delivery_charge = 0;
      if($parcel_weight<=3){
        if($sender_district == $receiver_district){
          $delivery_charge = 60;
        }else{
          $delivery_charge = 80;
        }
      } else if($parcel_weight > 3){
        if($sender_district == $receiver_district){
          $delivery_charge = 60 + 60*0.4;
        }else{
          $delivery_charge = 80 + 80*0.4;
        }
      };
    }
  }
}
