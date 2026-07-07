<?php


class Rider
{
  public $id;
  public $user_id;
  public $rider_name;
  public $rider_email;
  public $rider_phone;
  public $license_no;
  public $vehicle_type;
  public $vehicle_registration;
  public $district_id;
  public $created_at;

  public function __construct() {}

  public function set($user_id, $rider_name, $rider_email, $rider_phone, $license_no, $vehicle_type, $vehicle_registration, $district_id)
  {
    $this->user_id = $user_id;
    $this->rider_name = $rider_name;
    $this->rider_email = $rider_email;
    $this->rider_phone = $rider_phone;
    $this->license_no = $license_no;
    $this->vehicle_type = $vehicle_type;
    $this->vehicle_registration = $vehicle_registration;
    $this->district_id = $district_id;
  }


  //cerate rider application
  public function create()
  {
    global $db;
    $sql = "INSERT INTO riders (user_id, rider_name, rider_email, rider_phone, license_no, vehicle_type, vehicle_registration, district_id) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param(
      "issssssi",
      $this->user_id,
      $this->rider_name,
      $this->rider_email,
      $this->rider_phone,
      $this->license_no,
      $this->vehicle_type,
      $this->vehicle_registration,
      $this->district_id
    );
    $stmt->execute();
    return $db->insert_id;
  }

  //show all riders
  public static function allRiders()
  {
    global $db;
    $sql = "SELECT riders.*, districts.district_name 
    FROM riders JOIN districts
    ON riders.district_id=districts.id";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }

  // find rider by id 
  public static function findRiderByUserId($id)
  {
    global $db;
    $sql = "SELECT riders.*, districts.district_name 
    FROM riders JOIN districts
    ON riders.district_id=districts.id 
    WHERE riders.user_id=? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows ? $result->fetch_object() : null;
  }

  //show all approved riders
  public static function allApprovedRiders()
  {
    global $db;
    $sql = "SELECT riders.*,
    districts.district_name
    FROM riders
    JOIN districts
    ON riders.district_id=districts.id
    WHERE riders.status='approved'
    ORDER BY riders.created_at DESC";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }

  //show all pending riders
  public static function allPendingRiders()
  {
    global $db;
    $sql = "SELECT riders.*,
    districts.district_name
    FROM riders
    JOIN districts
    ON riders.district_id=districts.id
    WHERE riders.status='pending'
    ORDER BY riders.created_at DESC";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }
}
