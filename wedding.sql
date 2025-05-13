-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 01:34 PM
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
-- Database: `wedding`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookingdata`
--

CREATE TABLE `bookingdata` (
  `id` int(11) NOT NULL,
  `userId` varchar(15) NOT NULL,
  `dulha` varchar(50) NOT NULL,
  `dulhan` varchar(50) NOT NULL,
  `shadiDate` varchar(20) NOT NULL,
  `barat` varchar(300) NOT NULL,
  `address` varchar(500) NOT NULL,
  `bookingKarta` varchar(50) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `dealAmount` varchar(20) NOT NULL,
  `initialPay` varchar(20) NOT NULL,
  `services` varchar(500) NOT NULL,
  `extraQuery` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demoimages`
--

CREATE TABLE `demoimages` (
  `id` int(11) NOT NULL,
  `image` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demoprewedding`
--

CREATE TABLE `demoprewedding` (
  `id` int(11) NOT NULL,
  `items` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demowedding`
--

CREATE TABLE `demowedding` (
  `id` int(11) NOT NULL,
  `items` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingdata`
--
ALTER TABLE `bookingdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demoimages`
--
ALTER TABLE `demoimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demoprewedding`
--
ALTER TABLE `demoprewedding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demowedding`
--
ALTER TABLE `demowedding`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookingdata`
--
ALTER TABLE `bookingdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `demoimages`
--
ALTER TABLE `demoimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demoprewedding`
--
ALTER TABLE `demoprewedding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demowedding`
--
ALTER TABLE `demowedding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
