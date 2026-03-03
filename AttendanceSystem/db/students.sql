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
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `roll_no` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course` varchar(55) NOT NULL,
  `status` enum('Pending','Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `roll_no`, `name`, `mobile`, `email`, `course`, `status`, `created_at`, `updated_at`) VALUES
(11, 'BISR0011', 'Willow Morales', '+1 (381) 733-4879', 'pycerox@mailinator.com', 'Corrupti consectetu', 'Active', '2026-03-02 14:44:14', '2026-03-02 14:44:14'),
(12, 'BISR0012', 'Maile Hardin', '+1 (317) 894-9678', 'pefut@mailinator.com', 'Non ipsum eum sint', 'Active', '2026-03-02 14:44:22', '2026-03-02 14:44:22'),
(13, 'BISR0013', 'Maile Hardin', '+1 (317) 894-9678', 'pefut@mailinator.com', 'Non ipsum eum sint', 'Active', '2026-03-02 14:44:51', '2026-03-02 14:44:51'),
(14, 'BISR0014', 'Jade Vaughn', '+1 (885) 897-5267', 'civor@mailinator.com', 'Eiusmod est doloremq', 'Active', '2026-03-02 14:45:23', '2026-03-02 14:45:23'),
(15, 'BISR0015', 'AJIT KUMAR', '6205526784', 'ajitk23192@gmail.com', 'DevSecOps Eng', 'Active', '2026-03-02 14:45:45', '2026-03-02 14:45:45'),
(16, 'BISR0016', 'Tate Christian', '+1 (468) 306-7741', 'cezofon@mailinator.com', 'Architecto officiis', 'Active', '2026-03-02 14:54:44', '2026-03-02 14:54:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_roll_no` (`roll_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
