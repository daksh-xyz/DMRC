-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 28, 2024 at 08:41 AM
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
-- Database: `dmrc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `Alumni_id` int(11) NOT NULL,
  `First_Name` varchar(45) DEFAULT NULL,
  `Last_Name` varchar(45) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Mobile` bigint(10) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `District` varchar(45) DEFAULT NULL,
  `City` varchar(40) DEFAULT NULL,
  `State` varchar(40) DEFAULT NULL,
  `Pincode` int(15) DEFAULT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  `RegisterTime` datetime DEFAULT current_timestamp(),
  `pfp` varchar(75) DEFAULT 'user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_details`
--

CREATE TABLE `alumni_details` (
  `Alumni_id` int(11) NOT NULL,
  `BatchID` varchar(100) DEFAULT NULL,
  `Department` varchar(45) DEFAULT NULL,
  `UAN` mediumint(12) DEFAULT NULL,
  `PF` varchar(100) DEFAULT NULL,
  `Pension_Number` varchar(20) DEFAULT NULL,
  `PAN` varchar(10) DEFAULT NULL,
  `Join_Date` date DEFAULT NULL,
  `Last_date` date DEFAULT NULL,
  `CurrentEmployment` varchar(45) NOT NULL DEFAULT 'Retired'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_docs`
--

CREATE TABLE `alumni_docs` (
  `DocID` varchar(30) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `F16` varchar(100) NOT NULL DEFAULT 'null',
  `F16Status` varchar(100) NOT NULL DEFAULT 'Requested',
  `pSlip` varchar(100) NOT NULL DEFAULT 'null',
  `pSlipStatus` varchar(100) NOT NULL DEFAULT 'Requested',
  `SAnnuation` varchar(100) NOT NULL DEFAULT 'null',
  `SAnnuationStatus` varchar(100) NOT NULL DEFAULT 'Requested',
  `ServiceCertificate` varchar(100) NOT NULL DEFAULT 'null',
  `ServiceCertificateStatus` varchar(100) NOT NULL DEFAULT 'Requested',
  `ReleaseLetter` varchar(100) NOT NULL DEFAULT 'null',
  `ReleaseLetterStatus` varchar(100) NOT NULL DEFAULT 'Requested',
  `requestTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_notifs`
--

CREATE TABLE `alumni_notifs` (
  `NotificationID` int(11) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `message` varchar(150) NOT NULL DEFAULT 'requested a document !',
  `NotifTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_socials`
--

CREATE TABLE `alumni_socials` (
  `Alumni_id` int(11) NOT NULL,
  `Facebook` varchar(45) DEFAULT NULL,
  `Twitter` varchar(45) DEFAULT NULL,
  `LinkedIn` varchar(45) DEFAULT NULL,
  `Instagram` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `Alumni_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `FriendhsipDate` date NOT NULL DEFAULT current_timestamp(),
  `FriendshipStatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`Alumni_id`);

--
-- Indexes for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD UNIQUE KEY `Alumni_id` (`Alumni_id`);

--
-- Indexes for table `alumni_docs`
--
ALTER TABLE `alumni_docs`
  ADD PRIMARY KEY (`DocID`),
  ADD KEY `SenderID` (`SenderID`);

--
-- Indexes for table `alumni_notifs`
--
ALTER TABLE `alumni_notifs`
  ADD KEY `SenderID` (`SenderID`);

--
-- Indexes for table `alumni_socials`
--
ALTER TABLE `alumni_socials`
  ADD KEY `Alumni_id` (`Alumni_id`);

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD KEY `Alumni_id` (`Alumni_id`),
  ADD KEY `User_id` (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `Alumni_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD CONSTRAINT `alumni_details_ibfk_1` FOREIGN KEY (`Alumni_id`) REFERENCES `alumni` (`Alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumni_docs`
--
ALTER TABLE `alumni_docs`
  ADD CONSTRAINT `alumni_docs_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `alumni` (`Alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumni_notifs`
--
ALTER TABLE `alumni_notifs`
  ADD CONSTRAINT `alumni_notifs_ibfk_3` FOREIGN KEY (`SenderID`) REFERENCES `admin` (`AdminID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumni_socials`
--
ALTER TABLE `alumni_socials`
  ADD CONSTRAINT `alumni_socials_ibfk_1` FOREIGN KEY (`Alumni_id`) REFERENCES `alumni` (`Alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_ibfk_1` FOREIGN KEY (`Alumni_id`) REFERENCES `alumni` (`Alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `connections_ibfk_2` FOREIGN KEY (`User_id`) REFERENCES `alumni` (`Alumni_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
