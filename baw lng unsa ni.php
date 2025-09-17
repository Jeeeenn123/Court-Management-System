<?php
include "../db_connect.php";
session_start();

// Load SweetAlert
echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';

if (!isset($_SESSION['username'])) {
    echo "<script>
            swal('Login Required', 'You need to log in first.', 'warning')
            .then(() => { window.location.href = '../index.php'; });
          </script>";
    exit(); 
}

$username = $_SESSION['username'];

$user_sql = "SELECT email, phonenumber FROM users WHERE username = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
    $email = $user_data['email'];
    $phone = $user_data['phonenumber'];
} else {
    echo "<script>
            swal('Error', 'User data not found.', 'error')
            .then(() => { window.location.href='../index.php'; });
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $court_type = $_POST['court_type'];
    $date = $_POST['date'];
    $time_in = $_POST['timein'];
    $time_out = $_POST['timeout'];

    if (strtotime($time_out) <= strtotime($time_in)) {
        echo "<script>
                swal('Invalid Time', 'Time out must be later than time in.', 'error')
                .then(() => { window.history.back(); });
              </script>";
        exit();
    }

    $conflict_sql = "SELECT * FROM reservations 
                    WHERE court_type = ? AND date = ? 
                    AND (
                        (time_in <= ? AND time_out > ?) OR 
                        (time_in < ? AND time_out >= ?)
                    )";
    $conflict_stmt = $conn->prepare($conflict_sql);
    $conflict_stmt->bind_param("ssssss", $court_type, $date, $time_in, $time_in, $time_out, $time_out);
    $conflict_stmt->execute();
    $conflict_result = $conflict_stmt->get_result();

    if ($conflict_result->num_rows > 0) {
        echo "<script>
                swal('Booking Conflict', 'This time slot is already booked. Please choose another.', 'error')
                .then(() => { window.history.back(); });
              </script>";
        exit();
    }

    $sql = "INSERT INTO reservations (fullname, court_type, date, time_in, time_out, email, phonenumber, status) 
            VALUES (?,?,?,?,?,?,?, 'PENDING')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fullname, $court_type, $date, $time_in, $time_out, $email, $phone);

    if ($stmt->execute()) {
        echo "<script>
                swal('Success!', 'Your booking was submitted.', 'success')
                .then(() => { window.location.href='home.php'; });
              </script>";
    } else {
        echo "<script>
                swal('Error', 'There was a problem saving your booking.', 'error');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link rel="stylesheet" href="assets/css/booking.css">
    <!-- SweetAlert script (for fallback if not already loaded in PHP) -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<div class="container-form">
    <form action="booking.php" method="post">
        <h2>Booking Form</h2>

        <input name="fullname" type="text" placeholder="Fullname" required> <br>

        <div class="type-date">
            <label for="court_type">Court Type:</label> 
            <select name="court_type" id="court_type" required>
                <option value="basketball">Basketball Court</option>
                <option value="volleyball">Volleyball Court</option>
            </select><br> 

            <label for="date">Date:</label> 
            <input type="date" id="date" name="date" required><br><br>           

            <label for="duration">Duration:</label>
            <select id="duration" onchange="filterTimeSlots()" required>
                <option value="">Select Duration</option>
                <option value="1hr">1 Hour</option>
                <option value="2hrs">2 Hours</option>
            </select><br><br>

            <label for="timeSlot">Time Slot:</label>
            <select id="timeSlot" name="timein" required>
                <option value="">Time</option>
                <!-- 1 Hour Slots -->
                <option data-duration="1hr" value="8:00">8AM - 9AM</option>
                <option data-duration="1hr" value="9:00">9AM - 10AM</option>
                <option data-duration="1hr" value="11:00">11AM - 12PM</option>
                <option data-duration="1hr" value="12:00">12PM - 1PM</option>
                <option data-duration="1hr" value="13:00">1PM - 2PM</option>
                <option data-duration="1hr" value="14:00">2PM - 3PM</option>
                <option data-duration="1hr" value="15:00">3PM - 4PM</option>
                <option data-duration="1hr" value="16:00">4PM - 5PM</option>
                <option data-duration="1hr" value="17:00">5PM - 6PM</option>
                <option data-duration="1hr" value="18:00">6PM - 7PM</option>
                <option data-duration="1hr" value="19:00">7PM - 8PM</option>
                <option data-duration="1hr" value="20:00">8PM - 9PM</option>
                <option data-duration="1hr" value="21:00">9PM - 10PM</option>

                <!-- 2 Hour Slots -->
                <option data-duration="2hrs" value="8:00">8AM - 10AM</option>
                <option data-duration="2hrs" value="10:00">10AM - 12PM</option>
                <option data-duration="2hrs" value="12:00">12PM - 2PM</option>
                <option data-duration="2hrs" value="14:00">2PM - 4PM</option>
                <option data-duration="2hrs" value="16:00">4PM - 6PM</option>
                <option data-duration="2hrs" value="18:00">6PM - 8PM</option>
                <option data-duration="2hrs" value="20:00">8PM - 10PM</option>
            </select>

            <!-- Automatically set time_out using JS -->
            <input type="hidden" name="timeout" id="timeout">
        </div>

        <button type="submit" class="btn" name="submit">Book Now</button> <br><br>   
    </form>

    <a href="home.php"><button class="home">Home</button></a>
</div>

<script>
function filterTimeSlots() {
    var duration = document.getElementById("duration").value;
    var timeSlot = document.getElementById("timeSlot");
    var options = timeSlot.options;

    timeSlot.selectedIndex = 0;

    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        var dataDuration = option.getAttribute("data-duration");
        if (!dataDuration || duration === "") {
            option.style.display = i === 0 ? "" : "none";
        } else {
            option.style.display = (dataDuration === duration) ? "" : "none";
        }
    }
}

// Automatically calculate timeout based on selected timein and duration
document.getElementById("timeSlot").addEventListener("change", function () {
    const selected = this.value;
    const duration = document.getElementById("duration").value;
    const timeOutInput = document.getElementById("timeout");

    if (!selected || !duration) {
        timeOutInput.value = "";
        return;
    }

    const [hourStr, minuteStr] = selected.split(":");
    let hour = parseInt(hourStr);
    let addHours = duration === "1hr" ? 1 : 2;
    hour += addHours;
    if (hour >= 24) hour -= 24;

    const formatted = hour.toString().padStart(2, '0') + ":" + minuteStr;
    timeOutInput.value = formatted;
});
</script>

</body>
</html>
