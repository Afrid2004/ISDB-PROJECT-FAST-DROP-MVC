<?php

class Payment
{
  public $id;
  public $parcel_id;
  public $amount;
  public $currency;
  public $payment_method;
  public $transaction_id;
  public $payment_status;
  public $paid_at;

  public function __construct() {}

  public function set(
    $parcel_id,
    $amount,
    $payment_method,
    $transaction_id = null,
    $payment_status = "pending",
    $currency = "BDT",
    $paid_at = null
  ) {
    $this->parcel_id = $parcel_id;
    $this->amount = $amount;
    $this->currency = $currency;
    $this->payment_method = $payment_method;
    $this->transaction_id = $transaction_id;
    $this->payment_status = $payment_status;
    $this->paid_at = $paid_at;
  }

  // Create Payment
  public function create()
  {
    global $db;

    $sql = "INSERT INTO payments
        (parcel_id, amount, currency, payment_method, transaction_id, payment_status, paid_at)
        VALUES (?,?,?,?,?,?,?)";

    $stmt = $db->prepare($sql);

    $stmt->bind_param(
      "idsssss",
      $this->parcel_id,
      $this->amount,
      $this->currency,
      $this->payment_method,
      $this->transaction_id,
      $this->payment_status,
      $this->paid_at
    );

    if ($stmt->execute()) {
      return $db->insert_id;
    }

    return false;
  }

  // Update Payment
  public function update($id)
  {
    global $db;

    $sql = "UPDATE payments SET
                parcel_id=?,
                amount=?,
                currency=?,
                payment_method=?,
                transaction_id=?,
                payment_status=?,
                paid_at=?
                WHERE id=?";

    $stmt = $db->prepare($sql);

    $stmt->bind_param(
      "idsssssi",
      $this->parcel_id,
      $this->amount,
      $this->currency,
      $this->payment_method,
      $this->transaction_id,
      $this->payment_status,
      $this->paid_at,
      $id
    );

    return $stmt->execute();
  }

  // Payment Success
  public static function paymentSuccess($parcel_id, $transaction_id)
  {
    global $db;

    $sql = "UPDATE payments
            SET payment_status='paid',
                transaction_id=?,
                paid_at=NOW()
            WHERE parcel_id=?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $transaction_id, $parcel_id);

    return $stmt->execute();
  }

  // Payment Failed
  public static function paymentFailed($parcel_id)
  {
    global $db;

    $sql = "UPDATE payments
            SET payment_status='failed'
            WHERE parcel_id=?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $parcel_id);

    return $stmt->execute();
  }

  // Find Payment by ID
  public static function find($id)
  {
    global $db;

    $sql = "SELECT * FROM payments WHERE id=?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_object();
  }

  // Find Payment by Parcel ID
  public static function findByParcel($parcel_id)
  {
    global $db;

    $sql = "SELECT * FROM payments WHERE parcel_id=?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $parcel_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_object();
  }

  // All Payments
  public static function allPayments()
  {
    $pagination = new Pagination(10);
    $countSql = "SELECT COUNT(*) AS total FROM payments";
    $dataSql = "SELECT * FROM payments ORDER BY id DESC";
    return [
      "data" => $pagination->paginate(
        $countSql,
        $dataSql,
      ),
      "links" => $pagination->links(),
      "perPage" => $pagination->getPerPage(),
      "currentPage" => $pagination->getCurrentPage()
    ];
  }

  // Delete Payment
  public static function delete($id)
  {
    global $db;

    $sql = "DELETE FROM payments WHERE id=?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);

    return $stmt->execute();
  }
}
