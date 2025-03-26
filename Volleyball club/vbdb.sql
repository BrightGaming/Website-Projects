-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2024 at 02:39 AM
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
-- Database: `vbdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `vbdb`
--

CREATE TABLE `vbdb` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Age` int(3) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `Password` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vbdb`
--

INSERT INTO `vbdb` (`ID`, `Name`, `Age`, `Email`, `Address`, `Phone`, `DOB`, `Password`) VALUES
(1, 'Tan Yi Han', 20, 'tp070378@gmail.com', '123, Jalan Gembira 1', '0124822163', '2024-10-15', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vbdb`
--
ALTER TABLE `vbdb`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vbdb`
--
ALTER TABLE `vbdb`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
