-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2025 at 07:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `court_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_bookings`
--

CREATE TABLE `accepted_bookings` (
  `accepted_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phonenumber` varchar(150) NOT NULL,
  `court_type` varchar(150) NOT NULL,
  `date` varchar(150) NOT NULL,
  `time_slot` varchar(150) NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `accepted_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_bookings`
--

CREATE TABLE `cancelled_bookings` (
  `cancelled_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phonenumber` varchar(150) NOT NULL,
  `court_type` varchar(150) NOT NULL,
  `date` varchar(150) NOT NULL,
  `time_slot` varchar(150) NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `cancelled_date` datetime NOT NULL,
  `status` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `denied_bookings`
--

CREATE TABLE `denied_bookings` (
  `denied_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phonenumber` varchar(150) NOT NULL,
  `court_type` varchar(150) NOT NULL,
  `date` varchar(150) NOT NULL,
  `time_slot` varchar(150) NOT NULL,
  `created_at` varchar(150) NOT NULL,
  `denied_date` varchar(150) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `logs_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `user_agent` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`logs_id`, `users_id`, `username`, `role`, `ip_address`, `user_agent`) VALUES
(1, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Sa'),
(2, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Sa'),
(3, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Sa'),
(4, 11, 'admintest', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(5, 11, 'admintest', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(6, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(7, 3, 'ric', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(8, 3, 'ric', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(9, 3, 'ric', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(10, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(11, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(12, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(13, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(14, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(15, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(16, 15, 'admin123', 'admin', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(17, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(18, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(19, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(20, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(21, 16, 'ricss', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(22, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(23, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(24, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(25, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(26, 16, 'ricss', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa'),
(27, 12, 'rics', 'user', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Sa');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `court_type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time_slot` varchar(10) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `status` varchar(20) NOT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `created_at`, `status`, `users_id`) VALUES
(1, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2025-08-24', '5PM - 6PM', '2025-08-21 23:32:28.000000', 'PENDING', NULL),
(2, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Basketball', '2025-09-08', '4PM - 5PM', '2025-09-05 16:27:41.000000', 'PENDING', NULL),
(3, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', 'Volleyball', '2025-09-08', '1PM - 2PM', '2025-09-05 16:27:54.000000', 'PENDING', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `fullname`, `email`, `phonenumber`, `password`, `created_at`, `role`) VALUES
(2, NULL, '', NULL, '2147483647', '$2y$10$X9QPxSjrGcYs2BKSbkisWuyFaGtXCQ.sDLvHDj1LFzrUNFt6IfYCW', '2025-04-29 14:04:16', ''),
(3, 'Ric', '', NULL, '2147483647', '$2y$10$xKDDgQS2upqrC5Aijp1tk.YUTooDK7nttalhbR25SRmAHw9jk.NZ.', '2025-04-29 14:07:22', ''),
(4, 'ricc', '', NULL, '2147483647', '$2y$10$CZO6/GLOuhE9lRRrTqER3ODDaiTaBarMp4schLFKpdPTonOGySik6', '2025-05-01 07:14:02', ''),
(5, 'user', '', NULL, '2147483647', '$2y$10$TQDmm.ZG87axdvWAqjTYX.rr97yyTWdohbqXFtTQl7nZx0HFvgbn6', '2025-05-01 07:34:49', 'user'),
(6, 'test', '', NULL, '09198154880', '$2y$10$7yt.ebR18WaP4Sf5cmphqexKxQyh8OLFQgv1z6vYhSyDRRFOswlCG', '2025-06-12 05:08:01', 'user'),
(7, 'admin', '', NULL, NULL, '$2y$10$c2GZQKeFQ5HOa/mqoqtCLu5.YrW4duHGKONX1ZuM3PK', '2025-06-12 05:11:05', 'admin'),
(8, 'admin2', '', NULL, NULL, '$2y$10$FxWzo/DV42UzLIiHDP3RquexW7uR/4DpAem4YLOZ7M0', '2025-06-12 05:11:05', 'admin'),
(10, 'qwe', '', 'qwe@gmail.com', '09123456789', '$2y$10$UGFB722hsRSlXAgByRGr9e5Knw1xPafvNcGqf3y4EnNfVYUvDM62u', '2025-07-11 11:39:11', 'user'),
(11, 'admintest', '', 'admin@yahoo.com', '09123456778', '$2y$10$qoJDzP2BnG7Rqc2HdZmX7esuPXvi5Qw6pAl4hV5t78GKOjHUOWFxi', '2025-07-11 13:26:29', 'admin'),
(12, 'rics', 'rico ivan', 'rics@yahoo.com', '09123456789', '$2y$10$TbWRk22JSXhPFhwulURcIua6JjYhAQs7/HZ3.BeXf6h1KKv1FRNYS', '2025-08-21 15:48:39', 'user'),
(13, 'papi', '', 'ninyo@gmail.com', '09123456789', '$2y$10$CTzwGiYIwC/0zZJU4JuPG.UqvYvJWd5EUf.EsBXgKNfoUko.fgbzq', '2025-07-19 05:51:05', 'user'),
(14, 'kalbis', 'kristian dave kalbis', 'kalbis@gmail.com', '09123456789', '$2y$10$nDUbwiHPLGJcfnN54eT3SerRBhyziZ1Fkl8ULNn8hUk6kJ0UekVGO', '2025-07-19 06:30:29', 'user'),
(15, 'admin123', 'rico', 'rico@gmail.com', '09112456789', '$2y$10$M3YlBGY0dKumWO6aSHtx1uafAVW1wj1Zpmdcp3mva8tMtaxMsERvO', '2025-08-02 05:38:58', 'admin'),
(16, 'ricss', 'ricooo', 'rio@gmail.com', '09123456789', '$2y$10$FF9O/pIfcoDhuCco9g7KVeT8AY5cuyqtrQRrxD0DihqNy8ugMBuIi', '2025-09-05 16:32:59', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  ADD PRIMARY KEY (`accepted_id`),
  ADD KEY `fk_accepted_reservation` (`reservation_id`);

--
-- Indexes for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  ADD PRIMARY KEY (`cancelled_id`),
  ADD KEY `fk_cancelled_reservation` (`reservation_id`);

--
-- Indexes for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  ADD PRIMARY KEY (`denied_id`),
  ADD KEY `fk_denied_reservation` (`reservation_id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`logs_id`),
  ADD KEY `fk_loginlogs_users` (`users_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `fk_reservations_users` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  MODIFY `accepted_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  MODIFY `cancelled_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  MODIFY `denied_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  ADD CONSTRAINT `fk_accepted_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE;

--
-- Constraints for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  ADD CONSTRAINT `fk_cancelled_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE;

--
-- Constraints for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  ADD CONSTRAINT `fk_denied_reservation` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`) ON DELETE CASCADE;

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `fk_loginlogs_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
