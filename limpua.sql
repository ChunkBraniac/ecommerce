-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 13, 2023 at 08:09 PM
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
-- Database: `limpua`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminDB`
--

CREATE TABLE `adminDB` (
  `admin_id` int(255) NOT NULL,
  `admin_name` varchar(1000) NOT NULL,
  `admin_email` varchar(1000) NOT NULL,
  `admin_password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminDB`
--

INSERT INTO `adminDB` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(3, 'obah', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `item_id` int(255) NOT NULL,
  `added_id` varchar(1000) NOT NULL,
  `item_name` varchar(1000) NOT NULL,
  `item_image` varchar(1000) NOT NULL,
  `item_price_old` varchar(1000) NOT NULL,
  `item_price_new` varchar(1000) NOT NULL,
  `item_cartegory` varchar(1000) NOT NULL,
  `item_description` varchar(1000) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_email` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `product_id` int(255) NOT NULL,
  `product_name` varchar(1000) NOT NULL,
  `product_price_old` varchar(1000) NOT NULL,
  `product_price_new` varchar(1000) NOT NULL,
  `product_image` varchar(1000) NOT NULL,
  `product_cartegory` varchar(1000) NOT NULL,
  `product_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`product_id`, `product_name`, `product_price_old`, `product_price_new`, `product_image`, `product_cartegory`, `product_description`) VALUES
(4, 'Television', '300', '200', '1.jpg', 'Electronics', '🌟 Stunning 4K Ultra HD Resolution: Immerse yourself in breathtaking clarity and vividness with 4K resolution, delivering four times the pixels of Full HD. Every detail comes to life, from the smallest nuances to the grandest vistas.'),
(5, 'Camera', '340', '230', '2.jpg', 'Electronics', '📷 Professional-Quality Imaging: Unleash your creativity with our state-of-the-art camera, designed for both amateur enthusiasts and professional photographers. Capture stunning, high-resolution images with exceptional clarity.'),
(6, 'Game Console', '310', '200', '3.jpg', 'Electronics', '🎮 Powerful Performance: Experience lightning-fast gaming with our high-performance console. From fast-paced action games to immersive open-world adventures, this console can handle it all.'),
(7, 'Bluetooth Speakers', '400', '159', '5.jpg', 'Electronics', 'Nothing here');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `first_name` varchar(1000) NOT NULL,
  `last_name` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `confirm_pass` varchar(1000) NOT NULL,
  `code` varchar(1000) NOT NULL,
  `verified` varchar(1000) NOT NULL,
  `datet` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `confirm_pass`, `code`, `verified`, `datet`) VALUES
(3, 'Obah', 'anthony', 'anthonyobah37@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '296370', '0', 'Thursday Sep 2023 22:02'),
(4, 'Tony', 'boss', 'me@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '354819', '0', 'Saturday Sep 2023 21:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminDB`
--
ALTER TABLE `adminDB`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminDB`
--
ALTER TABLE `adminDB`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `item_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
