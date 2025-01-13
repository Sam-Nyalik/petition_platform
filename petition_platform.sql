-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2025 at 05:07 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petition_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `fullName`, `emailAddress`, `password`, `date_created`) VALUES
(1, 'Petition Administrator', 'admin@petition.parliament.sr', '$2y$10$2nOjUKyB958Lkdna4aoVgOPrjWtENekYYfVhskA5tkTnICWMx45q.', '2025-01-09 11:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `all_petitions`
--

CREATE TABLE `all_petitions` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(1500) NOT NULL,
  `author` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `petitions_committee_response` varchar(400) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `signatures` int(11) NOT NULL DEFAULT 0,
  `signature_threshhold` int(11) DEFAULT 0,
  `petitioner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_petitions`
--

INSERT INTO `all_petitions` (`id`, `title`, `content`, `author`, `status`, `petitions_committee_response`, `date_created`, `date_updated`, `signatures`, `signature_threshhold`, `petitioner_id`) VALUES
(1, 'Support Renewable Energy Development in Our Community', 'We, the undersigned, urge local government and policymakers to prioritize investment in renewable energy projects, such as solar and wind power, to reduce our community\'s carbon footprint and promote environmental sustainability. By transitioning to cleaner energy sources, we can improve air quality, create green jobs, and ensure a healthier future for generations to come.\r\n\r\nSign this petition to show your support for a greener, more sustainable community!', 'john@gmail.com', 0, 'OK, your grievances have reached home', '2025-01-12 18:25:16', '2025-01-12 18:26:41', 1, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bioID`
--

CREATE TABLE `bioID` (
  `id` int(11) NOT NULL,
  `unique_code` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bioID`
--

INSERT INTO `bioID` (`id`, `unique_code`, `status`, `date_created`) VALUES
(1, 'K1YL8VA2HG', 0, '2025-01-10 08:39:32'),
(2, '7DMPYAZAP2', 0, '2025-01-10 08:40:10'),
(3, 'D05HPPQNJ4', 0, '2025-01-10 08:40:23'),
(4, '2WYIM3QCK9', 0, '2025-01-10 08:40:37'),
(5, 'DHKFIYHMAZ', 0, '2025-01-10 08:40:48'),
(6, 'LZK7P0X0LQ', 0, '2025-01-10 08:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `petitioners`
--

CREATE TABLE `petitioners` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `date_of_birth` varchar(200) NOT NULL,
  `biometric_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petitioners`
--

INSERT INTO `petitioners` (`id`, `fullName`, `emailAddress`, `date_of_birth`, `biometric_id`, `password`, `date_created`) VALUES
(1, 'John Doe', 'john@gmail.com', '2002-06-13', 'DHKFIYHMAZ', '$2y$10$OdIiTxegmbmgP0OMMMPGF.zjrzRRnEqWHRC6rrvEzPpQzKKi16gF6', '2025-01-12 18:06:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `all_petitions`
--
ALTER TABLE `all_petitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bioID`
--
ALTER TABLE `bioID`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petitioners`
--
ALTER TABLE `petitioners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `all_petitions`
--
ALTER TABLE `all_petitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bioID`
--
ALTER TABLE `bioID`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `petitioners`
--
ALTER TABLE `petitioners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
