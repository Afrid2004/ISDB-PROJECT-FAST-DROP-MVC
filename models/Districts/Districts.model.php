<?php

class Districts
{
  // show all active districts
  public static function allDistricts()
  {
    global $db;
    $sql = "SELECT * FROM districts WHERE status='active'";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }
}