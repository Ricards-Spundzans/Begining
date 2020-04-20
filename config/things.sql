-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2020 at 02:12 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalogue_task_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `things`
--

CREATE TABLE `things` (
  `id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `type` int(11) NOT NULL,
  `parameter_1` double NOT NULL,
  `parameter_2` double NOT NULL,
  `parameter_3` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `things`
--

INSERT INTO `things` (`id`, `sku`, `name`, `price`, `type`, `parameter_1`, `parameter_2`, `parameter_3`, `created_at`) VALUES
(130, '713BOB719', 'Animal Farm', '5.19', 3, 700, 0, 0, '2020-04-10 09:28:18'),
(131, '237CDC991', 'Film', '5.20', 1, 10000, 0, 0, '2020-04-10 09:29:16'),
(132, '681FNF136', 'Table', '24.21', 2, 2500, 1500, 1600, '2020-04-10 09:29:42'),
(133, '751BOB589', '1984', '4.68', 3, 600, 0, 0, '2020-04-10 09:30:33'),
(134, '907FNF574', 'Chair', '9.03', 2, 914, 508, 457, '2020-04-10 09:31:26'),
(135, '589CDC490', 'Cinema', '8.34', 1, 4000, 0, 0, '2020-04-10 09:32:04'),
(136, '152BOB901', 'The Catcher in the Rye', '8.99', 3, 934, 0, 0, '2020-04-10 09:37:44'),
(137, '683FNF991', 'Cupboard', '12.22', 2, 2500, 1800, 1000, '2020-04-10 09:42:36'),
(138, '131CDC836', 'Blade runner 2049', '5.21', 1, 5000, 0, 0, '2020-04-10 09:58:35'),
(150, '606BOB930', 'Cold Blood', '3.43', 3, 856, 0, 0, '2020-04-17 11:28:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `things`
--
ALTER TABLE `things`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `things`
--
ALTER TABLE `things`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
