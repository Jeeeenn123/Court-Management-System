<?php
include "../db_connect.php";
session_start(); 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn->begin_transaction();

    try {
        
        $select_sql = "SELECT * FROM reservations WHERE reservation_id = ?";
        $select_stmt = $conn->prepare($select_sql);
        $select_stmt->bind_param("i", $id);
        $select_stmt->execute();
        $result = $select_stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            
            $insert_sql = "INSERT INTO accepted_bookings (
                reservation_id, username, fullname, email, phonenumber,
                court_type, date, time_slot, created_at, accepted_date, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Accepted')";

            $stmt_insert = $conn->prepare($insert_sql);
            $stmt_insert->bind_param(
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

            if ($stmt_insert->execute()) {
                
                $update_sql = "UPDATE reservations SET status = 'accepted' WHERE reservation_id = ?";
                $stmt_update = $conn->prepare($update_sql);
                $stmt_update->bind_param("i", $id);
                $stmt_update->execute();

                $delete_sql = "DELETE FROM reservations WHERE reservation_id = ?";
                $stmt_delete = $conn->prepare($delete_sql);
                $stmt_delete->bind_param("i", $id);
                $stmt_delete->execute();

                
                $conn->commit();

                echo "Reservation accepted successfully!";
            } else {
                throw new Exception("Insert failed: " . $stmt_insert->error);
            }
        } else {
            throw new Exception("Reservation not found.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Reservation ID is not set.";
}
?>
