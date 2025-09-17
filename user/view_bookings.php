<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />
    <link rel="stylesheet" href="assets/css/view_bookings.css">
    <title>Bookings</title>
</head>
<body>
    <div class="#top"></div>
    <header class="nav-bar">
        <div class="logo"><a href="#top">Logo</a></div>
        <div class="align-right">
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="booking.php">Book Now</a></li>
                <li><a href="home.php#court">View Court</a></li>
                <li><a href="view_bookings.php">View Bookings</a></li>
            </ul>
            <div class="dropdown">
                    <button id="menuBtn" class="menu-btn"><span class="material-symbols-outlined">menu</span></button>
                        <div class="content-dropdown">                                                  
                            <a href="../logout.php"><button class="logoutBtn">Log out</button></a>
                        </div>
                    </div>
        </div>
    </header>

    <section id="bookings">
        <h1 style="text-align: center; padding: 70px">Bookings</h1> 
        <table class="table">
            <tr>
                <th>Fullname</th>
                <th>Court Type</th>
                <th>Booking Date</th>
                <th>Time</th>
            </tr>
            <?php
        include "../db_connect.php";

            $sql = "SELECT * FROM reservations";
            $result = $conn -> query($sql);

            while($row = $result -> fetch_assoc()){
                echo "<tr>
                        <td>".$row['fullname']."</td>
                        <td>".$row['court_type']."</td>
                        <td>" . date("F j, Y", strtotime($row['date'])) . "</td>
                        <td>".$row['time_slot']."</td>               
                    </tr>";
            }
            ?>
        </table>
    </section>

    <script>
        
        // click drop down menu
        const menuBtn = document.getElementById("menuBtn");
        const dropdown = document.querySelector(".content-dropdown");
        menuBtn.addEventListener("click", () => {
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });
    </script>

</body>
</html>