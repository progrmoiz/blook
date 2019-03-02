-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2019 at 06:12 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blook`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `goodread_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `goodread_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `isbn` varchar(10) NOT NULL,
  `isbn13` varchar(13) NOT NULL,
  `published` date NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `image_url` varchar(200) NOT NULL,
  `description` text,
  `language_code` varchar(10) NOT NULL,
  `average_rating` double NOT NULL,
  `format` varchar(20) NOT NULL,
  `num_pages` int(11) NOT NULL,
  `similar_books_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buy_links`
--

CREATE TABLE `buy_links` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `bookId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `linkbookauthor`
--

CREATE TABLE `linkbookauthor` (
  `bookId` int(11) NOT NULL,
  `authorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `readstatus`
--

CREATE TABLE `readstatus` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `status_alt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(254) NOT NULL,
  `hashedPassword` varchar(60) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isAdmin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userfavoritecategory`
--

CREATE TABLE `userfavoritecategory` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `genre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userreadstatus`
--

CREATE TABLE `userreadstatus` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status_id` int(1) NOT NULL,
  `updateAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `goodread_id` (`goodread_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `goodread_id` (`goodread_id`),
  ADD UNIQUE KEY `isbn13` (`isbn13`);

--
-- Indexes for table `buy_links`
--
ALTER TABLE `buy_links`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD KEY `category_fk0` (`bookId`);

--
-- Indexes for table `linkbookauthor`
--
ALTER TABLE `linkbookauthor`
  ADD KEY `linkBookAuthor_fk1` (`bookId`),
  ADD KEY `linkBookAuthor_fk0` (`authorId`);

--
-- Indexes for table `readstatus`
--
ALTER TABLE `readstatus`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `userfavoritecategory`
--
ALTER TABLE `userfavoritecategory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`user_id`,`genre`) USING BTREE;

--
-- Indexes for table `userreadstatus`
--
ALTER TABLE `userreadstatus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`user_id`,`book_id`),
  ADD KEY `userReadStatus_fk1` (`book_id`),
  ADD KEY `userReadStatus_fk2` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userfavoritecategory`
--
ALTER TABLE `userfavoritecategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userreadstatus`
--
ALTER TABLE `userreadstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_fk0` FOREIGN KEY (`bookId`) REFERENCES `book` (`goodread_id`);

--
-- Constraints for table `linkbookauthor`
--
ALTER TABLE `linkbookauthor`
  ADD CONSTRAINT `linkBookAuthor_fk0` FOREIGN KEY (`authorId`) REFERENCES `author` (`goodread_id`),
  ADD CONSTRAINT `linkBookAuthor_fk1` FOREIGN KEY (`bookId`) REFERENCES `book` (`goodread_id`);

--
-- Constraints for table `userfavoritecategory`
--
ALTER TABLE `userfavoritecategory`
  ADD CONSTRAINT `userFavoriteCategory_fk0` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`id`);

--
-- Constraints for table `userreadstatus`
--
ALTER TABLE `userreadstatus`
  ADD CONSTRAINT `userReadStatus_fk0` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`id`),
  ADD CONSTRAINT `userReadStatus_fk1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `userReadStatus_fk2` FOREIGN KEY (`status_id`) REFERENCES `readstatus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
