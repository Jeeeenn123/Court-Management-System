<?php
    session_start();
    include "../db_connect.php";

    if(!isset($_SESSION['username'])){
        header("Location: ../index.php");
        exit();
    }

    $username = $_SESSION['username'];

    $sql = "SELECT reservation_id, username, fullname, email, phonenumber, court_type, date, time_slot, created_at, status
    FROM reservations
    WHERE username = ? AND status = 'pending'
    
    UNION

    SELECT reservation_id, username, fullname, email, phonenumber, court_type, date, time_slot, created_at, status
    FROM accepted_bookings
    WHERE username = ?
    
    UNION

    SELECT reservation_id, username, fullname, email, phonenumber, court_type, date, time_slot, created_at, status
    FROM denied_bookings
    WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <title>Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        /* Navigation Styles */
        .nav-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .nav-bar:hover {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .logo img {
            height: 50px;
            width: auto;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .logo:hover img {
            transform: scale(1.05);
        }

        .align-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .nav-links a:hover::before {
            left: 0;
        }

        .nav-links a:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }

        .menu-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .menu-btn:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
        }

        .content-dropdown {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logoutBtn {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .logoutBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(255, 107, 107, 0.5);
        }

        /* Home Section Styles */
        #home {
            margin-top: 100px;
            padding: 2rem;
        }

        .sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section2, .section1 {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .section2:hover, .section1:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .section2 h2 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .section2 h4 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 1rem;
        }

        .section2 hr {
            border: none;
            height: 3px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
            margin: 1rem 0;
        }

        .section1 h1 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 1rem;
        }

        .section1 hr {
            border: none;
            height: 2px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
            margin: 1rem 0;
        }

        .section1 p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.8;
            text-align: justify;
        }

        /* Table Styles */
        #table {
            margin-top: 2rem;
        }

        .table {
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-weight: 400;
            transition: all 0.3s ease;
        }

        .table tr:nth-child(even) td {
            background: rgba(102, 126, 234, 0.05);
        }

        .table tr:hover td {
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            transform: scale(1.01);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-danger {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: white;
            box-shadow: 0 3px 10px rgba(255, 107, 107, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 107, 107, 0.5);
        }

        /* Court Section Styles */
        #court {
            padding: 4rem 2rem;
            text-align: center;
        }

        .section-heading {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 3rem;
            position: relative;
        }

        .section-heading::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(45deg, #fff, rgba(255, 255, 255, 0.7));
            border-radius: 2px;
        }

        .court-section {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .slider {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .slider img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        .slider img.displaySlide {
            opacity: 1;
        }

        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
            color: white;
            border: none;
            padding: 1rem 1.2rem;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .prev {
            left: 20px;
        }

        .next {
            right: 20px;
        }

        .prev:hover, .next:hover {
            background: linear-gradient(45deg, #667eea, #764ba2);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sections {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .section2, .section1 {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav-bar {
                padding: 1rem;
            }

            #home {
                padding: 1rem;
                margin-top: 80px;
            }

            .sections {
                gap: 1.5rem;
            }

            .section2, .section1 {
                padding: 1.5rem;
            }

            .section2 h2 {
                font-size: 1.8rem;
            }

            .section1 h1 {
                font-size: 1.6rem;
            }

            .section-heading {
                font-size: 2.2rem;
            }

            .slider {
                height: 300px;
            }

            .prev, .next {
                padding: 0.8rem 1rem;
                font-size: 1rem;
            }

            .prev {
                left: 10px;
            }

            .next {
                right: 10px;
            }
        }

        @media (max-width: 480px) {
            .section2 h2 {
                font-size: 1.5rem;
            }

            .section1 h1 {
                font-size: 1.4rem;
            }

            .section-heading {
                font-size: 2rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
            }

            .slider {
                height: 250px;
            }
        }

        /* Loading Animations */
        .section2 {
            animation: slideInLeft 0.8s ease;
        }

        .section1 {
            animation: slideInRight 0.8s ease;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #764ba2, #667eea);
        }
    </style>
</head>
<body>
    <div class="#top"></div>
    <header class="nav-bar">
        <div class="logo"><a href="#top"><img src="assets/imgs/seal.png" alt="seal"></a></div>
        <div class="align-right">
            <ul class="nav-links">
                <li><a href="#top">Home</a></li>
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
        </div>
    </header> 

    <section id="home">
        <div class="sections">
            <div class="section2">
                <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
                <h4>Your Booking</h4> <br>
                <hr> <br>
                <div id="table">
<table class="table">
        <tr>
            <th>Full Name</th>
            <th>Court Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td><?php echo htmlspecialchars($row['court_type']); ?></td>
                <td><?php echo htmlspecialchars(date("F j, Y", strtotime($row['date']))); ?></td>
                <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <?php if ($row['status'] === 'PENDING'): ?>
                        <a href="cancel.php?id=<?php echo $row['reservation_id']; ?>" 
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to cancel this booking?');">
                            Cancel
                        </a>
                    <?php else: ?>
                        <span style="color: black;">N/A</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
</table>
</div>
            </div>
            <div class="section1">
                <h1 style="text-align:center; padding: 2px;">Introduction</h1>
                <hr style="margin: 10px">
                <p>Brgy Ermita, Cebu is an organized way for residents to book and use sports courts such as basketball or volleyball courts.
                     This system helps manage the schedule by allowing people to reserve courts ahead of time, ensuring fair access and reducing conflicts.
                    It can be done manually through barangay offices or digitally via an online platform, making it easier for the community to enjoy sports facilities conveniently and efficiently.
                     This initiative promotes active lifestyles and community engagement in Brgy Ermita.
                </p>
            </div>
        </div>
    </section>

    <section id="court">
        <h1 class="section-heading">View Court</h1>
        <div class="court-section">
            <h1 style="display: none;">H1</h1>
            <div class="slider">
                <img src="assets/imgs/guada_court1.jpg" alt="guada_court1">
                <img src="assets/imgs/guada_court2.jpg" alt="guada_court2">
                <img src="assets/imgs/guada_court3.jpg" alt="guada_court3">
            </div>       
                <button class="prev" id="prev">&#10094</button>
                <button class="next" id="next">&#10095</button>         
        </div>
    </section>

    <script>
        //For Image Slider
        const slides = document.querySelectorAll(".slider img"); //select all the slides
        let slideIndex = 0;  //set 0 to start first slide  
        let intervalId = null;

        //initializeSlider();
        document.addEventListener("DOMContentLoaded", initializeSlider)
        function initializeSlider(){
            if(slides.length > 0){
            slides[slideIndex].classList.add("displaySlide");
            intervalId = setInterval(nextSlide, 3000);
            }
        }
        function showSlide(index){
            if(index >= slides.length){ //img loop
                slideIndex = 0;
            }else if(index < 0){
                slideIndex = slides.length - 1;
            }
            slides.forEach(slide => {
                slide.classList.remove("displaySlide");
            });
            slides[slideIndex].classList.add("displaySlide");
        }

        //prev btn
        const prevBtn = document.getElementById("prev");
        prevBtn.addEventListener("click", prevSlide);
        function prevSlide(){
            clearInterval(intervalId);
            slideIndex--;
            showSlide(slideIndex);
        }

        //next btn
        const nextBtn = document.getElementById("next");
        nextBtn.addEventListener("click", nextSlide);
        function nextSlide(){
            slideIndex++;
            showSlide(slideIndex);
        }

        // click drop down menu
        const menuBtn = document.getElementById("menuBtn");
        const dropdown = document.querySelector(".content-dropdown");
        menuBtn.addEventListener("click", () => {
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

    </script>

</body>
</html>x