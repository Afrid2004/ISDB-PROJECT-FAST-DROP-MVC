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
        "name"     => $user->name,
        "email"    => $user->email,
      ];

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