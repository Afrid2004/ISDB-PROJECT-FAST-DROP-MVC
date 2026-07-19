<?php 
echo "<pre>";
print_r($allRiderData);
echo "</pre>";
?>

<div>
  <div>
    <h2 class="text-white font-medium text-2xl mb-3">All Riders</h2>
    <!-- Success Message -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="mb-4 rounded-md border border-lime-500/30 bg-lime-500/30 px-4 py-3 text-white">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-circle-check"></i>
          <span><?php echo $_SESSION['success']; ?></span>
        </div>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="mb-4 rounded-md border border-red-500/30 bg-red-500/30 px-4 py-3 text-white">
        <div class="flex items-start gap-2">
          <i class="fa-solid fa-circle-xmark mt-1"></i>
          <ul class="list-none space-y-1">
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php
      unset($_SESSION['errors']);
    endif;
    ?>
    <div>
      <?php if ($allRiderData) { ?>
        <div class="overflow-x-auto table-scrollbar border border-gray-500/30 shadow-sm">
          <table class="min-w-full whitespace-nowrap">
            <thead class="bg-black/30 border-b border-gray-500/30 text-white uppercase text-sm">
              <tr>
                <th class="px-6 py-3 text-left">#Sl</th>
                <th class="px-6 py-3 text-left">RIder Info</th>
                <th class="px-6 py-3 text-left">Service Info</th>
                <th class="px-6 py-3 text-left">Vehicle Info</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Work Status</th>
                <th class="px-6 py-3 text-left">Completed Tasks</th>
                <th class="px-6 py-3 text-left">Action</th>
                <th class="px-6 py-3 text-left">Created At</th>
              </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
              <?php
              $start = ($currentPage - 1) * $perPage;
              foreach ($allRiderData as $key => $data) {
                $statusClass = match ($data->status) {
                  'approved' => 'bg-lime-500/20 text-lime-400',
                  'suspended' => 'bg-red-500/20 text-red-400',
                  default     => 'bg-gray-500/20 text-gray-400'
                };
                $workStatusClass = match ($data->work_status) {
                  'available' => 'bg-lime-500/20 text-lime-400',
                  'busy' => 'bg-yellow-500/20 text-yellow-400',
                  default     => 'bg-gray-500/20 text-gray-400'
                }
              ?>

                <tr
                  class="border-b border-gray-500/30 last:border-b-0 bg-black/40 hover:bg-black/50 duration-150 text-white">
                  <td class="px-6 py-4"><?= $start + $key + 1 ?></td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <div class="w-9 h-9 flex items-center justify-center overflow-hidden rounded-full">
                        <?php echo avatar($data->rider_name) ?>
                      </div>
                      <div>
                        <p><?php echo $data->rider_name; ?></p>
                        <p><?php echo $data->rider_email; ?></p>
                        <p><?php echo $data->rider_phone; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div>
                      <p>Area: <?php echo $data->district_name; ?></p>
                      <p>License: <?php echo $data->license_no; ?></p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div>
                      <p>Type: <?php echo ucfirst($data->vehicle_type); ?></p>
                      <p>Registration: <?php echo $data->vehicle_registration; ?></p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-3 text-sm py-1 rounded <?php echo $statusClass ?>">
                      <?php echo ucfirst($data->status) ?>
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-3 text-sm py-1 rounded <?php echo $workStatusClass ?>">
                      <?php echo ucfirst($data->work_status) ?>
                    </span>
                  </td>
                  
                  <td class="px-6 py-4">
                    <div class="flex flex-col gap-2">
                      <?php if ($data->status == 'approved'): ?>
                        <a href="<?php echo $base_url ?>/dashboard/suspendrider?id=<?php echo $data->id ?>"
                          class="px-3 flex items-center gap-1 py-2 rounded bg-red-500/20 text-red-400 hover:bg-red-500/30 active:bg-red-500/20 cursor-pointer justify-center">
                          <i class="fa-solid fa-ban text-xs"></i> Suspend
                        </a>
                      <?php elseif ($data->status == 'suspended'): ?>
                        <a href="<?php echo $base_url ?>/dashboard/unsuspendrider?id=<?php echo $data->id ?>"
                          class="px-3 flex items-center gap-1 py-2 rounded bg-lime-500/20 text-lime-400 hover:bg-lime-500/30 active:bg-lime-500/20 cursor-pointer justify-center">
                          <i class="fa-solid fa-check text-xs"></i> Activate
                        </a>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo date("d F Y", strtotime($data->created_at)) ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <?= $pagination ?>
      <?php } else { ?>
        <div class="bg-black/40 border border-gray-500/30 text-white px-4 py-3">
          No Rider Data found!
        </div>
      <?php } ?>
    </div>
  </div>


</div>