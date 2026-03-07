-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 07, 2026 at 06:11 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `birail_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_mobile` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `user_otp` int NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_status` enum('Pending','Verified','Blocked') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`user_id`, `user_name`, `user_mobile`, `user_email`, `user_otp`, `user_password`, `user_status`, `created_at`, `updated_at`) VALUES
(1, 'Ajit Kumar', '7808982006', 'ajitk23192@gmail.com', 704921, '$2y$10$79SFoUjInhLykOEH4XJKFeikenDv6RmzV4PQwcyebmzM1k0zLu3ZO', 'Verified', '2025-09-16 13:46:25', '2026-02-08 13:36:38'),
(5, 'Nilam Rajput', '06205526784', 'nilam23192@gmail.com', 810006, '$2y$10$EpRknQHEVt/P038rLJZ0xeJ/68ZgvU5S37OwREKH0oC1mRNk7FBd.', 'Verified', '2025-10-15 15:56:01', '2026-02-08 13:34:35'),
(6, 'Subol Sah', '+918578891610', 'subolsah23192@gmail.com', 186037, '$2y$10$1Wh2weklIRn.QUnXYBKYReMUl.xKwfZgY.xrKFR7dBYJ8gYubLIh.', 'Verified', '2025-12-09 17:35:48', '2025-12-09 17:36:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_mobile` (`user_mobile`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
