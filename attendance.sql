-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 03:39 AM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityID` varchar(11) NOT NULL,
  `activityName` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(150) NOT NULL,
  `advisorID` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityID`, `activityName`, `date`, `time`, `location`, `advisorID`) VALUES
('0001', 'Annual General Meeting', '2026-05-08', '09:00:00', 'Lecture Theatre', '0001'),
('0002', 'New Members Briefing', '2026-05-11', '10:00:00', 'LR512', '0001'),
('0003', 'Tech Trivia', '2026-05-28', '10:00:00', 'LR512', '0001'),
('0004', 'UI/UX Redesign Sprints', '2026-06-03', '18:00:00', 'ICT Lab A', '0002'),
('0005', 'Game Development Jams', '2026-06-13', '15:00:00', 'ICT Lab B', '0003'),
('0006', 'Ethical Hacking Workshops', '2026-06-21', '17:00:00', 'LR511', '0002');

--
-- Triggers `activity`
--
DELIMITER $$
CREATE TRIGGER `after_activity_insert` AFTER INSERT ON `activity` FOR EACH ROW BEGIN
    INSERT INTO record (studentID, activityID, attendanceStatus)
    SELECT studentID, NEW.activityID, 'Absent'
    FROM student;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `advisor`
--

CREATE TABLE `advisor` (
  `advisorID` varchar(11) NOT NULL,
  `advisorName` varchar(100) NOT NULL,
  `advisorPw` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisor`
--

INSERT INTO `advisor` (`advisorID`, `advisorName`, `advisorPw`) VALUES
('0001', 'Nor Hanina Zainal Abidin', 'abc123'),
('0002', 'Jivita Raja', '123abc'),
('0003', 'Kim Min Lai', 'aaa111');

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

CREATE TABLE `record` (
  `studentID` varchar(11) NOT NULL,
  `activityID` varchar(11) NOT NULL,
  `attendanceStatus` varchar(50) NOT NULL DEFAULT 'Absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`studentID`, `activityID`, `attendanceStatus`) VALUES
('P25017090', '0001', 'Present'),
('P25017090', '0002', 'Present'),
('P25017090', '0003', 'Absent'),
('P25017090', '0004', 'Present'),
('P25017090', '0005', 'Absent'),
('P25017090', '0006', 'Absent'),
('P25017098', '0001', 'Present'),
('P25017098', '0002', 'Absent'),
('P25017098', '0003', 'Present'),
('P25017098', '0004', 'Present'),
('P25017098', '0005', 'Absent'),
('P25017098', '0006', 'Absent'),
('P25017111', '0001', 'Absent'),
('P25017111', '0002', 'Absent'),
('P25017111', '0003', 'Present'),
('P25017111', '0004', 'Absent'),
('P25017111', '0005', 'Absent'),
('P25017111', '0006', 'Absent'),
('P25017221', '0001', 'Absent'),
('P25017221', '0002', 'Absent'),
('P25017221', '0003', 'Present'),
('P25017221', '0004', 'Absent'),
('P25017221', '0005', 'Absent'),
('P25017221', '0006', 'Absent'),
('P25017468', '0001', 'Absent'),
('P25017468', '0002', 'Absent'),
('P25017468', '0003', 'Absent'),
('P25017468', '0004', 'Present'),
('P25017468', '0005', 'Present'),
('P25017468', '0006', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` varchar(11) NOT NULL,
  `studentName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` varchar(14) NOT NULL,
  `programme` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `studentName`, `password`, `phoneNo`, `programme`) VALUES
('P25017090', 'Muhammad Aryan Bin Mohamad Pazli', '333333', '60126036316', 'DCS'),
('P25017098', 'Derrick Wong Jun Wei', '111111', '60164202942', 'DCS'),
('P25017111', 'Chew Yen Joo', '654321', '60104610328', 'DCS'),
('P25017221', 'Abdul Mohammad Nafees', '222222', '601112416657', 'DCS'),
('P25017468', 'Ooi Ming Tatt', '123456', '60164451289', 'DCS');

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `after_student_insert` AFTER INSERT ON `student` FOR EACH ROW BEGIN
    INSERT INTO record (studentID, activityID, attendanceStatus)
    SELECT NEW.studentID, activityID, 'Absent'
    FROM activity;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`),
  ADD KEY `idx_activity_advisorID` (`advisorID`);

--
-- Indexes for table `advisor`
--
ALTER TABLE `advisor`
  ADD PRIMARY KEY (`advisorID`);

--
-- Indexes for table `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`studentID`,`activityID`),
  ADD KEY `idx_record_activityID` (`activityID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `fk_activity_advisor` FOREIGN KEY (`advisorID`) REFERENCES `advisor` (`advisorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `fk_record_activity` FOREIGN KEY (`activityID`) REFERENCES `activity` (`activityID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_record_student` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
