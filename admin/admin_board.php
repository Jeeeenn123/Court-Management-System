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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container-flex">
<div class="sidebar">
    <div class="profile">
        <div class="img"><img src="assets/imgs/pfp.jpg" alt=""></div>
        <h4>Welcome Admin!</h4>
    </div>
    
    <div class="links">
        <a href="admin_board.php" class="dashboard"><img src="assets/imgs/dashboard.png" class="icon"><span class="list">Dashboard</span></a>
        <a href="reservations.php"><img src="assets/imgs/calendar.png" class="icon"><span class="list">Reservations</span></a>
        <a class="dropdown-btn"><img src="assets/imgs/history.png" class="icon"><span class="list">History</span><img src="assets/imgs/arrow.png" class="arrow"></a>
        <div class="dropdown-container">
            <a href="accepted.php"><img src="assets/imgs/accept.png" class="icon"><span class="list">Accepted</span></a>
            <a href="denied.php"><img src="assets/imgs/denied.png" class="icon"><span class="list">Denied</span></a>
            <a href="cancelled.php"><img src="assets/imgs/cancelled.png" class="icon"><span class="list">Cancellled</span></a>
        </div>
    <a href="users.php"><img src="assets/imgs/users.png"><span class="list">Users</span></a>
    </div>
    <div class="logoutBtn">
        <a href="../logout.php"><img src="assets/imgs/logout.png" class="icon"><span class="list">Log Out</span></a>
    </div>
</div>
<div class="content">

    <div class="metrics">
        <div class="box1">
<?php
        $sql = "SELECT COUNT(*) AS total FROM reservations";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            echo "<h2>" . $row['total'] . "</h2><br>";
            echo "<hr><br><br>";
            echo  "<p>Total Reservations</p>";
        } else {
            echo "Failed to retrieve data.";
        }
?>
</div>
    <div class="box2">
<?php
        $sql = "SELECT COUNT(*) AS total FROM accepted_bookings";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            echo "<h2>" . $row['total'] . "</h2><br>";
            echo "<hr><br><br>";
            echo  "<p>Total Accept Bookings</p>";
        } else {
            echo "Failed to retrieve data.";
        }
?>
</div>
    <div class="box3">
<?php
        $sql = "SELECT COUNT(*) AS total FROM denied_bookings";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            echo "<h2>" . $row['total'] . "</h2><br>";
            echo "<hr><br><br>";
            echo  "<p>Total Accept Bookings</p>";
        } else {
            echo "Failed to retrieve data.";
        }
?>
</div>
    <div class="box4">
<?php
        $sql = "SELECT COUNT(*) AS total FROM cancelled_bookings";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            echo "<h2>" . $row['total'] . "</h2><br>";
            echo "<hr><br><br>";
            echo  "<p>Total Accept Bookings</p>";
        } else {
            echo "Failed to retrieve data.";
        }
?>
</div>
    </div>

<div class="charts">
<div class="reservation-chart">
<?php
$sql = "SELECT MONTH(date) AS month, YEAR(date) AS year, COUNT(*) AS total_reservations 
        FROM reservations 
        GROUP BY YEAR(date), MONTH(date) 
        ORDER BY YEAR(date), MONTH(date)";
        
$result = $conn->query($sql);

$months = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $months[] = date("F", mktime(0, 0, 0, $row['month'], 10)) . " " . $row['year'];
    $counts[] = $row['total_reservations'];
}
?>
<canvas id="reservationChart"></canvas>
</div>

<div class="users-chart">
<?php
$sql = "SELECT MONTH(created_at) AS month, YEAR(created_at) AS year, COUNT(*) AS total_users 
        FROM users 
        GROUP BY YEAR(created_at), MONTH(created_at) 
        ORDER BY YEAR(created_at), MONTH(created_at)";

$result = $conn->query($sql);

$userMonths = [];
$userCounts = [];

while ($row = $result->fetch_assoc()) {
    $userMonths[] = date("F", mktime(0, 0, 0, $row['month'], 10)) . " " . $row['year'];
    $userCounts[] = $row['total_users'];
}
?>
<canvas id="userChart"></canvas>
</div>
</div>

    </div>
</div>




<script>
    //DROPDOWN
    const dropdownBtn = document.querySelector(".dropdown-btn");
    const dropdownContainer = document.querySelector(".dropdown-container");
    const dropDownItems = dropdownContainer.querySelector("a");

    dropdownBtn.addEventListener("click", () => {
      dropdownContainer.style.display =
        dropdownContainer.style.display === "block" ? "none" : "block";
      
        dropdownBtn.classList.toggle("active-btn");
        dropdownBtn.classList.toggle("rotate");
    });

    //BAR CHART
    const ctx = document.getElementById('reservationChart').getContext('2d');
        const reservationChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Reservations',
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Monthly Reservations'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

const ctx2 = document.getElementById('userChart').getContext('2d');
const userChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($userMonths); ?>,
        datasets: [{
            label: 'New Users',
            data: <?php echo json_encode($userCounts); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            borderRadius: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Monthly New Users'
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});
</script>
</body>
</html>