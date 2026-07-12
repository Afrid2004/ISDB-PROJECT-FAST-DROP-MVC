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

  function assingrider()
  {
    $riderid = intval($_GET['id']);
  }
}
