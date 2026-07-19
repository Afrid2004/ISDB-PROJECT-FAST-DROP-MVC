<div>
  <div>
    <div class="mb-3 flex items-center justify-between gap-2">
      <h2 class="text-white font-medium text-2xl ">All Payment History</h2>
    </div>
    <div>
      <?php if ($allPaymentdata) { ?>
        <div class="overflow-x-auto table-scrollbar border border-gray-500/30 shadow-sm">
          <table class="min-w-full whitespace-nowrap">
            <thead class="bg-black/30 border-b border-gray-500/30 text-white uppercase text-sm">
              <tr>
                <th class="px-6 py-3 text-left">#Sl</th>
                <th class="px-6 py-3 text-left">Parcel Id</th>
                <th class="px-6 py-3 text-left">Amount</th>
                <th class="px-6 py-3 text-left">Payment Method</th>
                <th class="px-6 py-3 text-left">Transaction Id</th>
                <th class="px-6 py-3 text-left">Payment Status</th>
                <th class="px-6 py-3 text-left">Paid At</th>
                <th class="px-6 py-3 text-left">Action</th>
              </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
              <?php
              $start = ($currentPage - 1) * $perPage;
              foreach ($allPaymentdata as $key => $data) {
                $paymentClass = match ($data->payment_status) {
                  "pending"             => "bg-yellow-500/20 text-yellow-400",
                  "paid"                => "bg-teal-500/20 text-teal-400",
                  "failed"              => "bg-red-500/20 text-red-400",
                  "refunded"            => "bg-orange-500/20 text-orange-400",
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
                      <p><?php echo $data->parcel_id; ?></p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div>
                      <p><?php echo $data->amount; ?> TK</p>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-3 py-2 rounded bg-lime-500/20 text-lime-400">
                      <?php echo ucfirst($data->payment_method); ?>
                    </span>
                  </td>
                  <td class="px-6 py-4"><?php echo $data->transaction_id ?? "NULL" ?></td>
                  <td class="px-6 py-4">
                    <span class="px-3 py-2 rounded <?php echo $paymentClass ?>">
                      <?php echo $data->payment_status ?>
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <?php echo date("d F Y", strtotime($data->paid_at)) ?>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex flex-col gap-2">
                      <a href="<?php echo $base_url . "/dashboard/parceldetails?id=" . $data->id ?>"
                        class="viewParcelBtn px-3 flex items-center gap-1 py-2 rounded bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 active:bg-blue-500/20 cursor-pointer justify-center">
                        <i class="fa-regular fa-eye text-xs"></i> View
                      </a>
                    </div>
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