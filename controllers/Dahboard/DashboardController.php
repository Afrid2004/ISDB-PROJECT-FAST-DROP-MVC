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
    $page = 'index';
    $role = $_SESSION['user']['role_id'];
    view("dashboard", compact('role', 'page'));
  }

  // dynamicly render role based pages
  function allusers(){
     $role = $_SESSION['user']['role_id'];
     if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
      redirect("");
      exit;
    }
    $allUserdata = User::showUser();
    $page = 'allusers';
    view("dashboard", compact('role', 'page', 'allUserdata'));
  }
}
