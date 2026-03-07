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
-- Table structure for table `trains_tbl`
--

CREATE TABLE `trains_tbl` (
  `train_id` int NOT NULL,
  `train_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `train_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `train_route_id` int NOT NULL,
  `train_ac_capacity` int UNSIGNED DEFAULT '0',
  `train_sl_capacity` int UNSIGNED DEFAULT '0',
  `train_gn_capacity` int UNSIGNED DEFAULT '0',
  `train_total_capacity` int UNSIGNED GENERATED ALWAYS AS (((`train_ac_capacity` + `train_sl_capacity`) + `train_gn_capacity`)) STORED,
  `train_stime` time NOT NULL,
  `train_etime` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trains_tbl`
--

INSERT INTO `trains_tbl` (`train_id`, `train_number`, `train_name`, `train_route_id`, `train_ac_capacity`, `train_sl_capacity`, `train_gn_capacity`, `train_stime`, `train_etime`, `created_at`, `updated_at`) VALUES
(6, '2562010', 'Nilam Express', 18, 1, 0, 0, '20:00:00', '00:50:00', '2025-09-13 12:35:10', '2025-09-13 12:35:10'),
(7, '12850', 'Mumbai Express', 4, 120, 300, 200, '06:30:00', '22:15:00', '2025-09-13 12:27:00', NULL),
(8, '22432', 'Chennai Mail', 5, 150, 450, 250, '19:45:00', '15:20:00', '2025-09-13 12:27:00', NULL),
(9, '18615', 'Hyderabad Superfast', 3, 80, 250, 150, '08:00:00', '19:00:00', '2025-09-13 12:27:00', NULL),
(10, '12953', 'Agartala Express', 13, 100, 350, 180, '22:00:00', '12:30:00', '2025-09-13 12:27:00', NULL),
(11, '15018', 'Gomti Express', 7, 90, 280, 170, '05:40:00', '13:00:00', '2025-09-13 12:27:00', NULL),
(12, '11030', 'Amritsar Mail', 15, 75, 200, 100, '04:15:00', '09:00:00', '2025-09-13 12:27:00', NULL),
(13, '14521', 'Kochi Fast', 16, 110, 320, 210, '11:00:00', '16:00:00', '2025-09-13 12:27:00', NULL),
(14, '12411', 'Bhubaneswar Superfast', 14, 130, 400, 220, '15:30:00', '23:00:00', '2025-09-13 12:27:00', NULL),
(15, '12860', 'Prayagraj Express', 18, 95, 275, 160, '07:00:00', '10:30:00', '2025-09-13 12:27:00', NULL),
(16, '22201', 'Duronto Express', 21, 140, 0, 0, '21:00:00', '13:00:00', '2025-09-13 12:27:00', NULL),
(17, '12137', 'Deccan Queen', 8, 85, 260, 180, '10:10:00', '18:50:00', '2025-09-13 12:27:00', NULL),
(18, '11029', 'Vadodara Fast', 9, 60, 180, 90, '06:00:00', '09:00:00', '2025-09-13 12:27:00', NULL),
(19, '12627', 'Jammu Mail', 17, 105, 310, 190, '08:30:00', '15:45:00', '2025-09-13 12:27:00', NULL),
(20, '12628', 'Mumbai Superfast', 22, 115, 330, 220, '20:30:00', '16:00:00', '2025-09-13 12:27:00', NULL),
(21, '12642', 'Kerala Express', 28, 130, 420, 240, '18:00:00', '11:00:00', '2025-09-13 12:27:00', NULL),
(22, '12631', 'Guwahati Express', 32, 100, 310, 180, '09:00:00', '23:30:00', '2025-09-13 12:27:00', NULL),
(23, '12656', 'Kolkata Mail', 33, 160, 480, 280, '14:00:00', '12:00:00', '2025-09-13 12:27:00', NULL),
(24, '12662', 'Hyderabad Express', 34, 125, 350, 220, '23:00:00', '08:00:00', '2025-09-13 12:27:00', NULL),
(25, '12666', 'New Delhi Express', 35, 140, 400, 230, '16:00:00', '08:00:00', '2025-09-13 12:27:00', NULL),
(26, '12674', 'Lucknow Express', 36, 110, 320, 190, '07:30:00', '21:00:00', '2025-09-13 12:27:00', NULL),
(27, '12678', 'Bhopal Fast', 38, 95, 280, 160, '06:00:00', '15:00:00', '2025-09-13 12:27:00', NULL),
(28, '12682', 'Surat Express', 39, 70, 200, 120, '08:00:00', '11:00:00', '2025-09-13 12:27:00', NULL),
(29, '12686', 'Nagpur Fast', 40, 80, 240, 130, '05:30:00', '11:00:00', '2025-09-13 12:27:00', NULL),
(30, '12690', 'Jaipur Express', 41, 130, 380, 210, '19:00:00', '13:00:00', '2025-09-13 12:27:00', NULL),
(31, '12694', 'Katihar Fast', 42, 60, 180, 90, '09:30:00', '16:00:00', '2025-09-13 12:27:00', NULL),
(32, '12698', 'Guwahati Express', 43, 90, 280, 150, '08:45:00', '21:00:00', '2025-09-13 12:27:00', NULL),
(33, '12702', 'Bhubaneswar Express', 44, 110, 330, 200, '12:00:00', '20:00:00', '2025-09-13 12:27:00', NULL),
(34, '12706', 'Amritsar Mail', 45, 80, 240, 130, '06:00:00', '11:00:00', '2025-09-13 12:27:00', NULL),
(35, '12710', 'Kerala Fast', 46, 120, 350, 220, '11:30:00', '16:30:00', '2025-09-13 12:27:00', NULL),
(36, '12714', 'Srinagar Express', 47, 95, 280, 160, '09:00:00', '16:00:00', '2025-09-13 12:27:00', NULL),
(37, '12718', 'Prayagraj Fast', 48, 70, 210, 110, '07:30:00', '10:30:00', '2025-09-13 12:27:00', NULL),
(38, '12722', 'Bhopal Express', 49, 85, 250, 140, '06:00:00', '11:00:00', '2025-09-13 12:27:00', NULL),
(39, '12726', 'Gwalior Fast', 50, 65, 190, 100, '05:00:00', '07:30:00', '2025-09-13 12:27:00', NULL),
(40, '12730', 'Lucknow Fast', 7, 95, 280, 160, '08:00:00', '15:00:00', '2025-09-13 12:27:00', NULL),
(41, '12734', 'Mumbai Express', 2, 140, 400, 250, '19:00:00', '10:00:00', '2025-09-13 12:27:00', NULL),
(42, '12738', 'Duronto Express', 2, 100, 0, 0, '05:00:00', '10:30:00', '2025-09-13 12:27:00', NULL),
(43, '12742', 'Express', 3, 75, 220, 130, '09:00:00', '15:00:00', '2025-09-13 12:27:00', NULL),
(44, '12746', 'Superfast Express', 4, 110, 310, 190, '12:00:00', '18:00:00', '2025-09-13 12:27:00', NULL),
(45, '12750', 'Rajdhani Express', 5, 150, 450, 250, '15:00:00', '21:00:00', '2025-09-13 12:27:00', NULL),
(46, '12754', 'Mail Express', 6, 90, 260, 150, '06:30:00', '13:00:00', '2025-09-13 12:27:00', NULL),
(47, '12758', 'Sampark Kranti', 7, 100, 300, 180, '18:00:00', '23:00:00', '2025-09-13 12:27:00', NULL),
(48, '12762', 'Garib Rath', 8, 120, 350, 220, '07:00:00', '14:00:00', '2025-09-13 12:27:00', NULL),
(49, '12766', 'Jan Shatabdi', 9, 80, 240, 140, '05:30:00', '10:30:00', '2025-09-13 12:27:00', NULL),
(50, '12770', 'Humsafar Express', 10, 130, 380, 200, '17:00:00', '02:00:00', '2025-09-13 12:27:00', NULL),
(51, '12774', 'Vande Bharat', 11, 140, 0, 0, '06:00:00', '13:00:00', '2025-09-13 12:27:00', NULL),
(52, '12778', 'Duronto Express', 12, 100, 0, 0, '09:00:00', '14:00:00', '2025-09-13 12:27:00', NULL),
(53, '12782', 'Express', 13, 70, 200, 120, '15:00:00', '22:00:00', '2025-09-13 12:27:00', NULL),
(54, '12786', 'Superfast Express', 14, 115, 330, 200, '18:30:00', '02:00:00', '2025-09-13 12:27:00', NULL),
(55, '12790', 'Rajdhani Express', 15, 145, 420, 240, '21:00:00', '05:00:00', '2025-09-13 12:27:00', NULL),
(56, '12794', 'Mail Express', 16, 85, 250, 140, '04:00:00', '09:00:00', '2025-09-13 12:27:00', NULL),
(57, '12798', 'Sampark Kranti', 17, 95, 280, 160, '07:30:00', '15:30:00', '2025-09-13 12:27:00', NULL),
(58, '12802', 'Garib Rath', 18, 125, 360, 220, '10:00:00', '17:00:00', '2025-09-13 12:27:00', NULL),
(59, '12806', 'Jan Shatabdi', 19, 75, 220, 130, '06:00:00', '09:00:00', '2025-09-13 12:27:00', NULL),
(60, '12810', 'Humsafar Express', 20, 135, 400, 210, '18:00:00', '03:00:00', '2025-09-13 12:27:00', NULL),
(61, '12814', 'Vande Bharat', 21, 150, 0, 0, '07:30:00', '14:30:00', '2025-09-13 12:27:00', NULL),
(62, '12818', 'Duronto Express', 22, 110, 0, 0, '10:00:00', '16:00:00', '2025-09-13 12:27:00', NULL),
(63, '12822', 'Express', 23, 80, 230, 140, '16:00:00', '23:00:00', '2025-09-13 12:27:00', NULL),
(64, '12826', 'Superfast Express', 24, 120, 350, 220, '19:30:00', '03:00:00', '2025-09-13 12:27:00', NULL),
(65, '12830', 'Rajdhani Express', 25, 155, 450, 260, '22:00:00', '07:00:00', '2025-09-13 12:27:00', NULL),
(66, '12834', 'Mail Express', 26, 95, 280, 160, '05:00:00', '11:30:00', '2025-09-13 12:27:00', NULL),
(67, '12838', 'Sampark Kranti', 27, 105, 310, 180, '08:30:00', '16:00:00', '2025-09-13 12:27:00', NULL),
(68, '12842', 'Garib Rath', 28, 130, 380, 230, '11:00:00', '19:00:00', '2025-09-13 12:27:00', NULL),
(69, '12846', 'Jan Shatabdi', 29, 85, 250, 140, '06:30:00', '10:00:00', '2025-09-13 12:27:00', NULL),
(71, '12854', 'Vande Bharat', 31, 160, 0, 0, '08:00:00', '15:00:00', '2025-09-13 12:27:00', NULL),
(72, '05740', 'Patna Special', 60, 100, 200, 300, '11:15:00', '05:40:00', '2025-10-17 05:20:13', '2025-10-17 05:20:13'),
(73, '000001', 'Vande Bharat Express', 39, 100, 200, 400, '00:00:00', '22:00:00', '2025-10-19 14:27:02', NULL),
(74, '12309', 'Rajdhani Express', 18, 50, 100, 200, '16:55:00', '08:30:00', '2025-10-19 14:40:30', '2025-10-19 14:40:30'),
(75, '12951', 'Mumbai Rajdhani', 35, 50, 100, 200, '17:00:00', '08:35:00', '2025-10-19 14:40:44', '2025-10-19 14:40:44'),
(76, '12301', 'Duronto Express', 37, 50, 100, 200, '22:05:00', '10:50:00', '2025-10-19 14:40:57', '2025-10-19 14:40:57'),
(77, '12227', 'Duronto Express', 68, 50, 100, 200, '20:00:00', '05:00:00', '2025-10-19 14:41:09', '2025-10-19 14:41:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trains_tbl`
--
ALTER TABLE `trains_tbl`
  ADD PRIMARY KEY (`train_id`),
  ADD UNIQUE KEY `train_number` (`train_number`),
  ADD KEY `idx_route` (`train_route_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trains_tbl`
--
ALTER TABLE `trains_tbl`
  MODIFY `train_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
