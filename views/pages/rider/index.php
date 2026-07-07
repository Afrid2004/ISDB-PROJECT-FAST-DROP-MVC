<?php
$alldistricts = Districts::allDistricts();
?>

<div>
  <div class="mb-5">
    <!-- breadcrumbs -->
    <div
      class="w-full h-100 bg-[url('<?php echo $base_url ?>/assets/images/hero-2-bg.webp')] bg-cover bg-center bg-fixed">
      <div class="flex items-center justify-center p-5 w-full h-full bg-black/50">
        <h1 class="text-white font-medium text-3xl flex items-center justify-center gap-2"><i
            class="fa-solid fa-angles-right text-xl"></i> home / rider</h1>
      </div>
    </div>
  </div>
  <div>
    <div class="container">
      <div class="py-5">
        <div>
          <form method="post">
            <div class="grid grid-cols-12 gap-7">

              <!-- Personal Information -->
              <div class="col-span-12">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-user text-teal-400"></i>
                  </div>
                  <div>
                    <h2 class="text-xl font-semibold text-secondary">
                      Rider Information
                    </h2>
                    <p class="text-gray text-sm">
                      Personal information
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                  <div>
                    <label for="ridername" class="block mb-2 text-gray">
                      Rider Name
                    </label>
                    <input type="text"
                      class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                      id="ridername" name="ridername" placeholder="Enter rider name" required>
                  </div>
                  <div>
                    <label for="rideremail" class="block mb-2 text-gray">
                      Rider Email
                    </label>
                    <input type="email"
                      class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                      id="rideremail" name="rideremail" placeholder="Enter rider email" required>
                  </div>
                  <div>
                    <label for="riderphone" class="block mb-2 text-gray">
                      Rider Phone
                    </label>
                    <input type="tel"
                      class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                      id="riderphone" name="riderphone" placeholder="Enter rider phone" required>
                  </div>
                  <div>
                    <label for="licenseno" class="block mb-2 text-gray">
                      License Number
                    </label>
                    <input type="text"
                      class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                      id="licenseno" name="licenseno" placeholder="Enter license number" required>
                  </div>
                </div>
              </div>

              <!-- Vehicle Information -->
              <div class="col-span-12">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-motorcycle text-teal-400"></i>
                  </div>
                  <div>
                    <h2 class="text-xl font-semibold text-secondary">
                      Vehicle Information
                    </h2>
                    <p class="text-gray text-sm">
                      Vehicle details
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                  <div>
                    <label for="vehicletype" class="block mb-2 text-gray">
                      Vehicle Type
                    </label>
                    <select name="vehicletype"
                      class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 text-secondary focus:border-teal-500 outline-none">
                      <option value="" selected disabled>Select Vehicle</option>
                      <option value="bike">Bike</option>
                      <option value="bicycle">Bicycle</option>
                      <option value="car">Car</option>
                      <option value="pickup">Pickup</option>
                      <option value="container">Container</option>
                    </select>
                  </div>
                  <div>
                    <label for="vehicleregistration" class="block mb-2 text-gray">
                      Vehicle Registration
                    </label>
                    <input type="text"
                      class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                      id="vehicleregistration" name="vehicleregistration" placeholder="Enter Vehicle Registration"
                      required>
                  </div>
                </div>
              </div>

              <!-- Service Area -->

              <div class="col-span-12">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-location-dot text-teal-400"></i>
                  </div>
                  <div>
                    <h2 class="text-xl font-semibold text-secondary">
                      Service Area
                    </h2>
                    <p class="text-gray text-sm">
                      Choose your working district
                    </p>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="senderdistrict" class="block mb-2 text-gray">
                    Sender District
                  </label>
                  <select
                    class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 text-secondary focus:border-teal-500 outline-none"
                    name="senderdistrict" id="senderdistrict" required>
                    <option value="" <?php echo empty($old['senderdistrict']) ? 'selected' : '' ?> disabled>Select
                      District
                    </option>
                    <?php if ($alldistricts) {
                      foreach ($alldistricts as $district) {
                    ?>
                        <option <?php echo (($old['senderdistrict'] ?? '') == $district->id) ? 'selected' : '' ?>
                          value="<?php echo $district->id ?>"><?php echo $district->district_name ?></option>
                    <?php }
                    } ?>
                  </select>
                </div>
                <button
                  class="px-4 py-2 bg-primary text-lg hover:bg-hover text-white duration-150 w-full cursor-pointer"
                  type="submit" name="btn_submit">Apply as Rider
                </button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>