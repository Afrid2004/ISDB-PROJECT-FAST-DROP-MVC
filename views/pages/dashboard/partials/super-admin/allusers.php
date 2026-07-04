<div>
  <div>
    <h2 class="text-white font-medium text-2xl mb-3">All Users</h2>
    <div>
      <?php if ($allUserdata) { ?>
      <div class="overflow-x-auto border border-gray-500/30 shadow-sm">
        <table class="min-w-full">
          <thead class="bg-black/30 border-b border-gray-500/30 text-white uppercase text-sm">
            <tr>
              <th class="px-6 py-3 text-left">#Sl</th>
              <th class="px-6 py-3 text-left">Name</th>
              <th class="px-6 py-3 text-left">Email</th>
              <th class="px-6 py-3 text-left">Role</th>
              <th class="px-6 py-3 text-left">Created At</th>
            </tr>
          </thead>
          <tbody class="text-gray-700 text-sm">
            <?php foreach ($allUserdata as $key => $data) {
                $key++;
                $name = $data->name;
                $photo = $data->photo_url;
                // role design dynamic 
                $role = $data->rolename;
                $roleClass = match ($role) {
                  "super_admin" => "bg-red-500/20 text-red-400",
                  "admin"       => "bg-blue-500/20 text-blue-400",
                  "rider"       => "bg-yellow-500/20 text-yellow-400",
                  "user"        => "bg-green-500/20 text-green-400",
                  default       => "bg-gray-500/20 text-gray-300",
                };
              ?>

            <tr
              class="border-b border-gray-500/30 last:border-b-0 bg-black/25 hover:bg-black/40 duration-150 text-white">
              <td class="px-6 py-4"><?php echo $key ?></td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                  <div
                    class="w-10 h-10 flex items-center justify-center rounded-full border boreder-gray-500/50 overflow-hidden shrink-0">
                    <?php echo avatar($name, $photo); ?>
                  </div>
                  <div>
                    <h2 class="text-white"><?php echo "{$data->name}" ?></h2>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4"><?php echo "{$data->email}" ?></td>
              <td class="px-6 py-4">
                <span class="px-2 py-1 rounded <?php echo $roleClass ?>">
                  <?php echo implode(" ", explode("_", $data->rolename)) ?>
                </span>
              </td>
              <td class="px-6 py-4">
                <?php echo date("d F Y", strtotime($data->created_at)) ?>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>

      <div class="bg-black/20 border border-gray-500/50 shadow-sm text-white">
        No Data found!
      </div>
      <?php } ?>
    </div>
  </div>
</div>