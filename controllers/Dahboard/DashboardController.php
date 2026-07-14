<?php

class DashboardController
{
  /*====================super admin dashboard================ */
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
    if (!isset($_SESSION['user']) || ($role != 1 && $role != 3 && $role != 4)) {
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



  //pending parcels page 
  function pendingparcels()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }

    $page = "pendingparcels";
    $pendingParcelsData = Parcel::allPendingParcels();
    view("dashboard", compact('role', 'page', 'pendingParcelsData'));
  }

  //delivered parcels page 
  function deliveredparcels()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }

    $page = "deliveredparcels";
    $deliveredParcelsData = Parcel::allDeliveredParcels();
    view("dashboard", compact('role', 'page', 'deliveredParcelsData'));
  }

  //cancelled parcels page 
  function cancelledparcels()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }

    $page = "cancelledparcels";
    $cancelledParcelsData = Parcel::allCancelledParcels();
    view("dashboard", compact('role', 'page', 'cancelledParcelsData'));
  }

  // addrider page 
  function addrider()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }

    $page = "addrider";
    $addRiderData = Rider::allPendingDeclineRiders();
    view("dashboard", compact('role', 'page', 'addRiderData'));
  }

  // allrider page 
  function allriders()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }

    $page = "allriders";
    $allRiderData = Rider::allApprovedSuspendedRiders();
    view("dashboard", compact('role', 'page', 'allRiderData'));
  }

  // approver rider 
  function approverider()
  {
    $role = $_SESSION['user']['role_id'];
    if ($role != 1) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    if (Rider::approveRiderById($id)) {
      $_SESSION['success'] = "Rider approved successfully.";
    }
    redirect("dashboard/addrider");
  }

  // decline rider
  function declinerider()
  {
    $role = $_SESSION['user']['role_id'];
    if ($role != 1) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    if (Rider::declineRiderById($id)) {
      $_SESSION['success'] = "Rider application has been declined.";
    }
    redirect("dashboard/addrider");
  }

  // suspend rider 
  function suspendrider()
  {
    if ($_SESSION['user']['role_id'] != 1) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    if (Rider::suspendRiderById($id)) {
      $_SESSION['success'] = "Rider has been suspended successfully.";
    }
    redirect("dashboard/allriders");
  }

  //unsuspend rider 
  function unsuspendrider()
  {
    if ($_SESSION['user']['role_id'] != 1) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    if (Rider::unsuspendRiderById($id)) {
      $_SESSION['success'] = "Rider has been activated successfully.";
    }
    redirect("dashboard/allriders");
  }

  /*====================user dashboard================ */
  function myparcels()
  {
    if (!isset($_SESSION['user'])) {
      redirect("login");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    $userId = $_SESSION['user']['id'];
    if ($role == 3 || $role == 4) {
      $myParcelData = Parcel::findParcelByUserId($userId);
    }
    $page = "myparcels";
    view("dashboard", compact('role', 'page', 'myParcelData'));
  }


  // edit parcel page 
  function editparcel()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || ($role != 3)) {
      redirect("");
      exit;
    }
    $id = intval($_GET['id']);
    $parcelData = Parcel::findParcelById($id);
    $page = "editparcel";
    view("dashboard", compact(
      'role',
      'page',
      'parcelData'
    ));
  }


  /*====================rider dashboard================ */
  function assignedparcels()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || ($role != 4)) {
      redirect("");
      exit;
    }
    $userid = $_SESSION['user']['id'];
    $rider = Rider::findRiderByUserId($userid);
    $page = 'assignedparcels';
    $assgnedParcelData = Parcel::allAssignedParcels($rider->id);
    view('dashboard', compact('role', 'page', 'assgnedParcelData'));
  }

  function acceptedparcels()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) && ($role != 4)) {
      redirect("");
      exit;
    }
    $userid = $_SESSION['user']['id'];
    $rider = Rider::findRiderByUserId($userid);
    $page = 'acceptedparcels';
    $acceptedParcelData = Rider::allAcceptedParcels($rider->id);
    view('dashboard', compact('role', 'page', 'acceptedParcelData'));
  }
}
