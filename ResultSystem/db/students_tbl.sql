-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2026 at 08:28 PM
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
-- Database: `result_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `students_tbl`
--

CREATE TABLE `students_tbl` (
  `id` int(11) NOT NULL,
  `rollno` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT 'Male',
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `math` int(11) DEFAULT 0,
  `sc` int(11) DEFAULT 0,
  `ssc` int(11) DEFAULT 0,
  `eng` int(11) DEFAULT 0,
  `hnd` int(11) DEFAULT 0,
  `obmarks` int(11) DEFAULT 0,
  `percentage` decimal(5,2) DEFAULT 0.00,
  `division` varchar(50) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `grade_point` decimal(3,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_tbl`
--

INSERT INTO `students_tbl` (`id`, `rollno`, `name`, `fname`, `mname`, `dob`, `gender`, `email`, `phone`, `address`, `math`, `sc`, `ssc`, `eng`, `hnd`, `obmarks`, `percentage`, `division`, `grade`, `grade_point`, `created_at`, `updated_at`) VALUES
(10, 1, 'Nilam Sah', 'Ajit SAH', 'Nilam SAH', '2010-03-25', 'Male', NULL, NULL, NULL, 66, 77, 58, 78, 98, 377, 75.40, 'First Division', 'A+', 9.00, '2026-04-03 18:19:57', '2026-04-03 18:19:57'),
(11, 19, 'Carl Parrish', 'Nina Kennedy', 'Xenos Morrow', '1973-11-18', 'Male', NULL, NULL, NULL, 45, 59, 84, 51, 70, 309, 61.80, 'First Division', 'A', 8.00, '2026-04-03 18:20:22', '2026-04-03 18:20:22');

--
-- Triggers `students_tbl`
--
DELIMITER $$
CREATE TRIGGER `after_student_update` AFTER UPDATE ON `students_tbl` FOR EACH ROW BEGIN
    INSERT INTO result_logs (student_id, action, old_data, new_data)
    VALUES (NEW.id, 'UPDATE', 
            JSON_OBJECT('marks', OLD.obmarks, 'percentage', OLD.percentage),
            JSON_OBJECT('marks', NEW.obmarks, 'percentage', NEW.percentage));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students_tbl`
--
ALTER TABLE `students_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rollno` (`rollno`),
  ADD KEY `idx_rollno` (`rollno`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_division` (`division`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students_tbl`
--
ALTER TABLE `students_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
