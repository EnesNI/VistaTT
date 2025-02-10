-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 02:20 PM
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
(4, 'Emporium Hotel', 'Genius discounts at this property are subject to booking dates, stay dates, and other available deals.\r\n\r\nReliable info:Guests say the description and photos for this property are accurate.\r\nOnly 164 feet from Beyazit Tram Stop, Emporium Hotel is 5 minutes\' walk from Grand Bazaar. It features free WiFi, and a Mediterranean-style interior with indoor palm trees, a fountain and soft color patterns.\r\n\r\nAll rooms at Emporium Hotel include air conditioning, a flat-screen TV with satellite channels and a mini-bar. There is an electric kettle and a safety deposit box. Private bathroom comes with free toiletries and a hairdryer.\r\n\r\nThe Emporium’s breakfast room offers a rich breakfast of Turkish dishes each morning. Nearby restaurants and cafes suit all kinds of culinary tastes.\r\n\r\nBlue Mosque, Hagia Sophia and Topkapi Palace are a 15-minute walk away. Emporium Hotel is located opposite Istanbul University. Istanbul Airport is 28 mi from the property.\r\n\r\nCouples in particular like the location – they rated it 9.3 for a two-person trip.', 2, 6, 'uploads/16593202.jpg,uploads/16603285.jpg,uploads/16605661.jpg,uploads/16605709.jpg,uploads/470382915.jpg,uploads/470382921.jpg,uploads/470391728.jpg', '2025-02-08 16:09:47', 0.00, '', NULL, '', '', NULL, NULL),
(5, 'New Hotel', 'sadasdadasdadsadsa', 3, 13, 'uploads/16593202.jpg,uploads/16603285.jpg,uploads/16605661.jpg,uploads/16605709.jpg,uploads/470382915.jpg,uploads/470382921.jpg,uploads/470391728.jpg', '2025-02-08 21:45:33', 200.00, 'ewwwwwweeeeeeeeeeewwwwwwwwrrrrrrrrrrrrrr', NULL, 'Istambul', 'Standard Double or Twin Room 17 m² Air conditioning Patio Private bathroom Flat-screen TV Soundproof Minibar Free Wifi Room Size 17 m² 2 twin beds Comfy beds, 8.2 – Based on 330 reviews Tastefully decorated, this room offers air conditioning, a flat-scree', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
