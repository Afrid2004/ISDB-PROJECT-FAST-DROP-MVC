<div class="space-y-5">

  <!-- Page Title -->
  <div>
    <h2 class="text-2xl font-semibold text-white">
      My Account
    </h2>
    <p class="text-gray-300 mt-1">
      Manage your personal information and account settings.
    </p>
  </div>

  <!-- Profile Header -->
  <div class="bg-black/40 border border-gray-500/30 p-6">

    <div class="flex flex-col md:flex-row md:items-center gap-5">

      <div
        class="w-24 h-24 border border-gray-500/30 overflow-hidden flex items-center justify-center bg-black/30 shrink-0">

        <?php echo avatar($user->name, $user->photo_url) ?>

      </div>

      <div class="space-y-2">

        <h2 class="text-2xl font-semibold text-white">
          <?php echo $user->name ?>
        </h2>

        <p class="text-gray-400">
          <i class="fa-regular fa-envelope mr-2"></i>
          <?php echo $user->email ?>
        </p>

        <p class="text-gray-400">
          <i class="fa-solid fa-shield-halved mr-2"></i>
          <?php echo ucfirst(str_replace("_", " ", $user->rolename)) ?>
        </p>

        <p class="text-gray-400">
          <i class="fa-regular fa-calendar mr-2"></i>
          Member Since : <?php echo date("d F Y", strtotime($user->created_at)) ?>
        </p>

      </div>

    </div>

  </div>

  <!-- Status Cards -->

  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div class="bg-black/40 border border-gray-500/30 p-5">

      <p class="text-gray-400 mb-2">
        Account Status
      </p>

      <span class="px-3 py-2 bg-lime-500/20 text-lime-400 inline-flex items-center gap-2">

        <i class="fa-solid fa-circle-check"></i>

        <?php echo ucfirst($user->status) ?>

      </span>

    </div>

    <div class="bg-black/40 border border-gray-500/30 p-5">

      <p class="text-gray-400 mb-2">
        Email Verification
      </p>

      <span class="px-3 py-2 bg-blue-500/20 text-blue-400 inline-flex items-center gap-2">

        <i class="fa-solid fa-envelope-circle-check"></i>

        Verified

      </span>

    </div>

  </div>

  <!-- Personal Information -->

  <div class="bg-black/40 border border-gray-500/30">

    <div class="border-b border-gray-500/30 px-6 py-4">

      <h2 class="text-lg text-white font-medium">
        Personal Information
      </h2>

    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-10">

      <div>
        <p class="text-gray-400 text-sm">Full Name</p>
        <p class="text-white mt-1"><?php echo $user->name ?></p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Email</p>
        <p class="text-white mt-1"><?php echo $user->email ?></p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Phone</p>
        <p class="text-white mt-1"><?php echo $user->phone ? $user->phone : "Null" ?></p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">District</p>
        <p class="text-white mt-1"><?php echo $user->districtname ?></p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Address</p>
        <p class="text-white mt-1"><?php echo $user->address ? $user->address : "Null" ?></p>
      </div>

    </div>

  </div>

  <!-- Security -->

  <div class="bg-black/40 border border-gray-500/30">

    <div class="border-b border-gray-500/30 px-6 py-4">

      <h2 class="text-lg text-white font-medium">
        Security
      </h2>

    </div>

    <div class="p-6 flex flex-col gap-5">

      <div class="flex items-center justify-between">

        <div>

          <p class="text-gray-400 text-sm">
            Password
          </p>

          <p class="text-white mt-1">
            **************
          </p>

        </div>

        <a href="<?php echo $base_url ?>/dashboard/editprofile"
          class="px-4 py-2 bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30">

          <i class="fa-solid fa-key mr-2"></i>

          Change Password

        </a>

      </div>


      <div>

        <p class="text-gray-400 text-sm">
          Account Status
        </p>

        <p class="text-lime-400 mt-1">
          Active
        </p>

      </div>

      <div class="bg-black/40 border border-gray-500/30 p-5">
        <div class="flex items-start gap-4">

          <!-- Content -->
          <div class="flex-1">

            <h3 class="text-white font-medium text-lg">
              Last Login
            </h3>

            <p class="text-gray-400 text-sm mt-1">
              Your most recent login activity
            </p>

            <div class="mt-4 space-y-2">

              <div class="flex items-center gap-2 text-sm">
                <i class="fa-regular fa-calendar text-blue-400 w-4"></i>
                <span class="text-gray-400">Date :</span>

                <span class="text-white">
                  <?php
                  if (!empty($user->last_login)) {
                    echo date("d F Y", strtotime($user->last_login));
                  } else {
                    echo "First Login";
                  }
                  ?>
                </span>
              </div>

              <div class="flex items-center gap-2 text-sm">
                <i class="fa-regular fa-clock text-green-400 w-4"></i>
                <span class="text-gray-400">Time :</span>

                <span class="text-white">
                  <?php
                  if (!empty($user->last_login)) {
                    echo date("h:i A", strtotime($user->last_login));
                  } else {
                    echo "--";
                  }
                  ?>
                </span>
              </div>

              <div class="flex items-center gap-2 text-sm">
                <i class="fa-solid fa-globe text-cyan-400 w-4"></i>
                <span class="text-gray-400">Location :</span>

                <span class="text-white">
                  <?php echo $user->last_location ?>
                </span>
              </div>

              <div class="flex items-center gap-2 text-sm">
                <i class="fa-solid fa-laptop text-yellow-400 w-4"></i>
                <span class="text-gray-400">Device :</span>

                <span class="text-white">
                  <?php echo $user->last_device ?>
                </span>
              </div>

              <div class="flex items-center gap-2 text-sm">
                <i class="fa-brands fa-chrome text-orange-400 w-4"></i>
                <span class="text-gray-400">Browser :</span>

                <span class="text-white">
                  <?php echo $user->last_browser ?>
                </span>
              </div>

              <div class="flex items-center gap-2 text-sm">
                <i class="fa-solid fa-network-wired text-purple-400 w-4"></i>
                <span class="text-gray-400">IP Address :</span>

                <span class="text-white">
                  <?php echo $user->last_ip ?>
                </span>
              </div>

            </div>

          </div>

        </div>
      </div>


    </div>

  </div>

  <!-- Actions -->

  <div class="bg-black/40 border border-gray-500/30">

    <div class="border-b border-gray-500/30 px-6 py-4">

      <h2 class="text-lg text-white font-medium">
        Actions
      </h2>

    </div>

    <div class="p-6 flex flex-wrap gap-3">

      <a href="<?php echo $base_url ?>/dashboard/editprofile"
        class="px-4 py-2 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30">

        <i class="fa-regular fa-pen-to-square mr-2"></i>

        Edit Profile

      </a>

      <a href="<?php echo $base_url ?>/logout" class="px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500/30">

        <i class="fa-solid fa-right-from-bracket mr-2"></i>

        Logout

      </a>

    </div>

  </div>

</div>