<div>
  <div>
    <div class="mb-3 flex items-center justify-between gap-2">
      <h2 class="text-white font-medium text-2xl ">All Parcels</h2>
      <a href="<?php echo $base_url ?>/parcel"
        class="px-3 flex items-center gap-1 py-2 rounded bg-lime-500/20 text-lime-400 hover:bg-lime-500/30 active:bg-lime-500/20 cursor-pointer justify-center">
        Create new<i class="fa-solid fa-plus text-xs"></i>
      </a>
    </div>
    <div>
      <?php if ($myParcelData) { ?>
        <div class="overflow-x-auto table-scrollbar border border-gray-500/30 shadow-sm">
          <table class="min-w-full whitespace-nowrap">
            <thead class="bg-black/30 border-b border-gray-500/30 text-white uppercase text-sm">
              <tr>
                <th class="px-6 py-3 text-left">#Sl</th>
                <th class="px-6 py-3 text-left">Parcel Info</th>
                <th class="px-6 py-3 text-left">From</th>
                <th class="px-6 py-3 text-left">To</th>
                <th class="px-6 py-3 text-left">Delivery Charge</th>
                <th class="px-6 py-3 text-left">Payment Status</th>
                <th class="px-6 py-3 text-left">Parcel Status</th>
                <th class="px-6 py-3 text-left">Action</th>
                <th class="px-6 py-3 text-left">Created At</th>
              </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
              <?php
              $start = ($currentPage - 1) * $perPage;
              foreach ($myParcelData as $key => $data) {
                $paymentClass = match ($data->payment_status) {
                  "pending"             => "bg-yellow-500/20 text-yellow-400",
                  "paid"                => "bg-teal-500/20 text-teal-400",
                  "failed"              => "bg-red-500/20 text-red-400",
                  "refunded"            => "bg-orange-500/20 text-orange-400",
                  default              => "bg-gray-500/20 text-gray-300",
                };

                $parcelClass = match ($data->parcel_status) {
                  "pending"            => "bg-yellow-500/20 text-yellow-400",
                  "pending_pickup"     => "bg-yellow-500/20 text-yellow-400",
                  "assigned"           => "bg-blue-500/20 text-blue-400",
                  "rider_accepted"     => "bg-lime-500/20 text-lime-400",
                  "rider_rejected"     => "bg-orange-500/20 text-orange-400",
                  "picked_up"          => "bg-cyan-500/20 text-cyan-400",
                  "in_transit"         => "bg-purple-500/20 text-purple-400",
                  "delivered"          => "bg-green-500/20 text-green-400",
                  default              => "bg-gray-500/20 text-gray-300",
                };
              ?>

                <tr
                  class="border-b border-gray-500/30 last:border-b-0 bg-black/40 hover:bg-black/50 duration-150 text-white">
                  <td class="px-6 py-4">
                    <?= $start + $key + 1 ?>
                  </td>
                  <td class="px-6 py-4">
                    <div>
                      <p><?php echo $data->parcel_name; ?> [<?php echo $data->weight; ?> KG]</p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div>
                      <p><?php echo $data->sender_district_name; ?></p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div>
                      <p><?php echo $data->receiver_district_name; ?></p>
                    </div>
                  </td>
                  <td class="px-6 py-4"><?php echo $data->delivery_charge ?> TK</td>
                  <td class="px-6 py-4">
                    <?php if ($data->payment_status == 'pending' || $data->payment_status == 'failed'): ?>
                      <a href="<?php echo $base_url . '/parcel/pay?id=' . $data->id ?>"
                        class="px-3 flex items-center gap-1 py-2 rounded bg-lime-500/20 text-lime-400 hover:bg-lime-500/30 active:bg-lime-500/20 cursor-pointer justify-center">
                        Pay <i class="fa-solid fa-sack-dollar text-xs"></i>
                      </a>
                    <?php else: ?>
                      <span class="px-3 py-2 rounded <?php echo $paymentClass ?>">
                        <?php echo $data->payment_status ?>
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-3 py-2 rounded <?php echo $parcelClass ?>">
                      <?php echo str_replace("_", " ", $data->parcel_status) ?>
                    </span>
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex flex-col gap-2">
                      <a href="<?php echo $base_url . "/dashboard/parceldetails?id=" . $data->id ?>"
                        class="viewParcelBtn px-3 flex items-center gap-1 py-2 rounded bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 active:bg-blue-500/20 cursor-pointer justify-center">
                        <i class="fa-regular fa-eye text-xs"></i> View
                      </a>
                      <a href="<?php echo $base_url . "/trackparcel?id=" . $data->tracking_id ?>"
                        class="viewParcelBtn px-3 flex items-center gap-1 py-2 rounded bg-lime-500/20 text-lime-400 hover:bg-lime-500/30 active:bg-lime-500/20 cursor-pointer justify-center">
                        <i class="fa-solid fa-location-dot text-xs"></i> Track Parcel
                      </a>
                      <?php if ($data->payment_status == 'pending'): ?>
                        <a href="<?php echo $base_url . '/dashboard/editparcel?id=' . $data->id ?>"
                          class="px-3 flex items-center gap-1 py-2 rounded bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 active:bg-yellow-500/20 cursor-pointer justify-center">
                          <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
                        </a>
                      <?php endif; ?>

                      <?php if ($data->payment_status == 'pending' && $data->parcel_status == 'pending'): ?>
                        <a href="<?= $base_url ?>/parcel/delete?id=<?= $data->id ?>"
                          class="px-3 flex items-center gap-1 py-2 rounded bg-red-500/20 text-red-400 hover:bg-red-500/30 active:bg-red-500/20 cursor-pointer justify-center">
                          <i class="fa-regular fa-trash-can text-xs"></i> Delete
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
          No Data found!
        </div>
      <?php } ?>
    </div>
  </div>


</div>