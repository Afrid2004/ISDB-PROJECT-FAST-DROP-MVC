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
    $pagination = new Pagination(10);
    $countSql = "SELECT COUNT(*) AS total FROM users";
    $dataSql = "SELECT users.*, roles.role_name AS rolename
        FROM users
        JOIN roles ON users.role_id = roles.id";
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

  public static function pendingAdmin()
  {
    $pagination = new Pagination(10);
    $countSql = "SELECT COUNT(*) AS total FROM users WHERE role_id=?";
    $dataSql = "SELECT users.*, roles.role_name AS rolename
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE role_id=?";
    return [
      "data" => $pagination->paginate(
        $countSql,
        $dataSql,
        "i",
        [3]
      ),
      "links" => $pagination->links(),
      "perPage" => $pagination->getPerPage(),
      "currentPage" => $pagination->getCurrentPage()
    ];
  }

  // make admin 
  public static function makeAdmin($user_id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT * FROM users WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_object();

      if (!$user) {
        throw new Exception("User not found");
      }

      if ($user->role_id == 2) {
        throw new Exception("User is already an admin.");
      }

      if ($user->id == $_SESSION['user']['id']) {
        throw new Exception("You are already logged in as admin.");
      }

      $sql = "UPDATE users SET role_id=2 WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      if ($stmt->affected_rows < 0) {
        throw new Exception("Failed to make admin!");
      }

      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }

  //all admin
  public static function allAdmin()
  {
    $pagination = new Pagination(10);
    $countSql = "SELECT COUNT(*) AS total FROM users WHERE role_id=?";
    $dataSql = "SELECT users.*, roles.role_name AS rolename
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE role_id=?";
    return [
      "data" => $pagination->paginate(
        $countSql,
        $dataSql,
        "i",
        [2]
      ),
      "links" => $pagination->links(),
      "perPage" => $pagination->getPerPage(),
      "currentPage" => $pagination->getCurrentPage()
    ];
  }

  // make admin 
  public static function removeAdmin($user_id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT * FROM users WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_object();

      if (!$user) {
        throw new Exception("User not found");
      }

      if ($user->role_id == 1) {
        throw new Exception("Super Admin cannot be removed.");
      }

      if ($user->id == $_SESSION['user']['id']) {
        throw new Exception("You cannot remove yourself.");
      }

      $sql = "UPDATE users SET role_id=3 WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      if ($stmt->affected_rows == 0) {
        throw new Exception("Failed to remove admin!");
      }

      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }

  // block user
  public static function blockuser($user_id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT * FROM users WHERE id=? AND status='active'";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_object();

      if (!$user) {
        throw new Exception("User not found");
      }

      if ($user->role_id == 1 && $user->role_id == 2) {
        throw new Exception("Super Admin or Admin cannot be blocked.");
      }

      if ($user->id == $_SESSION['user']['id']) {
        throw new Exception("You cannot block yourself.");
      }

      $sql = "UPDATE users SET status='blocked' WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      if ($stmt->affected_rows == 0) {
        throw new Exception("Failed to block user!");
      }
      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }


  // activate user
  public static function activateuser($user_id)
  {
    global $db;
    $db->begin_transaction();
    try {
      $sql = "SELECT * FROM users WHERE id=? AND status='blocked'";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_object();

      if (!$user) {
        throw new Exception("User not found");
      }

      if ($user->role_id == 1 && $user->role_id == 2) {
        throw new Exception("Super Admin or Admin cannot be activate.");
      }

      if ($user->id == $_SESSION['user']['id']) {
        throw new Exception("You cannot activate yourself.");
      }

      $sql = "UPDATE users SET status='active' WHERE id=?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      if ($stmt->affected_rows == 0) {
        throw new Exception("Failed to activate user!");
      }
      $db->commit();
      return true;
    } catch (Exception $e) {
      $db->rollback();
      $_SESSION['errors'][] = $e->getMessage();
      return false;
    }
  }

  // find user by id 
  public static function findUser($id)
  {
    global $db;
    $sql = "SELECT users.*, roles.role_name AS rolename
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.id = $id LIMIT 1";
    $stmt = $db->query($sql);
    if ($stmt && $stmt->num_rows > 0) {
      return $stmt->fetch_object();
    }
    return null;
  }

  //find user role and id
  public static function userRole($id)
  {
    global $db;
    $sql = "SELECT users.*, roles.role_name AS rolename
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.id = $id";
    $stmt = $db->query($sql);
    if ($stmt) {
      return $stmt->fetch_object();
    }
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
