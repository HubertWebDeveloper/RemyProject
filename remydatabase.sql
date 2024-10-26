-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 02:48 PM
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
-- Database: `remydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `advert`
--

CREATE TABLE `advert` (
  `id` int(11) NOT NULL,
  `compound` varchar(100) NOT NULL,
  `video` varchar(255) NOT NULL,
  `published_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advert`
--

INSERT INTO `advert` (`id`, `compound`, `video`, `published_date`, `end_date`, `status`) VALUES
(2, '1', '2361938-uhd_3840_2160_30fps.mp4', '2024-10-24', '2024-11-01', 'Posted'),
(3, '2', '3975494-hd_1920_1080_24fps.mp4', '2024-10-26', '2024-11-02', 'Posted');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `new_price` varchar(10) NOT NULL,
  `old_price` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `title`, `new_price`, `old_price`, `description`, `location`, `date`, `status`) VALUES
(1, 'new house for testing', '12000', '12500', '1bedroom, worshroom', 'maua rd, kemu, scholars', '2024-10-24', 'Posted'),
(2, 'second', '11000', '12000', '2 bedroom', 'maua', '2024-10-24', 'Posted'),
(4, 'card to text ', '15000', '16000', '2 bedrooms, kitchen, sittingroom.', 'Kenya, nairobi', '2024-10-25', 'Posted'),
(6, 'new text request', '12000', '18000', '1 bedroom', 'Kenya, nairobi', '2024-10-26', 'Posted'),
(7, 'nnnnnnn', '12300', '13000', '1 bedroom, kitchen', 'mnmnmnmnhiuyt', '2024-10-26', 'Posted');

-- --------------------------------------------------------

--
-- Table structure for table `card_images`
--

CREATE TABLE `card_images` (
  `id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card_images`
--

INSERT INTO `card_images` (`id`, `card_id`, `image`) VALUES
(8, 2, '[\"671b5421af322.jpg\",\"671b5421af79a.jpg\"]'),
(9, 1, '[\"671b5455e819a.jpg\",\"671b5455e84a4.jpg\"]'),
(10, 4, '[\"671b8dbc25121.jpg\",\"671b8dbc255ea.jpg\",\"671b8dbc25822.jpg\",\"671b8dbc25a57.jpg\"]'),
(12, 6, '[\"671cc5e8a8f2c.jpg\",\"671cc5e8a943b.jpg\",\"671cc5e8a9804.jpg\"]'),
(13, 7, '[\"671ccb6453706.jpg\",\"671ccb6453b63.jpg\",\"671ccb6453f76.jpg\",\"671ccb645437d.jpg\",\"671ccb645491b.jpg\",\"671ccb6454c4a.jpg\",\"671ccb6454f8f.jpg\"]');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `name`, `email`, `comment`, `status`) VALUES
(4, 'second product', 'hhirwa1390@stu.kemu.ac.ke', 'ncncjaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaanmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm', 'Unposted'),
(5, 'second product', 'hirwa1998.hubert@gmail.com', 'nn', 'Posted'),
(6, 'second product', 'hirwa1998.hubert@gmail.com', 'nxnxm', 'Posted');

-- --------------------------------------------------------

--
-- Table structure for table `compound`
--

CREATE TABLE `compound` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `l_contact` varchar(14) NOT NULL,
  `c_contact` varchar(14) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compound`
--

INSERT INTO `compound` (`id`, `name`, `l_contact`, `c_contact`, `location`) VALUES
(3, 'nenen', '23456', '76543', 'neme');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `phone`, `password`, `userType`) VALUES
(1, 'hhirwa1390@stu.ke', 'hubertYolly', '0781794795', '123', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `userrequest`
--

CREATE TABLE `userrequest` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userrequest`
--

INSERT INTO `userrequest` (`id`, `email`, `phone`, `status`) VALUES
(1, 'hirwa@gmail.com', '07255233', 'Unpiad');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_images`
--
ALTER TABLE `card_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compound`
--
ALTER TABLE `compound`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userrequest`
--
ALTER TABLE `userrequest`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advert`
--
ALTER TABLE `advert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `card_images`
--
ALTER TABLE `card_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `compound`
--
ALTER TABLE `compound`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userrequest`
--
ALTER TABLE `userrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
