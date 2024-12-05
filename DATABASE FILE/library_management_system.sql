-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 12:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_ID` int(11) NOT NULL,
  `admin_username` varchar(60) NOT NULL,
  `admin_password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_username`, `admin_password`) VALUES
(1, 'admin', 'administration');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `ISBN` int(11) NOT NULL,
  `book_title` varchar(50) NOT NULL,
  `book_author` varchar(50) NOT NULL,
  `book_category` varchar(50) NOT NULL,
  `book_published` year(4) NOT NULL,
  `book_copies` int(11) NOT NULL,
  `book_is_request` tinyint(1) NOT NULL,
  `admin_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`ISBN`, `book_title`, `book_author`, `book_category`, `book_published`, `book_copies`, `book_is_request`, `admin_ID`) VALUES
(9, 'New Book Title', 'Author Name', 'Category', '2023', 10, 1, 1),
(14, 'Atomic Habits', 'James Clear', 'Non Fiction', '2017', 231, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `book_request`
--

CREATE TABLE `book_request` (
  `br_ID` int(11) NOT NULL,
  `br_title` varchar(60) NOT NULL,
  `br_author` varchar(60) NOT NULL,
  `br_category` varchar(60) NOT NULL,
  `br_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stud_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_request`
--

INSERT INTO `book_request` (`br_ID`, `br_title`, `br_author`, `br_category`, `br_date`, `stud_id`) VALUES
(3, 'Ikigai', 'Unknown', 'Non Fiction', '2023-12-08 02:49:09', 3);

-- --------------------------------------------------------

--
-- Table structure for table `book_transactions`
--

CREATE TABLE `book_transactions` (
  `bt_ID` int(11) NOT NULL,
  `bt_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bt_status` int(11) NOT NULL DEFAULT 0,
  `ISBN` int(11) NOT NULL,
  `s_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_transactions`
--

INSERT INTO `book_transactions` (`bt_ID`, `bt_date`, `bt_status`, `ISBN`, `s_ID`) VALUES
(16, '2023-12-08 02:50:22', 1, 9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_ID` int(11) NOT NULL,
  `s_fname` varchar(50) NOT NULL,
  `s_lname` varchar(50) NOT NULL,
  `s_course` varchar(50) NOT NULL,
  `s_section` varchar(50) NOT NULL,
  `s_year` int(11) NOT NULL,
  `s_username` varchar(50) NOT NULL,
  `s_password` varchar(50) NOT NULL,
  `admin_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_ID`, `s_fname`, `s_lname`, `s_course`, `s_section`, `s_year`, `s_username`, `s_password`, `admin_ID`) VALUES
(1, 'Marealie', 'Espedillon', 'BSIT', 'E', 3, 'marealie', 'marealie123', NULL),
(2, 'Shiela', 'Clorado', 'BSIT', 'E', 3, 'sheila', 'sheila123', NULL),
(3, 'Rondale', 'Bufete', 'BSIT', 'E', 3, 'rondale', 'rondale123', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `admin_books_fk` (`admin_ID`);

--
-- Indexes for table `book_request`
--
ALTER TABLE `book_request`
  ADD PRIMARY KEY (`br_ID`),
  ADD KEY `stud_id` (`stud_id`);

--
-- Indexes for table `book_transactions`
--
ALTER TABLE `book_transactions`
  ADD PRIMARY KEY (`bt_ID`),
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `s_ID` (`s_ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_ID`),
  ADD KEY `admin_ID` (`admin_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `ISBN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `book_request`
--
ALTER TABLE `book_request`
  MODIFY `br_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `book_transactions`
--
ALTER TABLE `book_transactions`
  MODIFY `bt_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `admin_books_fk` FOREIGN KEY (`admin_ID`) REFERENCES `admin` (`admin_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `book_request`
--
ALTER TABLE `book_request`
  ADD CONSTRAINT `stud_id` FOREIGN KEY (`stud_id`) REFERENCES `students` (`s_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_transactions`
--
ALTER TABLE `book_transactions`
  ADD CONSTRAINT `ISBN` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s_ID` FOREIGN KEY (`s_ID`) REFERENCES `students` (`s_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `admin_ID` FOREIGN KEY (`admin_ID`) REFERENCES `admin` (`admin_ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
