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
    // //admin dashboard
    // case 2:
    //   include_once('partials/$page.php');
    //   break;
    // //user dashboard
    // case 3:
    //   include_once('partials/$page.php');
    //   break;
    // //rider dashboard
    // case 4:
    //   include_once('partials/$page.php');
    //   break;
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
$userRole = User::userRole($_SESSION['user']['id']);
$roleNameArray = explode("_", $userRole->rolename);
$rolename = implode(" ", $roleNameArray);

$name = $_SESSION['user']['name'];
$photo = $_SESSION['user']['photo_url'];


?>

<div>
  <div class="bg-[url('<?php echo $base_url ?>/assets/images/dashboard.png')] bg-cover bg-center h-screen">

    <div class="h-full">
      <div class="flex w-full h-full">
        <!-- sidebar  -->
        <div class="w-65 shrink-0">
          <div class="h-screen flex flex-col">
            <!-- header -->
            <div
              class="px-4 h-20 flex items-center justify-between gap-7 border-b border-gray-500/50 border-r bg-black/30">
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
        <div class="w-full h-full flex flex-col overflow-hidden">
          <!-- header  -->
          <div class="px-4 h-20 flex items-center justify-between border-b border-gray-500/50 bg-black/30">
            <div>
              <div class="w-8 h-8 flex items-center justify-center text-white bg-white/10">
                <i class="fa-solid fa-angles-left"></i>
              </div>
            </div>
            <div>
              <div>
                <div>
                  <div class="relative">
                    <button id="userBtn" class="cursor-pointer max-w-60">
                      <div class="flex items-center gap-2">
                        <div
                          class="w-10 h-10 flex items-center justify-center rounded-full border boreder-gray-500/50 overflow-hidden shrink-0">
                          <?php echo avatar($name, $photo) ?>
                        </div>
                        <div>
                          <h2 class="text-white text-left line-clamp-1"><?php echo $name ?></h2>
                          <p class="text-white/70 uppercase line-clamp-1  text-left text-sm"><?php echo $rolename ?></p>
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
          <div class="p-5 h-full overflow-auto custom-scrollbar">
            <!-- dashboard wrapper  -->
            <?php renderDashboard($role, $page, $allUserdata ?? null) ?>
          </div>
        </div>
        <!-- content box  -->
      </div>
    </div>
  </div>
</div>