<?php
session_start();
include "../db_connect.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FullCalendar Booking</title>

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet" />
  <style>
    #calendar {
      width: 600px;
      margin: 20px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
      padding: 10px;
    }
    .modal { display: none; position: fixed; z-index: 1000; inset: 0; background: rgba(0,0,0,.5); }
    .modal-content { background: #fff; margin: 10% auto; padding: 20px; border-radius: 10px; width: 90%; max-width: 420px; box-shadow: 0 6px 18px rgba(0,0,0,.12); }
    .modal h2 { text-align: center; margin-bottom: 12px; }
    .close { float:right; font-size:22px; font-weight:bold; cursor:pointer; color:#aaa; }
    .close:hover { color:#000; }
    .form-group { margin-bottom: 12px; }
    label { display:block; margin-bottom:6px; font-weight:600; }
    input, select { width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; font-size:14px; box-sizing:border-box; }
    button { background:#007bff; color:#fff; border:none; padding:10px 16px; border-radius:6px; cursor:pointer; font-size:14px; }
    button:hover { background:#0056b3; }
    @keyframes fadeIn { from{opacity:0; transform:translateY(-8px)} to{opacity:1; transform:translateY(0)} }
    .booked { background: #ff4c1fff !important; color:#333 !important; font-weight:700; }
  </style>
</head>
<body>
  <a href="home.php" style="color: black; text-decoration: none;">&lt; Go Back</a>
  <div id="calendar"></div>

  <!-- Modal -->
  <div id="dateModal" class="modal" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true">
      <span class="close" title="Close">&times;</span>
      <h2>Book Court</h2>
      <form action="booking_process.php" method="post" id="bookingForm">
        <input type="hidden" id="dbDate" name="date" />

        <div class="form-group">
          <label>Date:</label>
          <input type="text" id="displayDate" readonly />
        </div>

        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" name="fullname" value="<?php echo htmlspecialchars($stored_fullname); ?>" required />
        </div>

        <div class="form-group">
          <label for="court">Court Type:</label>
          <select id="court" name="court_type" required>
            <option value="">Select court</option>
            <option value="Basketball">Basketball</option>
            <option value="Volleyball">Volleyball</option>
          </select>
        </div>

        <div class="form-group">
          <label for="time">Time:</label>
          <select id="time" name="time" required>
            <option value="">Select time</option>
            <option value="8AM - 9AM">8AM - 9AM</option>
            <option value="9AM - 10AM">9AM - 10AM</option>
            <option value="10AM - 11AM">10AM - 11AM</option>
            <option value="11AM - 12PM">11AM - 12PM</option>
            <option value="1PM - 2PM">1PM - 2PM</option>
            <option value="2PM - 3PM">2PM - 3PM</option>
            <option value="3PM - 4PM">3PM - 4PM</option>
            <option value="4PM - 5PM">4PM - 5PM</option>
            <option value="5PM - 6PM">5PM - 6PM</option>
            <option value="6PM - 7PM">6PM - 7PM</option>
            <option value="7PM - 8PM">7PM - 8PM</option>
            <option value="8PM - 9PM">8PM - 9PM</option>
            <option value="9PM - 10PM">9PM - 10PM</option>
          </select>
        </div>

        <div style="text-align:center; margin-top:14px;">
          <button type="submit" id="submitBtn">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');
      const modal = document.getElementById('dateModal');
      const closeBtn = document.querySelector('.close');
      const displayDate = document.getElementById('displayDate');
      const dbDate = document.getElementById('dbDate');
      const timeSelect = document.getElementById('time');
      const bookingForm = document.getElementById('bookingForm');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

        // Load background events (dates with bookings)
        events: 'fetch_bookings.php',

        dateClick: function (info) {
          // Set date values
          dbDate.value = info.dateStr;
          const dateObj = new Date(info.dateStr);
          displayDate.value = dateObj.toLocaleDateString(undefined, {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
          });

          // Remove previous highlights
          for (let i = 0; i < timeSelect.options.length; i++) {
            const opt = timeSelect.options[i];
            opt.classList.remove('booked');
            opt.disabled = false;
          }

          // Fetch booked times for clicked date and highlight them (but keep options visible)
          fetch('fetch_bookings.php?date=' + encodeURIComponent(info.dateStr))
            .then(res => {
              if (!res.ok) throw new Error('Network response was not ok');
              return res.json();
            })
            .then(rows => {
              // rows expected: [{time: "8AM - 9AM"}, ...]
              rows.forEach(r => {
                for (let i = 0; i < timeSelect.options.length; i++) {
                  const opt = timeSelect.options[i];
                  if (opt.value === r.time) {
                    opt.classList.add('booked'); // highlight booked time
                    // leave enabled so user can still view; we'll block submit if chosen
                  }
                }
              });
            })
            .catch(err => {
              console.error('Failed to load booked times:', err);
            });

          modal.style.display = 'block';
        }
      });

      calendar.render();

      // Close modal handlers
      closeBtn.onclick = () => modal.style.display = 'none';
      window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

      // Prevent submitting a booked time
      bookingForm.addEventListener('submit', function (e) {
        const selected = timeSelect.options[timeSelect.selectedIndex];
        if (!selected || selected.value === '') {
          e.preventDefault();
          alert('Please choose a time.');
          return;
        }
        if (selected.classList.contains('booked')) {
          e.preventDefault();
          alert('That time is already booked. Please choose another time.');
          return;
        }
        // otherwise form will be submitted to booking_process.php
      });
    });
  </script>
</body>
</html>
