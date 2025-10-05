<?php
session_start();
include "../db_connect.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get reservation
    $sql = "SELECT * FROM reservations WHERE reservation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ✅ Update status in reservations
        $update = "UPDATE reservations SET status = 'denied' WHERE reservation_id = ?";
        $upd = $conn->prepare($update);
        $upd->bind_param("i", $id);
        $upd->execute();

        // ✅ Insert into denied_bookings
        $insert = "INSERT INTO denied_bookings 
            (reservation_id, username, fullname, email, phonenumber, court_type, date, time_slot, created_at, denied_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'denied')";
        $ins = $conn->prepare($insert);
        $ins->bind_param(
            "issssssss",
            $row['reservation_id'],
            $row['username'],
            $row['fullname'],
            $row['email'],
            $row['phonenumber'],
            $row['court_type'],
            $row['date'],
            $row['time_slot'],
            $row['created_at']
        );
        $ins->execute();

        header("Location: reservations.php?success=denied");
        exit;
    } else {
        echo "Reservation not found.";
    }
} else {
    echo "Invalid request.";
}
