<?php

class Cashout
{
  public $id;
  public $parcel_id;
  public $rider_id;
  public $original_delivery_charge;
  public $rider_commission;
  public $payment_method;
  public $transaction_id;
  public $cashout_status;

  public function __construct() {}

  public function set(
    $parcel_id,
    $rider_id,
    $original_delivery_charge,
    $rider_commission,
    $payment_method = "cash",
    $transaction_id = null,
    $cashout_status = "pending"
  ) {
    $this->parcel_id = $parcel_id;
    $this->rider_id = $rider_id;
    $this->original_delivery_charge = $original_delivery_charge;
    $this->rider_commission = $rider_commission;
    $this->payment_method = $payment_method;
    $this->transaction_id = $transaction_id;
    $this->cashout_status = $cashout_status;
  }

  // Insert Cashout
  public function create()
  {
    global $db;

    $sql = "INSERT INTO cashouts
        (
            parcel_id,
            rider_id,
            original_delivery_charge,
            rider_commission,
            payment_method,
            transaction_id,
            cashout_status
        )
        VALUES (?,?,?,?,?,?,?)";

    $stmt = $db->prepare($sql);

    $stmt->bind_param(
      "iiddsss",
      $this->parcel_id,
      $this->rider_id,
      $this->original_delivery_charge,
      $this->rider_commission,
      $this->payment_method,
      $this->transaction_id,
      $this->cashout_status
    );

    return $stmt->execute();
  }

  // All Pending Cashouts By Rider
  public static function pendingByRider($riderId)
  {
    global $db;

    $sql = "SELECT *
                FROM cashouts
                WHERE rider_id=?
                AND cashout_status='pending'
                ORDER BY created_at DESC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $riderId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return array_map(
        fn($item) => (object)$item,
        $result->fetch_all(MYSQLI_ASSOC)
      );
    }

    return [];
  }

  // All Paid Cashouts
  public static function paidByRider($riderId)
  {
    global $db;

    $sql = "SELECT *
                FROM cashouts
                WHERE rider_id=?
                AND cashout_status='paid'
                ORDER BY paid_at DESC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $riderId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return array_map(
        fn($item) => (object)$item,
        $result->fetch_all(MYSQLI_ASSOC)
      );
    }

    return [];
  }

  // check if already cashouted or not 
  public static function findByParcelId($parcelId)
  {
    global $db;
    $sql = "SELECT *
            FROM cashouts
            WHERE parcel_id=?
            LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $parcelId);
    $stmt->execute();
    return $stmt->get_result()->fetch_object();
  }

  // Total Pending Commission
  public static function totalPendingAmount($riderId)
  {
    global $db;

    $sql = "SELECT SUM(rider_commission) AS total
                FROM cashouts
                WHERE rider_id=?
                AND cashout_status='pending'";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $riderId);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_object();

    return $result->total ?? 0;
  }

  // Cashout Success
  public static function cashoutSuccess($parcelId, $paymentMethod = "cash")
  {
    global $db;

    $sql = "UPDATE cashouts
                SET
                    cashout_status='paid',
                    payment_method=?,
                    paid_at=NOW()
                WHERE parcel_id=?
                AND cashout_status='pending'";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $paymentMethod, $parcelId);

    return $stmt->execute();
  }
}
