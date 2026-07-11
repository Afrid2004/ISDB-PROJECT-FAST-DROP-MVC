<?php
ob_start();
session_start();
require_once("configs/config.php");
require_once("models/model.php");
require_once("controllers/controller.php");

// Automatically log in the user if a valid remember token exists
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {

  $user = User::findRememberToken($_COOKIE['remember_token']);

  // Restore the user session from the remember token
  if ($user) {
    $_SESSION['user'] = [
      "id"      => $user->id,
      "photo_url" => $user->photo_url,
      "role_id" => $user->role_id,
      "name"    => $user->name,
      "email"   => $user->email
    ];
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto+Slab:wght@100..900&display=swap"
    rel="stylesheet" />
  <!-- swipper js cdn -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
  <!-- font awsome cdn -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- tailwind css cdn -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="<?php echo $base_url ?>/assets/css/style.css" />
  <link rel="shortcut icon" href="<?php echo $base_url ?>/assets/images/favicon.ico" type="image/x-icon">
  <title>Fast Drop | Logistic Website</title>
  <style type="text/tailwindcss">
    @theme {
        --color-primary: #00bba7;
        --color-prmlight: #00fae1;
        --color-hover: #009689;
        --color-secondary: #162636;
        --color-gray: #76879e;
      }
      .container {
        @apply px-4 lg:px-0 w-full max-w-110 sm:max-w-150 md:max-w-187.5 lg:max-w-250 xl:max-w-300 2xl:max-w-325 mx-auto;
      }
      .btn::after {
        position: absolute;
        content: "";
        width: 0;
        height: 100%;
        background: #162636;
        left: 0;
        top: 0;
        transition: all 0.3s ease-in-out;
        border-radius: 0 50% 50% 0;
      }
      .btn:hover::after {
        width: 200%;
      }
      .btn {
        position: relative;
        overflow: hidden;
      }
      .btn > * {
        position: relative;
        z-index: 1;
        transition: all 0.1s ease-in-out;
      }
      .btn:hover > * {
        color: white;
      }

      .menu-toogler {
        @apply opacity-100 pointer-events-auto duration-150;
      }

      .menu-sidebar-toggle {
        @apply translate-x-0 duration-300;
      }

    </style>
</head>