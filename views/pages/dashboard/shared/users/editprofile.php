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

  <?php if (!empty($_SESSION['errors'])): ?>
    <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 mb-5">
      <ul class="list-disc ml-5 space-y-1">
        <?php foreach ($_SESSION['errors'] as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 mb-5">
      <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <form action="<?php echo $base_url ?>/dashboard/updateprofile" method="POST" enctype="multipart/form-data"
    class="space-y-6">

    <!-- Profile Photo -->
    <div class="bg-black/40 border border-gray-500/30">

      <div class="px-6 py-4 border-b border-gray-500/30">
        <h3 class="text-lg font-medium text-white">
          Profile Photo
        </h3>
      </div>

      <div class="p-6 flex flex-col md:flex-row items-center gap-8">

        <div class="w-36 h-36 border border-gray-500/30 overflow-hidden flex items-center justify-center bg-black/20">

          <?php echo avatar($user->name, $user->photo_url) ?>

        </div>

        <div class="flex-1">

          <label
            class="inline-flex items-center gap-2 px-5 py-3 bg-teal-500/20 text-teal-400 cursor-pointer hover:bg-teal-500/30">

            <i class="fa-solid fa-camera"></i>

            Upload New Photo

            <input type="file" name="file" class="hidden">

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

          <input type="text" name="name" value="<?php echo $user->name ?? "" ?>"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Email
          </label>

          <input type="email" name="email" value="<?php echo $user->email ?? "" ?>" readonly
            class="w-full bg-black/20 outline-none border border-gray-500/30 px-4 py-3 text-gray-400 cursor-not-allowed">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Phone
          </label>

          <input type="text" name="phone" value="<?php echo $user->phone ?? "" ?>"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            District
          </label>

          <select name="district"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500">

            <option selected disabled>Select District</option>
            <?php foreach ($alldistricts as $district) { ?>
              <option <?php echo ($district->id == $user->district_id) ? 'selected' : '' ?>
                value="<?php echo $district->id ?>"><?php echo $district->district_name; ?></option>
            <?php } ?>

          </select>

        </div>

        <div>

          <label class="block text-gray-300 mb-2">
            Address
          </label>

          <textarea name="address" rows="3"
            class="w-full bg-black/30 border border-gray-500/30 px-4 py-3 text-white focus:outline-none focus:border-blue-500"><?php echo $user->address ?? "" ?></textarea>
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

          <div class="flex items-center gap-1 w-full bg-black/30 border border-gray-500/30 h-10">
            <input name="currentpassword" type="password"
              class="text-white px-4  h-full w-full outline-none border-none " placeholder="••••••••">
            <div class="shrink-0 pe-4">
              <i class="fa-regular fa-eye text-gray cursor-pointer showpassIcon"></i>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-gray-300 mb-2">
            New Password
          </label>

          <div class="flex items-center gap-1 w-full bg-black/30 border border-gray-500/30 h-10">
            <input name="newpassword" type="password" class="text-white px-4  h-full w-full outline-none border-none "
              placeholder="••••••••">
            <div class="shrink-0 pe-4">
              <i class="fa-regular fa-eye text-gray cursor-pointer showpassIcon"></i>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-gray-300 mb-2">
            Confirm Password
          </label>

          <div class="flex items-center gap-1 w-full bg-black/30 border border-gray-500/30 h-10">
            <input name="confirmpassword" type="password"
              class="text-white px-4  h-full w-full outline-none border-none " placeholder="••••••••">
            <div class="shrink-0 pe-4">
              <i class="fa-regular fa-eye text-gray cursor-pointer showpassIcon"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Buttons -->

    <div class="flex flex-wrap gap-3">

      <button type="submit" name="btn_submit"
        class="px-6 py-3 bg-lime-500/20 text-lime-400 hover:bg-lime-500/30 transition cursor-pointer">

        <i class="fa-solid fa-floppy-disk mr-2"></i>

        Save Changes

      </button>

      <a href="<?php echo $base_url ?>/dashboard/myaccount"
        class="px-6 py-3 bg-gray-500/20 text-gray-300 hover:bg-gray-500/30 transition cursor-pointer">

        <i class="fa-solid fa-arrow-left mr-2"></i>

        Cancel

      </a>

    </div>

  </form>

</div>