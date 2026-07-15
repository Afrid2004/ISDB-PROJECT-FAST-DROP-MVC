<?php
$alldistricts = Districts::allDistricts();
$old = $_SESSION['old'] ?? [];
?>

<div>
  <div class="mb-5">
    <!-- breadcrumbs -->
    <div
      class="w-full h-100 bg-[url('<?php echo $base_url ?>/assets/images/hero-1-bg.webp')] bg-cover bg-center bg-fixed">
      <div class="flex items-center justify-center p-5 w-full h-full bg-black/50">
        <h1 class="text-white font-medium text-3xl flex items-center justify-center gap-2"><i
            class="fa-solid fa-angles-right text-xl"></i> home / parcel</h1>
      </div>
    </div>
  </div>
  <div>
    <div class="container">
      <div class="py-5">
        <div>
          <form method="post" action="<?php echo $base_url ?>/parcel/submit">
            <!-- Error Messages -->
            <?php if (!empty($_SESSION['errors'])): ?>
              <div class="mb-4 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                  <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($_SESSION['success'])): ?>
              <div class="mb-4 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-700">
                <?php echo $_SESSION['success'];  ?>
              </div>
              <?php unset($_SESSION['success']); ?>
            <?php endif; ?>


            <div class="grid grid-cols-12 gap-5 mb-3">
              <!-- parcel info  -->
              <div class="col-span-12">
                <div>
                  <div class="flex items-center gap-3 mb-6 ">
                    <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                      <i class="fa-solid fa-box-archive text-teal-400"></i>
                    </div>
                    <div>
                      <h2 class="text-xl font-semibold text-secondary">
                        Parcel Information
                      </h2>
                      <p class="text-gray text-sm">
                        Type of parcel
                      </p>
                    </div>
                  </div>
                  <div>
                    <div class="mb-3">
                      <div class="mb-2 text-gray">
                        <p>Parcel Type</p>
                      </div>
                      <div class="flex gap-3 flex-wrap md:flex-nowrap">
                        <label for="document"
                          class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-300/70 text-gray-600  bg-white hover:bg-teal-50 has-checked:text-teal-500 has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer">
                          <input id="document" <?php echo $old['parceltype'] ?? '' === 'document' ? 'checked' : '' ?>
                            class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-white bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500"
                            type="radio" value="document" name="parceltype" />
                          Document
                        </label>
                        <label for="fragile"
                          class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-300/70 text-gray-600  bg-white hover:bg-teal-50 has-checked:text-teal-500 has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer">
                          <input id="fragile" <?php echo $old['parceltype'] ?? '' === 'fragile' ? 'checked' : '' ?>
                            class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-white
                          bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none
                          checked:border-teal-500 checked:ring-teal-500" type="radio" value="fragile"
                            name="parceltype" />
                          Fragile
                        </label>
                        <label for="electronics"
                          class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-300/70 text-gray-600  bg-white hover:bg-teal-50 has-checked:text-teal-500 has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer">
                          <input id="electronics"
                            <?php echo $old['parceltype'] ?? '' === 'electronics' ? 'checked' : '' ?>
                            class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-white bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500"
                            type="radio" value="electronics" name="parceltype" />
                          Electronics
                        </label>
                        <label for="others"
                          class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-300/70 text-gray-600  bg-white hover:bg-teal-50 has-checked:text-teal-500 has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer">
                          <input <?php echo $old['parceltype'] ?? '' === 'others' ? 'checked' : '' ?> id="others"
                            class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-white bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500"
                            type="radio" value="others" name="parceltype" />
                          Others
                        </label>
                      </div>
                    </div>
                    <div class="flex items-center gap-5 w-full flex-wrap md:flex-nowrap">
                      <div class="w-full">
                        <label for="parcelname" class="block mb-2 text-gray">
                          Parcel Name
                        </label>
                        <input value="<?php echo $old['parcelname'] ?? '' ?>" type="text"
                          class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                          id="parcelname" name="parcelname" placeholder="Enter parcel name" required>
                      </div>
                      <div class="w-full">
                        <label for="parcelweight" class="block mb-2 text-gray">
                          Parcel Weight (KG)
                        </label>
                        <input value="<?php echo $old['parcelweight'] ?? '' ?>" type="number"
                          class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                          id="parcelweight" name="parcelweight" placeholder="Enter parcel weight" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- sender info  -->
              <div class="col-span-12 lg:col-span-6">
                <div>
                  <div class="flex items-center gap-3 mb-6">
                    <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                      <i class="fa-solid fa-user text-teal-400"></i>
                    </div>
                    <div>
                      <h2 class="text-xl font-semibold text-secondary">
                        Sender Information
                      </h2>
                      <p class="text-gray text-sm">
                        Pickup information
                      </p>
                    </div>
                  </div>
                  <div>
                    <div class="mb-3">
                      <label for="sendername" class="block mb-2 text-gray">
                        Sender Name
                      </label>
                      <input value="<?php echo  $old['sendername'] ?? '' ?>" type="text"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="sendername" name="sendername" placeholder="Enter sender name" required>
                    </div>
                    <div class="mb-3">
                      <label for="senderphone" class="block mb-2 text-gray">
                        Sender Phone
                      </label>
                      <input value="<?php echo $old['senderphone'] ?? '' ?>" type="tel"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="senderphone" name="senderphone" placeholder="Enter sender phone" required>
                    </div>
                    <div class="mb-3">
                      <label for="senderemail" class="block mb-2 text-gray">
                        Sender Email
                      </label>
                      <input value="<?php echo $old['senderemail'] ?? '' ?>" type="email"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="senderemail" name="senderemail" placeholder="Enter sender email" required>
                    </div>
                    <div class="mb-3">
                      <label for="senderaddress" class="block mb-2 text-gray">
                        Sender Address
                      </label>
                      <input value="<?php echo $old['senderaddress'] ?? '' ?>" type="text"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="senderaddress" name="senderaddress" placeholder="Enter sender address" required>
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
                  </div>
                </div>
              </div>

              <!-- Receiver info  -->
              <div class="col-span-12 lg:col-span-6">
                <div>
                  <div class="flex items-center gap-3 mb-6">
                    <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                      <i class="fa-solid fa-location-dot text-teal-400"></i>
                    </div>
                    <div>
                      <h2 class="text-xl font-semibold text-secondary">
                        Receiver Information
                      </h2>
                      <p class="text-gray text-sm">
                        Delivery destination
                      </p>
                    </div>
                  </div>
                  <div>
                    <div class="mb-3">
                      <label for="receivername" class="block mb-2 text-gray">
                        Receiver Name
                      </label>
                      <input value="<?php echo $old['receivername'] ?? '' ?>" type="text"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="receivername" name="receivername" placeholder="Enter receiver name" required>
                    </div>
                    <div class="mb-3">
                      <label for="receiverphone" class="block mb-2 text-gray">
                        Receiver Phone
                      </label>
                      <input value="<?php echo $old['receiverphone'] ?? ''  ?>" type="tel"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="receiverphone" name="receiverphone" placeholder="Enter receiver phone" required>
                    </div>
                    <div class="mb-3">
                      <label for="receiveremail" class="block mb-2 text-gray">
                        Receiver Email
                      </label>
                      <input value="<?php echo $old['receiveremail'] ?? ''  ?>" type="email"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="receiveremail" name="receiveremail" placeholder="Enter receiver email" required>
                    </div>
                    <div class="mb-3">
                      <label for="receiveraddress" class="block mb-2 text-gray">
                        Receiver Address
                      </label>
                      <input value="<?php echo $old['receiveraddress'] ?? ''  ?>" type="text"
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"
                        id="receiveraddress" name="receiveraddress" placeholder="Enter receiver address" required>
                    </div>
                    <div class="mb-3">
                      <label for="receiverdistrict" class="block mb-2 text-gray">
                        Receiver District
                      </label>
                      <select
                        class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 text-secondary focus:border-teal-500 outline-none"
                        name="receiverdistrict" id="receiverdistrict" required>
                        <option value="" <?php echo empty($old['receiverdistrict']) ? 'selected' : '' ?> disabled>Select
                          District</option>
                        <?php if ($alldistricts) {
                          foreach ($alldistricts as $district) {
                        ?>
                            <option <?php echo (($old['receiverdistrict'] ?? '') == $district->id) ? 'selected' : '' ?>
                              value="<?php echo $district->id ?>"><?php echo $district->district_name ?></option>
                        <?php }
                        } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <!-- note  -->
              <div class="col-span-12">
                <label for="parcelnote" class="block mb-2 text-gray">
                  Note:
                </label>
                <textarea name="parcelnote" id="parcelnote"
                  class="w-full border bg-white border-gray/30 rounded-sm px-4 py-3 outline-none text-secondary focus:border-teal-500"><?php echo ($old['parcelnote'] ?? '') ?></textarea>
              </div>
            </div>
            <div>
              <button class="px-4 py-2 bg-primary text-lg hover:bg-hover text-white duration-150 w-full cursor-pointer"
                type="submit" name="btn_submit">Create Parcel


              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>