<?php

class Tracking
{
  public $id;
  public $parcel_id;
  public $tracking_status;
  public $location;
  public $details;

  public function __construct() {}

  public function set($parcel_id, $tracking_status, $location = null, $details = null)
  {
    $this->parcel_id = $parcel_id;
    $this->tracking_status = $tracking_status;
    $this->location = $location;
    $this->details = $details;
  }

  // create trackings 
  public function create()
  {
    global $db;
    $sql = "INSERT INTO trackings (parcel_id, tracking_status, location, details) VALUES (?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isss", $this->parcel_id, $this->tracking_status, $this->location, $this->details);
    if ($stmt->execute()) {
      return $db->insert_id;
    };
    return false;
  }

  // update create trackings 
  // public function update($id)
  // {
  //   global $db;
  //   $sql = "UPDATE trackings SET parcel_id=?, tracking_status=?, location=?, details=? WHERE id=?";
  //   $stmt = $db->prepare($sql);
  //   $stmt->bind_param("isssi", $this->parcel_id, $this->tracking_status, $this->location, $this->details, $id);
  //   return $stmt->execute();
  // }


  // All Tracking History
  public static function history($parcel_id)
  {
    global $db;
    $sql = "SELECT * FROM trackings WHERE parcel_id=? ORDER BY id ASC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $parcel_id);
    $stmt->execute();
    return array_map(fn($item) => (object)$item, $stmt->get_result()->fetch_all(MYSQLI_ASSOC));
  }
}
