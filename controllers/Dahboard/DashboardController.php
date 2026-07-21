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
    $allRiderData = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'allRiderData', 'pagination', 'perPage', 'currentPage'));
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


  function paymenthistories()
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
    $page = 'paymenthistories';
    $result = Payment::allPayments();
    $allPaymentdata  = $result['data'];
    $pagination = $result['links'];
    $perPage = $result['perPage'];
    $currentPage = $result['currentPage'];
    view("dashboard", compact('role', 'page', 'allPaymentdata', 'pagination', 'perPage', 'currentPage'));
  }

  function myaccount()
  {
    if (!isset($_SESSION['user'])) {
      redirect("login");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    $userId = $_SESSION['user']['id'];
    $user = User::findUser($userId);
    $page = 'myaccount';
    view("dashboard", compact('role', 'page', 'user'));
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

  function editprofile()
  {
    if (!isset($_SESSION['user'])) {
      redirect("");
      exit;
    }
    $role = $_SESSION['user']['role_id'];
    $userId = $_SESSION['user']['id'];
    $user = User::findUser($userId);
    $page = 'editprofile';
    view("dashboard", compact('role', 'page', 'user'));
  }

  function updateprofile()
  {
    if (isset($_POST['btn_submit'])) {
      $photo = $_FILES['file'];
      $image_type = $photo['type'];
      $image_size = $photo['size'];
      $temp_name = $photo['tmp_name'];
      $user = User::findUser($_SESSION['user']['id']);
      $allowedTypes = ["image/jpg", "image/jpeg", "image/png", "image/webp"];
      $image_url = $user->photo_url;
      if (!empty($_FILES['file']['name'])) {
        if (!in_array($image_type, $allowedTypes)) {
          $_SESSION['errors'][] = "Invalid image type.";
        }
        if ($image_size > 2 * 1024 * 1024) {
          $_SESSION['errors'][] = "Maximum size 2MB.";
        }
        if (!$photo['error']) {
          $image_url = uploadToImageBB($temp_name);
        }
        if (!$image_url) {
          $_SESSION['errors'][] = "Failed to upload image.";
        }
      }
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $phone = trim($_POST['phone']);
      $district = intval($_POST['district']);
      $address = trim($_POST['address']);
      $newpassword = trim($_POST['newpassword']);
      if (empty($name)) {
        $_SESSION['errors'][] = "Name is required.";
      }

      if (!empty($phone) && !preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
        $_SESSION['errors'][] = "Invalid phone number.";
      }

      if ($district <= 0) {
        $_SESSION['errors'][] = "Please select a district.";
      }

      $password = $user->password;
      if (!empty($newpassword)) {

        $currentpassword = $_POST['currentpassword'];
        $confirmpassword = $_POST['confirmpassword'];

        if (!password_verify($currentpassword, $user->password)) {
          $_SESSION['errors'][] = "Current password is incorrect.";
        }

        if (strlen($newpassword) < 8) {
          $_SESSION['errors'][] = "Password must be at least 8 characters.";
        }

        if ($newpassword !== $confirmpassword) {
          $_SESSION['errors'][] = "Passwords do not match.";
        }
        if (!empty($newpassword)) {
          $password = password_hash($newpassword, PASSWORD_DEFAULT);
        }
      }

      if (!empty($_SESSION['errors'])) {
        redirect("dashboard/editprofile");
        exit;
      }


      $userClass = new User();
      $userClass->set(
        $user->id,
        $user->role_id,
        $name,
        $email,
        $password,
        $image_url ?? null,
        $phone,
        $district,
        $address
      );
      $success = $userClass->updateprofile();

      if ($success) {
        $_SESSION['user']['name'] = $name;
        if ($image_url) {
          $_SESSION['user']['photo_url'] = $image_url;
        }
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['success'] = "Profile updated successfully.";
      }

      redirect("dashboard/myaccount");
    }
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
