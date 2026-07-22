<?php

class Dashboard
{
  public static function getStats()
  {
    global $db;
    $sql = "SELECT
    (SELECT COUNT(*) FROM users WHERE role_id = 3) AS total_users,
    (SELECT COUNT(*) FROM users WHERE role_id = 2) AS total_admins,
    (SELECT COUNT(*) FROM users WHERE role_id = 4) AS total_riders,
    (SELECT COUNT(*) FROM parcels) AS total_parcels,
    (SELECT COUNT(*) FROM parcels
        WHERE parcel_status='delivered') AS delivered_parcels,
    (SELECT COUNT(*) FROM parcels
        WHERE parcel_status!='delivered') AS pending_parcels,
    (SELECT IFNULL(SUM(amount),0)
        FROM payments
        WHERE payment_status='paid') AS total_revenue,
    (SELECT IFNULL(SUM(delivery_charge),0)
        FROM parcels
        WHERE payment_status='pending') AS total_cod";
    $result = $db->query($sql);
    return $result->fetch_object();
  }


  public static function getRecentActivities($limit = 10)
  {
    global $db;

    $sql = "(SELECT
                id,
                CONCAT(name, ' created a new account.') AS description,
                'New user registered' AS title,
                'user' AS type,
                created_at
            FROM users
        )
        UNION ALL
        (
            SELECT
                id,
                CONCAT('Parcel #', tracking_id, ' has been submitted.') AS description,
                'New parcel created' AS title,
                'parcel' AS type,
                created_at
            FROM parcels
        )
        UNION ALL
        (
            SELECT
                id,
                CONCAT(name, ' is now an active rider.') AS description,
                'Rider approved' AS title,
                'rider' AS type,
                updated_at AS created_at
            FROM users
            WHERE role_id = 4
        )
        UNION ALL
        (
            SELECT
                id,
                CONCAT('৳ ', amount, ' payment received.') AS description,
                'Payment Received' AS title,
                'payment' AS type,
                created_at
            FROM payments
            WHERE payment_status='paid'
        )
        ORDER BY created_at DESC
        LIMIT ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
  }


  public static function getPendingTasks()
  {
    global $db;

    $sql = "SELECT
        (
            SELECT COUNT(*)
            FROM riders
            WHERE status = 'pending'
        ) AS pending_riders,

        (
            SELECT COUNT(*)
            FROM parcels
            WHERE parcel_status = 'pending'
        ) AS pending_parcels,

        (
            SELECT COUNT(*)
            FROM payments
            WHERE payment_status = 'pending'
        ) AS pending_payments";

    $result = $db->query($sql);

    return $result->fetch_object();
  }
}
