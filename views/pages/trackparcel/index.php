<?php
echo "<pre>";
print_r($data);
echo "</pre>";
echo "track parcel page";

?>
<div class="bg-gradient-to-r from-primary to-hover py-20">

  <div class="max-w-7xl mx-auto px-5 text-center">

    <h1 class="text-4xl md:text-5xl font-bold text-white">

      Track Your Parcel

    </h1>

    <p class="mt-4 text-lg text-white/90 max-w-2xl mx-auto">

      Stay updated with your shipment's journey.
      Enter your tracking ID below to view the latest
      delivery status and shipment timeline.

    </p>

  </div>

</div>


<div class="py-16 bg-gray-50 min-h-screen">
  <div class="container">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
      <h2 class="text-2xl font-semibold text-secondary mb-2">
        Track Shipment
      </h2>

      <p class="text-gray mb-6">
        Enter your tracking ID to view parcel details.
      </p>

      <form action="" method="GET">
        <div class="flex flex-col lg:flex-row gap-4">
          <input type="text" value="<?php echo $_GET['id'] ?? "" ?>" name="id"
            placeholder="Enter Tracking ID (Example: FD-260714344243)"
            class="w-full border border-gray-300 rounded-xl px-5 py-4 outline-none focus:border-primary transition duration-200 text-secondary">
          <button type="submit"
            class="cursor-pointer bg-primary hover:bg-hover transition duration-300 text-white px-8 rounded-xl font-medium flex justify-center items-center gap-2 shrink-0 py-4">
            <i class="fa-solid fa-location-dot"></i>
            Track Parcel
          </button>
        </div>
      </form>
    </div>

    <!-- ========================= -->
    <!-- Parcel Summary Card -->
    <!-- ========================= -->

    <div class="mt-10 bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
      <div class="flex flex-col lg:flex-row justify-between gap-10">
        <!-- Left -->
        <div class="space-y-3">
          <span
            class="inline-flex items-center gap-2 <?php echo Tracking::statusClass($data[0]->parcel_status) ?> px-4 py-2 rounded-full text-sm">
            <i class="fa-solid <?php
                                echo Tracking::statusIcon($data[0]->parcel_status);
                                ?>"></i>
            <?php
            echo Tracking::statusText($data[0]->parcel_status);
            ?>
          </span>
          <h2 class="text-3xl font-bold text-secondary">
            <?php echo $data[0]->parcel_name ?>
          </h2>

          <p class="text-gray">
            Tracking ID :
            <span class="font-semibold text-secondary">
              <?php echo $data[0]->tracking_id ?>
            </span>
          </p>

          <p class="text-gray">
            Parcel Type :
            <span class="text-secondary font-medium">
              <?php echo ucfirst($data[0]->parcel_type) ?>
            </span>
          </p>
        </div>

        <!-- Right -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
          <div>
            <p class="text-gray text-sm">
              Sender
            </p>
            <h4 class="font-semibold text-secondary mt-1">
              <?php echo ucfirst($data[0]->sender_district_name) ?>
            </h4>
          </div>
          <div>
            <p class="text-gray text-sm">
              Receiver
            </p>
            <h4 class="font-semibold text-secondary mt-1">
              <?php echo ucfirst($data[0]->receiver_district_name) ?>
            </h4>
          </div>
          <div>
            <p class="text-gray text-sm">
              Weight
            </p>
            <h4 class="font-semibold text-secondary mt-1">
              <?php echo $data[0]->weight ?> KG
            </h4>
          </div>
          <div>

            <p class="text-gray text-sm">

              Delivery Charge

            </p>

            <h4 class="font-semibold text-secondary mt-1">

              <?php echo $data[0]->delivery_charge ?> TK

            </h4>

          </div>

          <div>

            <p class="text-gray text-sm">

              Payment

            </p>

            <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-600 font-medium mt-1">

              <?php echo ucfirst($data[0]->payment_status) ?>

            </span>

          </div>

          <div>

            <p class="text-gray text-sm">

              Current Status

            </p>

            <span class="inline-flex px-3 py-1 rounded-full bg-primary/10 text-primary font-medium mt-1">

              <?php
              echo ucfirst(str_replace("_", " ", $data[0]->parcel_status));
              ?>

            </span>

          </div>

        </div>

      </div>

    </div>

    <!-- ========================= -->
    <!-- Shipment Timeline -->
    <!-- ========================= -->

    <div class="mt-10 bg-white rounded-2xl shadow-lg border border-gray-200 p-8">

      <div class="mb-10">

        <h2 class="text-3xl font-bold text-secondary">

          Shipment Timeline

        </h2>

        <p class="text-gray mt-2">

          Track every stage of your parcel delivery.

        </p>

      </div>

      <div class="relative">

        <!-- Vertical Line -->

        <div class="absolute left-6 top-0 h-full w-1 bg-primary/20 rounded-full">
        </div>

        <?php if ($data): ?>
        <?php foreach ($data as $value): ?>
        <!-- Timeline Item -->
        <div class="relative flex gap-6 pb-10">

          <div
            class="relative z-10 w-12 h-12 rounded-full flex <?php echo Tracking::statusClass($value->tracking_status) ?> items-center justify-center shadow-lg">

            <i class="fa-solid <?php echo Tracking::statusIcon($value->tracking_status) ?>"></i>

          </div>

          <div class="flex-1 bg-gray-50 border border-gray-200 rounded-xl p-6">
            <div class="flex justify-between flex-col lg:flex-row gap-4">
              <div>
                <h3 class="text-lg font-semibold text-secondary">
                  <?php echo Tracking::statusText($value->tracking_status) ?>
                </h3>
                <p class="text-gray mt-2">
                  <?php echo $value->details ?>
                </p>
              </div>

              <div class="text-right">

                <p class="text-primary font-semibold text-xl">

                  <?php echo $value->current_location ?>

                </p>

                <p class="text-gray">

                  <?php echo date("d F Y", strtotime($value->tracking_time)) . " • " . date("h:i A", strtotime($value->tracking_time)) ?>

                </p>

              </div>

            </div>

          </div>

        </div>
        <?php endforeach;
        endif; ?>

      </div>

    </div>

  </div>

</div>