-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2018 at 10:44 AM
-- Server version: 10.0.30-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chantrau_xy_4142`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_video`
--

CREATE TABLE `data_video` (
  `id` bigint(20) NOT NULL,
  `origin_url` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_video`
--

INSERT INTO `data_video` (`id`, `origin_url`, `code`, `created_at`, `updated_at`) VALUES
(2, 'https://nodefiles.com/embed-7vke3qpy44lc-x.html', 'e2db5904e752b512a49ceee6fd273ab0', '2018-03-11 08:54:33', '2018-03-11 08:54:33'),
(3, 'https://streamable.com/s/a9cms/vlilgm', '5b49d2d92894028464726b536287c16d', '2018-03-11 08:55:11', '2018-03-11 08:55:11'),
(4, 'https://nodefiles.com/embed-frkyrfseqddn', '621982963402724f58ae8a22b03c1aef', '2018-03-11 10:12:47', '2018-03-11 10:12:47'),
(5, 'https://nodefiles.com/embed-w0lmy1vj7gh0.html', '60577df67c06e77c293c2c39dd88d95b', '2018-03-11 10:13:14', '2018-03-11 10:13:14'),
(6, 'https://nodefiles.com/embed-d7jghvr10f9b.html', 'db400f62ef11e2dbfbfc91325b4530ee', '2018-03-12 02:51:34', '2018-03-12 02:51:34'),
(7, 'https://streamable.com/a9cms', '85e9c351d88af52a6c4c58bef99ecef7', '2018-03-12 02:53:01', '2018-03-12 02:53:01'),
(8, 'https://streamable.com/kvbk8', '8bb4f2c67edb9d65ace4fabe3ace75be', '2018-03-12 03:08:46', '2018-03-12 03:08:46'),
(9, 'https://streamable.com/hu1qh', '12b2a67fb836d68980f0489d06aa9b77', '2018-03-12 03:09:27', '2018-03-12 03:09:27'),
(10, 'http://phukiencuoi.xyz/play/60577df67c06e77c293c2c39dd88d95b', '173321ed9478f1566ebc107cdf556e4b', '2018-03-12 03:39:12', '2018-03-12 03:39:12'),
(11, 'http://phukiencuoi.xyz/play/5b49d2d92894028464726b536287c16d', '3891614fdf993065f8961c7f41915756', '2018-03-12 03:39:22', '2018-03-12 03:39:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_video`
--
ALTER TABLE `data_video`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `origin_url_2` (`origin_url`),
  ADD KEY `code` (`code`),
  ADD KEY `origin_url` (`origin_url`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_video`
--
ALTER TABLE `data_video`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
