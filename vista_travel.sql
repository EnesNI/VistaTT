-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 04:30 PM
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
  `longitude` decimal(10,6) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `no_credit_card` tinyint(1) DEFAULT 0,
  `beachfront` tinyint(1) DEFAULT 0,
  `five_stars` tinyint(1) DEFAULT 0,
  `rating_8plus` tinyint(1) DEFAULT 0,
  `vacation_homes` tinyint(1) DEFAULT 0,
  `pet_friendly` tinyint(1) DEFAULT 0,
  `apartments` tinyint(1) DEFAULT 0,
  `breakfast_dinner` tinyint(1) DEFAULT 0,
  `horseback_riding` tinyint(1) DEFAULT 0,
  `cycling` tinyint(1) DEFAULT 0,
  `beach` tinyint(1) DEFAULT 0,
  `fishing` tinyint(1) DEFAULT 0,
  `hiking` tinyint(1) DEFAULT 0,
  `bedrooms` int(11) DEFAULT 0,
  `bathrooms` int(11) DEFAULT 0,
  `parking` tinyint(1) DEFAULT 0,
  `restaurant` tinyint(1) DEFAULT 0,
  `room_service` tinyint(1) DEFAULT 0,
  `front_desk` tinyint(1) DEFAULT 0,
  `fitness_center` tinyint(1) DEFAULT 0,
  `non_smoking` tinyint(1) DEFAULT 0,
  `airport_shuttle` tinyint(1) DEFAULT 0,
  `family_rooms` tinyint(1) DEFAULT 0,
  `spa` tinyint(1) DEFAULT 0,
  `free_wifi` tinyint(1) DEFAULT 0,
  `charging_station` tinyint(1) DEFAULT 0,
  `wheelchair_access` tinyint(1) DEFAULT 0,
  `swimming_pool` tinyint(1) DEFAULT 0,
  `filters` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `location`, `description`, `room_capacity`, `available_rooms`, `photos`, `created_at`, `price_per_person`, `room_details`, `reviews`, `map_location`, `includes`, `latitude`, `longitude`, `image_url`, `no_credit_card`, `beachfront`, `five_stars`, `rating_8plus`, `vacation_homes`, `pet_friendly`, `apartments`, `breakfast_dinner`, `horseback_riding`, `cycling`, `beach`, `fishing`, `hiking`, `bedrooms`, `bathrooms`, `parking`, `restaurant`, `room_service`, `front_desk`, `fitness_center`, `non_smoking`, `airport_shuttle`, `family_rooms`, `spa`, `free_wifi`, `charging_station`, `wheelchair_access`, `swimming_pool`, `filters`) VALUES
(4, 'Emporium Hotel', 'Genius discounts at this property are subject to booking dates, stay dates, and other available deals.\r\n\r\nReliable info:Guests say the description and photos for this property are accurate.\r\nOnly 164 feet from Beyazit Tram Stop, Emporium Hotel is 5 minutes\' walk from Grand Bazaar. It features free WiFi, and a Mediterranean-style interior with indoor palm trees, a fountain and soft color patterns.\r\n\r\nAll rooms at Emporium Hotel include air conditioning, a flat-screen TV with satellite channels and a mini-bar. There is an electric kettle and a safety deposit box. Private bathroom comes with free toiletries and a hairdryer.\r\n\r\nThe Emporium’s breakfast room offers a rich breakfast of Turkish dishes each morning. Nearby restaurants and cafes suit all kinds of culinary tastes.\r\n\r\nBlue Mosque, Hagia Sophia and Topkapi Palace are a 15-minute walk away. Emporium Hotel is located opposite Istanbul University. Istanbul Airport is 28 mi from the property.\r\n\r\nCouples in particular like the location – they rated it 9.3 for a two-person trip.', 2, 6, 'uploads/16593202.jpg,uploads/16603285.jpg,uploads/16605661.jpg,uploads/16605709.jpg,uploads/470382915.jpg,uploads/470382921.jpg,uploads/470391728.jpg', '2025-02-08 16:09:47', 0.00, '', NULL, '', '', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL),
(5, 'New Hotel', 'sadasdadasdadsadsa', 3, 13, 'uploads/16593202.jpg,uploads/16603285.jpg,uploads/16605661.jpg,uploads/16605709.jpg,uploads/470382915.jpg,uploads/470382921.jpg,uploads/470391728.jpg', '2025-02-08 21:45:33', 200.00, 'ewwwwwweeeeeeeeeeewwwwwwwwrrrrrrrrrrrrrr', NULL, 'Istambul', 'Standard Double or Twin Room 17 m² Air conditioning Patio Private bathroom Flat-screen TV Soundproof Minibar Free Wifi Room Size 17 m² 2 twin beds Comfy beds, 8.2 – Based on 330 reviews Tastefully decorated, this room offers air conditioning, a flat-scree', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL),
(8, 'New York', 'eadnaodnaowdnaowdnawd', 2, 12, 'uploads/16593202.jpg,uploads/16603285.jpg,uploads/16605661.jpg,uploads/16605709.jpg', '2025-02-09 13:56:21', 295.50, 'adkbnadcojas cn jklzcn kjlszx hnjkxgb ', NULL, '', 'Standard Double or Twin Room 17 m² Air conditioning Patio Private bathroom Flat-screen TV Soundproof Minibar Free Wifi Room Size 17 m² 2 twin beds Comfy beds, 8.2 – Based on 330 reviews Tastefully decorated, this room offers air conditioning, a flat-scree', 40.721926, -73.908106, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL),
(9, 'Tirana', 'asdasdasdadsasd', 3, 4, 'uploads/470382915.jpg,uploads/470382921.jpg,uploads/470391728.jpg', '2025-02-09 14:08:26', 100.00, 'sdasdsdadsadsadasd', NULL, '', 'Standard Double or Twin Room 17 m² Air conditioning Patio Private bathroom Flat-screen TV Soundproof Minibar Free Wifi Room Size 17 m² 2 twin beds Comfy beds, 8.2 – Based on 330 reviews Tastefully decorated, this room offers air conditioning, a flat-scree', 41.332819, 19.810043, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`, `created_at`, `is_admin`) VALUES
(2, 'enesnimani1@gmail.com', 'Eness', 'Nimani', '$2y$10$da63g8Ed9rXGDxFmrepvgOHkK51c3gCHN.Cl/pf9aAAzRTwei4Vn6', '2025-01-29 21:41:32', 1),
(6, 'enesnimani@gmail.com', 'Enes', 'Nimani', '$2y$10$ApDenXwCU0qmK1rkipm7eONU4YVqbz0K1gTKiUnAVHT93dE9nR8ta', '2025-02-18 19:01:04', 0),
(8, 'ermir.nimani@gmail.com', 'Ermir', 'Nimani', '$2y$10$EJEAvkBswlkRzJt9Tc8AAeOTNXdgak4f6uc.a5nw3j1CBieni4Biu', '2025-02-25 19:19:00', 0),
(10, 'alex@gmail.com', 'Alex', 'honda', '$2y$10$J3BWQcYn0raaUt8EabdRauas4ykYwpTi2VbUrLaLLc8ZY2DUnP0HO', '2025-02-26 20:00:26', 1),
(11, 'hello@gmail.com', 'hello', 'hello', '$2y$10$D6X6VoSNhFBpLuAbHLCR..rr4HhmGADhGnw.GVB/exgkdW3r0ft1W', '2025-02-26 20:24:41', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
