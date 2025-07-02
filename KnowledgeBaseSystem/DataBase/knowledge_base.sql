-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 04:30 PM
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
-- Database: `knowledge_base`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `doc_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`doc_id`, `title`, `content`, `author_id`, `is_public`, `last_modified`) VALUES
(1, 'the project', '<h2 style=\"font-style:italic;\"><strong>some data to ubdated the project discription can make list of it done by own</strong></h2>', 1, 1, '2025-07-02 11:35:00'),
(2, 'poject demo', '<p>nothing to share&nbsp mgqeljhgey;</p>', 1, 0, '2025-07-02 11:35:10'),
(3, 'info of new project', '<p>bold dicition made&nbsp; changer in futcher</p>\r\n', 1, 1, '2025-07-02 12:04:21'),
(4, 'Project Plan', 'Initial project plan with milestones and goals. the plan', 1, 1, '2025-07-02 14:15:32'),
(5, 'Team Guidelines', 'Team collaboration and communication policies.', 2, 0, '2025-07-02 14:01:21'),
(6, 'Marketing Strategy', 'Outline of the product marketing phases.', 3, 0, '2025-07-02 13:21:49'),
(7, 'Technical Specs', 'Detailed technical specifications of the system. add', 4, 1, '2025-07-02 14:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `doc_access`
--

CREATE TABLE `doc_access` (
  `access_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission` enum('view','edit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doc_access`
--

INSERT INTO `doc_access` (`access_id`, `doc_id`, `user_id`, `permission`) VALUES
(1, 3, 2, 'view'),
(2, 1, 2, 'view'),
(3, 1, 3, 'edit'),
(4, 2, 1, 'view'),
(5, 2, 3, 'edit'),
(6, 2, 4, 'view'),
(7, 3, 1, 'view'),
(8, 3, 4, 'edit'),
(9, 4, 3, 'edit'),
(10, 5, 2, 'edit'),
(11, 5, 4, 'view'),
(12, 6, 1, 'view'),
(13, 6, 3, 'edit'),
(14, 7, 4, 'edit'),
(15, 7, 2, 'edit'),
(16, 1, 2, 'view'),
(17, 1, 3, 'edit'),
(18, 2, 1, 'view'),
(19, 2, 3, 'edit'),
(20, 2, 4, 'view'),
(21, 3, 1, 'view'),
(22, 3, 4, 'edit'),
(23, 4, 3, 'edit'),
(24, 5, 2, 'edit'),
(25, 5, 4, 'view'),
(26, 6, 1, 'view'),
(27, 6, 3, 'edit'),
(28, 7, 4, 'edit'),
(29, 7, 2, 'view'),
(30, 1, 4, 'view'),
(31, 2, 2, 'edit'),
(32, 3, 2, 'view'),
(33, 4, 1, 'view'),
(34, 4, 2, 'edit'),
(35, 5, 3, 'edit'),
(36, 6, 4, 'view'),
(37, 7, 1, 'view'),
(38, 7, 3, 'view');

-- --------------------------------------------------------

--
-- Table structure for table `doc_versions`
--

CREATE TABLE `doc_versions` (
  `version_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `modified_by` int(11) NOT NULL,
  `version_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doc_versions`
--

INSERT INTO `doc_versions` (`version_id`, `doc_id`, `content`, `modified_by`, `version_timestamp`) VALUES
(1, 1, 'Test content version', 2, '2025-07-02 10:36:49'),
(2, 1, '<h2 style=\"font-style:italic;\"><strong>some data to ubdated the project discription can make list of it done dsts</strong></h2>', 1, '2025-07-02 11:15:59'),
(3, 1, '<h2 style=\"font-style:italic;\"><strong>some data to ubdated the project discription can make list of it done by own</strong></h2>', 1, '2025-07-02 11:35:00'),
(4, 2, '<p>nothing to share&nbsp mgqeljhgey;</p>', 1, '2025-07-02 11:35:10'),
(5, 1, 'Initial version of Project Plan', 1, '2025-07-02 13:25:58'),
(6, 1, 'Updated plan with comments from team', 3, '2025-07-02 13:25:58'),
(7, 2, 'Initial Guidelines', 2, '2025-07-02 13:25:58'),
(8, 2, 'Revised with new protocols', 3, '2025-07-02 13:25:58'),
(9, 3, 'Draft marketing phases', 3, '2025-07-02 13:25:58'),
(10, 3, 'Included Q3 promotion strategy', 4, '2025-07-02 13:25:58'),
(11, 4, 'Technical specs draft', 4, '2025-07-02 13:25:58'),
(12, 4, 'Added database schema details', 3, '2025-07-02 13:25:58'),
(13, 5, 'First release note', 1, '2025-07-02 13:25:58'),
(14, 5, 'Fixed typos, added footer', 2, '2025-07-02 13:25:58'),
(15, 6, 'Basic user guide', 2, '2025-07-02 13:25:58'),
(16, 6, 'Included troubleshooting section', 3, '2025-07-02 13:25:58'),
(17, 7, 'Bug log v1', 3, '2025-07-02 13:25:58'),
(18, 7, 'Added UI-related bugs', 4, '2025-07-02 13:25:58'),
(19, 7, 'Marked bugs as fixed', 1, '2025-07-02 13:25:58'),
(20, 5, 'Team collaboration and communication policies. as did', 2, '2025-07-02 13:50:01'),
(21, 5, 'Team collaboration and communication policies.', 2, '2025-07-02 14:01:21'),
(22, 7, 'Detailed technical specifications of the system. add', 2, '2025-07-02 14:15:10'),
(23, 4, 'Initial project plan with milestones and goals. the plan', 2, '2025-07-02 14:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `reset_token`, `created_at`) VALUES
(1, 'Anjan Kumar N', 'anjankumar31n@gmail.com', '$2y$10$AL1pBla8OdkwWGcUW26TVuQ/l3CvlxH8Mqe7l09KvLaP0cpIsWYNG', NULL, '2025-07-02 07:51:58'),
(2, 'sunil', 'anjankumar3132004@gmail.com', '$2y$10$tbxxjuB6ppW4G0LEmQWIAOCPOHl/7h4LXpPDKBJJqVjWHFozlVLQ.', NULL, '2025-07-02 08:49:48'),
(3, 'anithan', 'rvit22bcs407.rvitm@rvei.edu.in', '$2y$10$bllkUa2QX32vYNN1.syPQeblT.SvbQRp/DAglGFMEXPeMQ20tzgXW', NULL, '2025-07-02 12:26:54'),
(4, 'anil', 'innocentdecent71@gmail.com', '$2y$10$nDVqC/M1TocoKbaWhivViu2y/n1IT9omvhln5qJpoUV7lUvqnMIJG', NULL, '2025-07-02 13:20:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `author_id` (`author_id`);
ALTER TABLE `documents` ADD FULLTEXT KEY `title` (`title`,`content`);

--
-- Indexes for table `doc_access`
--
ALTER TABLE `doc_access`
  ADD PRIMARY KEY (`access_id`),
  ADD KEY `doc_id` (`doc_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `doc_versions`
--
ALTER TABLE `doc_versions`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `doc_id` (`doc_id`),
  ADD KEY `modified_by` (`modified_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doc_access`
--
ALTER TABLE `doc_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `doc_versions`
--
ALTER TABLE `doc_versions`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `doc_access`
--
ALTER TABLE `doc_access`
  ADD CONSTRAINT `doc_access_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `documents` (`doc_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doc_access_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `doc_versions`
--
ALTER TABLE `doc_versions`
  ADD CONSTRAINT `doc_versions_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `documents` (`doc_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doc_versions_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
