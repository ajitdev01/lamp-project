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
-- Table structure for table `bookings_tbl`
--

CREATE TABLE `bookings_tbl` (
  `booking_tbl` int NOT NULL,
  `pnr_no` varchar(22) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `train_id` int NOT NULL,
  `train_no` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `route_id` int NOT NULL,
  `booking_status` varchar(33) COLLATE utf8mb4_general_ci NOT NULL,
  `doj` date NOT NULL,
  `base_fare` decimal(10,2) NOT NULL,
  `tax_fee` decimal(10,2) NOT NULL,
  `total_amt` decimal(10,2) NOT NULL,
  `payment_id` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_ref` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `passengers_info` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings_tbl`
--

INSERT INTO `bookings_tbl` (`booking_tbl`, `pnr_no`, `user_id`, `train_id`, `train_no`, `route_id`, `booking_status`, `doj`, `base_fare`, `tax_fee`, `total_amt`, `payment_id`, `payment_ref`, `created_at`, `updated_at`, `passengers_info`) VALUES
(10, '45324935903', 5, 58, '12802', 18, 'Pending', '2026-01-01', 2000.00, 100.00, 2100.00, 'pay_RpaQHDWMYVdeZx', 'OnlinePayment', '2025-12-09 16:56:09', NULL, '[{\"name\":\"AJIT KUMAR\",\"age\":\"19\",\"gender\":\"Male\",\"coach\":\"General\"},{\"name\":\"Nilam Kumari\",\"age\":\"16\",\"gender\":\"Female\",\"coach\":\"AC\"},{\"name\":\"mom\",\"age\":\"46\",\"gender\":\"Female\",\"coach\":\"AC\"},{\"name\":\"nana\",\"age\":\"55\",\"gender\":\"Male\",\"coach\":\"Sleeper\"}]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings_tbl`
--
ALTER TABLE `bookings_tbl`
  ADD PRIMARY KEY (`booking_tbl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings_tbl`
--
ALTER TABLE `bookings_tbl`
  MODIFY `booking_tbl` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
