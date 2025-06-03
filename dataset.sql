-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 12:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback_answers`
--

CREATE TABLE `feedback_answers` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `reply` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_answers`
--

INSERT INTO `feedback_answers` (`id`, `group_id`, `question_id`, `rating`, `reply`, `email`, `created_at`) VALUES
(3, 53, 23, 4, 'kjac qcw', 'ezhil@gmail.com', NULL),
(4, 53, 24, 4, 'kjac qcw', 'ezhil@gmail.com', NULL),
(5, 54, 24, 5, 'Welcome', 'prakash@gmail.com', NULL),
(6, 54, 23, 4, 'Welcome', 'prakash@gmail.com', NULL),
(7, 54, 22, 3, 'Welcome', 'prakash@gmail.com', NULL),
(8, 54, 24, 4, 'thankyou So Much', 'kiruba@gmail.com', NULL),
(9, 54, 23, 3, 'thankyou So Much', 'kiruba@gmail.com', NULL),
(10, 54, 22, 5, 'thankyou So Much', 'kiruba@gmail.com', NULL),
(11, 54, 24, 5, 'vdsv', 'kalai@gmail.com', NULL),
(12, 54, 23, 4, 'vdsv', 'kalai@gmail.com', NULL),
(13, 54, 22, 2, 'vdsv', 'kalai@gmail.com', NULL),
(14, 54, 24, 5, 'mac sa', 'raman@gmail.com', NULL),
(15, 54, 23, 4, 'mac sa', 'raman@gmail.com', NULL),
(16, 54, 22, 2, 'mac sa', 'raman@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_groups`
--

CREATE TABLE `feedback_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_groups`
--

INSERT INTO `feedback_groups` (`id`, `name`, `created_at`) VALUES
(53, 'Group 1', '2025-05-20 16:21:36'),
(54, 'group2', '2025-05-21 07:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_question`
--

CREATE TABLE `feedback_question` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_question`
--

INSERT INTO `feedback_question` (`id`, `name`, `message`, `created_at`) VALUES
(22, 'prakash', 'this ui very beautiful', '2025-05-20 12:37:27'),
(23, 'kalai', 'its more beautiful design', '2025-05-20 12:38:00'),
(24, 'kiruba', 'this design more beautiful', '2025-05-20 12:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `group_questions`
--

CREATE TABLE `group_questions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_questions`
--

INSERT INTO `group_questions` (`id`, `group_id`, `question_id`) VALUES
(69, 53, 24),
(70, 53, 23),
(71, 54, 24),
(72, 54, 23),
(73, 54, 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'kakashi', 'kakasi123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback_answers`
--
ALTER TABLE `feedback_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_groups`
--
ALTER TABLE `feedback_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_question`
--
ALTER TABLE `feedback_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_questions`
--
ALTER TABLE `group_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback_answers`
--
ALTER TABLE `feedback_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `feedback_groups`
--
ALTER TABLE `feedback_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `feedback_question`
--
ALTER TABLE `feedback_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `group_questions`
--
ALTER TABLE `group_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_questions`
--
ALTER TABLE `group_questions`
  ADD CONSTRAINT `group_questions_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `feedback_groups` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
