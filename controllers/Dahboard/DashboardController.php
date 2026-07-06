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
  function allusers()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }
    $allUserdata = User::showUser();
    $page = 'allusers';
    view("dashboard", compact('role', 'page', 'allUserdata'));
  }

  // dynamically render all parcels page 
  function allparcels()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }
    $allParcelData = Parcel::allparcels();
    $page = "allparcels";
    view("dashboard", compact('role', 'page', 'allParcelData'));
  }


  // parceldetails page 
  function parceldetails()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    $parcelData = Parcel::findParcelById($id);
    $page = "parceldetails";
    view("dashboard", compact(
      'role',
      'page',
      'parcelData'
    ));
  }
}
