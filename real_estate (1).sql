-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 07:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `real_estate`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `email`, `phone`, `created_at`) VALUES
(1, 'Rahul Sharma', 'rahul@gmail.com', '9876543210', '2026-03-28 05:39:56'),
(2, 'Priya Mehta', 'priya@gmail.com', '9876543211', '2026-03-28 05:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `number`, `email`, `message`, `created_at`) VALUES
(1, 'Amit Sharma', '9876543210', 'amit@gmail.com', 'I am interested in renting a 2BHK apartment. Please share details.', '2026-03-28 05:48:04'),
(2, 'Neha Patel', '9823456712', 'neha@gmail.com', 'Can I schedule a visit for the property in Andheri?', '2026-03-28 05:48:04'),
(3, 'Rohit Verma', '9898989898', 'rohit@gmail.com', 'Looking to buy a flat in Mumbai. Please contact me.', '2026-03-28 05:48:04'),
(4, 'Sneha Joshi', '9765432101', 'sneha@gmail.com', 'Is the Worli apartment still available for rent?', '2026-03-28 05:48:04'),
(5, 'Karan Mehta', '9812345678', 'karan@gmail.com', 'Please provide price negotiation details for Bandra property.', '2026-03-28 05:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `agent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `description`, `location`, `city`, `type`, `rooms`, `bathrooms`, `area`, `price`, `image`, `featured`, `created_at`, `updated_at`, `agent_id`) VALUES
(1, 'Cozy 1BHK Apartment', 'Perfect for small family', 'Andheri East', 'Mumbai', 'rent', 1, 1, 550, 18000.00, 'apa.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:48:27', 1),
(2, 'Modern 2BHK Flat', 'Well furnished with balcony', 'Borivali West', 'Mumbai', 'buy', 2, 2, 900, 32000.00, 'apartment.jpg', 1, '2026-03-28 05:44:36', '2026-03-28 05:55:38', 1),
(3, 'Spacious 3BHK Apartment', 'Near metro station', 'Ghatkopar', 'Mumbai', 'rent', 3, 2, 1200, 45000.00, 'apartment1.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:56:01', 2),
(4, 'Budget Studio Apartment', 'Affordable and compact', 'Dahisar', 'Mumbai', 'buy', 1, 1, 400, 12000.00, 'apartment2.jpg', 1, '2026-03-28 05:44:36', '2026-03-28 05:56:21', 2),
(5, 'Luxury 2BHK Apartment', 'Sea view with parking', 'Worli', 'Mumbai', 'rent', 2, 2, 1100, 65000.00, 'apartment3.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:56:35', 1),
(6, 'Family 3BHK Flat', 'Good locality and schools nearby', 'Thane West', 'Mumbai', 'buy', 3, 3, 1400, 50000.00, 'apartment4.jpg', 1, '2026-03-28 05:44:36', '2026-03-28 05:56:51', 2),
(7, 'Premium 2BHK Apartment', 'Newly constructed building', 'Powai', 'Mumbai', 'buy', 2, 2, 1000, 15000000.00, 'apartment5.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:57:08', 1),
(8, 'Luxury 4BHK Villa', 'Independent villa with garden', 'Juhu', 'Mumbai', 'rent', 4, 4, 3500, 75000000.00, 'apartment6.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:57:56', 2),
(9, 'Affordable 1BHK Flat', 'Best for first-time buyers', 'Kalyan', 'Mumbai', 'rent', 1, 1, 600, 5500000.00, 'apartment8.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:58:12', 1),
(10, 'Modern 3BHK Apartment', 'Spacious and airy rooms', 'Mulund', 'Mumbai', 'buy', 3, 2, 1300, 18000000.00, 'apartment9.jpg', 1, '2026-03-28 05:44:36', '2026-03-28 05:58:30', 2),
(11, 'Compact Studio Flat', 'Ideal for investment', 'Navi Mumbai', 'Mumbai', 'rent', 1, 1, 450, 4000000.00, 'card3.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:58:52', 1),
(12, 'Luxury Penthouse', 'Top floor with city view', 'Bandra', 'Mumbai', 'buy', 4, 3, 2800, 65000000.00, 'card2.jpg', 0, '2026-03-28 05:44:36', '2026-03-28 05:59:05', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
