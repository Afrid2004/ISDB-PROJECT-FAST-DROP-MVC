<div class="flex flex-col gap-1">
  <!-- home link-->
  <div>
    <a class="block" href="<?php echo $base_url ?>/dashboard">
      <div
        class="flex items-center gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none">
        <i class="fa-regular fa-house"></i>
        Dashboard
      </div>
    </a>
  </div>
  <!-- my parcels link  -->
  <div>
    <a class="block" href="<?php echo $base_url ?>/dashboard/myparcels">
      <div
        class="flex items-center gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none">
        <i class="fa-solid fa-box-archive"></i>
        My Parcels
      </div>
    </a>
  </div>

  <!-- parcels tab  -->
  <div>
    <div class="submenu_toggler">
      <button class="w-full cursor-pointer">
        <div
          class="flex items-center justify-between gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none [.active_&]:bg-white/10">
          <div class="flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-box-archive"></i>
            Parcels
          </div>
          <div class="shrink-0">
            <i class="fa-solid fa-angle-down text-sm [.active_&]:rotate-[180deg] duration-150"></i>
          </div>
        </div>
      </button>
      <div
        class="max-h-0 opacity-0 [.active_&]:py-3 [.active_&]:max-h-100 [.active_&]:opacity-100 duration-150 overflow-hidden">
        <div class="pl-2 border-l-2 border-gray-500/30">
          <div class="flex flex-col gap-1">
            <a class="block" href="<?php echo $base_url ?>/dashboard/allparcels">
              <div
                class="flex items-center gap-2 text-white/70 hover:text-white p-3 hover:bg-white/20 duration-150  leading-none">
                <i class="fa-solid fa-box-archive text-sm shrink-0"></i>
                All Parcels
              </div>
            </a>
            <a class="block" href="<?php echo $base_url ?>/dashboard/pendingparcels">
              <div
                class="flex items-center gap-2 text-white/70 hover:text-white p-3 hover:bg-white/20 duration-150  leading-none">
                <i class="fa-solid fa-hourglass text-sm shrink-0"></i>
                Pending Parcels
              </div>
            </a>
            <a class="block" href="<?php echo $base_url ?>/dashboard/deliveredparcels">
              <div
                class="flex items-center gap-2 text-white/70 hover:text-white p-3 hover:bg-white/20 duration-150  leading-none">
                <i class="fa-solid fa-check text-sm shrink-0"></i>
                Delivered Parcels
              </div>
            </a>
            <a class="block" href="<?php echo $base_url ?>/dashboard/cancelledparcels">
              <div
                class="flex items-center gap-2 text-white/70 hover:text-white p-3 hover:bg-white/20 duration-150  leading-none">
                <i class="fa-solid fa-xmark text-sm shrink-0"></i>
                Cancelled Parcels
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>