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

    // upadate parcel
    public function update($id, $user_id)
    {
        global $db;
        $sql = "UPDATE parcels SET
        parcel_name=?,
        parcel_type=?,
        weight=?,
        sender_name=?,
        sender_phone=?,
        sender_email=?,
        sender_address=?,
        sender_district_id=?,
        receiver_name=?,
        receiver_phone=?,
        receiver_email=?,
        receiver_address=?,
        receiver_district_id=?,
        delivery_charge=?,
        note=?
        WHERE id=? AND sender_user_id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param(
            "ssdssssissssidsii",
            $this->parcel_name,
            $this->parcel_type,
            $this->parcel_weight,
            $this->sender_name,
            $this->sender_phone,
            $this->sender_email,
            $this->sender_address,
            $this->sender_district,
            $this->receiver_name,
            $this->receiver_phone,
            $this->receiver_email,
            $this->receiver_address,
            $this->receiver_district,
            $this->delivery_charge,
            $this->parcel_note,
            $id,
            $user_id
        );
        return $stmt->execute();
    }

    //delete parcel
    public static function deleteParcelById($id, $sender_user_id)
    {
        global $db;
        $db->begin_transaction();
        try {
            $sql = "SELECT * FROM parcels
                WHERE id=?
                AND sender_user_id=?
                AND payment_status='pending'
                AND parcel_status='pending'
                LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $id, $sender_user_id);
            $stmt->execute();
            $parcel = $stmt->get_result()->fetch_object();
            if (!$parcel) {
                throw new Exception("Parcel cannot be deleted.");
            }
            // Delete tracking
            $stmt = $db->prepare("DELETE FROM trackings WHERE parcel_id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // payments table
            $stmt = $db->prepare("DELETE FROM payments WHERE parcel_id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            // Delete parcel
            $stmt = $db->prepare("DELETE FROM parcels WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to delete parcel.");
            }
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollback();
            $_SESSION['errors'][] = $e->getMessage();
            return false;
        }
    }

    public static function makePayment($id, $sender_user_id)
    {
        global $db;
        $db->begin_transaction();
        try {
            $sql = "UPDATE parcels SET payment_status='paid', parcel_status='pending_pickup' WHERE id=? AND sender_user_id=? AND payment_status='pending'";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $id, $sender_user_id);
            $stmt->execute();
            if ($stmt->affected_rows == 0) {
                throw new Exception("Payment failed!");
            };

            // create tracking 
            $tracking = new Tracking();
            $tracking->set($id, "pending", NULL, "Parcel request created.");
            $trackingId = $tracking->create();
            if (!$trackingId) {
                throw new Exception("Tracking creation failed!");
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollback();
            $_SESSION['errors'][] = $e->getMessage();
            return false;
        }
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
        riders.rider_name AS rider_name,
        riders.rider_email AS rider_email,
        riders.rider_phone AS rider_phone,
        riders.vehicle_type AS vehicle_type,
        sender.district_name AS sender_district_name,
        receiver.district_name AS receiver_district_name
        FROM parcels 
        LEFT JOIN riders 
            ON parcels.assigned_rider_id=riders.id
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
        $sql = "SELECT parcels.*, 
        sender.district_name AS sender_district_name,
        receiver.district_name AS receiver_district_name
        FROM parcels 
        JOIN districts AS sender 
            ON parcels.sender_district_id=sender.id
        JOIN districts AS receiver
            ON parcels.receiver_district_id=receiver.id
        WHERE parcels.sender_user_id=? ORDER BY parcels.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return array_map(fn($item) => (object)$item, $stmt->get_result()->fetch_all(MYSQLI_ASSOC));
    }


    // pending parcel that payment status is paid
    public static function allPendingParcels()
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
        WHERE parcels.payment_status='paid' AND parcels.parcel_status='pending_pickup' 
        ORDER BY parcels.id DESC";
        $stmt = $db->query($sql);
        if ($stmt && $stmt->num_rows > 0) {
            return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
        }
        return null;
    }

    // assign parcel 
    public static function assignRider($parcelId, $riderId)
    {
        global $db;
        $sql = "UPDATE parcels
        SET assigned_rider_id=?,
        parcel_status='assigned'
        WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $riderId, $parcelId);
        return $stmt->execute();
    }

    // accept parcel
    public static function acceptParcel($parcelId, $riderId)
    {
        global $db;
        $db->begin_transaction();
        try {

            // find parcel 
            $sql = "SELECT * FROM parcels 
            WHERE id=?
            AND parcel_status='assigned'
            AND assigned_rider_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $parcelId, $riderId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_object();
            if (!$result) {
                throw new Exception("Parcel not found!");
            }

            //update parcel status
            $sql = "UPDATE parcels set parcel_status='rider_accepted'
        WHERE id=? AND assigned_rider_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $parcelId, $riderId);
            $stmt->execute();

            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to update parcel status!");
            }

            //update rider status
            $sql = "UPDATE riders set work_status='busy'
        WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $riderId);
            $stmt->execute();
            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to update rider status!");
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollback();
            $_SESSION['errors'][] = $e->getMessage();
            return false;
        }
    }

    // reject parcel
    public static function rejectParcel($parcelId, $riderId)
    {
        global $db;
        $db->begin_transaction();
        try {
            // find parcel 
            $sql = "SELECT * FROM parcels 
            WHERE id=?
            AND parcel_status='assigned'
            AND assigned_rider_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $parcelId, $riderId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_object();
            if (!$result) {
                throw new Exception("Parcel not found!");
            }

            //update parcel status
            $sql = "UPDATE parcels set parcel_status='rider_rejected', assigned_rider_id=NULL
        WHERE id=? AND assigned_rider_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $parcelId, $riderId);
            $stmt->execute();
            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to update parcel status!");
            }

            //update rider status
            $sql = "UPDATE riders set work_status='available'
        WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $riderId);
            $stmt->execute();
            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to update rider status!");
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollback();
            $_SESSION['errors'][] = $e->getMessage();
            return false;
        }
    }

    // parcel that which have assigned rider
    public static function allAssignedParcels($id)
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
        WHERE parcels.payment_status='paid' 
        AND parcels.parcel_status='assigned'
        AND parcels.assigned_rider_id=?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return array_map(fn($item) => (object)$item, $result->fetch_all(MYSQLI_ASSOC));
        }
        return [];
    }

    // update parcel status
    public static function updateParcelStatus($parcel_id, $parcel_status, $rider_id)
    {
        global $db;
        $db->begin_transaction();
        try {
            $sql = "SELECT * FROM parcels WHERE id=? AND assigned_rider_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $parcel_id, $rider_id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_object();

            if (!$result) {
                throw new Exception("Parcel not found or not assigned to this rider.");
            }

            // update status 
            $allowedStatus = [
                "rider_accepted" => "picked_up",
                "picked_up"      => "in_transit",
                "in_transit"     => "delivered",
            ];

            if (
                !isset($allowedStatus[$parcel->parcel_status]) ||
                $allowedStatus[$parcel->parcel_status] !== $parcel_status
            ) {
                throw new Exception("Invalid parcel status transition.");
            }

            $sql = "UPDATE parcels SET 
            parcel_status=?
            WHERE id=? AND assigned_rider_id=?
            ";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sii", $parcel_status, $parcel_id, $rider_id);
            $stmt->execute();
            if ($stmt->affected_rows <= 0) {
                throw new Exception("Failed to update parcel status.");
            }


            // rider status switch to available 
            if ($parcel_status === "delivered") {
                $sql = "UPDATE riders
                    SET work_status='available'
                    WHERE id=?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("i", $rider_id);
                $stmt->execute();
                if ($stmt->affected_rows <= 0) {
                    throw new Exception("Failed to update rider status.");
                }
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollback();
            $_SESSION['errors'][] = $e->getMessage();
            return false;
        }
    }


    // parcel that are delivered
    public static function allDeliveredParcels()
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
        WHERE parcels.payment_status='paid' AND parcels.parcel_status='delivered' 
        ORDER BY parcels.id DESC";
        $stmt = $db->query($sql);
        if ($stmt && $stmt->num_rows > 0) {
            return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
        }
        return null;
    }

    // parcel that are delivered
    public static function allCancelledParcels()
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
        WHERE parcels.payment_status='paid' AND parcels.parcel_status='cancelled' 
        ORDER BY parcels.id DESC";
        $stmt = $db->query($sql);
        if ($stmt && $stmt->num_rows > 0) {
            return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
        }
        return null;
    }
}
