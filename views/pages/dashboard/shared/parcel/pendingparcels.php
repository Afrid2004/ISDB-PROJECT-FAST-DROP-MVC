<?php
print_r($pendingParcelsData);
?>


<div>
    <div>
        <h2 class="text-white font-medium text-2xl mb-3">All Pending Parcels</h2>
        <div>
            <?php if ($pendingParcelsData) { ?>
                <div class="overflow-x-auto border border-gray-500/30 shadow-sm">
                    <table class="min-w-full">
                        <thead class="bg-black/30 border-b border-gray-500/30 text-white uppercase text-sm">
                            <tr>
                                <th class="px-6 py-3 text-left">#Sl</th>
                                <th class="px-6 py-3 text-left">Parcel Info</th>
                                <th class="px-6 py-3 text-left">From</th>
                                <th class="px-6 py-3 text-left">To</th>
                                <th class="px-6 py-3 text-left">Delivery Charge</th>
                                <th class="px-6 py-3 text-left">Payment Status</th>
                                <th class="px-6 py-3 text-left">Parcel Status</th>
                                <th class="px-6 py-3 text-left">Created At</th>
                                <th class="px-6 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <?php foreach ($pendingParcelsData as $key => $data) {
                                $key++;
                                $paymentClass = match ($data->payment_status) {
                                    "pending"             => "bg-yellow-500/20 text-yellow-400",
                                    "paid"                => "bg-teal-500/20 text-teal-400",
                                    "failed"              => "bg-red-500/20 text-red-400",
                                    "refunded"            => "bg-orange-500/20 text-orange-400",
                                    default              => "bg-gray-500/20 text-gray-300",
                                };

                                $parcelClass = match ($data->parcel_status) {
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

                                <tr
                                    class="border-b border-gray-500/30 last:border-b-0 bg-black/40 hover:bg-black/50 duration-150 text-white">
                                    <td class="px-6 py-4"><?php echo $key ?></td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p><?php echo $data->parcel_name; ?> [<?php echo $data->weight; ?> KG]</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p><?php echo $data->sender_district_name; ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p><?php echo $data->receiver_district_name; ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4"><?php echo $data->delivery_charge ?> TK</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-2 rounded <?php echo $paymentClass ?>">
                                            <?php echo $data->payment_status ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-2 rounded <?php echo $parcelClass ?>">
                                            <?php echo $data->parcel_status ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo date("d F Y", strtotime($data->created_at)) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            <a href="<?php echo $base_url."/dashboard/parceldetails?id=".$data->id ?>" class="viewParcelBtn px-3 flex items-center gap-1 py-2 rounded bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 active:bg-blue-500/20 cursor-pointer justify-center">
                                                <i class="fa-regular fa-eye text-xs"></i> View
                                            </a>
                                            <span class="px-3 flex items-center gap-1 py-2 rounded bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 active:bg-yellow-500/20 cursor-pointer justify-center">
                                                <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
                                            </span>
                                            <span class="px-3 flex items-center gap-1 py-2 rounded bg-red-500/20 text-red-400 hover:bg-red-500/30 active:bg-red-500/20 cursor-pointer justify-center">
                                                <i class="fa-regular fa-trash-can text-xs"></i> Delete
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>

                <div class="bg-black/40 border border-gray-500/30 text-white px-4 py-3">
                    No Pending Parcels Data found!
                </div>
            <?php } ?>
        </div>
    </div>


</div>