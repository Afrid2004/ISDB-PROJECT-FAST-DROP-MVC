<?php


class RiderApi
{
  function available()
  {
    $district = intval($_GET['district'] ?? 0);
    if ($district <= 0) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => 'Invalid district'
      ]);
      return;
    }
    $data = Rider::availableByDistrict($district);
    if (!empty($data)) {
      echo json_encode([
        'success' => true,
        'data' => $data
      ]);
    } else {
      echo json_encode([
        'success' => false,
        'message' => 'No rider available'
      ]);
    }
  }

  function cashout($params)
  {
    if (!isset($_SESSION['user'])) {
      echo json_encode([
        "success" => false,
        "message" => "Please login first."
      ]);
      return;
    }
    $parcel_id = $params['parcel_id'];
    $method = $params['method'];
    $user_id = $_SESSION['user']['id'];
    $rider = Rider::findRiderByUserId($user_id);
    if (!$rider) {
      echo json_encode([
        "success" => false,
        "message" => "Rider account could not be found."
      ]);
      return;
    }
    // Verify parcel belongs to this rider
    $parcel = Parcel::findParcelById($parcel_id);
    if (!$parcel || $parcel->assigned_rider_id != $rider->id) {
      echo json_encode([
        "success" => false,
        "message" => "You are not authorized to perform this cashout."
      ]);
      return;
    }
    $success = Cashout::cashoutSuccess($parcel_id, $method);
    if ($success) {
      echo json_encode([
        "success" => true,
        "message" => "Cashout has been completed successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to update parcel status."
      ]);
    }
  }
}
