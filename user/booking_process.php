<?php
include "../db_connect.php";
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // helps show real errors in dev
$conn->set_charset('utf8mb4');

if (!isset($_SESSION['username'])) {
    echo "<script>alert('You need to log in first'); window.location.href='../index.php';</script>";
    exit();
}

    $username = $_SESSION['username'];
    
    $user_sql = "SELECT email, phonenumber, fullname FROM users WHERE username = ?";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("s", $username);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();

if ($user_result->num_rows === 0) {
    echo "<script>alert('User record not found.'); window.location.href='../index.php';</script>";
    exit();
}

    $user_row = $user_result->fetch_assoc();
    $email = $user_row['email'];
    $phone = $user_row['phonenumber'];
    $stored_fullname = $user_row['fullname'];
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $fullname   = trim($_POST['fullname'] ?? '');
    if ($fullname === '' && !empty($stored_fullname)) {
        $fullname = $stored_fullname;
    }

    $court_type = $_POST['court_type'] ?? '';
    $date       = $_POST['date'] ?? '';
    $timeSlot   = $_POST['time'] ?? ''; 

    if ($fullname === '' || $court_type === '' || $date === '' || $timeSlot === '') {
        echo "<script>alert('Please fill in all fields.'); history.back();</script>";
        exit();
    }

    if (strtotime($date) < strtotime(date('Y-m-d'))) {
        echo "<script>alert('Date cannot be in the past.'); history.back();</script>";
        exit();
    }

    $check = $conn->prepare("SELECT reservation_id FROM reservations
                            WHERE court_type=? AND date=? AND time_slot=? 
                               AND status IN ('PENDING','ACCEPTED') LIMIT 1");

    $check->bind_param("sss", $court_type, $date, $timeSlot);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "<script>alert('That time slot is already booked. Choose another.'); history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO reservations 
            (username, fullname, email, phonenumber, court_type, date, time_slot, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'PENDING', NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssss",
        $username,
        $fullname,
        $email,
        $phone,
        $court_type,
        $date,
        $timeSlot
    );

    if ($stmt->execute()) {
        echo "<script>alert('Booking successful!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Error saving booking: " . $stmt->error . "');</script>";
    }
}


