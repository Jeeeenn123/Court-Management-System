<?php 
session_start();
include "../db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Court Dashboard - History</title>
    <link rel="stylesheet" href="assets/css/boards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="sidebar">
    <h2>CourtReserve</h2>
    <ul>
        <a href="admin_board.php"><li>Dashboard</li></a>
        <a href="bookings.php"><li>Reservations</li></a>
        <a class="dropdown-btn"><li class="active">History</li></a>
        <div class="dropdown-menu">
            <a href="">Total Accepted</a>
            <a href="">Total Denied</a>
            <a href="">Total Cancelled</a>
        </div>
    </ul>
    <div class="logout-btn">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="../logout.php">Log out</a>
    </div>
</div>

<div class="main-content">
    <header>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p class="subtitle">History of All Bookings</p>
        <br>
    </header>

    <div class="bookings">

        <!-- Accepted Bookings -->
        <div class="table-section">
            <h3>Accepted Bookings</h3>
            <?php
            $sql = "SELECT * FROM accepted_bookings ORDER BY created_at DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<div class='table-wrapper'><table>";
                echo "<tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Court Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["reservation_id"]) . "</td>
                            <td>" . htmlspecialchars($row["fullname"]) . "</td>
                            <td>" . htmlspecialchars($row["email"]) . "</td>
                            <td>" . htmlspecialchars($row["phonenumber"]) . "</td>
                            <td>" . htmlspecialchars($row["court_type"]) . "</td>
                            <td>" . date("F j, Y", strtotime($row["date"])) . "</td>
                            <td>" . htmlspecialchars($row["time_slot"]) . "</td>
                            <td>" . date("F j, Y g:i A", strtotime($row["created_at"])) . "</td>
                            <td>" . htmlspecialchars($row["status"]) . "</td>
                            <td><button class='button-delete'><i class='fas fa-trash'></i></button></td>
                          </tr>";
                }
                echo "</table></div>";
            } else {
                echo "<p>No accepted bookings found.</p>";
            }
            ?>
        </div>
        <br>

    </div>
</div>
<script>
    document.querySelectorAll(".dropdown-btn").forEach(button => {
        button.addEventListener("click", function () {
            let dropdown = this.nextElementSibling;
            let icon = this.querySelector(".fa-caret-right");

            // Toggle display
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

            // Rotate icon
            icon.classList.toggle("rotate");
        });
    });
</script>
</body>
</html>
