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

        <img src="https://placehold.co/150x150" alt="" class="w-full h-full object-cover">

      </div>

      <div class="space-y-2">

        <h2 class="text-2xl font-semibold text-white">
          Md Faisal Yousuf Afrid
        </h2>

        <p class="text-gray-400">
          <i class="fa-regular fa-envelope mr-2"></i>
          faisal@gmail.com
        </p>

        <p class="text-gray-400">
          <i class="fa-solid fa-shield-halved mr-2"></i>
          Admin
        </p>

        <p class="text-gray-400">
          <i class="fa-regular fa-calendar mr-2"></i>
          Member Since : 15 July 2026
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

        Active

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
        <p class="text-white mt-1">Md Faisal Yousuf Afrid</p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Username</p>
        <p class="text-white mt-1">afrid2004</p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Email</p>
        <p class="text-white mt-1">faisal@gmail.com</p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Phone</p>
        <p class="text-white mt-1">017xxxxxxxx</p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">District</p>
        <p class="text-white mt-1">Dhaka</p>
      </div>

      <div>
        <p class="text-gray-400 text-sm">Address</p>
        <p class="text-white mt-1">Mirpur, Dhaka</p>
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

        <button class="px-4 py-2 bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30">

          <i class="fa-solid fa-key mr-2"></i>

          Change Password

        </button>

      </div>

      <div>

        <p class="text-gray-400 text-sm">
          Last Login
        </p>

        <p class="text-white mt-1">
          19 July 2026 08:30 PM
        </p>

      </div>

      <div>

        <p class="text-gray-400 text-sm">
          Account Status
        </p>

        <p class="text-lime-400 mt-1">
          Active
        </p>

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

      <button class="px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500/30">

        <i class="fa-solid fa-right-from-bracket mr-2"></i>

        Logout

      </button>

    </div>

  </div>

</div>