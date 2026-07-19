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

  public static function statusIcon($status)
  {
    return match ($status) {
      'pending'         => 'fa-clock',
      'payment_paid'    => 'fa-money-bill-wave',
      'assigned'        => 'fa-user-check',
      'rider_accepted'  => 'fa-handshake',
      'picked_up'       => 'fa-box',
      'in_transit'      => 'fa-truck-fast',
      'delivered'       => 'fa-circle-check',
      'rider_rejected'  => 'fa-circle-xmark',
      default           => 'fa-box-open'
    };
  }

  public static function statusClass($status)
  {
    return match ($status) {

      'pending'         => 'bg-yellow-100 text-yellow-700',
      'payment_paid'    => 'bg-emerald-100 text-emerald-700',
      'assigned'        => 'bg-blue-100 text-blue-700',
      'rider_accepted'  => 'bg-indigo-100 text-indigo-700',
      'picked_up'       => 'bg-cyan-100 text-cyan-700',
      'in_transit'      => 'bg-purple-100 text-purple-700',
      'delivered'       => 'bg-green-100 text-green-700',
      'rider_rejected'  => 'bg-red-100 text-red-700',
      'cancelled'       => 'bg-red-100 text-red-700',
      default           => 'bg-gray-100 text-gray-700',
    };
  }
}