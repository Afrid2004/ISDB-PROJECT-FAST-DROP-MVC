<?php
$alldistricts = Districts::allDistricts();
$old = $_SESSION['old'] ?? [];
$parcel = $parcelData;
?>

<div>
    <h2 class="text-white font-medium text-2xl mb-3">Edit Parcel</h2>
    <form method="post" action="<?php echo $base_url ?>/parcel/update">
        <!-- get parcel id -->
        <input type="hidden" name="parcel_id" value="<?php echo $parcel->id ?>">
        <!-- Error Messages -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="mb-4 rounded-md border border-red-500/30 bg-red-500/30 px-4 py-3 text-white">
                <div class="flex items-start gap-2">
                    <i class="fa-solid fa-circle-xmark mt-1"></i>
                    <ul class="list-none space-y-1">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php
            unset($_SESSION['errors']);
        endif;
        ?>
        <!-- success message show  -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-4 rounded-md border border-lime-500/30 bg-lime-500/30 px-4 py-3 text-white">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo $_SESSION['success']; ?></span>
                </div>
            </div>
        <?php
            unset($_SESSION['success']);
        endif; ?>
        <div class="grid grid-cols-12 gap-5 mb-3">
            <!-- parcel info  -->
            <div class="col-span-12">
                <div>
                    <div class="flex items-center gap-3 mb-6 ">
                        <div class="w-11 h-11 rounded-lg bg-teal-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-box-archive text-teal-400"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-white">
                                Parcel Information
                            </h2>
                            <p class="text-gray-300 text-sm">
                                Type of parcel
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <div class="mb-2 text-gray-300">
                                <p>Parcel Type</p>
                            </div>
                            <div class="flex gap-3 flex-wrap md:flex-nowrap">
                                <label for="document"
                                    class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-700/70 text-white-600  bg-black/40  hover:bg-black/70 has-checked:text-white has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer text-white">
                                    <input id="document" <?php echo ($old['parceltype'] ?? $parcel->parcel_type) === 'document' ? 'checked' : '' ?>
                                        class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-transparent checked:bg-white  bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500"
                                        type="radio" value="document" name="parceltype" />
                                    Document
                                </label>
                                <label for="fragile"
                                    class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-700/70 text-white-600  bg-black/40  hover:bg-black/70 has-checked:text-white has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer text-white">
                                    <input id="fragile" <?php echo ($old['parceltype'] ?? $parcel->parcel_type) === 'fragile' ? 'checked' : '' ?>
                                        class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-transparent checked:bg-white  bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500" type="radio" value="fragile"
                                        name="parceltype" />
                                    Fragile
                                </label>
                                <label for="electronics"
                                    class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-700/70 text-white-600  bg-black/40  hover:bg-black/70 has-checked:text-white has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer text-white">
                                    <input id="electronics"
                                        <?php echo ($old['parceltype'] ?? $parcel->parcel_type) === 'electronics' ? 'checked' : '' ?>
                                        class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-transparent checked:bg-white  bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500"
                                        type="radio" value="electronics" name="parceltype" />
                                    Electronics
                                </label>
                                <label for="others"
                                    class="flex duration-150 transition-all md:justify-between items-center gap-3 rounded-sm px-2.5 h-10 ring-1 ring-gray-700/70 text-white-600  bg-black/40  hover:bg-black/70 has-checked:text-white has-checked:ring-teal-500 shrink-0 w-full md:w-fit cursor-pointer text-white">
                                    <input <?php echo ($old['parceltype'] ?? $parcel->parcel_type) === 'others' ? 'checked' : '' ?> id="others"
                                        class="box-content h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-transparent checked:bg-white  bg-clip-padding ring-1 ring-teal-950/20 duration-150 transition-all outline-none checked:border-teal-500 checked:ring-teal-500"
                                        type="radio" value="others" name="parceltype" />
                                    Others
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center gap-5 w-full flex-wrap md:flex-nowrap">
                            <div class="w-full">
                                <label for="parcelname" class="block mb-2 text-gray-300">
                                    Parcel Name
                                </label>
                                <input value="<?php echo $old['parcelname'] ?? $parcel->parcel_name ?>" type="text"
                                    class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                    id="parcelname" name="parcelname" placeholder="Enter parcel name" required>
                            </div>
                            <div class="w-full">
                                <label for="parcelweight" class="block mb-2 text-gray-300">
                                    Parcel Weight (KG)
                                </label>
                                <input value="<?php echo $old['parcelweight'] ?? $parcel->weight ?>" type="number"
                                    class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
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
                            <h2 class="text-xl font-semibold text-white">
                                Sender Information
                            </h2>
                            <p class="text-gray-300 text-sm">
                                Pickup information
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="sendername" class="block mb-2 text-gray-300">
                                Sender Name
                            </label>
                            <input value="<?php echo  $old['sendername'] ?? $parcel->sender_name ?>" type="text"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="sendername" name="sendername" placeholder="Enter sender name" required>
                        </div>
                        <div class="mb-3">
                            <label for="senderphone" class="block mb-2 text-gray-300">
                                Sender Phone
                            </label>
                            <input value="<?php echo $old['senderphone'] ??  $parcel->sender_phone ?>" type="tel"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="senderphone" name="senderphone" placeholder="Enter sender phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="senderemail" class="block mb-2 text-gray-300">
                                Sender Email
                            </label>
                            <input value="<?php echo $old['senderemail'] ??  $parcel->sender_email ?>" type="email"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="senderemail" name="senderemail" placeholder="Enter sender email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senderaddress" class="block mb-2 text-gray-300">
                                Sender Address
                            </label>
                            <input value="<?php echo $old['senderaddress'] ?? $parcel->sender_address ?>" type="text"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="senderaddress" name="senderaddress" placeholder="Enter sender address" required>
                        </div>
                        <div class="mb-3">
                            <label for="senderdistrict" class="block mb-2 text-gray-300">
                                Sender District
                            </label>
                            <select
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 text-white focus:border-teal-500 outline-none"
                                name="senderdistrict" id="senderdistrict" required>
                                <option value="" <?php echo empty($old['senderdistrict'] || $parcel->sender_district_id) ? 'selected' : '' ?> disabled>Select
                                    District
                                </option>
                                <?php if ($alldistricts) {
                                    foreach ($alldistricts as $district) {
                                ?>
                                        <option <?php echo (($old['senderdistrict'] ?? $parcel->sender_district_id) == $district->id) ? 'selected' : '' ?>
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
                            <h2 class="text-xl font-semibold text-white">
                                Receiver Information
                            </h2>
                            <p class="text-white text-sm">
                                Delivery destination
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="receivername" class="block mb-2 text-white">
                                Receiver Name
                            </label>
                            <input value="<?php echo $old['receivername'] ?? $parcel->receiver_name ?>" type="text"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="receivername" name="receivername" placeholder="Enter receiver name" required>
                        </div>
                        <div class="mb-3">
                            <label for="receiverphone" class="block mb-2 text-white">
                                Receiver Phone
                            </label>
                            <input value="<?php echo $old['receiverphone'] ?? $parcel->receiver_phone  ?>" type="tel"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="receiverphone" name="receiverphone" placeholder="Enter receiver phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="receiveremail" class="block mb-2 text-white">
                                Receiver Email
                            </label>
                            <input value="<?php echo $old['receiveremail'] ?? $parcel->receiver_email  ?>" type="email"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="receiveremail" name="receiveremail" placeholder="Enter receiver email" required>
                        </div>
                        <div class="mb-3">
                            <label for="receiveraddress" class="block mb-2 text-white">
                                Receiver Address
                            </label>
                            <input value="<?php echo $old['receiveraddress'] ?? $parcel->receiver_address  ?>" type="text"
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"
                                id="receiveraddress" name="receiveraddress" placeholder="Enter receiver address" required>
                        </div>
                        <div class="mb-3">
                            <label for="receiverdistrict" class="block mb-2 text-white">
                                Receiver District
                            </label>
                            <select
                                class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 text-white focus:border-teal-500 outline-none"
                                name="receiverdistrict" id="receiverdistrict" required>
                                <option value="" <?php echo empty($old['receiverdistrict'] || $parcel->receiver_district_id) ? 'selected' : '' ?> disabled>Select
                                    District</option>
                                <?php if ($alldistricts) {
                                    foreach ($alldistricts as $district) {
                                ?>
                                        <option <?php echo (($old['receiverdistrict'] ?? $parcel->receiver_district_id) == $district->id) ? 'selected' : '' ?>
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
                <label for="parcelnote" class="block mb-2 text-white">
                    Note:
                </label>
                <textarea name="parcelnote" id="parcelnote"
                    class="w-full border bg-black/40  border-gray/30 rounded-sm px-4 py-3 outline-none text-white focus:border-teal-500"><?php echo ($old['parcelnote'] ?? $parcel->note) ?></textarea>
            </div>
        </div>
        <div>
            <button class="px-4 py-2 bg-primary text-lg hover:bg-hover text-white duration-150 w-full cursor-pointer"
                type="submit" name="btn_submit">Update Parcel
            </button>
        </div>
    </form>
</div>