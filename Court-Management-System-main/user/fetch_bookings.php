<?php
// fetch_bookings.php
// Returns JSON:
//  - ?date=YYYY-MM-DD => [{ fullname, court_type, time, status }, ...]
//  - otherwise => FullCalendar event array for highlighting booked dates

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// try to include db_connect.php from a few likely locations
$included = false;
$paths = [
    __DIR__ . '/db_connect.php',
    __DIR__ . '/../db_connect.php',
    __DIR__ . '/user/db_connect.php',
];
foreach ($paths as $p) {
    if (file_exists($p)) { include_once $p; $included = true; break; }
}
if (!$included) {
    header('Content-Type: application/json; charset=utf-8', true, 500);
    echo json_encode(['error' => 'db_connect.php not found (tried multiple paths)']);
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset('utf8mb4');

header('Content-Type: application/json; charset=utf-8');

try {
    // Detect login: adjust if your login uses a different session key
    $isLoggedIn = isset($_SESSION['username']) && !empty($_SESSION['username']);

    // If date param provided -> return bookings for that date
    if (isset($_GET['date']) && $_GET['date'] !== '') {
        $date = $_GET['date'];

        // validate date (basic)
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if (!$d || $d->format('Y-m-d') !== $date) {
            echo json_encode([]); exit;
        }

        $sql = "SELECT fullname, court_type, time_slot AS time, status
                FROM reservations
                WHERE `date` = ?
                ORDER BY time_slot";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $res = $stmt->get_result();

        $out = [];
        while ($row = $res->fetch_assoc()) {
            if (!$isLoggedIn) {
                // mask or replace fullname for guests
                $row['fullname'] = "Login to view";
            }
            $out[] = $row;
        }
        echo json_encode($out);
        exit;
    }

    // Otherwise return event array for FullCalendar (booked dates with counts)
    $sql = "SELECT `date`, COUNT(*) AS total
            FROM reservations
            WHERE status IN ('PENDING','ACCEPTED')
            GROUP BY `date`";
    $res = $conn->query($sql);

    $events = [];
    while ($r = $res->fetch_assoc()) {
        $events[] = [
            'title'   => $r['total'] . ' booking(s)',
            'start'   => $r['date'],
            'allDay'  => true,
            'display' => 'background', // highlights the day
            'color'   => '#ff6b35'
        ];
    }

    echo json_encode($events);
} catch (Throwable $e) {
    http_response_code(500);
    // For production you may want to hide $e->getMessage()
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    error_log("fetch_bookings.php error: " . $e->getMessage());
}
