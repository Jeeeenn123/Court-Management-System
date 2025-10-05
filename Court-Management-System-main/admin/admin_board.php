<?php 
session_start();
include "../db_connect.php";

if(!isset($_SESSION['username'])){
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

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
        <div class="p-3 flex flex-col flex-1 overflow-y-auto">
          <a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 bg-green-200">Dashboard</a>
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

          <a href="users.php" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Users</a>
          <!--<a href="#" class="block rounded-lg px-3 py-2 mb-2 text-gray-700 hover:bg-gray-200">Profile</a>-->
          <a href="../logout.php" class="block rounded-lg px-3 py-2 text-red-600 hover:bg-red-100 mt-auto">Logout</a>
        </div>
      </div>

      <!--Main-->
      <div class="ml-64 flex-1 bg-blue-50 p-6 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, Admin Papi!</h1>

        <!--Boxes-->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
  <!--Total Reservations-->
  <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
    <div>
      <?php
        $sql = "SELECT COUNT(*) AS total FROM reservations";
        $result = $conn->query($sql);
        $reservations = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
        echo "<h3 class='text-3xl font-bold text-blue-600'>$reservations</h3>";
      ?>
      <p class="text-gray-600 font-medium">Total Reservations</p>
    </div>
    <i class="fas fa-calendar-check text-blue-500 text-4xl"></i>
  </div>

  <!--Total Users-->
  <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
    <div>
      <?php
        $sql = "SELECT COUNT(*) AS total FROM users";
        $result = $conn->query($sql);
        $users = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
        echo "<h3 class='text-3xl font-bold text-green-600'>$users</h3>";
      ?>
      <p class="text-gray-600 font-medium">Total Users</p>
    </div>
    <i class="fas fa-users text-green-500 text-4xl"></i>
  </div>

  <!--Accepted Bookings-->
  <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
    <div>
      <?php
        $sql = "SELECT COUNT(*) AS total FROM accepted_bookings";
        $result = $conn->query($sql);
        $accepted = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
        echo "<h3 class='text-3xl font-bold text-indigo-600'>$accepted</h3>";
      ?>
      <p class="text-gray-600 font-medium">Accepted</p>
    </div>
    <i class="fas fa-check-circle text-indigo-500 text-4xl"></i>
  </div>

  <!--Denied Bookings-->
  <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
    <div>
      <?php
        $sql = "SELECT COUNT(*) AS total FROM denied_bookings";
        $result = $conn->query($sql);
        $denied = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
        echo "<h3 class='text-3xl font-bold text-yellow-600'>$denied</h3>";
      ?>
      <p class="text-gray-600 font-medium">Denied</p>
    </div>
    <i class="fas fa-ban text-yellow-500 text-4xl"></i>
  </div>

  <!--Cancelled Bookings-->
  <div class="bg-white p-6 rounded-xl shadow-md flex items-center justify-between">
    <div>
      <?php
        $sql = "SELECT COUNT(*) AS total FROM cancelled_bookings";
        $result = $conn->query($sql);
        $cancelled = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
        echo "<h3 class='text-3xl font-bold text-red-600'>$cancelled</h3>";
      ?>
      <p class="text-gray-600 font-medium">Cancelled</p>
    </div>
    <i class="fas fa-times-circle text-red-500 text-4xl"></i>
  </div>
</div>


        <!--Boxes 2-->
<div class="flex flex-col lg:flex-row gap-5 mt-5">
  
  <!--Left: Line Chart-->
  <div class="bg-white h-80 flex-1 p-5 shadow-lg rounded-lg">
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Bookings Status (Line)</h2>
    <canvas id="statusChart"></canvas>
  </div>

  <!--Right: Pie Chart-->
<div class="bg-white h-80 flex-1 p-5 shadow-lg rounded-lg flex flex-col items-center justify-center">
  <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">Overall Records (Pie)</h2>
  <div class="w-64 h-64">
    <canvas id="pieChart"></canvas>
  </div>
</div>


      </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Line Chart
  const lineCtx = document.getElementById('statusChart').getContext('2d');
  const statusChart = new Chart(lineCtx, {
      type: 'line',
      data: {
          labels: ['Accepted', 'Denied', 'Cancelled'],
          datasets: [{
              label: 'Bookings Status',
              data: [<?php echo $accepted; ?>, <?php echo $denied; ?>, <?php echo $cancelled; ?>],
              borderColor: 'rgba(59,130,246,0.9)',
              backgroundColor: 'rgba(59,130,246,0.2)',
              borderWidth: 2,
              tension: 0.4,
              fill: true,
              pointBackgroundColor: ['green','red','orange']
          }]
      },
      options: {
          responsive: true,
          plugins: { 
              legend: { display: true, labels: { color: '#374151' } } 
          },
          scales: {
              y: { beginAtZero: true, ticks: { color: '#374151' } },
              x: { ticks: { color: '#374151' } }
          }
      }
  });

  // Pie Chart
  const pieCtx = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(pieCtx, {
      type: 'pie',
      data: {
          labels: ['Reservations', 'Users', 'Accepted', 'Denied', 'Cancelled'],
          datasets: [{
              data: [<?php echo $reservations; ?>, <?php echo $users; ?>, <?php echo $accepted; ?>, <?php echo $denied; ?>, <?php echo $cancelled; ?>],
              backgroundColor: [
                  'rgba(37, 99, 235, 1)', //Reservations
                  'rgba(22, 163, 74, 1)', //Users
                  'rgba(99,102,241,0.8)', //Accepted
                  'rgba(202,138,4,0.8)',  //Denied
                  'rgba(239,68,68,0.8)'   //Cancelled
              ],
              borderColor: '#fff',
              borderWidth: 2
          }]
      },
      options: {
          responsive: true,
          plugins: { 
              legend: { position: 'bottom', labels: { color: '#374151' } } 
          }
      }
  });
</script>

  </body>
</html>
