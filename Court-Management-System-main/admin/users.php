<?php
session_start();
include "../db_connect.php";

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reservations</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-50">
    <div class="flex">
      <!--Sidebar-->
      <div class="fixed top-0 left-0 flex h-screen w-64 flex-col bg-white shadow-lg">
        <div class="flex bg-gray-200 p-3 border-black border-b">
          <img src="assets/imgs/pfp.jpg" alt="pfp" class="w-16 rounded-full border-3 border-green-300">
          <h2 class="text-2xl font-semibold text-center text-gray-700 m-auto">Admin Papi</h2>
        </div>

        <!--Links-->
        <div class="p-3 flex flex-col flex-1">
        <a href="admin_board.php" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Dashboard</a>
        <a href="reservations.php" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Reservations</a>

        <!--Dropdown-->
        <div class="dropdown mb-2">
          <button class="btn w-100 text-start dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            History
          </button>
          <ul class="dropdown-menu w-100">
            <li><a class="dropdown-item" href="accepted.php">Accepted</a></li>
            <li><a class="dropdown-item" href="denied.php">Denied</a></li>
            <li><a class="dropdown-item" href="cancelled.php">Cancelled</a></li>
          </ul>
        </div>

        <a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 bg-green-200">Users</a>
        <!--<a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Profile</a>-->
        <a href="../logout.php" class="block rounded-lg px-3 py-2 text-red-600 hover:bg-red-100 mt-auto">Logout</a>
        </div>
      </div>

      <!--Main-->
      <div class="ml-64 flex-1 bg-blue-50 p-6 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800">Users</h1>
           
        <!--Table-->
    <div class="mt-4 overflow-x-auto">
    <?php if ($result->num_rows > 0) { ?>
      <table class="min-w-full bg-white shadow-sm rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Username</th>
            <th class="px-4 py-2 text-left">Fullname</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Phone</th>
            <th class="px-4 py-2 text-left">Password</th>
            <th class="px-4 py-2 text-left">Role</th>
            <th class="px-4 py-2 text-left">Created</th>
            <th class="px-4 py-2 text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()) { ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="px-4 py-2"><?= htmlspecialchars($row["users_id"]); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row["username"]); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row["fullname"]); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row["email"]); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($row["phonenumber"]); ?></td>
              <td class="px-4 py-2">***</td>
              <td class="px-4 py-2"><?= htmlspecialchars($row["role"]); ?></td>
              <td class="px-4 py-2"><?= date("m/d/Y", strtotime($row["created_at"])); ?></td>
              <td class="px-4 py-2">
                <a href="delete_user.php?id=<?= $row['users_id']; ?>" 
                  onclick="return confirm('Are you sure you want to delete this user?');"
                  class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                  <i class="fas fa-trash-can me-1"></i>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <div class="text-center text-gray-500 mt-4">No results found.</div>
    <?php } ?>
  </div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
