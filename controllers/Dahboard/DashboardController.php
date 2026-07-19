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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
      redirect("");
      exit;
    }
    $page = 'allusers';
    $result = User::showUser();
    $allUserdata  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'allUserdata', 'pagination', 'perPage', 'currentPage'));
  }

  // add admin
  function addadmin()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }
    $page = 'addadmin';
    $result = User::pendingAdmin();
    $allUserdata  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'allUserdata', 'pagination', 'perPage', 'currentPage'));
  }

  function alladmin()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) || $role != 1) {
      redirect("");
      exit;
    }
    $page = 'alladmin';
    $result = User::allAdmin();
    $allUserdata  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'allUserdata', 'pagination', 'perPage', 'currentPage'));
  }

  // dynamically render all parcels page 
  function allparcels()
  {
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    $id = intval($_GET['id'] ?? 0);
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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
      redirect("");
      exit;
    }
    $page = "pendingparcels";
    $result = Parcel::getParcelsByStatus(
      ['pending_pickup', 'rider_rejected'],
      'paid'
    );
    $pendingParcelsData = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'pendingParcelsData', 'pagination', 'perPage', 'currentPage'));
  }

  //delivered parcels page 
  function deliveredparcels()
  {
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
      redirect("");
      exit;
    }
    $page = "deliveredparcels";
    $result = Parcel::getParcelsByStatus(
      ['delivered'],
      'paid'
    );
    $deliveredParcelsData = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'deliveredParcelsData', 'pagination', 'perPage', 'currentPage'));
  }

  //cancelled parcels page 
  function cancelledparcels()
  {
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
      redirect("");
      exit;
    }
    $page = "cancelledparcels";
    $result = Parcel::getParcelsByStatus(
      ['cancelled'],
      'paid'
    );
    $cancelledParcelsData  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'cancelledParcelsData', 'pagination', 'perPage', 'currentPage'));
  }

  // addrider page 
  function addrider()
  {
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
      redirect("");
      exit;
    }
    $page = "allriders";
    $result = Rider::allApprovedSuspendedRiders();
    $countResult = Rider::deliverCompetedParcels($result['data']->id);
    $allRiderData = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    $totalCompleted = $countResult['totalCompleted'];
    view("dashboard", compact('role', 'page', 'allRiderData', 'pagination', 'perPage', 'currentPage', 'totalCompleted'));
  }

  // approver rider 
  function approverider()
  {
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
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
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    if ($role != 1 && $role != 2) {
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
    $result = Parcel::findParcelByUserId($userId);
    $myParcelData = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    $page = "myparcels";
    view("dashboard", compact('role', 'page', 'myParcelData', 'pagination', 'perPage', 'currentPage'));
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

    $page = "assignedparcels";
    $result = Parcel::getParcelsByStatus(
      ['assigned'],
      'paid',
      10,
      $rider->id,
    );
    $assgnedParcelData  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'assgnedParcelData', 'pagination', 'perPage', 'currentPage'));
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

  function completedtasks()
  {
    $role = $_SESSION['user']['role_id'];
    if (!isset($_SESSION['user']) && ($role != 4)) {
      redirect("");
      exit;
    }
    $userid = $_SESSION['user']['id'];
    $rider = Rider::findRiderByUserId($userid);
    $page = "completedtasks";
    $result = Rider::deliverCompetedParcels($rider->id);
    $completedParcelData  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    $totalCompleted = $result['totalCompleted'];
    view("dashboard", compact('role', 'page', 'completedParcelData', 'pagination', 'perPage', 'currentPage', 'totalCompleted'));
  }
}
