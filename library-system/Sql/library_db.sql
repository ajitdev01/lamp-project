-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 23, 2026 at 05:40 AM
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
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive','blocked') DEFAULT 'active',
  `profile_image` varchar(255) DEFAULT 'default-admin.png',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `status`, `profile_image`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'AJIT', 'ajitk23192@gmail.com', '$2y$10$fLQH2Grev6sfRawYczqoNuuQOAIm2PyOdpVJYFVDPaLjPbJrUvfa.', 'active', '1767515265.jpeg\r\n', '2026-02-23 05:30:17', '2026-01-04 07:57:31', '2026-02-23 05:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `image` varchar(255) DEFAULT 'default-book.png',
  `quantity` int NOT NULL DEFAULT '0',
  `available_quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `isbn`, `image`, `quantity`, `available_quantity`, `created_at`) VALUES
(43, 'Learning Python', 'Mark Lutz', 'Fiction', '9781449355739', '1771824795.jpeg', 11, 8, '2026-01-03 12:09:43'),
(44, 'Effective Java', 'Joshua Bloch', 'Java', '9780134685991', 'default-book.jpg', 6, 4, '2026-01-03 12:09:43'),
(45, 'Head First Design Patterns', 'Eric Freeman', 'Software Engineering', '9780596007126', 'default-book.jpg', 4, 3, '2026-01-03 12:09:43'),
(46, 'Operating System Concepts', 'Silberschatz', 'OS', '9781119800361', 'default-book.jpg', 5, 4, '2026-01-03 12:09:43'),
(47, 'Computer Networks', 'Andrew S. Tanenbaum', 'Networking', '9780132126953', 'default-book.jpg', 6, 6, '2026-01-03 12:09:43'),
(48, 'Database System Concepts', 'Abraham Silberschatz', 'Database', '9780073523323', 'default-book.jpg', 7, 7, '2026-01-03 12:09:43'),
(49, 'Web Development with Node & Express', 'Ethan Brown', 'Node.js', '9781492053514', 'default-book.jpg', 8, 7, '2026-01-03 12:09:43'),
(50, 'React Explained', 'Zac Gordon', 'React', '9781735467207', 'default-book.jpg', 10, 10, '2026-01-03 12:09:43'),
(51, 'MongoDB: The Definitive Guide', 'Kristina Chodorow', 'MongoDB', '9781491954461', 'default-book.jpg', 6, 6, '2026-01-03 12:09:43'),
(52, 'Docker Deep Dive', 'Nigel Poulton', 'DevOps', '9781521822807', 'default-book.jpg', 9, 9, '2026-01-03 12:09:43'),
(53, 'Kubernetes Up & Running', 'Kelsey Hightower', 'DevOps', '9781491935675', 'default-book.jpg', 5, 5, '2026-01-03 12:09:43'),
(54, 'Linux Command Line', 'William Shotts', 'Linux', '9781593279523', 'default-book.jpg', 12, 12, '2026-01-03 12:09:43'),
(55, 'Git Pro', 'Scott Chacon', 'Version Control', '9781484200773', 'default-book.jpg', 15, 15, '2026-01-03 12:09:43'),
(56, 'test1', 'you', 'History', '1234567890102', '1767515265.jpeg', 5, 5, '2026-01-04 08:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` int NOT NULL,
  `patron_id` int NOT NULL,
  `book_id` int NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned','overdue') DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`id`, `patron_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`) VALUES
(1, 1, 43, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(2, 12, 44, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(3, 12, 56, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(4, 12, 43, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(5, 12, 46, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(6, 1, 49, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(7, 1, 56, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(8, 18, 56, '2026-01-04', '2026-01-18', NULL, 'borrowed'),
(9, 1, 44, '2026-02-23', '2026-03-09', NULL, 'borrowed'),
(10, 1, 45, '2026-02-23', '2026-03-09', NULL, 'borrowed'),
(11, 20, 43, '2026-02-23', '2026-03-09', NULL, 'borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `patrons`
--

CREATE TABLE `patrons` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patrons`
--

INSERT INTO `patrons` (`id`, `name`, `email`, `phone`, `address`, `city`, `state`, `zip_code`, `date_of_birth`, `gender`, `password`, `status`, `created_at`) VALUES
(1, 'AJIT', 'nilam23192@gmail.com', '0620552678', 'DRM Building', NULL, 'Bihar', '854105', '2013-01-02', 'Male', '$2y$10$BO9lbxyYbfgNwAChBtJPSuG3.icJr6H7h/Ks8eFhD7etnb6V/.EOO', 'Active', '2026-01-03 13:00:37'),
(12, 'Liam Anderson', 'test@123', '555-010-1234', '123 Oak Lane', NULL, 'CO', '80201', '1990-05-15', 'Male', '$2y$10$rFL2gcxaXGCT4nF3a/BRyOsy4iC7pYg4RmnqFdOAQRPiwiK8.0Meq', 'Active', '2026-01-04 08:59:01'),
(13, 'Sophia Martinez', 's.martinez@webmail.net', '555-010-5678', '456 Pine Terrace', 'Austin', 'TX', '73301', '1995-11-22', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Suspended', '2026-01-04 08:59:01'),
(14, 'Zoya ', 'james.wilson@corp.org', '123456789', '789 Birch Court', 'Seattle', 'WA', '98101', '1982-03-10', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Inactive', '2026-01-04 08:59:01'),
(17, 'AJIT', 'nilam292@gmail.com', '', '', '', '', '', '2013-01-02', 'Other', '$2y$10$I.BTR8s4P4U2OJlDJxsVaePPrZAmJiN6soHLw97p/VapVXojoR79K', 'Active', '2026-01-04 12:32:46'),
(18, 'testJii1', 'testJii@1.com', '', '', '', '', '', '2013-01-04', 'Male', '$2y$10$/72YF9VuR7/sfwSvXHAL5e0iwMgUqjz1TzA/TuJvj0o8ANI9WpPRG', 'Active', '2026-01-04 12:41:28'),
(19, 'testJii@2.com', 'testJii@2.com', '', '', '', '', '', '2012-12-30', 'Male', '$2y$10$YzQhxkjTUXnNunN5OAcEA.fBoM3/sBNW7QZrp/e3XforoednyMnsG', 'Active', '2026-01-04 12:45:42'),
(20, 'alertMessage', 'alertMessage@g.com', '', '', '', '', '', '2013-01-04', 'Male', '$2y$10$ggeQ6eh0HytCpB9WlUwd7.VdC2DwZu99oMldPKObGDHfUYokz/VRe', 'Active', '2026-01-04 12:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `patron_id` int NOT NULL,
  `book_id` int NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `request_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `patron_id`, `book_id`, `status`, `request_date`) VALUES
(1, 1, 43, 'Approved', '2026-01-04 11:00:44'),
(2, 12, 56, 'Rejected', '2026-01-04 11:26:02'),
(3, 12, 43, 'Rejected', '2026-01-04 11:37:53'),
(4, 12, 44, 'Approved', '2026-01-04 11:37:55'),
(5, 12, 45, 'Rejected', '2026-01-04 11:37:57'),
(6, 12, 43, 'Approved', '2026-01-04 11:58:01'),
(7, 12, 56, 'Approved', '2026-01-04 12:01:05'),
(8, 12, 55, 'Rejected', '2026-01-04 12:04:02'),
(9, 12, 51, 'Rejected', '2026-01-04 12:04:07'),
(10, 12, 46, 'Approved', '2026-01-04 12:04:10'),
(11, 1, 49, 'Approved', '2026-01-04 12:10:45'),
(12, 1, 44, 'Approved', '2026-01-04 12:12:06'),
(13, 1, 45, 'Approved', '2026-01-04 12:15:30'),
(14, 1, 56, 'Approved', '2026-01-04 12:15:45'),
(15, 18, 56, 'Approved', '2026-01-04 12:41:40'),
(16, 20, 43, 'Approved', '2026-01-04 12:47:50'),
(17, 20, 56, 'Pending', '2026-02-23 05:33:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patron_id` (`patron_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `patrons`
--
ALTER TABLE `patrons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patrons`
--
ALTER TABLE `patrons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_ibfk_1` FOREIGN KEY (`patron_id`) REFERENCES `patrons` (`id`),
  ADD CONSTRAINT `borrows_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
