-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2026 at 04:01 PM
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
-- Database: `attendance_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `roll_no` varchar(10) NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `date`, `roll_no`, `status`, `created_at`) VALUES
(1, '2026-03-02', 'BCA001', 'Present', '2026-03-02 14:35:59'),
(2, '2026-03-02', 'BCA002', 'Absent', '2026-03-02 14:36:01'),
(3, '2026-03-02', 'BCA003', 'Present', '2026-03-02 14:36:02'),
(4, '2026-03-02', 'BCA006', 'Present', '2026-03-02 14:37:03'),
(5, '2026-03-02', 'BCA005', 'Present', '2026-03-02 14:37:03'),
(6, '2026-03-02', 'BCA007', 'Present', '2026-03-02 14:37:05'),
(7, '2026-03-02', 'BCA004', 'Present', '2026-03-02 14:37:06'),
(8, '2026-03-02', 'BCA008', 'Present', '2026-03-02 14:37:06'),
(9, '2026-03-02', 'BCA009', 'Present', '2026-03-02 14:37:09'),
(10, '2026-03-02', 'BCA010', 'Present', '2026-03-02 14:38:26'),
(11, '2026-03-02', 'BISR0011', 'Present', '2026-03-02 14:47:23'),
(12, '2026-03-02', 'BISR0012', 'Absent', '2026-03-02 14:47:24'),
(13, '2026-03-02', 'BISR0013', 'Present', '2026-03-02 14:47:26'),
(14, '2026-03-02', 'BISR0014', 'Present', '2026-03-02 14:47:27'),
(15, '2026-03-02', 'BISR0015', 'Present', '2026-03-02 14:47:29'),
(16, '2026-03-02', 'BISR0016', 'Absent', '2026-03-02 14:54:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
