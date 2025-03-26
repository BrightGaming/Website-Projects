-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 07:00 AM
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
-- Database: `volleyball_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cart`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `order_date`, `cart`) VALUES
(1, 'Yen Hann', '0101243456', 'hdhfgdhdhd', '2024-10-21 12:41:49', '[{\"name\":\"Volleyball Jersey\",\"price\":25,\"image\":\"http:\\/\\/localhost\\/RWDD2304\\/Assignment\\/Image\\/jerseyVolley.png\",\"quantity\":1,\"size\":\"S\"}]'),
(2, 'xx', '0109999999', 'hdhfgdhdhd', '2024-10-21 12:42:49', '[{\"name\":\"Volleyball\",\"price\":20,\"image\":\"http:\\/\\/localhost\\/RWDD2304\\/Assignment\\/Image\\/volleyBall.jpg\",\"quantity\":1,\"size\":\"\"},{\"name\":\"Volleyball Jersey\",\"price\":25,\"image\":\"http:\\/\\/localhost\\/RWDD2304\\/Assignment\\/Image\\/jerseyVolley.png\",\"quantity\":1,\"size\":\"M\"},{\"name\":\"Volleyball Shoes\",\"price\":45,\"image\":\"http:\\/\\/localhost\\/RWDD2304\\/Assignment\\/Image\\/shoe.jpg\",\"quantity\":1,\"size\":\"10\"}]'),
(3, 'Yen Hann', '0101243456', 'sdasdasd', '2024-10-21 12:51:49', '[{\"name\":\"Volleyball Jersey\",\"price\":25,\"image\":\"http:\\/\\/localhost\\/RWDD2304\\/Assignment\\/Image\\/jerseyVolley.png\",\"quantity\":1,\"size\":\"M\"}]'),
(4, 'Yen Hann', '0109999999', 'hdhfgdhdhd', '2024-10-21 12:56:17', '[{\"name\":\"Volleyball Jersey\",\"price\":25,\"image\":\"http:\\/\\/localhost\\/RWDD2304\\/Assignment\\/Image\\/jerseyVolley.png\",\"quantity\":1,\"size\":\"M\"}]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
