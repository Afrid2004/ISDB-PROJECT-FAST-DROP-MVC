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
  public static function allApprovedSuspendedRiders()
  {
    global $db;
    $sql = "SELECT riders.*,
    districts.district_name
    FROM riders
    JOIN districts
    ON riders.district_id=districts.id
    WHERE (riders.status='approved' OR riders.status='suspended')
    ORDER BY riders.created_at DESC";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }

  //show all pending riders
  public static function allPendingDeclineRiders()
  {
    global $db;
    $sql = "SELECT riders.*,
    districts.district_name
    FROM riders
    JOIN districts
    ON riders.district_id=districts.id
    WHERE (riders.status='pending' OR riders.status='declined')
    ORDER BY riders.created_at DESC";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }

  // add rider by id 
  public static function approveRiderById($id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT * FROM riders WHERE id=? AND (status='pending' OR status='declined') LIMIT 1";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $rider = $stmt->get_result()->fetch_object();

      if (!$rider) {
        throw new Exception("Rider not found!");
      }

      // rider table upadate 
      $ridersql = "UPDATE riders SET status='approved', work_status='available' WHERE id=?";
      $stmt = $db->prepare($ridersql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      if ($stmt->affected_rows == 0) {
        throw new Exception("Failed to update rider status.");
      }

      //user table update
      $role_id = 4;
      $usersql = "UPDATE users SET role_id=? WHERE id=?";
      $stmt = $db->prepare($usersql);
      $stmt->bind_param("ii", $role_id, $rider->user_id);
      $stmt->execute();
      if ($stmt->errno) {
        throw new Exception("Failed to update user role.");
      }

      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }

  public static function declineRiderById($id)
  {
    global $db;
    $sql = "UPDATE riders SET status='declined' WHERE id=? AND status!='declined'";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
      return true;
    }
    $_SESSION['errors'][] = "Rider application not found.";
    return false;
  }

  public static function suspendRiderById($id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT user_id FROM riders WHERE id=? LIMIT 1";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $rider = $stmt->get_result()->fetch_object();
      if (!$rider) {
        throw new Exception("Rider not found.");
      }
      // Update rider status
      $sql = "UPDATE riders 
                SET status='suspended', work_status='unavailable' 
                WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();

      // Change role back to user
      $userRole = 3;
      $sql = "UPDATE users 
                SET role_id=? 
                WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("ii", $userRole, $rider->user_id);
      $stmt->execute();
      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }

  public static function unsuspendRiderById($id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT user_id FROM riders WHERE id=? LIMIT 1";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $rider = $stmt->get_result()->fetch_object();
      if (!$rider) {
        throw new Exception("Rider not found.");
      }
      // Update rider status
      $sql = "UPDATE riders 
                SET status='approved', work_status='available' 
                WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $id);
      $stmt->execute();

      // Change role to rider
      $riderRole = 4;
      $sql = "UPDATE users 
                SET role_id=? 
                WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("ii", $riderRole, $rider->user_id);
      $stmt->execute();
      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }
}
