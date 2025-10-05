<?php
session_start();
include "db_connect.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) { 
            $_SESSION['users_id'] = $user['users_id'];                
            $_SESSION['username'] = $user['username'];              

            $role = $user['role'];
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $stmt = $conn->prepare("INSERT INTO login_logs (users_id, username, role, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user['users_id'], $username, $role, $ip_address, $user_agent);
            $stmt->execute();

            if ($user['role'] == 'admin') {
                header("Location: admin/admin_board.php");
            } else {
                header("Location: user/home.php");
            }
            exit();
        }
        $stmt->close();
    } else {
        $error = "ERROR: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brngy. Ermita Court Reservation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #ff6b35;
            --secondary-color: #f7931e;
            --dark-bg: #1a1a2e;
            --card-bg: #16213e;
            --text-primary: #ffffff;
            --text-secondary: #b8c5d1;
            --accent-blue: #0f4c75;
            --success: #27ae60;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--accent-blue) 100%);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(30px);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .login-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.6);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="basketball" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,107,53,0.1)" stroke-width="2"/><path d="M10 50 L90 50 M50 10 L50 90" stroke="rgba(255,107,53,0.1)" stroke-width="2"/></pattern></defs><rect width="100%" height="100%" fill="url(%23basketball)"/></svg>') center/cover;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 26, 46, 0.8);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 2rem;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .cta-btn {
            padding: 1rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cta-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
        }

        .cta-secondary {
            background: transparent;
            color: var(--text-primary);
            border: 2px solid var(--primary-color);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
        }

        /* Court Gallery Section */
        .court-section {
            padding: 100px 0;
            background: var(--card-bg);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 3rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gallery-container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .gallery-slider {
            position: relative;
            width: 100%;
            height: 500px;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: all 0.5s ease;
            background-size: cover;
            background-position: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide1 { background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/imgs/guada_court1.jpg" viewBox="0 0 800 500"><rect width="100%" height="100%" fill="%23228B22"/><rect x="50" y="50" width="700" height="400" fill="none" stroke="%23fff" stroke-width="4"/><circle cx="400" cy="250" r="80" fill="none" stroke="%23fff" stroke-width="3"/><rect x="50" y="180" width="120" height="140" fill="none" stroke="%23fff" stroke-width="3"/><rect x="630" y="180" width="120" height="140" fill="none" stroke="%23fff" stroke-width="3"/><text x="400" y="50" text-anchor="middle" fill="white" font-size="24">Basketball Court 1</text></svg>'); }
        
        .slide2 { background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/imgs/guada_court2.jpg" viewBox="0 0 800 500"><rect width="100%" height="100%" fill="%23FF6B35"/><rect x="50" y="50" width="700" height="400" fill="none" stroke="%23fff" stroke-width="4"/><circle cx="400" cy="250" r="80" fill="none" stroke="%23fff" stroke-width="3"/><rect x="50" y="180" width="120" height="140" fill="none" stroke="%23fff" stroke-width="3"/><rect x="630" y="180" width="120" height="140" fill="none" stroke="%23fff" stroke-width="3"/><text x="400" y="50" text-anchor="middle" fill="white" font-size="24">Basketball Court 2</text></svg>'); }
        
        .slide3 { background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('assets/imgs/guada_court3.jpg" viewBox="0 0 800 500"><rect width="100%" height="100%" fill="%230F4C75"/><rect x="50" y="50" width="700" height="400" fill="none" stroke="%23fff" stroke-width="4"/><circle cx="400" cy="250" r="80" fill="none" stroke="%23fff" stroke-width="3"/><rect x="50" y="180" width="120" height="140" fill="none" stroke="%23fff" stroke-width="3"/><rect x="630" y="180" width="120" height="140" fill="none" stroke="%23fff" stroke-width="3"/><text x="400" y="50" text-anchor="middle" fill="white" font-size="24">Basketball Court 3</text></svg>'); }

        .gallery-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 1rem;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .gallery-nav:hover {
            background: rgba(255, 107, 53, 0.8);
            transform: translateY(-50%) scale(1.1);
        }

        .prev { left: 20px; }
        .next { right: 20px; }

        .gallery-dots {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: var(--primary-color);
            transform: scale(1.2);
        }

        /* Login Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            transform: translateY(-50px);
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .modal h2 {
            font-size: 1.8rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.2);
        }

        .form-group input::placeholder {
            color: var(--text-secondary);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .register-link {
            text-align: center;
            color: var(--text-secondary);
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Animations */
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .gallery-slider {
                height: 300px;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                padding: 0 1rem;
            }

            .hero-content {
                padding: 1rem;
            }

            .container {
                padding: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo">
                <i class="fas fa-basketball-ball"></i> Barangay Ermita
            </a>
            <ul class="nav-links">
                <li><a href="login.php#top">Home</a></li>
                <li><a href="user/booking.php">Book Now</a></li>
                <li><a href="view_book.php">View Bookings</a></li>
            </ul>
            <button class="login-btn" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
            <button class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="floating">Barangay Ermita</h1>
            <p>We serve like you deserved</p>
            <div class="cta-buttons">
                <a href="#courts" class="cta-btn cta-primary">
                    <i class="fas fa-eye"></i> View Courts
                </a>
                <a href="#" class="cta-btn cta-secondary" id="bookNowBtn">
                    <i class="fas fa-calendar-plus"></i> Book Now
                </a>
            </div>
        </div>
    </section>

    <!-- Court Gallery Section -->
    <section id="courts" class="court-section">
        <div class="container">
            <h2 class="section-title">Our Courts</h2>
            <div class="gallery-container">
                <div class="gallery-slider">
                    <div class="slide slide1 active"></div>
                    <div class="slide slide2"></div>
                    <div class="slide slide3"></div>
                </div>
                <button class="gallery-nav prev" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="gallery-nav next" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="gallery-dots">
                <span class="dot active" data-slide="0"></span>
                <span class="dot" data-slide="1"></span>
                <span class="dot" data-slide="2"></span>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal-overlay" id="loginModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
                <button class="close-btn" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="login.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            <p class="register-link">
                Don't have an account? <a href="user/register.php">Register here</a>
            </p>
        </div>
    </div>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Modal functionality
        const loginBtn = document.getElementById('loginBtn');
        const bookNowBtn = document.getElementById('bookNowBtn');
        const loginModal = document.getElementById('loginModal');
        const closeModal = document.getElementById('closeModal');

        function openModal() {
            loginModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalFunc() {
            loginModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        loginBtn.addEventListener('click', openModal);
        bookNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal();
        });
        closeModal.addEventListener('click', closeModalFunc);

        loginModal.addEventListener('click', function(e) {
            if (e.target === loginModal) {
                closeModalFunc();
            }
        });

        // Escape key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && loginModal.classList.contains('active')) {
                closeModalFunc();
            }
        });

        // Gallery slider
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Handle wrap around
            if (index >= slides.length) currentSlide = 0;
            else if (index < 0) currentSlide = slides.length - 1;
            else currentSlide = index;

            // Add active class to current slide and dot
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        // Auto-play functionality
        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 4000);
        }

        function stopSlideshow() {
            clearInterval(slideInterval);
        }

        // Event listeners
        nextBtn.addEventListener('click', function() {
            stopSlideshow();
            nextSlide();
            startSlideshow();
        });

        prevBtn.addEventListener('click', function() {
            stopSlideshow();
            prevSlide();
            startSlideshow();
        });

        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                stopSlideshow();
                showSlide(index);
                startSlideshow();
            });
        });

        // Pause slideshow on hover
        const galleryContainer = document.querySelector('.gallery-container');
        galleryContainer.addEventListener('mouseenter', stopSlideshow);
        galleryContainer.addEventListener('mouseleave', startSlideshow);

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Initialize slideshow
        document.addEventListener('DOMContentLoaded', function() {
            startSlideshow();
        });

        // Add loading animation for images
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });
    </script>
</body>
</html>