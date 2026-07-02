<?php

class LogoutController
{
  function index()
  {
    session_start();
    if (isset($_SESSION['user'])) {
      //if user exist while log in remove the token data from db
      User::updateRememberToken($_SESSION['user']['id'], NULL);
    }
    // alse remove the token 
    setcookie("remember_token", "", time() - 3600, "/");
    session_unset();
    session_destroy();
    redirect("");
    exit;
  }
}
