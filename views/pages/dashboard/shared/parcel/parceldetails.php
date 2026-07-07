<?php

$paymentClass = match ($parcelData->payment_status) {
    "pending"   => "bg-yellow-500/20 text-yellow-400",
    "paid"      => "bg-teal-500/20 text-teal-400",
    "failed"    => "bg-red-500/20 text-red-400",
    "refunded"  => "bg-orange-500/20 text-orange-400",
    default     => "bg-gray-500/20 text-gray-300",
};

$parcelClass = match ($parcelData->parcel_status) {
    "pending"     => "bg-yellow-500/20 text-yellow-400",
    "assigned"    => "bg-blue-500/20 text-blue-400",
    "picked_up"   => "bg-cyan-500/20 text-cyan-400",
    "in_transit"  => "bg-purple-500/20 text-purple-400",
    "delivered"   => "bg-green-500/20 text-green-400",
    "cancelled"   => "bg-red-500/20 text-red-400",
    "returned"    => "bg-orange-500/20 text-orange-400",
    default       => "bg-gray-500/20 text-gray-300",
};

?>

<div>
    <div class="grid grid-cols-12 gap-5">
        <!-- Parcel Information -->
        <div class="col-span-12 lg:col-span-6">
            <div class="text-center px-4 py-3 bg-black/40 mb-3 border border-gray-500/30">
                <h2 class="text-2xl font-medium text-white">
                    <i class="fa-solid fa-box-archive text-xl text-teal-400"></i>
                    Parcel Information
                </h2>
            </div>

            <div class="flex flex-col gap-2">
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30">
                    <p class="text-white text-lg">
                        Tracking ID :
                        <span class="font-semibold"><?php echo $parcelData->tracking_id ?></span>
                    </p>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30">
                    <p class="text-white text-lg">
                        Parcel Name :
                        <?php echo $parcelData->parcel_name ?>
                    </p>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30">
                    <p class="text-white text-lg">
                        Parcel Type :
                        <?php echo ucfirst($parcelData->parcel_type) ?>
                    </p>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30">
                    <p class="text-white text-lg">
                        Weight :
                        <?php echo $parcelData->weight ?> KG
                    </p>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="col-span-12 lg:col-span-6">
            <div class="text-center px-4 py-3 bg-black/40 mb-3 border border-gray-500/30">
                <h2 class="text-white text-2xl font-medium">
                    <i class="fa-solid fa-truck text-xl text-teal-400"></i>
                    Delivery Information
                </h2>
            </div>
            <div class="flex flex-col gap-2">
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 flex justify-between items-center">
                    <p class="text-white text-lg">
                        Delivery Charge
                    </p>
                    <span class="text-white font-semibold">
                        TK <?php echo $parcelData->delivery_charge ?>
                    </span>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 flex justify-between items-center">
                    <p class="text-white text-lg">
                        Payment Status
                    </p>
                    <span class="px-3 py-1 rounded text-sm <?php echo $paymentClass ?>">
                        <?php echo ucfirst($parcelData->payment_status) ?>
                    </span>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 flex justify-between items-center">
                    <p class="text-white text-lg">
                        Parcel Status
                    </p>
                    <span class="px-3 py-1 rounded text-sm <?php echo $parcelClass ?>">
                        <?php echo ucfirst(str_replace("_", " ", $parcelData->parcel_status)) ?>
                    </span>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30">
                    <p class="text-white text-lg">
                        Created :
                        <?php echo date("d F Y h:i A", strtotime($parcelData->created_at)) ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sender Information -->
        <div class="col-span-12 lg:col-span-6">
            <div class="text-center px-4 py-3 bg-black/40 mb-3 border border-gray-500/30">
                <h2 class="text-white text-2xl font-medium">
                    <i class="fa-solid fa-user text-xl text-teal-400"></i>
                    Sender Information
                </h2>
            </div>
            <div class="flex flex-col gap-2">
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Name : <?php echo $parcelData->sender_name ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Phone : <?php echo $parcelData->sender_phone ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Email : <?php echo $parcelData->sender_email ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    District : <?php echo $parcelData->sender_district_name ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Address : <?php echo $parcelData->sender_address ?>
                </div>
            </div>
        </div>

        <!-- Receiver Information -->
        <div class="col-span-12 lg:col-span-6">
            <div class="text-center px-4 py-3 bg-black/40 mb-3 border border-gray-500/30">
                <h2 class="text-white text-2xl font-medium">
                    <i class="fa-solid fa-location-dot text-xl text-teal-400"></i>
                    Receiver Information
                </h2>
            </div>
            <div class="flex flex-col gap-2">
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Name : <?php echo $parcelData->receiver_name ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Phone : <?php echo $parcelData->receiver_phone ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Email : <?php echo $parcelData->receiver_email ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    District : <?php echo $parcelData->receiver_district_name ?>
                </div>
                <div class="bg-black/30 px-4 py-2 border border-gray-500/30 text-white text-lg">
                    Address : <?php echo $parcelData->receiver_address ?>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="col-span-12 lg:col-span-6">
            <div class="text-center px-4 py-3 bg-black/40 mb-3 border border-gray-500/30">
                <h2 class="text-white text-2xl font-medium">
                    <i class="fa-solid fa-note-sticky text-xl text-teal-400"></i>
                    Additional Information
                </h2>
            </div>
            <div class="bg-black/30 p-4 border border-gray-500/30 text-white text-lg">
                <?php echo $parcelData->note ? $parcelData->note : "No additional note."; ?>
            </div>
        </div>

        <!-- Rider Information -->
        <div class="col-span-12 lg:col-span-6">
            <div class="text-center px-4 py-3 bg-black/40 mb-3 border border-gray-500/30">
                <h2 class="text-white text-2xl font-medium">
                    <i class="fa-solid fa-motorcycle text-xl text-teal-400"></i>
                    Rider Information
                </h2>
            </div>
            <div class="bg-black/30 p-4 border border-gray-500/30 text-white text-lg">
                <?php
                    if ($parcelData->assigned_rider_id) {
                        echo "Assigned Rider ID : " . $parcelData->assigned_rider_id;
                    } else {
                        echo "No rider assigned yet.";
                    }
                ?>
            </div>
        </div>
    </div>
</div>