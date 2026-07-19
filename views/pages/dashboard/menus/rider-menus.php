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

  <!-- assigned parcels link  -->
  <div>
    <a class="block" href="<?php echo $base_url ?>/dashboard/assignedparcels">
      <div
        class="flex items-center gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none">
        <i class="fa-solid fa-layer-group"></i>
        Assigned Parcels
      </div>
    </a>
  </div>

  <!-- accepted parcels link  -->
  <div>
    <a class="block" href="<?php echo $base_url ?>/dashboard/acceptedparcels">
      <div
        class="flex items-center gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none">
        <i class="fa-solid fa-check"></i>
        Accepted Parcels
      </div>
    </a>
  </div>

  <!-- completed tasks link  -->
  <div>
    <a class="block" href="<?php echo $base_url ?>/dashboard/completedtasks">
      <div
        class="flex items-center gap-2 text-white/70 hover:text-white px-4 py-3 hover:bg-white/20 duration-150 text-lg leading-none">
        <i class="fa-solid fa-list-check"></i>
        Completed Tasks
      </div>
    </a>
  </div>

</div>