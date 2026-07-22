<?php
$data = Dashboard::getStats();
$recent = Dashboard::getRecentActivities(5);
$tasks = Dashboard::getPendingTasks();

$pendingRiders  = $tasks->pending_riders;
$pendingParcels = $tasks->pending_parcels;
$pendingPayments = $tasks->pending_payments;
$totalUsers = $data->total_users;
$totalAdmins = $data->total_admins;
$totalRiders = $data->total_riders;
$totalParcels = $data->total_parcels;
$totalDelivered = $data->delivered_parcels;
$totalPending = $data->pending_parcels;
$totalRevenue = $data->total_revenue;
$totalCod = $data->total_cod;
?>

<div class="space-y-8">

  <!-- Welcome Banner -->
  <div class="bg-black/40 border border-gray-500/30 p-8 shadow-xl overflow-hidden relative">

    <div class="absolute top-0 right-0 opacity-10 text-[180px]">
      <i class="fa-solid fa-user-shield"></i>
    </div>

    <div class="relative z-10">

      <h1 class="text-4xl font-bold text-white">
        Welcome Back,
        <span class="text-yellow-300">
          <?php echo implode(' ', array_slice(explode(' ', trim($_SESSION['user']['name'])), 0, 2)) ?>
          👋
        </span>
      </h1>

      <p class="text-gray-100 mt-3 max-w-2xl">
        Monitor the entire FastDrop Courier Management System from one place.
        Manage users, riders, parcels, reports and revenue efficiently.
      </p>

      <div class="flex flex-wrap gap-6 mt-6 text-sm text-white">

        <div>
          <i class="fa-solid fa-calendar-days mr-2"></i>
          <?php echo date("l, d F Y"); ?>
        </div>

        <div>
          <i class="fa-solid fa-clock mr-2"></i>
          <?php echo date("h:i A"); ?>
        </div>

      </div>

    </div>

  </div>



  <!-- Dashboard Stats -->

  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

    <!-- Users -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Total Users
          </p>

          <h2 class="text-3xl font-bold text-white mt-2">
            <?php echo $totalUsers ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 text-2xl">

          <i class="fa-solid fa-users"></i>

        </div>

      </div>

    </div>



    <!-- Admin -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Total Admin
          </p>

          <h2 class="text-3xl font-bold text-white mt-2">
            <?php echo $totalAdmins ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400 text-2xl">

          <i class="fa-solid fa-user-shield"></i>

        </div>

      </div>

    </div>



    <!-- Riders -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Total Riders
          </p>

          <h2 class="text-3xl font-bold text-white mt-2">
            <?php echo $totalRiders ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 text-2xl">

          <i class="fa-solid fa-motorcycle"></i>

        </div>

      </div>

    </div>



    <!-- Parcels -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Total Parcels
          </p>

          <h2 class="text-3xl font-bold text-white mt-2">
            <?php echo $totalParcels ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-orange-500/20 flex items-center justify-center text-orange-400 text-2xl">

          <i class="fa-solid fa-box"></i>

        </div>

      </div>

    </div>



    <!-- Delivered -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Delivered
          </p>

          <h2 class="text-3xl font-bold text-white mt-2">
            <?php echo $totalDelivered ?>
          </h2>

        </div>

        <div
          class="w-14 h-14 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-2xl">

          <i class="fa-solid fa-circle-check"></i>

        </div>

      </div>

    </div>



    <!-- Pending -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Pending Parcels
          </p>

          <h2 class="text-3xl font-bold text-white mt-2">
            <?php echo $totalPending ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-400 text-2xl">

          <i class="fa-solid fa-hourglass-half"></i>

        </div>

      </div>

    </div>



    <!-- Revenue -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            Total Revenue
          </p>

          <h2 class="text-2xl font-bold text-white mt-2">
            <?php echo number_format($totalRevenue, 2) ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-cyan-500/20 flex items-center justify-center text-cyan-400 text-2xl">

          <i class="fa-solid fa-sack-dollar"></i>

        </div>

      </div>

    </div>



    <!-- COD -->

    <div class="bg-black/40 border border-gray-500/30  p-6 hover:bg-black/50 transition">

      <div class="flex justify-between items-center">

        <div>

          <p class="text-gray-400 text-sm">
            COD Pending
          </p>

          <h2 class="text-2xl font-bold text-white mt-2">
            <?php echo number_format($totalCod, 2) ?>
          </h2>

        </div>

        <div class="w-14 h-14 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 text-2xl">

          <i class="fa-solid fa-money-bill-wave"></i>

        </div>

      </div>

    </div>

  </div>

  <!-- Recent Activity + Quick Actions -->

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- Recent Activities -->

    <div class="xl:col-span-2 bg-black/40 border border-gray-500/30">

      <div class="px-6 py-4 border-b border-gray-500/30 flex items-center justify-between">

        <h3 class="text-lg font-semibold text-white">
          Recent Activities
        </h3>

      </div>

      <div class="divide-y divide-gray-500/20">

        <?php while ($activity = $recent->fetch_object()) : ?>
          <?php
          switch ($activity->type) {

            case "user":
              $icon = "fa-user-plus";
              $bg = "bg-green-500/20";
              $color = "text-green-400";
              break;

            case "parcel":
              $icon = "fa-box";
              $bg = "bg-blue-500/20";
              $color = "text-blue-400";
              break;

            case "rider":
              $icon = "fa-motorcycle";
              $bg = "bg-purple-500/20";
              $color = "text-purple-400";
              break;

            case "payment":
              $icon = "fa-money-bill-wave";
              $bg = "bg-yellow-500/20";
              $color = "text-yellow-400";
              break;

            default:
              $icon = "fa-circle-info";
              $bg = "bg-gray-500/20";
              $color = "text-gray-400";
          }

          ?>

          <div class="flex items-start gap-4 p-5 hover:bg-black/30 transition">

            <div class="w-12 h-12 <?= $bg ?> flex items-center justify-center <?= $color ?>">

              <i class="fa-solid <?= $icon ?>"></i>

            </div>

            <div class="flex-1">

              <h4 class="text-white font-medium">
                <?= htmlspecialchars($activity->title) ?>
              </h4>

              <p class="text-gray-400 text-sm mt-1">
                <?= htmlspecialchars($activity->description) ?>
              </p>

            </div>

            <span class="text-xs text-gray-500 whitespace-nowrap">
              <?= date("d M, h:i A", strtotime($activity->created_at)) ?>
            </span>

          </div>

        <?php endwhile; ?>

      </div>

    </div>



    <!-- Quick Actions -->

    <div class="bg-black/40 border border-gray-500/30">

      <div class="px-6 py-4 border-b border-gray-500/30">
        <h3 class="text-lg font-semibold text-white">
          Pending Tasks
        </h3>
      </div>

      <div class="divide-y divide-gray-500/20">

        <a href="<?= $base_url ?>/dashboard/addrider"
          class="flex justify-between items-center p-5 hover:bg-black/30 transition">

          <div class="flex items-center gap-4">

            <div class="w-12 h-12 bg-green-500/20 flex items-center justify-center text-green-400">
              <i class="fa-solid fa-motorcycle"></i>
            </div>

            <div>
              <h4 class="text-white">Rider Applications</h4>
              <p class="text-gray-400 text-sm">
                Waiting for approval
              </p>
            </div>

          </div>

          <span class="bg-red-500/20 text-red-400 px-3 py-1">
            <?= $pendingRiders ?>
          </span>

        </a>



        <a href="<?= $base_url ?>/dashboard/pendingparcels"
          class="flex justify-between items-center p-5 hover:bg-black/30 transition">

          <div class="flex items-center gap-4">

            <div class="w-12 h-12 bg-orange-500/20 flex items-center justify-center text-orange-400">
              <i class="fa-solid fa-box"></i>
            </div>

            <div>
              <h4 class="text-white">Pending Parcels</h4>
              <p class="text-gray-400 text-sm">
                Need assignment
              </p>
            </div>

          </div>

          <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1">
            <?= $pendingParcels ?>
          </span>

        </a>



        <a href="<?= $base_url ?>/dashboard/paymenthistories"
          class="flex justify-between items-center p-5 hover:bg-black/30 transition">

          <div class="flex items-center gap-4">

            <div class="w-12 h-12 bg-cyan-500/20 flex items-center justify-center text-cyan-400">
              <i class="fa-solid fa-money-bill-wave"></i>
            </div>

            <div>
              <h4 class="text-white">Pending Payments</h4>
              <p class="text-gray-400 text-sm">
                Need verification
              </p>
            </div>

          </div>

          <span class="bg-blue-500/20 text-blue-400 px-3 py-1">
            <?= $pendingPayments ?>
          </span>

        </a>

      </div>

    </div>

  </div>

</div>