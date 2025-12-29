-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2025 at 01:12 PM
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
-- Database: `webappblog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `articles_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `PublicationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Tags` varchar(255) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `Title`, `Content`, `Category`, `PublicationDate`, `Tags`, `UserID`) VALUES
(3, 'sgdfnsgfdnf', 'sgnsgfnfg', 'snbfdgn', '2025-10-27 14:32:04', 'gfsdgfdr', 2),
(7, 'fdsvndfjklngjdfn', 'ngjdsnginsdiugn', '', '2025-10-30 04:14:50', '', 2),
(10, 'The concept of the world', 'Went my own way, then I made it. It\'s quite perplexing to prove all the thoughts you were clouded off to be wrong. Feels nice to be finally alive.', 'thoughts', '2025-11-09 10:22:40', 'living, diva, yass', 2),
(11, 'hyena noises', 'a bunch of hyena noises', 'nature', '2025-11-09 10:23:30', 'sotrue, nature, animals', 3),
(13, 'testing 1', 'testing 1', '', '2025-12-24 10:05:59', 'testingg', 6),
(15, 'bumping THAT', 'exactly brat of the year babyyyyyyyyy', '', '2025-12-24 10:44:10', '365, partygirl', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Bio` text DEFAULT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Email`, `Password`, `Bio`, `ProfilePicture`) VALUES
(2, 'julia', 'julia@mail.com', '$2y$10$1kl3uDj4nU9FBoR8Zdc9IeB4KYd8Dhz3kooLQPS9VHGMGX15rwfDC', 'im bumping that', 'https://pbs.twimg.com/profile_images/1742128956789424128/E9XNrLiU.jpg'),
(3, 'kas', 'kas@mail.com', '$2y$10$ptwbpQ2e2grlTvFeM3LOKuK15lPmwnW61t3T8nC73xgik1dxC.6OC', '', 'https://preview.redd.it/t70nrakqa9571.jpg?width=640&crop=smart&auto=webp&s=65479c43d11fa7aea66f6a36db0af950d1717df8'),
(4, 'okay', 'okay@mail.com', '$2y$10$2bXy95IMeW.AWjKS.pqAB.ovxoKn70xf95AcicJdXATHBTAzA0mgG', 'okay', 'https://pbs.twimg.com/profile_images/1660375143032471553/An673z7Z.jpg'),
(5, 'testing', 'testing@mail.com', '$2y$10$3Tfe6hu5YrX4bqe3SDqSNOTDfJeVf7.gHUTsMXLWc8vJiO.cEUZuO', 'okay', ''),
(6, 'admin', 'admin@mail.com', '$2y$10$Kypj9dKmNc4I50rKVZw2zO.6C9ihwMFFW2Ti.hPljldU3QPD41zo6', 'admin', 'https://pbs.twimg.com/profile_images/2002844666694447104/6EAZMu8x.jpg'),
(7, 'guggler', 'guggler@mail.com', '$2y$10$fXR6wPD5xGmyK/fPBv8Xs.sOl9qSC3JWjS/Ew7X1rMLiX4HAXWxFC', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`articles_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `FK_Post_User` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_Post_User` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
