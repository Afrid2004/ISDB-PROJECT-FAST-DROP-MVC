<?php

class User
{
  public $id;
  public $role_id;
  public $name;
  public $email;
  public $password;

  public function __construct() {}

  public function set($role_id, $name, $email, $password)
  {
    $this->role_id = $role_id;
    $this->name = $name;
    $this->email = $email;
    // hashing password giben by the user 
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  //create user
  public function save()
  {
    global $db;
    $sql = "INSERT INTO users (role_id, name, email, password) VALUES ('$this->role_id', '$this->name', '$this->email', '$this->password')";
    return $db->query($sql);
  }

  //read user
  public static function showUser()
  {
    global $db;
    $sql = "SELECT * FROM users";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return array_map(fn($item) => (object)$item, $stmt->fetch_all(MYSQLI_ASSOC));
    }
    return null;
  }

  // find user by id 
  public static function findUser($id)
  {
    global $db;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return $stmt->fetch_object();
    }
    return null;
  }

  //update user
  public function updateUser($id)
  {
    global $db;
    $sql = "UPDATE users SET role_id='$this->role_id', name='$this->name', email='$this->email', password='$this->password' WHERE id=$id";
    $stmt = $db->query($sql);
    if ($stmt) {
      return true;
    } else {
      return false;
    }
  }

  // delete user
  public static function deleteUser($id)
  {
    global $db;
    $sql = "DELETE FROM users WHERE id=$id";
    $stmt = $db->query($sql);
    if ($stmt) {
      return true;
    } else {
      return false;
    }
  }

  // Find User By Email (For Login)
  public static function findUserByEmail($email)
  {
    global $db;
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return $stmt->fetch_object();
    }
    return null;
  }

  //count user email
  public static function countUserEmail($email)
  {
    global $db;
    $sql = "SELECT COUNT(*) as total from users where email='$email'";
    $stmt = $db->query($sql);
    if ($stmt) {
      $row = $stmt->fetch_object();
      return $row->total;
    }
    return 0;
  }

  //update remember token when user login and check remember me
  public static function updateRememberToken($id, $token)
  {
    global $db;
    if ($token === NULL) {
      $db->query("
            UPDATE users
            SET remember_token=NULL
            WHERE id='$id'
        ");
    } else {
      $db->query("
            UPDATE users
            SET remember_token='$token'
            WHERE id='$id'
        ");
    }
  }

  //find remember token
  public static function findRememberToken($token)
  {
    global $db;
    $sql = "SELECT * FROM users WHERE remember_token='$token' LIMIT 1";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return $stmt->fetch_object();
    }
    return null;
  }
}
