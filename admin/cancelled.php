<?php
include "../db_connect.php";

$sql = "SELECT * FROM cancelled_bookings";
$result = $conn -> query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="container-flex">
<div class="sidebar">
    <div class="profile">
        <div class="img"><img src="assets/imgs/pfp.jpg" alt=""></div>
        <h4>Welcome Admin!</h4>
    </div>
    
    <div class="links">
        <a href="admin_board.php"><img src="assets/imgs/dashboard.png" class="icon"><span class="list">Dashboard</span></a>
        <a href="reservations.php"><img src="assets/imgs/calendar.png" class="icon"><span class="list">Reservations</span></a>
        <a class="dropdown-btn"><img src="assets/imgs/history.png" class="icon"><span class="list">History</span><img src="assets/imgs/arrow.png" class="arrow"></a>
        <div class="dropdown-container">
            <a href="accepted.php"><img src="assets/imgs/accept.png" class="icon"><span class="list">Accepted</span></a>
            <a href="denied.php"><img src="assets/imgs/denied.png" class="icon"><span class="list">Denied</span></a>
            <a href="cancelled.php" class="cancelled"><img src="assets/imgs/cancelled.png" class="icon"><span class="list">Cancellled</span></a>
        </div>
    <a href="users.php"><img src="assets/imgs/users.png"><span class="list">Users</span></a>
    </div>
    <div class="logoutBtn">
        <a href="../logout.php"><img src="assets/imgs/logout.png" class="icon"><span class="list">Log Out</span></a>
    </div>
</div>
<div class="content">
    <div class="table-display">
<?php

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phonenumber</th>
                    <th>Court_Type</th>
                    <th>Book Date</th>
                    <th>Time</th>
                    <th>Created Date</th>
                    <th>Status</th>
                    <th>Date Cancelled</th>
                </tr>"; 
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["reservation_id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["fullname"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["phonenumber"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["court_type"]) . "</td>";
                echo "<td>" . date("F j, Y", strtotime($row["date"])) . "</td>";
                echo "<td>" . htmlspecialchars($row["time_slot"]) . "</td>";
                echo "<td>" . date("F j, Y", strtotime($row["created_at"])) . "</td>";
                echo "<td>" . htmlspecialchars($row["status"]) . "</td>"; 
                echo "<td>" . date("F j, Y", strtotime($row["cancelled_date"])) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }

        $conn->close();
 
    ?>      
</table>
    </div>

    </div>
</div>




<script>
      // Handle dropdown toggle
    const dropdownBtn = document.querySelector(".dropdown-btn");
    const dropdownContainer = document.querySelector(".dropdown-container");
    const dropDownItems = dropdownContainer.querySelector("a");

    dropdownBtn.addEventListener("click", () => {
      dropdownContainer.style.display =
        dropdownContainer.style.display === "block" ? "none" : "block";
      
        dropdownBtn.classList.toggle("active-btn");
        dropdownBtn.classList.toggle("rotate");
    });
</script>
</body>
</html>