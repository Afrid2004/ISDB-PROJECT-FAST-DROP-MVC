<?php
$alldistricts = Districts::allDistricts();
?>

<div class="space-y-6">

  <!-- Page Header -->
  <div>
    <h2 class="text-2xl font-semibold text-white">
      Edit Profile
    </h2>
    <p class="text-gray-400 mt-1">
      Update your personal information and account settings.
    </p>
  </div>

  <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">

    <!-- Profile Photo -->
    <div class="bg-black/40 border border-gray-500/30">

      <div class="px-6 py-4 border-b border-gray-500/30">
        <h3 class="text-lg font-medium text-white">
          Profile Photo
        </h3>
      </div>

      <div class="p-6 flex flex-col md:flex-row items-center gap-8">

        <div class="w-36 h-36 border border-gray-500/30 overflow-hidden flex items-center justify-center bg-black/20">

          <img src="https://placehold.co/150x150" class="w-full h-full object-cover">

        </div>

        <div class="flex-1">

          <label
            class="inline-flex items-center gap-2 px-5 py-3 bg-blue-500/20 text-blue-400 cursor-pointer hover:bg-blue-500/30">

            <i class="fa-solid fa-camera"></i>

            Upload New Photo

            <input type="file" name="photo" class="hidden">

          </label>

          <p class="text-gray-400 text-sm mt-3">
            JPG, PNG, WEBP (Maximum 2 MB)
          </p>

        </div>

      </div>

    </div>

    <!-- Personal Information -->

    <div class="bg-black/40 border border-gray-500/30">

      <div class="px-6 py-4 border-b border-gray-500/30">
        <h3 class="text-lg font-medium text-white">
          Personal Information
        </h3>
      </div>

      <div class="p-6 grid md:grid-cols-2 gap-6">

        <div>

          <label class="block text-gray-300 mb-2">
            Full Name
          </label>

          <input type="text" value="<?php echo $user->name ?? "" ?>"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Email
          </label>

          <input type="email" value="<?php echo $user->email ?? "" ?>" readonly
            class="w-full bg-black/20 outline-none border border-gray-500/30 px-4 py-3 text-gray-400 cursor-not-allowed">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Phone
          </label>

          <input type="text" value="<?php echo $user->phone ?? "" ?>"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            District
          </label>

          <select
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

            <option selected disabled>Select District</option>
            <?php foreach ($alldistricts as $district) { ?>
              <option <?php echo ($district->id==$user->district_id) ? 'selected' : '' ?> value="<?php echo $district->id ?>"><?php echo $district->district_name; ?></option>
            <?php } ?>

          </select>

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Address
          </label>

          <textarea value="<?php echo $user->address ?? "" ?>" rows="3"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500"></textarea>

        </div>

      </div>

    </div>

    <!-- Password -->

    <div class="bg-black/40 border border-gray-500/30">

      <div class="px-6 py-4 border-b border-gray-500/30">
        <h3 class="text-lg font-medium text-white">
          Change Password
        </h3>
      </div>

      <div class="p-6 grid md:grid-cols-3 gap-6">

        <div>

          <label class="block text-gray-300 mb-2">
            Current Password
          </label>

          <input type="password"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            New Password
          </label>

          <input type="password"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Confirm Password
          </label>

          <input type="password"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

      </div>

    </div>

    <!-- Buttons -->

    <div class="flex flex-wrap gap-3">

      <button type="submit" class="px-6 py-3 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition">

        <i class="fa-solid fa-floppy-disk mr-2"></i>

        Save Changes

      </button>

      <a href="<?php echo $base_url ?>/dashboard/myaccount"
        class="px-6 py-3 bg-gray-500/20 text-gray-300 hover:bg-gray-500/30 transition">

        <i class="fa-solid fa-arrow-left mr-2"></i>

        Cancel

      </a>

    </div>

  </form>

</div>