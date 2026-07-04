<?php

function renderDashboard($role, $page = "index", $allUserdata = null)
{
  global $base_url;
  // dynamic render dashboard page on user role
  switch ($role) {
    // super admin dashboard
    case 1:
      include_once("partials/super-admin/$page.php");
      break;
    //admin dashboard
    case 2:
      include_once('partials/$page.php');
      break;
    //user dashboard
    case 3:
      include_once('partials/$page.php');
      break;
    //rider dashboard
    case 4:
      include_once('partials/$page.php');
      break;
    default:
      redirect("");
      break;
  }
}

function renderMenus($role)
{
  global $base_url;
  // dynamic render menus
  switch ($role) {
    // super admin menus
    case 1:
      include_once('menus/super-admin-menus.php');
      break;
    //admin menus
    case 2:
      include_once('menus/admin-menus.php');
      break;
    //user menus
    case 3:
      include_once('menus/user-menus.php');
      break;
    //rider menus
    case 4:
      include_once('menus/rider-menus.php');
      break;
    default:
      redirect("");
      break;
  }
}


// name slice 
$finalAvatar="";
$name = trim($_SESSION['user']['name']);
$name_array = explode(' ', $name);
$avatar = strtoupper($name_array[0][0]);
if (isset($name_array[1])) {
    $avatar .= strtoupper($name_array[1][0]);
}
$photo = isset($_SESSION['user']['photo_url'])  ?? null ;
if (!empty($photo)) {
    $finalAvatar = "
        <img
            src='$photo'
            class='w-full h-full object-cover'
            alt='Profile'>
    ";
} else {
    $finalAvatar = "
        <div class='w-full h-full flex items-center justify-center bg-white text-secondary font-semibold'>
            $avatar
        </div>
    ";
}
?>

<div>
  <div class="bg-[url('<?php echo $base_url ?>/assets/images/dashboard.png')] bg-cover bg-center min-h-screen">
    
    <div class="min-h-screen">
      <div class="flex w-full">
        <!-- sidebar  -->
        <div class="w-65 shrink-0">
          <div class="h-screen flex flex-col">
            <!-- header -->
            <div class="p-4 flex items-center justify-between gap-7 border-b border-gray-500/50 border-r bg-black/30">
              <div class="w-fit">
                <a class="block" href="<?php echo $base_url ?>">
                  <div class="w-40">
                    <img src="<?php echo $base_url ?>/assets/images/logo_white.png" alt="fast-drop" class="w-full">
                  </div>
                </a>
              </div>
            </div>
            <!-- /header -->
            <!-- side menus  -->
            <div class="p-4 bg-black/30 h-full overflow-hidden border-r border-gray-500/50 ">
              <div class="h-full overflow-y-auto custom-scrollbar pr-1">
                <!-- menus  -->
                <?php renderMenus($role) ?>
              </div>
            </div>
            <!-- /side menus  -->
          </div>
        </div>
        <!-- /sidebar  -->

        <!-- content box  -->
        <div>
          <!-- header  -->
          <div class="px-4 h-15 flex items-center justify-between border-b border-gray-500/50 bg-black/30">
            <div>
              <div class="w-8 h-8 flex items-center justify-center text-white bg-white/10">
                <i class="fa-solid fa-angles-left"></i>
              </div>
            </div>
            <div>
              <div>
                <div>
                  <div class="relative">
                    <button id="userBtn" class="cursor-pointer">
                      <div>
                        <div class="w-10 h-10 flex items-center justify-center rounded-full border boreder-gray-500/50 overflow-hidden">
                          <?php echo $finalAvatar ?>
                        </div>
                      </div>
                    </button>




                    <div id="userMenu"
                      class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md p-2 border border-gray-200">
                      <ul class="flex flex-col w-full overflow-hidden">
                        <li>
                          <p class="px-3 py-1 rounded-sm hover:bg-gray-200 block text-lg">
                            <?php echo $_SESSION['user']['email']; ?></p>
                        </li>
                        <li>
                          <a class="px-3 py-1 rounded-sm hover:bg-gray-200 block text-lg"
                            href="<?php echo $base_url ?>/logout">Logout</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--/ header  -->
          <div>
            <!-- dashboard wrapper  -->
            <?php renderDashboard($role, $page, $allUserdata ?? null) ?>
          </div>
        </div>
        <!-- content box  -->
      </div>
    </div>
  </div>
</div>