<?php

function renderDashboard($role)
{
  // dynamic render dashboard page on user role
  switch ($role) {
    // super admin dashboard
    case 1:
      include_once('partials/super-admin.php');
      break;
    //admin dashboard
    case 2:
      include_once('partials/admin.php');
      break;
    //user dashboard
    case 3:
      include_once('partials/user.php');
      break;
    //rider dashboard
    case 4:
      include_once('partials/rider.php');
      break;
    default:
      redirect("");
      break;
  }
}
?>

<div>
  <div class="bg-[url('<?php echo $base_url ?>/assets/images/dashboard.png')] bg-cover bg-center min-h-screen">
    <div class="min-h-screen">
      <div class="flex">
        <!-- sidebar  -->
        <div>
          <div class="border-r border-gray-500/80">
            <!-- header -->
            <div class="flex items-center justify-between gap-7 p-4 border-b border-gray-500/80 bg-white/13">
              <div class="w-fit">
                <a href="<?php echo $base_url ?>">
                  <div class="w-40">
                    <img src="<?php echo $base_url ?>/assets/images/logo_white.png" alt="fast-drop" class="w-full">
                  </div>
                </a>
              </div>
              <div>
                <div class="w-8 h-8 flex items-center justify-center text-white bg-white/20">
                  <i class="fa-solid fa-angles-left"></i>
                </div>
              </div>
            </div>
            <!-- /header -->
            <!-- side menus  -->
            <div class="p-4 bg-black/30">
              <div class="flex flex-col gap-1">
                <!-- menus -->
                <div>
                  <a class="block" href="<?php echo $base_url ?>/dashboard">
                    <div
                      class="flex items-center gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none">
                      <i class="fa-regular fa-house"></i>
                      Dashboard
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <!-- /side menus  -->
          </div>
        </div>
        <!-- /sidebar  -->
        <div>
          <div>
            <?php renderDashboard($role) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>