<?php

class ParcelApi
{
  function assignrider($params)
  {
    $parcel_id = $params['parcel_id'];
    $rider_id = $params['rider_id'];
    Parcel::assignRider($parcel_id, $rider_id);
    echo json_encode(['success' => true]);
  }
}
