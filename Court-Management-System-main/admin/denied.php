<?php
include "../db_connect.php";

$sql = "SELECT * FROM denied_bookings";
$result = $conn -> query($sql);
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
            <li><a class="dropdown-item hover:bg-gray-200" href="accepted.php">Accepted</a></li>
            <li><a class="dropdown-item bg-green-200" href="denied.php">Denied</a></li>
            <li><a class="dropdown-item hover:bg-gray-200" href="cancelled.php">Cancelled</a></li>
          </ul>
        </div>

        <a href="users.php" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Users</a>
        <!--<a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Profile</a>-->
        <a href="../lougout.php" class="block rounded-lg px-3 py-2 text-red-600 hover:bg-red-100 mt-auto">Logout</a>
        </div>
      </div>

      <!--Main-->
      <div class="ml-64 flex-1 bg-blue-50 p-6 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800">Denied</h1>
            
        
        <!--Table-->  
        <div class="mt-4">
  <?php
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          echo '<div class="bg-white shadow-sm rounded-lg p-4 mb-4 sm:table sm:table-fixed sm:min-w-full">';
          echo '<div class="sm:table-row">';
          echo '<div class="sm:table-cell"><span class="font-semibold">Fullname:</span> '.htmlspecialchars($row["fullname"]).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Email:</span> '.htmlspecialchars($row["email"]).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Phone:</span> '.htmlspecialchars($row["phonenumber"]).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Court Type:</span> '.htmlspecialchars($row["court_type"]).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Book Date:</span> '.date("m/d/Y", strtotime($row["date"])).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Time:</span> '.htmlspecialchars($row["time_slot"]).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Created:</span> '.date("m/d/Y", strtotime($row["created_at"])).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Status:</span> '.htmlspecialchars($row["status"]).'</div>';
          echo '<div class="sm:table-cell"><span class="font-semibold">Date Accepted:</span> '.date("m/d/Y", strtotime($row["denied_date"])).'</div>';
          echo '</div>'; // row
          echo '</div>'; // card
      }
  } else {
      echo "<div class='text-center text-gray-500 mt-4'>No results found.</div>";
  }
  ?>
</div>


      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
