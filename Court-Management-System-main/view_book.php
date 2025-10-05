<?php
include "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>View Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet" />
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f5f5f5;margin:0;padding:0}
    header{background:#333;color:#fff;padding:12px;text-align:center}
    #calendar{width:600px;margin:20px auto;background:#fff;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.15);padding:10px}
    .modal{display:none;position:fixed;z-index:1000;inset:0;background:rgba(0,0,0,.5)}
    .modal-content{background:#fff;margin:6% auto;padding:20px;border-radius:10px;width:90%;max-width:600px}
    .close{float:right;font-size:22px;font-weight:700;cursor:pointer;color:#aaa}
    .close:hover{color:#000}
    table{width:100%;border-collapse:collapse;margin-top:10px}
    th,td{border:1px solid #ddd;padding:8px;text-align:center;font-size:14px}
    th{background:#007bff;color:#fff}
    .no-booking{text-align:center;margin:15px 0;color:#555}
    pre.debug { background:#f8f8f8; padding:10px; border-radius:6px; overflow:auto; max-height:200px; }
    .anchor{position: relative; right: 720px; top: 30px; background-color: #ffffff; text-decoration: none; padding: 10px; border-radius: 50%; height: 10px; width: 10px;}
  </style>
</head>
<body>
  <header>
    <a href="index.php" class="anchor"><</a>  
  <h1>View Court Bookings</h1></header>
  <div id="calendar"></div>

  <div id="dateModal" class="modal" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true">
      <span class="close" title="Close">&times;</span>
      <h2>Bookings on <span id="modalDate"></span></h2>
      <div id="bookingList"></div>
      <div id="debugInfo"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const modal = document.getElementById('dateModal');
    const closeBtn = document.querySelector('.close');
    const modalDate = document.getElementById('modalDate');
    const bookingList = document.getElementById('bookingList');
    const debugInfo = document.getElementById('debugInfo');

    const fetchPath = 'user/fetch_bookings.php'; // adjust if file is elsewhere

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: fetchPath,
      dateClick: function(info) {
        modalDate.textContent = new Date(info.dateStr).toLocaleDateString(undefined, {
          weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
        bookingList.innerHTML = "<p>Loading...</p>";
        debugInfo.innerHTML = "";

        fetch(fetchPath + '?date=' + encodeURIComponent(info.dateStr), {
          credentials: 'same-origin' // IMPORTANT: sends session cookie for logged-in users
        })
        .then(async res => {
          const text = await res.text();
          // try to parse JSON; if not valid JSON show raw response for debugging
          try {
            const data = JSON.parse(text);
            return { ok: res.ok, data };
          } catch (e) {
            throw new Error('Invalid JSON response from server: ' + text);
          }
        })
        .then(({ ok, data }) => {
          if (!ok) throw new Error('Server error: ' + JSON.stringify(data));
          if (!Array.isArray(data) || data.length === 0) {
            bookingList.innerHTML = "<p class='no-booking'>No bookings for this date.</p>";
            return;
          }
          let table = `<table>
            <tr><th>Court</th><th>Time</th><th>Status</th></tr>`;
          data.forEach(r => {
            const court = r.court_type ?? r.court ?? '-';
            const time = r.time ?? r.time_slot ?? '-';
            const status = r.status ?? '-';
            table += `<tr>
              <td>${escapeHtml(court)}</td>
              <td>${escapeHtml(time)}</td>
              <td>${escapeHtml(status)}</td>
            </tr>`;
          });
          table += `</table>`;
          bookingList.innerHTML = table;
          // optional debug:
          //debugInfo.innerHTML = "<pre class='debug'>Raw JSON:\\n" + escapeHtml(JSON.stringify(data, null, 2)) + "</pre>";
        })
        .catch(err => {
          bookingList.innerHTML = "<p style='color:red;'>Failed to load bookings.</p>";
          debugInfo.innerHTML = "<pre class='debug'>Error: " + escapeHtml(err.message) + "</pre>";
          console.error(err);
        });

        modal.style.display = 'block';
      }
    });

    calendar.render();

    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

    function escapeHtml(s) {
      return String(s)
        .replaceAll('&','&amp;')
        .replaceAll('<','&lt;')
        .replaceAll('>','&gt;')
        .replaceAll('"','&quot;')
        .replaceAll("'",'&#039;');
    }
  });
  </script>
</body>
</html>