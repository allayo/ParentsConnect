-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 01:53 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parents_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(4, 'admin', '$2y$10$K.7/SSkZAPB2q16T.Dt7geVD9aY9kSZkC5ykyN0FlmeKKXQPcYTse');

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `post_date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `writeup` text NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `community`
--

INSERT INTO `community` (`id`, `author`, `post_date`, `title`, `writeup`, `like_count`) VALUES
(40, 'gracey', '2024-07-10 07:53:59', 'My experience as a first time mom', 'As a first-time mom, I, Grace, embarked on a transformative journey filled with endless love, sleepless nights, and a newfound appreciation for the little moments that make life extraordinary. Each day, I discover the boundless strength and resilience within me, as I navigate the joys and challenges of motherhood. With the help of Parents Connect the process has been so smooth and pleasant, I am able to access tips on how to best care for my child. Being a first time mom isn\'t easy but with Parents Connect I know what to do and I get to learn from more experienced parents.', 4),
(44, 'gracey', '2024-07-10 07:58:03', 'A happy time', 'Having a happy meal with my daughter, thanks to Parents connect!', 3),
(45, 'benH', '2024-07-10 08:08:14', 'Father 4 Lovely Daughters', 'Fathering my amazing daugthers is one of my most prized achievements, parenthood is truly a wonderful experience and Parent Connect makes the process 10x better. With the Meal Planner tool I and my wife are able to structure our kids feeding and ensure their meals are well balanced.', 2),
(46, 'benH', '2024-07-10 08:09:30', 'Catering for 4', 'I\'m constantly looking for new ways to entertain my kids and Parents Connect always provides the write info on how to do so.', 3),
(56, 'beebayo07', '2024-07-11 21:04:07', 'changes', 'yo wassup\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `username`) VALUES
(1, 4, 'benH'),
(2, 3, 'benH'),
(3, 2, 'benH'),
(4, 1, 'benH'),
(5, 5, 'benH'),
(6, 5, 'anny'),
(7, 4, 'anny'),
(8, 3, 'anny'),
(9, 2, 'anny'),
(10, 1, 'anny'),
(11, 40, 'gracey'),
(12, 44, 'benH'),
(13, 40, 'benH'),
(14, 45, 'benH'),
(15, 40, 'anny'),
(16, 46, 'anny'),
(17, 44, 'anny'),
(18, 47, 'anny'),
(19, 55, 'gracey'),
(20, 46, 'beebayo07'),
(21, 45, 'beebayo07'),
(22, 44, 'beebayo07'),
(23, 40, 'beebayo07'),
(24, 56, 'beebayo07'),
(25, 56, 'gracey'),
(26, 46, 'gracey');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `mealName` text NOT NULL,
  `breakfast` text NOT NULL,
  `snack` text NOT NULL,
  `lunch` text NOT NULL,
  `dinner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `mealName`, `breakfast`, `snack`, `lunch`, `dinner`) VALUES
(38, 'Meal for 4 - 8', 'Banana Oatmeal Pancakes or waffles (homemade, leftover, or frozen from the store), milk, extra sliced banana', 'Granola Bar with milk', 'Spinach and Cheese Pizza Roll, fruit and cucumbers', 'Broccoli Pesto Pasta, Pan-Seared Chicken, side applesauce'),
(39, 'Meal for 9 - 12', 'Waffles and fruits', 'Nuts and Orange juice', 'Grilled Cheese Sandwich', 'Chicken soup with pasta');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `update_text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dismissed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`id`, `update_text`, `created_at`, `dismissed`) VALUES
(1, 'User gracey shared a post titled \'aaaaa\'', '2024-07-10 15:14:52', 1),
(2, 'User gracey deleted a post with ID 50', '2024-07-10 15:16:04', 1),
(3, 'User updated information: gracey', '2024-07-10 16:00:05', 1),
(4, 'User updated information: gracey', '2024-07-10 16:00:30', 1),
(5, 'New user registered: bell', '2024-07-10 19:17:03', 1),
(6, 'New user registered: bell', '2024-07-10 19:19:47', 1),
(7, 'New user registered: bell', '2024-07-10 19:30:58', 1),
(8, 'User gracey shared a post titled \'wooot\'', '2024-07-11 14:04:29', 1),
(9, 'User gracey shared a post titled \'hhhhhhhhhh\'', '2024-07-11 14:06:43', 1),
(10, 'User gracey shared a post titled \'aaaaaaaaaaaaaaaaaaaaa\'', '2024-07-11 14:07:54', 1),
(11, 'User gracey shared a post titled \'newwwwwwwwwwwwwwwwwwwwwwwwwwwwww\'', '2024-07-11 14:09:16', 1),
(12, 'User gracey shared a post titled \'dddddddddddddd\'', '2024-07-11 14:13:22', 1),
(13, 'User gracey shared a post titled \'Meal\'', '2024-07-11 14:38:25', 0),
(14, 'User gracey liked a post with ID 55', '2024-07-11 14:38:54', 0),
(15, 'New user registered: beebayo07', '2024-07-11 18:26:14', 0),
(16, 'User beebayo07 liked a post with ID 46', '2024-07-11 19:02:36', 0),
(17, 'User beebayo07 liked a post with ID 45', '2024-07-11 19:02:46', 0),
(18, 'User beebayo07 liked a post with ID 44', '2024-07-11 19:03:00', 0),
(19, 'User beebayo07 liked a post with ID 40', '2024-07-11 19:03:42', 0),
(20, 'User beebayo07 shared a post titled \'changes\'', '2024-07-11 19:04:07', 0),
(21, 'User beebayo07 liked a post with ID 56', '2024-07-11 19:04:20', 0),
(22, 'User updated information: badguy07', '2024-07-11 19:06:37', 0),
(23, 'User updated information: beebayo07', '2024-07-11 19:07:01', 0),
(24, 'User gracey liked a post with ID 56', '2024-07-12 22:19:51', 0),
(25, 'User gracey liked a post with ID 46', '2024-07-12 22:19:55', 0),
(26, 'New user registered: hanny', '2024-07-21 16:16:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `password`, `email`) VALUES
(5, 'Grace', 'Cole', 'gracey', '$2y$10$Rrg/Lc5rPOMQone8BWvUYeOEVy1yZ//OnDqx9/mBhjszixfyY6R3C', 'grace@gmail.com'),
(6, 'Ben', 'Harry', 'benH', '$2y$10$P0JNtLPhtdW5j8eY9M8lhuRP0VmTxTRYEf1aBwyFHTsqH9XI.36HS', 'ben@gmail.com'),
(7, 'anna', 'Moses', 'anny', '$2y$10$WhuONS8kO1ntKxf9pXUZl.UDInvBkIka65dhOvc2gzD8bv.exJnku', 'anna@gmail.com'),
(8, 'Beatrice', 'Adebayo', 'beebayo07', '$2y$10$yLWallbyViYq2ip8QVqn9O.lHef/ZJLkCpvFw88O0R1po6HPhI8.G', 'beebayo@gmail.com'),
(9, 'Hannah', 'Victor', 'hanny', '$2y$10$ah9vLe6Z/iru1oBpsMO0v.YwyjFwULn5/NuvwI8b8VRV0mYAZCrg2', 'hannah@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
