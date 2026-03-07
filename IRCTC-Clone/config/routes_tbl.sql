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
-- Table structure for table `routes_tbl`
--

CREATE TABLE `routes_tbl` (
  `route_id` int NOT NULL,
  `route_start` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `route_end` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `route_distance` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes_tbl`
--

INSERT INTO `routes_tbl` (`route_id`, `route_start`, `route_end`, `route_distance`, `created_at`, `updated_at`) VALUES
(18, 'Katihar', 'Bettiha', 700.00, '2025-09-12 14:25:01', '2025-09-13 12:33:16'),
(19, 'New Delhi', 'Mumbai', 1400.00, '2025-09-13 12:24:00', NULL),
(20, 'Kolkata', 'katihar', 1660.00, '2025-09-13 12:24:00', '2025-12-08 14:22:17'),
(21, 'Bengaluru', 'Hyderabad', 575.00, '2025-09-13 12:24:00', NULL),
(22, 'Mumbai', 'Bengaluru', 980.00, '2025-09-13 12:24:00', NULL),
(23, 'Chennai', 'New Delhi', 2180.00, '2025-09-13 12:24:00', NULL),
(24, 'Hyderabad', 'Kolkata', 1550.00, '2025-09-13 12:24:00', NULL),
(25, 'Lucknow', 'Jaipur', 610.00, '2025-09-13 12:24:00', NULL),
(26, 'Pune', 'Ahmedabad', 650.00, '2025-09-13 12:24:00', NULL),
(27, 'Surat', 'Vadodara', 155.00, '2025-09-13 12:24:00', NULL),
(28, 'Nagpur', 'Bhopal', 390.00, '2025-09-13 12:24:00', NULL),
(29, 'Jaipur', 'Chennai', 2170.00, '2025-09-13 12:24:00', NULL),
(30, 'Patna', 'Katihar', 305.00, '2025-09-13 12:24:00', NULL),
(31, 'Guwahati', 'Agartala', 550.00, '2025-09-13 12:24:00', NULL),
(32, 'Bhubaneswar', 'Visakhapatnam', 440.00, '2025-09-13 12:24:00', NULL),
(33, 'Amritsar', 'Chandigarh', 230.00, '2025-09-13 12:24:00', NULL),
(34, 'Kochi', 'Thiruvananthapuram', 210.00, '2025-09-13 12:24:00', NULL),
(35, 'Jammu Tawi', 'Srinagar', 265.00, '2025-09-13 12:24:00', NULL),
(36, 'Varanasi', 'Prayagraj', 120.00, '2025-09-13 12:24:00', NULL),
(37, 'Bhopal', 'Indore', 190.00, '2025-09-13 12:24:00', NULL),
(38, 'Gwalior', 'Jhansi', 100.00, '2025-09-13 12:24:00', NULL),
(39, 'Delhi', 'Kolkata', 1500.00, '2025-09-13 12:24:00', NULL),
(40, 'Mumbai', 'Kochi', 1250.00, '2025-09-13 12:24:00', NULL),
(41, 'Hyderabad', 'Chennai', 625.00, '2025-09-13 12:24:00', NULL),
(42, 'Bengaluru', 'Kolkata', 1870.00, '2025-09-13 12:24:00', NULL),
(43, 'Ahmedabad', 'Lucknow', 1180.00, '2025-09-13 12:24:00', NULL),
(44, 'Jaipur', 'Bhubaneswar', 1675.00, '2025-09-13 12:24:00', NULL),
(45, 'Indore', 'Visakhapatnam', 1200.00, '2025-09-13 12:24:00', NULL),
(46, 'Thiruvananthapuram', 'Mumbai', 1680.00, '2025-09-13 12:24:00', NULL),
(47, 'Agra', 'Varanasi', 600.00, '2025-09-13 12:24:00', NULL),
(48, 'Madurai', 'Coimbatore', 220.00, '2025-09-13 12:24:00', NULL),
(49, 'Delhi', 'Amritsar', 450.00, '2025-09-13 12:24:00', NULL),
(50, 'Guwahati', 'Kolkata', 990.00, '2025-09-13 12:24:00', NULL),
(51, 'Mumbai', 'Kolkata', 1965.00, '2025-09-13 12:24:00', NULL),
(52, 'Chennai', 'Hyderabad', 650.00, '2025-09-13 12:24:00', NULL),
(53, 'Bengaluru', 'New Delhi', 2380.00, '2025-09-13 12:24:00', NULL),
(54, 'Lucknow', 'Hyderabad', 1260.00, '2025-09-13 12:24:00', NULL),
(55, 'Pune', 'Lucknow', 1400.00, '2025-09-13 12:24:00', NULL),
(56, 'Ahmedabad', 'Bhopal', 580.00, '2025-09-13 12:24:00', NULL),
(57, 'Vadodara', 'Surat', 155.00, '2025-09-13 12:24:00', NULL),
(58, 'Bhopal', 'Nagpur', 390.00, '2025-09-13 12:24:00', NULL),
(59, 'Chennai', 'Jaipur', 2170.00, '2025-09-13 12:24:00', NULL),
(60, 'Katihar', 'Patna', 305.00, '2025-09-13 12:24:00', NULL),
(61, 'Agartala', 'Guwahati', 550.00, '2025-09-13 12:24:00', NULL),
(62, 'Visakhapatnam', 'Bhubaneswar', 440.00, '2025-09-13 12:24:00', NULL),
(63, 'Chandigarh', 'Amritsar', 230.00, '2025-09-13 12:24:00', NULL),
(64, 'Thiruvananthapuram', 'Kochi', 210.00, '2025-09-13 12:24:00', NULL),
(65, 'Srinagar', 'Jammu Tawi', 265.00, '2025-09-13 12:24:00', NULL),
(66, 'Prayagraj', 'Varanasi', 120.00, '2025-09-13 12:24:00', NULL),
(67, 'Indore', 'Bhopal', 190.00, '2025-09-13 12:24:00', NULL),
(68, 'Jhansi', 'Gwalior', 100.00, '2025-09-13 12:24:00', NULL),
(69, 'katihar', 'patna', 298.00, '2025-10-17 05:07:18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `routes_tbl`
--
ALTER TABLE `routes_tbl`
  ADD PRIMARY KEY (`route_id`),
  ADD KEY `idx_route` (`route_start`,`route_end`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `routes_tbl`
--
ALTER TABLE `routes_tbl`
  MODIFY `route_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
