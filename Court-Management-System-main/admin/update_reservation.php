<?php
include "../db_connect.php";

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    // Map action to target table
    $targetTable = "";
    if ($action === "accept") {
        $targetTable = "accepted_bookings";
    } elseif ($action === "deny") {
        $targetTable = "denied_bookings";
    } elseif ($action === "cancel") {
        $targetTable = "cancelled_bookings";
    }

    if (!empty($targetTable)) {
        // 1. Fetch reservation details
        $sql = "SELECT * FROM reservations WHERE reservation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            // 2. Insert into target table
            $columns = implode(", ", array_keys($row));
            $placeholders = implode(", ", array_fill(0, count($row), "?"));
            $values = array_values($row);

            $insertSql = "INSERT INTO $targetTable ($columns) VALUES ($placeholders)";
            $insertStmt = $conn->prepare($insertSql);

            // Dynamically bind params
            $types = str_repeat("s", count($values)); // assume all are strings
            $insertStmt->bind_param($types, ...$values);

            if ($insertStmt->execute()) {
                // 3. Delete from reservations (remove current record)
                $deleteSql = "DELETE FROM reservations WHERE reservation_id = ?";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->bind_param("i", $id);
                $deleteStmt->execute();

                // ✅ Optional: Drop the reservations table itself after action
                // !! Only do this if you really mean to delete the ENTIRE table !!
                // $conn->query("DROP TABLE reservations");

                header("Location: reservations.php");
                exit();
            } else {
                echo "Error inserting into $targetTable: " . $conn->error;
            }
        } else {
            echo "Record not found.";
        }
    }
}
$conn->close();
?>
