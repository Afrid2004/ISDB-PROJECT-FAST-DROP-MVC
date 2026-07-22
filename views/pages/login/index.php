<?php
if (isset($_SESSION['user']['email'])) {
  redirect();
  exit;
}
?>

<div>
  <div
    class="flex items-center justify-center bg-[linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url('<?php echo $base_url ?>/assets/images/auth-bg.jpg')] bg-cover bg-center min-h-screen p-5">
    <div class="bg-white rounded-xl shadow-sm p-5 w-full max-w-3xl">
      <div class="grid grid-cols-12 gap-3">
        <div class="col-span-12 sm:col-span-6">
          <div>
            <div class="mb-3">
              <h1 class="roboto text-4xl font-bold text-secondary mb-3">Login</h1>
              <p class="flex items-center gap-1">Don't have an account? <a class="underline-text text-hover font-medium"
                  href="<?php echo $base_url ?>/register">Create now</a></p>
            </div>
            <div>
              <form method="post" action="<?php echo $base_url ?>/login/authenticate">
                <?php if (isset($_SESSION['error'])): ?>
                  <div class="mb-4 rounded bg-red-100 border border-red-300 text-red-700 px-4 py-2">
                    <?php
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                    ?>
                  </div>
                <?php endif ?>
                <div class="mb-3">
                  <label for="email">
                    <div class="mb-1 cursor-pointer w-fit">Email</div>
                  </label>
                  <div class="bg-gray-200/50 relative px-3 py-1.5 group">
                    <input value="<?php echo $_SESSION['old']['email'] ?? "" ?>"
                      class="outline-none border-none w-full bg-transparent" id="email" type="email" name="email"
                      placeholder="you@example.com">
                    <div
                      class="absolute left-0 bottom-0 h-0.5 bg-primary w-full scale-x-[0]  duration-300 group-focus-within:scale-x-[1] z-1">
                    </div>
                    <div class="absolute left-0 bottom-0 h-0.5 bg-gray-300/70 w-full"></div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="password">
                    <div class="mb-1 cursor-pointer w-fit">Password</div>
                  </label>
                  <div class="bg-gray-200/50 relative px-3 py-1.5 group">
                    <div class="flex items-center gap-1">
                      <input class="outline-none border-none w-full bg-transparent" id="password" type="password"
                        name="password" placeholder="••••••••">
                      <div>
                        <i class="fa-regular fa-eye text-gray cursor-pointer showpassIcon"></i>
                      </div>
                    </div>
                    <div
                      class="absolute left-0 bottom-0 h-0.5 bg-primary w-full scale-x-[0]  duration-300 group-focus-within:scale-x-[1] z-1">
                    </div>
                    <div class="absolute left-0 bottom-0 h-0.5 bg-gray-300/70 w-full"></div>
                  </div>
                </div>
                <!-- Remember Me -->
                <div class="mb-3 flex items-center gap-2">
                  <input id="remember" type="checkbox" name="remember" value="1">
                  <label for="remember" class="cursor-pointer">
                    Remember Me
                  </label>
                </div>
                <div>
                  <button
                    class="w-full py-1.5 bg-primary cursor-pointer text-white hover:bg-hover border-b-3 border-teal-600 duration-150"
                    type="submit" name="btn_submit"> Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-span-12 sm:col-span-6 w-full h-full overflow-hidden rounded-xl hidden sm:flex">
          <img loading="lazy" src="<?php echo $base_url ?>/assets/images/auth-bg.jpg" alt="ship"
            class="w-full h-full object-cover hover:scale-[1.1] duration-300">
        </div>
      </div>
    </div>
  </div>
</div>