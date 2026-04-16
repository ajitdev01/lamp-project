-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 08:16 AM
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
-- Database: `bi_library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` text NOT NULL,
  `admin_otp` int(6) DEFAULT NULL,
  `admin_status` varchar(55) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_otp`, `admin_status`, `created_at`, `updated_at`) VALUES
(1, 'Mr. Admin ', 'admin@bilibrary.com', '$2y$10$8ChViTGZpr05cFfa72R7Zu1yOx37plC1Z7YbU0MMC.uthzcpLktJ6', NULL, 'Active', '2026-03-31 06:50:28', '2026-03-31 06:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `books_tbl`
--

CREATE TABLE `books_tbl` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_isbn` varchar(55) NOT NULL,
  `book_edition` varchar(55) NOT NULL,
  `book_description` text NOT NULL,
  `book_image` text NOT NULL,
  `book_pyear` year(4) NOT NULL,
  `book_pages` int(11) NOT NULL,
  `book_instock` tinyint(1) NOT NULL,
  `librarian_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books_tbl`
--

INSERT INTO `books_tbl` (`book_id`, `book_title`, `book_author`, `book_isbn`, `book_edition`, `book_description`, `book_image`, `book_pyear`, `book_pages`, `book_instock`, `librarian_id`, `created_at`, `updated_at`) VALUES
(5, 'Lake Effect: A Novel', 'Cynthia DAprix Sweeney', '978-0063480896', '1st Edition', 'From the New York Times bestselling author of The Nest and Good Company comes a wry and tender portrait of two families forever changed by one lovestruck decision that will reverberate for decades.\r\n\r\nIt’s 1977 and an air of restlessness has settled on the residents of Cambridge Road in Rochester, New York, a place long fueled by the booming fortunes of Kodak and Xerox and, for some, the mores of the Catholic church. When Nina Larkin is given a copy of The Joy of Sex by her newly divorced friend, she can no longer dismiss the nearly nonexistent intimacy of her marriage. Just as her oldest child, Clara, is falling in love for the first time, Nina finds herself longing for the forbidden: a midlife awakening. An intoxicating fling with a prominent neighbor brings Nina a freedom she never thought possible—but also risks the reputations of both families and unravels Clara’s world, just as she stands on the threshold of adulthood.\r\n\r\nYears later, Clara, now a successful food stylist in New York City, has never been able to move past the long-ago scandal. Drawn back home by the pull of a family wedding and wrestling with her own demons, she makes a pivotal decision that turns her life upside down. Written with Cynthia DAprix Sweeneys signature humor and insight, Lake Effect is a wise and probing look at love and desire, mothers and daughters, loss and grief, and what we owe the people we love most. ', '1775106990_image_2026_4_2_783.webp', '2026', 256, 1, 13, '2026-04-02 05:16:30', '2026-04-02 05:16:30'),
(6, 'The Future Saints', 'Ashley Winstead', '978-1035920303', '5th Edition', 'THE NEW ROMANCE NOVEL FROM TIKTOK SENSATION ASHLEY WINSTEAD. When young record-label manager Theo encounters the band Future Saints, they’re playing at dive bar steps from their hometown, at the tail-end of a downward spiral following the death of their manager. Manifest, their record company, has sent Theo to coax a last-ditch record out of them. Theo is struck right away by Hannah, the group’s impetuous lead singer, who has gone off script in debuting a new song—and, in fact, a whole new sound. Theo\'s supposed to get the band back on track, but when their new music garners an even wider fan base than before, the plans begin to change—new tour, new record, new start. But Hannah’s descent into grief has larger consequences for the group, and she’s not willing to let go yet… not for fame or love. For fans of Daisy Jones and the Six and It Ends With Us, this is a love story – just not the one you’re expecting.', '1775107291_image_2026_4_2_359.webp', '2026', 384, 0, 13, '2026-04-02 05:21:31', '2026-04-02 06:19:51'),
(7, 'Winning People Without Losing Yourself', 'Ankur Warikoo', '978-0670099832', '4th Edition', 'Growing up, I believed life was about skills and degrees.\r\nUntil I entered the real world and realized something uncomfortable.\r\nMy skills mattered far less than my ability to deal with people.\r\nSomewhere along the way, I was simply tired.\r\nOf trying to make it work with people.\r\nI was struggling to answer: How do you deal with people without losing yourself?\r\nMost books teach you how to manage your mind. Very few teach you how to navigate other humans. This one does.\r\n\r\nIt is a collection of sharp, lived truths about how people behave, why they behave that way, and how you can respond with clarity instead of chaos.\r\n\r\nOne page. One insight. Start from any page.', '1775107496_image_2026_4_2_960.webp', '2026', 328, 1, 13, '2026-04-02 05:24:56', '2026-04-02 05:24:56'),
(8, 'Tension Mat Le Yaar', 'Divya Prakash Dubey', '978-8119555949', '2nd Edition', 'हर इंसान दो लड़ाइयाँ लड़ रहा है—एक दुनिया से, और एक ख़ुद से।\r\n\r\nबस इतना जान लो, तुम अकेले नहीं हो।”\r\n\r\nयह किताब मोटिवेशन नहीं देती—यह आपको गले लगाती है।\r\n\r\nटेंशन मत ले यार उन लोगों के लिए है\r\n\r\nजो सफल दिखते हुए भी भीतर से थके हुए हैं।\r\n\r\nजो सही रास्ते पर होने के बावजूद खोया हुआ महसूस करते हैं।\r\n\r\nजो बार-बार खुद से पूछते हैं— मैं कौन हूँ? मैं क्यों हूँ?', '1775107621_image_2026_4_2_162.webp', '2026', 208, 1, 13, '2026-04-02 05:27:01', '2026-04-02 05:27:01'),
(9, 'When the Rain Came: Volume 1', 'Matthew Eicheldinger', '979-8881605131', '3rd Edition', 'The rain never stops. The world is drowning. Survival is everything. This is the first book in a new gripping dystopian adventure series for young adult readers by New York Times bestselling author Matt Eicheldinger.\r\n\r\n“If we stay here, if we keep wandering without a real plan, we won’t last. Maybe The Hill is dangerous. But maybe it’s not. Maybe it’s the only plan we have.”\r\n \r\nSixteen-year-old Aurora knows how to survive. Life in the foster system has taught her how to stay quiet, stay smart, and stay ready. But nothing could prepare her for this: a never-ending storm that swallows cities, drowns forests, and turns the world into a flooded wasteland.', '1775107734_image_2026_4_2_585.webp', '2026', 320, 1, 13, '2026-04-02 05:28:54', '2026-04-02 05:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `issued_tbl`
--

CREATE TABLE `issued_tbl` (
  `isd_id` int(11) NOT NULL,
  `isd_request_id` int(11) NOT NULL,
  `isd_book_id` int(11) NOT NULL,
  `isd_st_id` int(11) NOT NULL,
  `isd_return_date` date NOT NULL,
  `isd_status` enum('Issued','Returned') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_tbl`
--

INSERT INTO `issued_tbl` (`isd_id`, `isd_request_id`, `isd_book_id`, `isd_st_id`, `isd_return_date`, `isd_status`, `created_at`, `updated_at`) VALUES
(1, 2, 8, 5, '2026-04-10', 'Returned', '2026-04-09 05:47:13', '2026-04-10 05:36:47'),
(2, 5, 9, 5, '2026-04-25', 'Returned', '2026-04-10 05:27:48', '2026-04-10 05:38:46'),
(3, 6, 7, 5, '2026-04-16', 'Returned', '2026-04-13 05:17:56', '2026-04-13 05:21:06'),
(4, 8, 9, 5, '2026-04-24', 'Returned', '2026-04-13 06:03:55', '2026-04-13 06:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `librarian_tbl`
--

CREATE TABLE `librarian_tbl` (
  `lb_id` int(11) NOT NULL,
  `lb_name` varchar(255) NOT NULL,
  `lb_email` varchar(255) NOT NULL,
  `lb_password` text NOT NULL,
  `lb_otp` int(11) DEFAULT NULL,
  `lb_status` enum('Pending','Active','Blocked','Inactive') NOT NULL,
  `lb_image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `librarian_tbl`
--

INSERT INTO `librarian_tbl` (`lb_id`, `lb_name`, `lb_email`, `lb_password`, `lb_otp`, `lb_status`, `lb_image`, `created_at`, `updated_at`) VALUES
(1, 'Gary Hawkins', 'haku@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:34:39', '2026-03-31 06:34:39'),
(2, 'Brent Alexander', 'luvuridun@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:34:58', '2026-03-31 06:34:58'),
(3, 'Lacota Finch', 'tetypaf@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:09', '2026-03-31 06:35:09'),
(4, 'Alice Davis', 'wuzereta@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:11', '2026-03-31 06:35:11'),
(5, 'Mercedes Parrish', 'hyduk@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:14', '2026-03-31 06:35:14'),
(6, 'Clayton Vincent', 'zizysu@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:16', '2026-03-31 06:35:16'),
(7, 'Vivian Gamble', 'didiladas@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:19', '2026-03-31 06:35:19'),
(8, 'Nadine Cardenas', 'qerewetol@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:21', '2026-03-31 06:35:21'),
(9, 'Maggy Chen', 'qizif@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:24', '2026-03-31 06:35:24'),
(10, 'Paula Kirkland', 'xutizivek@mailinator.com', 'Pa$$w0rd!', NULL, 'Active', '', '2026-03-31 06:35:26', '2026-03-31 06:35:26'),
(11, 'Skyler Hopper', 'wezafex@mailinator.com', '$2y$10$NPP/Y.nAaem08fueemYoB.yfW1pDToS8cRe0Ss0aK1es.HGFkY/bS', NULL, 'Active', '', '2026-03-31 06:36:54', '2026-03-31 06:36:54'),
(12, 'Jarrod Brooks', 'pydivow@mailinator.com', '$2y$10$FYw2tGVUFU9N2eUzmE.FFO87EbSNSFe8zB48U4JkSlEbl.ysoYZwe', NULL, 'Active', '', '2026-03-31 06:37:03', '2026-03-31 06:37:03'),
(13, 'Raj', 'raj@gmail.com', '$2y$10$SuFhHkoxY0yhBcwKyva7nOT2bKtDw.x76KwJ4.yzIbod.vnBoRIMK', NULL, 'Active', '', '2026-04-01 05:51:53', '2026-04-01 05:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `requests_tbl`
--

CREATE TABLE `requests_tbl` (
  `request_id` int(11) NOT NULL,
  `request_book_id` int(11) NOT NULL,
  `request_st_id` int(11) NOT NULL,
  `request_for_date` date NOT NULL,
  `request_status` enum('Pending','Issued','Rejected','Queue','Returned') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests_tbl`
--

INSERT INTO `requests_tbl` (`request_id`, `request_book_id`, `request_st_id`, `request_for_date`, `request_status`, `created_at`, `updated_at`) VALUES
(2, 8, 5, '2026-04-10', 'Returned', '2026-04-03 05:55:51', '2026-04-13 05:43:18'),
(3, 7, 5, '2026-04-17', 'Rejected', '2026-04-03 06:12:43', '2026-04-09 05:27:54'),
(4, 9, 5, '2026-05-30', 'Rejected', '2026-04-07 05:44:42', '2026-04-09 05:52:39'),
(5, 9, 5, '2026-04-25', 'Returned', '2026-04-10 05:27:21', '2026-04-13 05:43:09'),
(6, 7, 5, '2026-04-16', 'Returned', '2026-04-13 05:17:46', '2026-04-13 05:21:06'),
(7, 9, 5, '2026-04-15', 'Rejected', '2026-04-13 05:43:37', '2026-04-13 06:03:32'),
(8, 9, 5, '2026-04-24', 'Returned', '2026-04-13 06:03:45', '2026-04-13 06:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `students_tbl`
--

CREATE TABLE `students_tbl` (
  `st_id` int(11) NOT NULL,
  `st_name` varchar(255) NOT NULL,
  `st_email` varchar(255) NOT NULL,
  `st_password` text NOT NULL,
  `st_otp` int(6) NOT NULL,
  `st_status` enum('Pending','Active','Inactive','Blocked') NOT NULL,
  `st_image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_tbl`
--

INSERT INTO `students_tbl` (`st_id`, `st_name`, `st_email`, `st_password`, `st_otp`, `st_status`, `st_image`, `created_at`, `updated_at`) VALUES
(1, 'Naida Murphy', 'fesyl@mailinator.com', '$2y$10$SgnFqE1pherjLG2O.Wwyd.unoRf2.JBSy0Fp8rRjYWe2NxqrwNWrO', 0, 'Active', '', '2026-04-01 05:48:31', '2026-04-01 05:48:31'),
(2, 'Zenia', 'bybolut@mailinator.com', '$2y$10$xRNrkIfTGA5wdRAk2pXXo.elEFNYORlKhnM0FpTeML7vHayld6lh6', 0, 'Active', '1775108707_', '2026-04-02 05:45:07', '2026-04-02 05:45:07'),
(3, 'Karina', 'zavo@mailinator.com', '$2y$10$mceeP.HbiUBWUI3rbzMH7Oq/msgXM51Pw5j/9xkhQxFD2Vce7QB2q', 0, 'Active', '1775108786_WhatsApp_Image_2026-03-30_at_2.25.09_PM-removebg-preview.png', '2026-04-02 05:46:26', '2026-04-02 05:46:26'),
(4, 'Derek', 'vegaru@mailinator.com', '$2y$10$w8SyDuwhMG5kbHTDV3rIkOQ8nNSdR3RRzgwbo3ipenyX.6/G41KLe', 0, 'Active', 'user.webp', '2026-04-02 05:54:45', '2026-04-02 05:54:45'),
(5, 'Ritesh Kumar', 'ritesh@gmail.com', '$2y$10$HUuYep0mWRKjKsM.ntN6e.oYJBszW6x/Djwkr8RSd8//z6.I/dKUC', 0, 'Active', '1775802118_image_2026_3_31_581.jpg', '2026-04-02 05:57:17', '2026-04-10 06:21:58'),
(6, 'Afiya', 'afiya@gmail.com', '$2y$10$Tq02KafV4zvUPbi.vWEafeKNuOr81EEUf1936mEUkaFzQ.Qw5VxoC', 0, 'Active', 'user.webp', '2026-04-02 05:57:43', '2026-04-02 05:57:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `books_tbl`
--
ALTER TABLE `books_tbl`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `issued_tbl`
--
ALTER TABLE `issued_tbl`
  ADD PRIMARY KEY (`isd_id`);

--
-- Indexes for table `librarian_tbl`
--
ALTER TABLE `librarian_tbl`
  ADD PRIMARY KEY (`lb_id`);

--
-- Indexes for table `requests_tbl`
--
ALTER TABLE `requests_tbl`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `students_tbl`
--
ALTER TABLE `students_tbl`
  ADD PRIMARY KEY (`st_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books_tbl`
--
ALTER TABLE `books_tbl`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `issued_tbl`
--
ALTER TABLE `issued_tbl`
  MODIFY `isd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `librarian_tbl`
--
ALTER TABLE `librarian_tbl`
  MODIFY `lb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `requests_tbl`
--
ALTER TABLE `requests_tbl`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students_tbl`
--
ALTER TABLE `students_tbl`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
