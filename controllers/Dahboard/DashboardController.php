<?php

class DashboardController
{
  // root index folder 
  function index()
  {
    if (!isset($_SESSION['user'])) {
      redirect("login");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    view("", compact('role'));
  }
}
