<?php

class Parcel
{
    public $id;
    public $tracking_id;
    public $parcel_type;
    public $parcel_name;
    public $parcel_weight;

    public $sender_user_id;
    public $sender_name;
    public $sender_phone;
    public $sender_email;
    public $sender_address;
    public $sender_district;

    public $receiver_name;
    public $receiver_phone;
    public $receiver_email;
    public $receiver_address;
    public $receiver_district;

    public $parcel_note;
    public $parcel_status;
    public $payment_status;
    public $assigned_rider_id;
    public $delivery_charge;
    public $created_at;


    public function __construct() {}

    public function set($tracking_id, $parcel_type, $parcel_name, $parcel_weight, $sender_user_id, $sender_name, $sender_phone, $sender_email, $sender_address, $sender_district, $receiver_name, $receiver_phone, $receiver_email, $receiver_address, $receiver_district, $delivery_charge, $parcel_note)
    {
        $this->tracking_id = $tracking_id;
        $this->parcel_name = $parcel_name;
        $this->parcel_type = $parcel_type;
        $this->parcel_weight = $parcel_weight;
        $this->sender_user_id = $sender_user_id;
        $this->sender_name = $sender_name;
        $this->sender_phone = $sender_phone;
        $this->sender_email = $sender_email;
        $this->sender_address = $sender_address;
        $this->sender_district = $sender_district;
        $this->receiver_name = $receiver_name;
        $this->receiver_phone = $receiver_phone;
        $this->receiver_email = $receiver_email;
        $this->receiver_address = $receiver_address;
        $this->receiver_district = $receiver_district;
        $this->delivery_charge = $delivery_charge;
        $this->parcel_note = $parcel_note;
    }

    public function create()
    {
        global $db;
        $sql = "INSERT INTO parcels 
        (tracking_id, parcel_name, parcel_type, weight, sender_user_id, sender_name, sender_phone, sender_email, sender_address, sender_district_id, receiver_name, receiver_phone, receiver_email, receiver_address, receiver_district_id, delivery_charge, note) VALUES 
        (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssdissssissssids", $this->tracking_id, $this->parcel_name, $this->parcel_type, $this->parcel_weight, $this->sender_user_id, $this->sender_name, $this->sender_phone, $this->sender_email, $this->sender_address, $this->sender_district, $this->receiver_name, $this->receiver_phone, $this->receiver_email, $this->receiver_address, $this->receiver_district, $this->delivery_charge, $this->parcel_note);
        if ($stmt->execute()) {
            return $db->insert_id;
        }
        return false;
    }

    // generate tracking id and return it
    public static function generateTrackingId()
    {
        do {
            $trackings = "FD-" . date("ymd") . rand(100000, 999999);
            $existTrackingId = self::findByTrackingID($trackings);
        } while ($existTrackingId);

        return $trackings;
    }

    // find tracking id 
    public static function findByTrackingID($tracking)
    {
        global $db;
        // prepare statement secure 
        $sql = "SELECT * FROM parcels WHERE tracking_id=? LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $tracking);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // show all parcels 
    public static function allparcels()
    {
        global $db;
        $sql = "SELECT parcels.*, 
        sender.district_name AS sender_district_name,
        receiver.district_name AS receiver_district_name
        FROM parcels 
        JOIN districts AS sender 
            ON parcels.sender_district_id=sender.id
        JOIN districts AS receiver
            ON parcels.receiver_district_id=receiver.id
        ORDER BY parcels.id DESC";
        $stmt = $db->query($sql);
        if ($stmt && $stmt->num_rows > 0) {
            return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
        }
        return null;
    }

    // find parcel by id
    public static function findParcelById($id)
    {
        global $db;
        $sql = "SELECT parcels.*, 
        sender.district_name AS sender_district_name,
        receiver.district_name AS receiver_district_name
        FROM parcels 
        JOIN districts AS sender 
            ON parcels.sender_district_id=sender.id
        JOIN districts AS receiver
            ON parcels.receiver_district_id=receiver.id
        WHERE parcels.id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    // find parcel by user id 
    public static function findParcelByUserId($id)
    {
        global $db;
        $sql = "SELECT * FROM parcels WHERE sender_user_id=? ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return array_map(fn($item) => (object)$item, $stmt->get_result()->fetch_all(MYSQLI_ASSOC));
    }
}
