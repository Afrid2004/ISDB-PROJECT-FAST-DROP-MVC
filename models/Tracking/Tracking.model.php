<?php

class Tracking
{
  public $id;
  public $parcel_id;
  public $tracking_status;
  public $location_id;
  public $details;

  public function __construct() {}

  public function set($parcel_id, $tracking_status, $location_id = null, $details = null)
  {
    $this->parcel_id = $parcel_id;
    $this->tracking_status = $tracking_status;
    $this->location_id = $location_id;
    $this->details = $details;
  }

  // create trackings 
  public function create()
  {
    global $db;
    $sql = "INSERT INTO trackings (parcel_id, tracking_status, location_id, details) VALUES (?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isis", $this->parcel_id, $this->tracking_status, $this->location_id, $this->details);
    if ($stmt->execute()) {
      return $db->insert_id;
    };
    return false;
  }


  // All Tracking History
  public static function history($parcel_id)
  {
    global $db;
    $sql = "SELECT
    trackings.*,
    districts.district_name
    FROM trackings
    LEFT JOIN districts
    ON trackings.location_id=districts.id
    WHERE parcel_id=?
    ORDER BY trackings.id ASC";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $parcel_id);
    $stmt->execute();
    return array_map(fn($item) => (object)$item, $stmt->get_result()->fetch_all(MYSQLI_ASSOC));
  }

  public static function statusText($status)
  {
    return [
      'pending'         => 'Parcel Created',
      'payment_paid'    => 'Payment Completed',
      'assigned'        => 'Assigned to Rider',
      'rider_accepted'  => 'Rider Accepted',
      'picked_up'       => 'Picked Up',
      'in_transit'      => 'In Transit',
      'delivered'       => 'Delivered Successfully',
      'rider_rejected'  => 'Rider Rejected',
    ][$status] ?? ucfirst(str_replace("_", " ", $status));
  }
}
