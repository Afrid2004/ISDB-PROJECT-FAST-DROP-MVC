<?php

class ParcelApi
{
  function assignrider($params)
  {
    $parcel_id = $params['parcel_id'];
    $rider_id = $params['rider_id'];
    $result = Parcel::assignRider($parcel_id, $rider_id);
    if ($result) {
      echo json_encode([
        "success" => true,
        "message" => "Rider assigned successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to assign rider."
      ]);
    }
  }

  function acceptparcel($params)
  {
    $parcel_id = $params['parcel_id'];
    $rider_id = $params['rider_id'];
    $result = Parcel::acceptParcel($parcel_id, $rider_id);
    if ($result) {
      echo json_encode([
        "success" => true,
        "message" => "Parcel accepted successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to accept parcel."
      ]);
    }
  }

  function rejectparcel($params)
  {
    $parcel_id = $params['parcel_id'];
    $rider_id = $params['rider_id'];
    $result = Parcel::rejectParcel($parcel_id, $rider_id);
    if ($result) {
      echo json_encode([
        "success" => true,
        "message" => "Parcel rejected successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to reject parcel."
      ]);
    }
  }

  function updatestatus($params)
  {
    if (!isset($_SESSION['user'])) {
      echo json_encode([
        "success" => false,
        "message" => "Please login first."
      ]);
      return;
    }
    $parcel_id = $params['parcel_id'];
    $parcel_status = $params['parcel_status'];
    $user_id = $_SESSION['user']['id'];
    $rider = Rider::findRiderByUserId($user_id);
    if (!$rider) {
      echo json_encode([
        "success" => false,
        "message" => "Rider not found."
      ]);
      return;
    }
    $result = Parcel::updateParcelStatus(
      $parcel_id,
      $parcel_status,
      $rider->id
    );
    if ($result) {
      echo json_encode([
        "success" => true,
        "message" => "Parcel status updated successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to update parcel status."
      ]);
    }
  }
}
