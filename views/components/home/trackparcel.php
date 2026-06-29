<!-- track parcel section start -->
<section>
  <div
    class="w-full h-120 bg-[url('<?php echo $base_url ?>/assets/images/bg-track.webp')] bg-cover bg-center bg-fixed overflow-hidden">
    <div class="container h-full">
      <div class="flex items-center justify-center lg:justify-end w-full h-full">
        <div
          class="w-full max-w-xl bg-white/10 backdrop-blur-xl border border-white/10 lg:border-none lg:bg-white/0 lg:backdrop-blur-none p-5 trackingSection translate-y-10 opacity-0 [&.scroll-tracking]:translate-y-0 [&.scroll-tracking]:opacity-100 duration-500 delay-150">
          <h4 class="text-amber-400 text-2xl mb-3">We are Logistics</h4>
          <h2 class="text-white roboto font-bold text-4xl lg:text-5xl leadeing-0 md:leading-15 mb-5">
            Delivering Trust, One Shipment at a Time
          </h2>
          <p class="text-white text-lg mb-5">
            Fast, secure, and reliable courier solutions connecting your
            business to every destination.
          </p>
          <div>
            <form>
              <div class="flex items-center h-13 w-full">
                <input type="text" name="trackingId"
                  class="w-full bg-white h-full px-4 outline-none border-none text-lg" id="trackingId"
                  placeholder="Enter your tracking id..." required />
                <button type="submit" name="btn_track"
                  class="uppercase cursor-pointer text-white bg-primary hover:bg-hover active:bg-primary flex gap-2 items-center justify-center px-4 h-full shrink-0 text-lg">
                  Track
                  <i class="fa-solid fa-location-crosshairs"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- track parcel section end -->