<?php
session_start();
include "../db_connect.php";

$sql = "SELECT * FROM reservations";
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
        <a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 bg-green-200">Reservations</a>

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

        <a href="users.php" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Users</a>
        <!--<a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Profile</a>-->
        <a href="../logout.php" class="block rounded-lg px-3 py-2 text-red-600 hover:bg-red-100 mt-auto">Logout</a>
        </div>
      </div>

      <!--Main-->
      <div class="ml-64 flex-1 bg-blue-50 p-6 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800">Reservations</h1>
           
        <!--Table-->
        <?php 
        if ($result->num_rows > 0) {
            echo "<table class=\"table-fixed w-full mt-3\">";
            echo "<tr class=\"border-b bg-gray-200\">
                    <th class=\"px-2 py-1\">Fullname</th>
                    <th class=\"px-2 py-1\">Email</th>
                    <th class=\"px-2 py-1\">Phonenumber</th>
                    <th class=\"px-2 py-1\">Court_Type</th>
                    <th class=\"px-2 py-1\">Book Date</th>
                    <th class=\"px-2 py-1\">Time</th>
                    <th class=\"px-2 py-1\">Created Date</th>
                    <th class=\"px-2 py-1\">Status</th>
                    <th class=\"px-2 py-1\">Action</th>
                </tr>";
            
            while($row = $result->fetch_assoc()) {
                echo "<tr class=\"border-b\">";
                echo "<td class=\"px-2 py-1\">" . htmlspecialchars($row["fullname"]) . "</td>";
                echo "<td class=\"px-2 py-1\">" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td class=\"px-2 py-1\">" . htmlspecialchars($row["phonenumber"]) . "</td>";
                echo "<td class=\"px-2 py-1\">" . htmlspecialchars($row["court_type"]) . "</td>";
                echo "<td class=\"px-2 py-1\">" . date("m/d/y", strtotime($row["date"])) . "</td>";
                echo "<td class=\"px-2 py-1\">" . htmlspecialchars($row["time_slot"]) . "</td>";
                echo "<td class=\"px-2 py-1\">" . date("m/d/y", strtotime($row["created_at"])) . "</td>";
                echo "<td class=\"px-2 py-1\">" . htmlspecialchars($row["status"]) . "</td>";
                echo "<td class=\"-px-4 -py-2\">
                        <a href='accept_process.php?id=" . $row["reservation_id"] . "' class='btn'><i class=\"fas fa-check-square text-green-500 text-3xl\"></i></a>
                        <a href='deny_process.php?id=" . $row["reservation_id"] . "' class='btn' onclick=\"return confirm('Are you sure you want to deny this booking?');\"><i class=\"fas fa-times-square text-red-500 text-3xl\"></i></a>
                    </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }

        $conn->close();
 
    ?>   
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
