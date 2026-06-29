<!-- header start -->
<header>
  <div class="fixed w-full z-10 bg-black/30 duration-300 border border-transparent" id="header">
    <div class="container">
      <div>
        <!-- destop menu and logo start -->
        <div class="flex items-center justify-between gap-5 py-3">
          <div class="w-40 md:w-50 shrink-0">
            <a href="/">
              <img id="logo" src="<?php echo $base_url ?>/assets/images/logo_white.png" alt="fast-drop"
                class="w-full" />
            </a>
          </div>

          <!-- desktop menu start-->
          <div>
            <nav>
              <div class="hidden lg:flex items-center gap-5">
                <div>
                  <ul class="flex items-center gap-5 text-lg uppercase text-white desktop-menu">
                    <li>
                      <a class="hover:text-primary" href="/">Home</a>
                    </li>
                    <li>
                      <a class="hover:text-primary" href="#">About</a>
                    </li>
                    <li>
                      <a class="hover:text-primary" href="#">Contact</a>
                    </li>
                    <li>
                      <a class="hover:text-primary" href="#">Blog</a>
                    </li>
                  </ul>
                </div>
                <div class="btn bg-primary">
                  <a href="#" class="uppercase px-4 py-2 block text-white">Tracking</a>
                </div>
              </div>
              <!-- menu bar open for mobile -->
              <div onclick="MobileMenuToggle()"
                class="lg:hidden cursor-pointer bg-primary w-8 h-8 flex items-center justify-center text-white hover:bg-hover duration-75">
                <i class="fa-solid fa-bars"></i>
              </div>
            </nav>
          </div>
          <!-- desktop menu end-->
        </div>
        <!-- destop menu and logo end -->

        <!-- mobile menu modal start -->
        <nav id="mobileMenuModal" class="opacity-0 pointer-events-none duration-150">
          <div onclick="MobileMenuToggle()"
            class="fixed bg-black/40 w-full h-screen top-0 left-0 flex justify-end items-center z-20">
            <div id="menuSidebar" onclick="event.stopPropagation()"
              class="bg-white translate-x-full w-full max-w-sm h-full overflow-y-auto p-4 duration-300">
              <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-4">
                <div class="w-40 shrink-0">
                  <a href="/">
                    <img src="<?php echo $base_url ?>/assets/images/logo_black.png" alt="fast-drop" class="w-full" />
                  </a>
                </div>
                <div onclick="MobileMenuToggle()"
                  class="lg:hidden cursor-pointer bg-primary w-8 h-8 flex items-center justify-center text-white hover:bg-hover duration-75">
                  <i class="fa-solid fa-xmark"></i>
                </div>
              </div>

              <!-- menus -->
              <div>
                <ul class="flex flex-col gap-3 uppercase mb-3 mobile-menu">
                  <li>
                    <a href="/"
                      class="bg-gray-200/70 block py-2 px-4 hover:bg-primary hover:text-white duration-150">Home</a>
                  </li>
                  <li>
                    <a href="#"
                      class="bg-gray-200/70 block py-2 px-4 hover:bg-primary hover:text-white duration-150">About</a>
                  </li>
                  <li>
                    <a href="#"
                      class="bg-gray-200/70 block py-2 px-4 hover:bg-primary hover:text-white duration-150">Contact</a>
                  </li>
                  <li>
                    <a href="#"
                      class="bg-gray-200/70 block py-2 px-4 hover:bg-primary hover:text-white duration-150">Blog</a>
                  </li>
                </ul>
                <div class="btn bg-primary">
                  <a href="#" class="uppercase px-4 py-2 block text-white">Tracking</a>
                </div>
              </div>
              <!-- menus -->
            </div>
          </div>
        </nav>
        <!-- mobile menu modal end -->
      </div>
    </div>
  </div>
</header>
<!-- header end -->

<!-- main body start -->
<main>