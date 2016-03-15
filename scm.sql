-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2016 at 08:53 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scm`
--

-- --------------------------------------------------------

--
-- Table structure for table `revision`
--

CREATE TABLE IF NOT EXISTS `revision` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `comments` varchar(64) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `revision`
--

INSERT INTO `revision` (`id`, `file_id`, `version`, `comments`, `update_time`) VALUES
(31, 21, 1, 'фівфцвфів', '2016-03-14 14:38:24'),
(32, 21, 2, 'фівфцвфів', '2016-03-14 14:38:51'),
(33, 22, 1, 'first upload', '2016-03-15 07:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(64) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Email`, `Pass`, `FirstName`, `LastName`) VALUES
(1, '111@111.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'Andriy', 'Dziblyk'),
(2, '111@222.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'sdfsdf2', 'sdfsdfsdf3'),
(3, '333@333.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'sdfsdf', 'sdfsdf'),
(4, '444@444.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'sdf', 'sdfsdfsf'),
(9, 'asdasd@dses.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'Asdasdasss', 'Ssssss'),
(10, '1@1.com', '01112333444455555556667777777888899aaaabbbbbbcccccddddeeeeffffff', 'Dsdf', 'Dfd'),
(11, '3@3.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'Kota', 'Sprota'),
(12, '7@7.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'Andmin', 'Admin'),
(13, 'michal@wojtowicz.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'Michal', 'Wojtowicz'),
(14, '123@123.com', '000000011112333334455556667777888888999999aaaaabbbbbbbccccccddee', 'Sdad', 'Sdsdasd');

-- --------------------------------------------------------

--
-- Table structure for table `user_files`
--

CREATE TABLE IF NOT EXISTS `user_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(32) NOT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_files`
--

INSERT INTO `user_files` (`id`, `user_id`, `file_name`, `description`) VALUES
(21, 10, 'maцy.txt', 'фафіафіафіа'),
(22, 10, 'some.php', 'some description');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `revision`
--
ALTER TABLE `revision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `update_time` (`update_time`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Pass` (`Pass`);

--
-- Indexes for table `user_files`
--
ALTER TABLE `user_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file_name` (`file_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `revision`
--
ALTER TABLE `revision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_files`
--
ALTER TABLE `user_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `revision`
--
ALTER TABLE `revision`
  ADD CONSTRAINT `revision_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `user_files` (`id`);

--
-- Constraints for table `user_files`
--
ALTER TABLE `user_files`
  ADD CONSTRAINT `user_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
