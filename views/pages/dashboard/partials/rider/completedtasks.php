

<div>
  <div class="mb-5 flex items-center justify-between gap-2">
    <h2 class="text-white font-medium text-2xl">
      Completed Tasks
    </h2>
  </div>

  <!-- Summary Cards -->
  <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">

    <div class="bg-black/40 border border-gray-500/30 p-5">
      <p class="text-gray-400 text-sm uppercase">
        Total Deliveries
      </p>

      <h2 class="text-3xl font-semibold text-white mt-2">
        <?php echo count($completedParcelData); ?>
      </h2>
    </div>

    <div class="bg-black/40 border border-gray-500/30 p-5">
      <p class="text-gray-400 text-sm uppercase">
        Total Earnings
      </p>

      <h2 class="text-3xl font-semibold text-green-400 mt-2">
        <?php
        $totalEarn = 0;
        foreach ($completedParcelData as $item) {
          $totalEarn += $item->delivery_charge;
        }
        echo number_format($totalEarn, 2);
        ?> TK
      </h2>
    </div>

    <div class="bg-black/40 border border-gray-500/30 p-5">
      <p class="text-gray-400 text-sm uppercase">
        Cashout Pending
      </p>

      <h2 class="text-3xl font-semibold text-yellow-400 mt-2">
        <?php echo number_format($totalEarn, 2); ?> TK
      </h2>
    </div>

  </div> -->

  <?php if ($completedParcelData) { ?>

  <div class="overflow-x-auto table-scrollbar border border-gray-500/30 shadow-sm">

    <table class="min-w-full whitespace-nowrap">

      <thead class="bg-black/30 border-b border-gray-500/30 text-white uppercase text-sm">

        <tr>

          <th class="px-6 py-3 text-left">#Sl</th>

          <th class="px-6 py-3 text-left">
            Parcel Info
          </th>

          <th class="px-6 py-3 text-left">
            Delivery Charge
          </th>

          <th class="px-6 py-3 text-left">
            Rider Earnings
          </th>

          <th class="px-6 py-3 text-left">
            Payment Status
          </th>

          <th class="px-6 py-3 text-left">
            Cashout Status
          </th>

          <th class="px-6 py-3 text-left">
            Action
          </th>

          <th class="px-6 py-3 text-left">
            Delivered At
          </th>

        </tr>

      </thead>

      <tbody class="text-gray-700 text-sm">
        <?php
          $start = ($currentPage - 1) * $perPage;
          foreach ($completedParcelData as $key => $data):
            $paymentClass = match ($data->payment_status) {
              "pending"  => "bg-yellow-500/20 text-yellow-400",
              "paid"     => "bg-teal-500/20 text-teal-400",
              "failed"   => "bg-red-500/20 text-red-400",
              "refunded" => "bg-orange-500/20 text-orange-400",
              default    => "bg-gray-500/20 text-gray-300",
            };

            $cashoutClass = match ($data->cashout_status) {
              "paid" => "bg-green-500/20 text-green-400",
              "processing" => "bg-blue-500/20 text-blue-400",
              default => "bg-yellow-500/20 text-yellow-400"
            };

          ?>

        <tr class="border-b border-gray-500/30 last:border-b-0 bg-black/40 hover:bg-black/50 duration-150 text-white">
          <td class="px-6 py-4"><?= $start + $key + 1 ?></td>
          </td>

          <td class="px-6 py-4">
            <div>
              <p><?= $data->parcel_name ?></p>
              <small class="text-gray-400">
                <?= $data->weight ?> KG
              </small>
            </div>
          </td>
          <td class="px-6 py-4">
            <?= number_format($data->delivery_charge, 2) ?> TK
          </td>

          <td class="px-6 py-4">
            <span class="text-lime-400 font-medium">
              <?= number_format($data->rider_commission, 2) ?> TK
            </span>
          </td>

          <td class="px-6 py-4">
            <span class="px-3 py-2 rounded <?= $paymentClass ?>">
              <?= ucfirst($data->payment_status) ?>
            </span>
          </td>

          <td class="px-6 py-4">
            <span class="px-3 py-2 rounded <?= $cashoutClass ?>">
              <?= ucfirst($data->cashout_status) ?>
            </span>
          </td>

          <td class="px-6 py-4">

            <div class="flex flex-col gap-2">

              <a href="<?= $base_url ?>/dashboard/parceldetails?id=<?= $data->id ?>"
                class="px-3 flex items-center gap-1 py-2 rounded bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 active:bg-blue-500/20 cursor-pointer justify-center">

                <i class="fa-regular fa-eye text-sm"></i>

                View

              </a>

              <?php if ($data->cashout_status == "pending"): ?>

              <button data-parcelid="<?= $data->id ?>"
                class="cashoutBtn px-3 flex items-center gap-1 py-2 rounded bg-green-500/20 text-green-400 hover:bg-green-500/30 active:bg-green-500/20 cursor-pointer justify-center">

                <i class="fa-solid fa-wallet text-sm"></i>

                Cashout

              </button>

              <?php endif; ?>

            </div>

          </td>

          <td class="px-6 py-4">

            <?= date("d F Y", strtotime($data->updated_at)) ?>

          </td>

        </tr>

        <?php endforeach; ?>
      </tbody>

    </table>

  </div>
  <?= $pagination ?>
  <?php } else { ?>

  <div class="bg-black/40 border border-gray-500/30 text-white px-4 py-3">

    No Completed Task Found!

  </div>

  <?php } ?>

</div>

</div>