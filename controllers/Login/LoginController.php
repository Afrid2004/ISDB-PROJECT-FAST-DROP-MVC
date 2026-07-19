<?php

class LoginController
{
  function index()
  {
    view("");
    unset($_SESSION["old"]);
  }

  function authenticate()
  {
    if (!isset($_POST['btn_submit'])) {
      redirect("login");
      exit;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $_SESSION['old'] = [
      'email' => $email
    ];

    // validate email or password 
    if (empty($email) || empty($password)) {
      $_SESSION['error'] = "All fields are required!";
      redirect("login");
      exit;
    }

    //validate the email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['error'] = "Invalid email!";
      redirect("login");
      exit;
    }

    // find user email 
    $user = User::findUserByEmail($email);
    if (!$user) {
      $_SESSION["error"] = "Email not found.";
      redirect("login");
      exit;
    }

    // validate password 
    if (!password_verify($password, $user->password)) {
      $_SESSION["error"] = "Incorrect password.";
      redirect("login");
      exit;
    }

    if ($user && password_verify($password, $user->password)) {
      $_SESSION['user'] = [
        "id"       => $user->id,
        "role_id"  => $user->role_id,
        "photo_url" => $user->photo_url,
        "name"     => $user->name,
        "email"    => $user->email,
      ];

      // store last login info 
      $ip = $_SERVER['REMOTE_ADDR'];
      if ($ip === '::1') {
        $ip = '127.0.0.1';
      }
      $userAgernt = $_SERVER['HTTP_USER_AGENT'];
      $browser = getBrowser($userAgernt);
      $device = getDeviceName($userAgernt);
      $location = getLocation($ip);
      User::updateLoginInfo($user->id, $ip, $browser, $device, $location);

      //if user checked in remember me box then store user token in cookie
      if ($remember) {
        // generate random token 
        $token = bin2hex(random_bytes(24));
        // insert it into remember_token column in users table 
        User::updateRememberToken($user->id, $token);

        // set cookie for 7 days 
        setcookie('remember_token', $token, time() + (7 * 24 * 60 * 60), "/");
      }
      unset($_SESSION["old"]);
      redirect("");
      exit;
    }
  }
}



// http only cookie 
// setcookie(
//     "remember_token",
//     $token,
//     [
//         "expires" => time() + 30 * 24 * 60 * 60,
//         "path" => "/",
//         "httponly" => true,
//         "secure" => false // HTTPS হলে true
//     ]
// );