-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 06:40 AM
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
-- Database: `charity_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `adminName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminName`, `email`, `password`, `created_at`, `image`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$959jPDH8P8V7DkeSo28iO.iYieFGr5YTN2hW4zSb8EmKjJZ6JAEpS', '2024-06-04 08:38:45', 'images/admin/admin.jpg'),
(6, 'test', 'test@gmail.com', '$2y$10$vZi7ur7kdKhITfaNJtCpAetUc5RIxax1CBwUL/X3HcP.RtZ9Ax23G', '2024-06-04 17:04:28', '');

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `target_amount` decimal(10,2) NOT NULL,
  `raised_amount` decimal(10,2) DEFAULT 0.00,
  `status` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `title`, `description`, `target_amount`, `raised_amount`, `status`, `start_date`, `end_date`, `created_at`, `img`) VALUES
(1, 'Disaster Relief', 'When disaster strikes in India, Lions are often among the first to offer aid. And LCIF India is right there with them, ready to support their efforts with funding assistance through global disaster relief programs.', 50000.00, 52759.00, 'inactive', '2024-05-31', '2024-07-31', '2024-05-31 09:24:34', 'disaster.jpeg'),
(5, 'This 5-Year-Old Is Getting Weaker By The Minute Because Of A Dangerous Disease, Help Her Live', '\nParesh and Banasmita smile at their daughter’s queries and try to hide their fears and worries. And their fears are plenty. They\'re worried that they might not be able to celebrate her next birthday unless she gets a bone marrow transplant. This is not the future they had hoped for her - these parents are helpless and desperate.\n\nThis dangerous disease is making the little girl weak with every passing day \n\nSoumyashree is fighting Thalassemia Major - an inherited blood disorder characterized by less oxygen-carrying protein (haemoglobin) and fewer red blood cells in the body than normal. For the last 5 years, the little girl has been surviving on regular blood transfusions. \n\nSoumyashree was 3 months old when Banasmita noticed she was losing weight and slowly turning pale. The young mother was scared and rushed her to a hospital in Balasore, a small town in Odisha.\n\nYour support can give this little girl a second chance at life', 275000.00, 171546.00, 'active', '2024-05-08', '0000-00-00', '2024-06-04 17:14:36', 'Help-Soumyashree1670629423.webp'),
(6, 'Help Children in Need', 'Providing food, clothing, and education to underprivileged children.', 25000.00, 13165.00, 'active', '2024-05-15', '2024-06-06', '2024-06-06 08:28:45', 'img_1.jpg'),
(7, 'Save the Rainforest', 'Protecting and preserving the rainforest to combat climate change.', 15000.00, 6626.00, 'active', '2024-06-05', '0000-00-00', '2024-06-06 08:29:49', 'pexels-ch1276-540006.jpg'),
(8, 'Medical Aid for Refugees', 'Providing medical assistance and healthcare to refugees in crisis zones.', 35000.00, 24561.00, 'active', '2023-06-15', '2024-06-06', '2024-06-06 08:30:43', 'pexels-ahmed-akacha-3313934-4959222.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `donation_date` date DEFAULT current_timestamp(),
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`id`, `user_id`, `campaign_id`, `donation_date`, `amount`) VALUES
(11, 3, 5, '2024-06-04', 1523.00),
(12, 3, 1, '2024-06-05', 58623.00),
(13, 4, 1, '2024-06-05', 24563.00),
(14, 4, 5, '2024-06-05', 85632.00),
(15, 4, 8, '2024-06-06', 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `imgsrc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `imgsrc`) VALUES
(11, 'Help-Soumyashree1670629423.webp'),
(12, 'disaster.jpeg'),
(13, 'images.jpeg'),
(14, 'images2.jpeg'),
(15, 'product-5d52a6ffeac4e.[1600].jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`) VALUES
(3, 'zeta', 'zeta@gmail.com', '$2y$10$luidC/PvI1a9HcUWxcKJx.r98Dg0oHn2dXp32LIuxSC.uMWGnFq3K', ''),
(4, 'developer', 'dev@gmail.com', '$2y$10$JpP7VSMrz78ImGUtA9zYEe.8362OZAn3IqJQIA8ypZYJ2rrqoyJ3C', 'images/profile/360_F_601171862_l7yZ0wujj8o2SowiKTUsfLEEx8KunYNd.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `donation_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
