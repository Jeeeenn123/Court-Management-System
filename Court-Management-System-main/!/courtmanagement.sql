-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 04:43 AM
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
-- Database: `courtmanagement`
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

--
-- Dumping data for table `accepted_bookings`
--

INSERT INTO `accepted_bookings` (`accepted_id`, `reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `created_at`, `accepted_date`, `status`) VALUES
(1, 16, 'test1 ', 'rico', 'test@gmail.com', '12436345747', 'Volleyball', '2025-07-31', '11AM - 12P', '2025-07-30 19:45:23.000000', '2025-07-30 19:52:29', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_bookings`
--

CREATE TABLE `cancelled_bookings` (
  `cancelled_id` int(11) NOT NULL,
  `reservation_id` varchar(100) NOT NULL,
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

--
-- Dumping data for table `cancelled_bookings`
--

INSERT INTO `cancelled_bookings` (`cancelled_id`, `reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `created_at`, `cancelled_date`, `status`) VALUES
(1, '18', 'test1 ', 0, 'test@gmail.com', '12436345747', 'Basketball', '2025-07-31', '4PM - 5PM', '2025-07-30 20:52:07.000000', '2025-07-30 21:05:09', 'Cancelled'),
(2, '20', 'test1 ', 0, 'test@gmail.com', '12436345747', 'Basketball', '2025-07-31', '7PM - 8PM', '2025-07-30 20:54:05.000000', '2025-07-30 21:05:18', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `denied_bookings`
--

CREATE TABLE `denied_bookings` (
  `denied_id` int(11) NOT NULL,
  `reservation_id` varchar(100) NOT NULL,
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

--
-- Dumping data for table `denied_bookings`
--

INSERT INTO `denied_bookings` (`denied_id`, `reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `created_at`, `denied_date`, `status`) VALUES
(1, '14', 'kalbis', 'krintian dave kalbis', 'kalbis@gmail.com', '09123456789', 'basketball', '2025-07-20', '14-16', '2025-07-19 14:31:53.000000', '2025-07-30 19:52:42', 'Denied');

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
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `username`, `fullname`, `email`, `phonenumber`, `court_type`, `date`, `time_slot`, `created_at`, `status`) VALUES
(17, 'test1 ', 'rico nasad', 'test@gmail.com', '12436345747', 'Basketball', '2025-07-31', '11AM - 12P', '2025-07-30 12:51:39.000000', 'PENDING'),
(19, 'test1 ', 'asdasdasdasd', 'test@gmail.com', '12436345747', 'Volleyball', '2025-07-31', '7PM - 8PM', '2025-07-30 12:52:44.000000', 'PENDING');

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
(1, NULL, '', NULL, '2147483647', '$2y$10$TSUErRsRb4E6qUKwlQYQC.76JySCXqg0vVffSgMumEHrOLaEfUp.K', '2025-04-29 14:03:33', ''),
(2, NULL, '', NULL, '2147483647', '$2y$10$X9QPxSjrGcYs2BKSbkisWuyFaGtXCQ.sDLvHDj1LFzrUNFt6IfYCW', '2025-04-29 14:04:16', ''),
(3, 'Ric', '', NULL, '2147483647', '$2y$10$xKDDgQS2upqrC5Aijp1tk.YUTooDK7nttalhbR25SRmAHw9jk.NZ.', '2025-04-29 14:07:22', ''),
(4, 'ricc', '', NULL, '2147483647', '$2y$10$CZO6/GLOuhE9lRRrTqER3ODDaiTaBarMp4schLFKpdPTonOGySik6', '2025-05-01 07:14:02', ''),
(5, 'user', '', NULL, '2147483647', '$2y$10$TQDmm.ZG87axdvWAqjTYX.rr97yyTWdohbqXFtTQl7nZx0HFvgbn6', '2025-05-01 07:34:49', 'user'),
(6, 'test', '', NULL, '09198154880', '$2y$10$7yt.ebR18WaP4Sf5cmphqexKxQyh8OLFQgv1z6vYhSyDRRFOswlCG', '2025-06-12 05:08:01', 'user'),
(7, 'admin', '', NULL, NULL, '$2y$10$c2GZQKeFQ5HOa/mqoqtCLu5.YrW4duHGKONX1ZuM3PK', '2025-06-12 05:11:05', 'admin'),
(8, 'admin2', '', NULL, NULL, '$2y$10$FxWzo/DV42UzLIiHDP3RquexW7uR/4DpAem4YLOZ7M0', '2025-06-12 05:11:05', 'admin'),
(9, 'test1 ', '', 'test@gmail.com', '12436345747', '$2y$10$5vK1fbHUuFVQ64ELqzHiiOCdSdpTAMLZy/BM5bP9OO0IbcIs5IbHO', '2025-06-14 06:09:08', 'admin'),
(10, 'qwe', '', 'qwe@gmail.com', '09123456789', '$2y$10$UGFB722hsRSlXAgByRGr9e5Knw1xPafvNcGqf3y4EnNfVYUvDM62u', '2025-07-11 11:39:11', 'user'),
(11, 'admintest', '', 'admin@yahoo.com', '09123456778', '$2y$10$qoJDzP2BnG7Rqc2HdZmX7esuPXvi5Qw6pAl4hV5t78GKOjHUOWFxi', '2025-07-11 13:26:29', 'admin'),
(12, 'rics', '', 'rics@yahoo.com', '09123456789', '$2y$10$TbWRk22JSXhPFhwulURcIua6JjYhAQs7/HZ3.BeXf6h1KKv1FRNYS', '2025-07-12 05:28:47', 'user'),
(13, 'papi', '', 'ninyo@gmail.com', '09123456789', '$2y$10$CTzwGiYIwC/0zZJU4JuPG.UqvYvJWd5EUf.EsBXgKNfoUko.fgbzq', '2025-07-19 05:51:05', 'user'),
(14, 'kalbis', 'kristian dave kalbis', 'kalbis@gmail.com', '09123456789', '$2y$10$nDUbwiHPLGJcfnN54eT3SerRBhyziZ1Fkl8ULNn8hUk6kJ0UekVGO', '2025-07-19 06:30:29', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  ADD PRIMARY KEY (`accepted_id`);

--
-- Indexes for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  ADD PRIMARY KEY (`cancelled_id`);

--
-- Indexes for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  ADD PRIMARY KEY (`denied_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

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
  MODIFY `accepted_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  MODIFY `cancelled_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  MODIFY `denied_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accepted_bookings`
--
ALTER TABLE `accepted_bookings`
  ADD CONSTRAINT `accepted_bookings_ibfk_1` FOREIGN KEY (`accepted_id`) REFERENCES `users` (`users_id`);

--
-- Constraints for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  ADD CONSTRAINT `cancelled_bookings_ibfk_1` FOREIGN KEY (`cancelled_id`) REFERENCES `users` (`users_id`);

--
-- Constraints for table `denied_bookings`
--
ALTER TABLE `denied_bookings`
  ADD CONSTRAINT `denied_bookings_ibfk_1` FOREIGN KEY (`denied_id`) REFERENCES `users` (`users_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
