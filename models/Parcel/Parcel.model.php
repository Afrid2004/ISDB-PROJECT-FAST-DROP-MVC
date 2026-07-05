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
    public $delivery_charge;
    public $created_at;


    public function __construct()
    {
    }

    public function set($tracking_id, $parcel_type, $parcel_name, $parcel_weight, $sender_user_id, $sender_name, $sender_phone, $sender_email, $sender_address, $sender_district, $receiver_name, $receiver_phone, $receiver_email, $receiver_address, $receiver_district, $delivery_charge, $parcel_note){
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
        $this->payment_status = 'pending';
        $this->parcel_status = 'pending';
        $this->parcel_note = $parcel_note;
    }

    public function create(){
        global $db;
        $sql = "INSERT INTO parcels 
        (tracking_id, parcel_name, parcel_type, weight, sender_user_id, sender_name, sender_phone, sender_email, sender_address, sender_district_id, receiver_name, receiver_phone, receiver_email, receiver_address, receiver_district_id, delivery_charge, payment_status, parcel_status, note) VALUES 
        ('$this->tracking_id', '$this->parcel_name', '$this->parcel_type', '$this->parcel_weight', '$this->sender_user_id', '$this->sender_name', '$this->sender_phone', '$this->sender_email', '$this->sender_address', '$this->sender_district', '$this->receiver_name', '$this->receiver_phone', '$this->receiver_email', '$this->receiver_address', '$this->receiver_district', '$this->delivery_charge', '$this->payment_status', '$this->parcel_status', '$this->parcel_note')";
        $stmt = $db->query($sql);
        if(!$stmt){
            echo "Failed to submit parcel!";
        }
    }

    //generate tracking id 
    public static function generateTrackingId(){
        global $db;
        do{
            $trackingId = "FD-".date("ymd").rand(100000, 99999);
        }
    }


}
