-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 01:32 PM
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
-- Database: `vista_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `room_capacity` int(11) NOT NULL,
  `available_rooms` int(11) NOT NULL,
  `photos` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `price_per_person` decimal(10,2) NOT NULL,
  `room_details` text NOT NULL,
  `reviews` text DEFAULT NULL,
  `map_location` varchar(255) NOT NULL,
  `includes` varchar(255) NOT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `location`, `description`, `room_capacity`, `available_rooms`, `photos`, `created_at`, `price_per_person`, `room_details`, `reviews`, `map_location`, `includes`, `latitude`, `longitude`) VALUES
(1, 'sadasdas', 'dasdasdasd', 2, 13, 'uploads/19651.webp', '2025-01-30 13:21:12', 0.00, '', NULL, '', '', NULL, NULL),
(2, 'sadasdas', 'dasdasdasd', 2, 13, '', '2025-01-30 13:22:21', 0.00, '', NULL, '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`, `created_at`) VALUES
(1, 'enesnimani87@gmail.com', 'Enes', 'Nimani', '$2y$10$5327tiQhj5Z.TU8bojheOe3pHDPq5ZSvaidx7cHSMmA5j6jcAvzRO', '2025-01-29 18:56:16'),
(2, 'enesnimani1@gmail.com', 'Enes', 'Nimani', '$2y$10$da63g8Ed9rXGDxFmrepvgOHkK51c3gCHN.Cl/pf9aAAzRTwei4Vn6', '2025-01-29 21:41:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
