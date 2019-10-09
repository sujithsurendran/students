-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2019 at 04:46 PM
-- Server version: 10.1.38-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `institution`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_of_admission` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `branch` varchar(15) NOT NULL,
  `internal_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender_id` tinyint(1) NOT NULL DEFAULT '0',
  `designation_id` int(11) NOT NULL DEFAULT '1',
  `program_id` int(11) NOT NULL DEFAULT '0',
  `dob` date NOT NULL,
  `password` varchar(50) NOT NULL,
  `password_hash` varchar(50) DEFAULT NULL,
  `user_type_id` int(11) NOT NULL DEFAULT '0',
  `mobile` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `address3` varchar(50) DEFAULT NULL,
  `address4` varchar(50) DEFAULT NULL,
  `pin` varchar(10) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `roll_no_pf_no` varchar(5) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `year_of_admission`, `email`, `branch`, `internal_id`, `name`, `gender_id`, `designation_id`, `program_id`, `dob`, `password`, `password_hash`, `user_type_id`, `mobile`, `phone`, `address1`, `address2`, `address3`, `address4`, `pin`, `district`, `state`, `country`, `blood_group`, `roll_no_pf_no`, `joining_date`, `created_at`, `last_login`) VALUES
(1, 2019, 'titty@mec.ac.in', '1', 'titty', 'Titty', 0, 6, 0, '2001-03-03', 'c4ca4238a0b923820dcc509a6f75849b', '', 3, '1', '2', '3', '4', '5', '', '6', '7', '8', '9', '8', 'ttt', '1998-09-01', '2019-10-01 12:03:54', '2019-10-01 12:03:47'),
(2, 2018, 'suji@s.com', '1', '1205-19', 'StudentName', 0, 11, 0, '2002-10-09', 'c4ca4238a0b923820dcc509a6f75849b', '', 1, '', 'asdasda', '123456789101234567890123456789', '1111', '123456789101234567890123456789', NULL, '1234567891', '', '', 'India', '8', '', '1980-01-02', '2019-07-02 16:39:21', NULL),
(10, 2019, 'admin@mec.com', '1', 'admin', 'Admin', 0, 0, 0, '1970-01-01', 'c4ca4238a0b923820dcc509a6f75849b', '', 10, '', '', 'Address Line 1', 'Address Line 2', 'Address Line 1', NULL, 'Address Li', '', '', 'India', '1', '', '1970-01-01', '2019-02-13 16:09:37', '2019-10-01 14:59:24'),
(11, 2019, 'a001@aaa.com', '1', '1203-19', 'ZzzY', 0, 1, 0, '1970-01-01', 'c4ca4238a0b923820dcc509a6f75849b', '', 1, '', '', 'Address Line 1', 'Address Line 2', 'Address Line 1', NULL, '', '', '', 'India', '1', '', '1970-01-01', '2019-05-07 15:03:54', NULL),
(16, 2019, 'a022202@asd.com', '1', '1204-19', 'Test Abcd', 0, 1, 0, '1970-01-01', 'c4ca4238a0b923820dcc509a6f75849b', '', 1, '111', '1111', '11231', '12123', '11231', NULL, '123123', '123123', '123123', 'India', '1', '1204-', '1970-01-01', '2019-10-01 15:01:00', NULL),
(20, 2019, 'x002', 'Computer Scienc', '1200-19', '', 0, 1, 0, '1970-01-01', 'de1e30aef8236b8ee35497f36a02e84a', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-04-26 15:57:06', NULL),
(21, 2019, 'x003', 'Computer Scienc', '1201-19', '', 0, 1, 0, '1970-01-01', 'a4caf521c65c25a982f5f6be2b621fc7', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-04-26 16:00:07', NULL),
(22, 2019, 'x004', 'Computer Scienc', '1202-19', '', 0, 1, 0, '1970-01-01', '0427353204c196f2f214780fb378298d', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-04-26 16:00:53', NULL),
(23, 2019, 'x006', 'Computer Scienc', 'x006', '', 0, 1, 0, '1970-01-01', '90e9727eb615128756b7426aec578c9d', '', 2, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-04-26 16:26:39', NULL),
(24, 2019, 'x007', 'Computer Scienc', 'x007', '', 0, 1, 0, '1970-01-01', 'b05e3c01a448b95666ead41636d5b4bb', '', 2, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-04-26 16:27:08', NULL),
(25, 2019, 'xyz001@aaa.com', '4', 'xyz001', 'Appukuttan K K', 0, 1, 0, '1973-05-25', '55fca5f0010fb1ba4d90c577b64ff9c9', '', 2, '999', '999', 'Address Line 1', 'Address Line 2', 'Address Line 1', NULL, '1111', 'Ernakulam', 'Kerala', 'India', '2', 'xyz00', '1980-01-22', '2019-04-29 15:39:18', '2019-04-29 15:23:35'),
(26, 2019, 'x009', 'Computer Scienc', 'x009', '', 0, 1, 0, '1970-01-01', '8e2dcaae698ee73774fd6c0cd1773432', '', 2, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-04-30 15:33:15', NULL),
(27, 2019, 'z99-19', 'Computer Scienc', 'z1-001', '', 0, 1, 0, '1970-01-01', '', '', 2, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-02 12:16:41', NULL),
(28, 2019, 'k001', 'Computer Scienc', '1206-19', '', 0, 1, 0, '1970-01-01', 'b47cbbe51cb6976e32344014a46a58d7', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-13 15:41:44', NULL),
(29, 2019, 'kq001', 'Computer Scienc', 'kq001', '', 0, 1, 0, '1970-01-01', 'ee88d8db60931a2f34d580b98c468f6a', '', 3, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-14 10:56:23', NULL),
(30, 2019, '1207-19', 'Computer Scienc', '1207-19', '', 0, 1, 0, '1970-01-01', 'edf04f0f403c15ee963f3eaba73f992d', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-15 16:11:56', NULL),
(32, 2019, '1208-19', 'Computer Scienc', '1208-19', '', 0, 1, 0, '1970-01-01', '0390982f3753bbcb4ea039ee9d980618', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-15 16:12:14', NULL),
(33, 2019, '1209-19', 'Computer Scienc', '1209-19', '', 0, 1, 0, '1970-01-01', 'e30112cfd75d59580e85c90532cb7460', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-29 12:37:17', NULL),
(34, 2019, '1210-19', 'Computer Scienc', '1210-19', '', 0, 1, 0, '1970-01-01', '31a8a69f55457a06168d02098b2b7b13', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-29 12:37:26', NULL),
(35, 2019, '1211-19', 'Computer Scienc', '1211-19', '', 0, 1, 0, '1970-01-01', '41fb4e71ca0cbe4da242379a253f469d', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-05-29 12:37:42', NULL),
(36, 2019, '1212-19', 'Computer Scienc', '1212-19', '', 0, 1, 0, '1970-01-01', '14f5ba811e0bbdbce02f531426db59ac', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-06-11 13:53:48', '2019-06-11 13:55:48'),
(37, 2019, '1220-19', 'Computer Scienc', '1220-19', '', 0, 1, 0, '1970-01-01', 'c7dbae4eb28df89b089796326a117850', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-06-11 13:59:14', NULL),
(38, 2019, '1219-19', 'Computer Scienc', '1219-19', '', 0, 1, 0, '1970-01-01', 'ff6d598a45c6243e87abd699f5842e0e', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-06-11 13:59:39', NULL),
(39, 2019, 'x001', 'Computer Scienc', 'x001', '', 0, 1, 0, '1970-01-01', '74e6afad999a658eb72406ed0994ac77', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-08-02 12:05:15', '2019-08-02 12:05:33'),
(40, 2019, 'a1000', 'Computer Scienc', 'a1000', '', 0, 1, 0, '1970-01-01', '710addad9a951dd1e9e9adf86baf82d2', '', 1, NULL, NULL, 'Address Line 1', 'Address Line 2', NULL, NULL, NULL, NULL, NULL, 'India', '2380091', NULL, NULL, '2019-09-25 15:52:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `internal_id` (`internal_id`),
  ADD UNIQUE KEY `login` (`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
