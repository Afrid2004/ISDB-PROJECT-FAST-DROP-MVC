<div>
  <div>
    <h2 class="text-white font-medium text-2xl mb-3">All Pending Parcels</h2>
    <div>
      <?php if ($pendingParcelsData) { ?>
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
              foreach ($pendingParcelsData as $key => $data) {
                $key++;
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
              <td class="px-6 py-4"><?php echo $start + $key + 1 ?></td>
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
                <span class="px-3 py-2 rounded <?php echo $paymentClass ?>">
                  <?php echo $data->payment_status ?>
                </span>
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
                  <?php if ($data->payment_status == 'paid' && $data->parcel_status == 'pending_pickup'): ?>
                  <button data-parcel="<?php echo $data->id ?>" data-district="<?php echo $data->sender_district_id ?>"
                    class="showRidersBtn px-3 flex items-center gap-1 py-2 rounded bg-lime-500/20 text-lime-400 hover:bg-lime-500/30 active:bg-lime-500/20 cursor-pointer justify-center">
                    <i class="fa-solid fa-person-biking text-xs"></i></i> Show Riders
                  </button>
                  <?php endif ?>
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
        No Pending Parcels Data found!
      </div>
      <?php } ?>
    </div>
  </div>

  <!-- show rider model  -->
  <div id="riderModal" onclick="toggleModal()"
    class="fixed opacity-0 pointer-events-none duration-150 inset-0 p-5 bg-black/40 backdrop-blur-xl flex justify-center items-center z-50">
    <div onclick="event.stopPropagation()" class="bg-white rounded-lg p-6 w-full max-w-[800px]">
      <div class="flex justify-between mb-4">
        <h2 class="text-xl font-medium text-secondary">Available Riders</h2>
        <button onclick="toggleModal()" id="closeModal"
          class="text-gray-500 bg-gray-200 hover:bg-gray-300 cursor-pointer w-9 h-9 flex items-center justify-center rounded-sm">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div>
        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
          <table class="min-w-full whitespace-nowrap">
            <thead class="bg-gray-100 border-b border-gray-200 text-secondary uppercase text-sm">
              <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Rider Name</th>
                <th class="px-6 py-3 text-left">Phone</th>
                <th class="px-6 py-3 text-left">Vehicle Type</th>
                <th class="px-6 py-3 text-center">Action</th>
              </tr>
            </thead>

            <tbody class="text-secondary text-sm" id="allRiderDiv">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>