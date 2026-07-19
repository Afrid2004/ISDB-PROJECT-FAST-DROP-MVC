<?php

class UserApi
{
  function index()
  {
    echo json_encode(["message" => "user api is running"]);
  }

  function makeadmin($params)
  {
    $user_id = intval($params['id'] ?? 0);

    if ($user_id <= 0) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => 'Invalid user'
      ]);
      return;
    }
    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
      http_response_code(403);
      echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
      ]);
      return;
    }
    $success = User::makeAdmin($user_id);
    if ($success) {
      echo json_encode([
        "success" => true,
        "message" => "User role updated successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to update role."
      ]);
    }
  }


  function removeadmin($params)
  {
    $user_id = intval($params['id'] ?? 0);

    if ($user_id <= 0) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => 'Invalid user'
      ]);
      return;
    }

    if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
      http_response_code(403);
      echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
      ]);
      return;
    }
    $success = User::removeAdmin($user_id);
    if ($success) {
      echo json_encode([
        "success" => true,
        "message" => "User role updated successfully."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to update role."
      ]);
    }
  }


  function blockuser($params){
    $user_id = intval($params['id'] ?? 0);
    if ($user_id <= 0) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => 'Invalid user'
      ]);
      return;
    }
    if (!isset($_SESSION['user']) || ($_SESSION['user']['role_id'] != 1 && $_SESSION['user']['role_id'] != 2)) {
      http_response_code(403);
      echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
      ]);
      return;
    }

    $success = User::blockuser($user_id);
    if ($success) {
      echo json_encode([
        "success" => true,
        "message" => "User has been blocked."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to block user."
      ]);
    }
  }

  function activateuser($params){
    $user_id = intval($params['id'] ?? 0);
    if ($user_id <= 0) {
      http_response_code(400);
      echo json_encode([
        'success' => false,
        'message' => 'Invalid user'
      ]);
      return;
    }
    if (!isset($_SESSION['user']) || ($_SESSION['user']['role_id'] != 1 && $_SESSION['user']['role_id'] != 2)) {
      http_response_code(403);
      echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
      ]);
      return;
    }

    $success = User::activateuser($user_id);
    if ($success) {
      echo json_encode([
        "success" => true,
        "message" => "User has been activated."
      ]);
    } else {
      echo json_encode([
        "success" => false,
        "message" => $_SESSION['errors'][0] ?? "Failed to activate user."
      ]);
    }
  }
}
