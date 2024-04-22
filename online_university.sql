-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 10:52 AM
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
-- Database: `online_university`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `fullname`, `email`, `password`) VALUES
(1, 'Nilla Ntambi', 'nillantambi@gmail.com', '$2y$10$bFXkS5LMLn0DCEEkf/uwL.LjC919qjZ6UP0i37JxpQEdxO7OvZJO6');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_four_id` int(11) NOT NULL,
  `form_six_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `status_message` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `user_id`, `form_four_id`, `form_six_id`, `program_id`, `status_message`, `status`) VALUES
(1, 1, 1, 1, 1, 'Congratulations! You have been selected', 'approved'),
(2, 2, 2, 2, 1, 'Visit the page to make an application again', 'rejected'),
(3, 2, 3, 3, 1, 'Visit the page to make an application again', 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `form_four`
--

CREATE TABLE `form_four` (
  `form_four_id` int(11) NOT NULL,
  `exam_year_o` varchar(250) NOT NULL,
  `subjects_o` varchar(250) NOT NULL,
  `grades_o` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_four`
--

INSERT INTO `form_four` (`form_four_id`, `exam_year_o`, `subjects_o`, `grades_o`) VALUES
(1, '2019', 'Physics, Chemistry, Mathematics, Biology, English, Kiswahili, History', 'B, B, A, B, B, C, C'),
(2, '2019', 'Physics, Chemistry, Mathematics, Biology, English, Kiswahili, History', 'B, B, A, B, B, C, C'),
(3, '2019', 'Physics, Chemistry, Mathematics, Biology, English, Kiswahili, History', 'B, B, A, B, B, C, C');

-- --------------------------------------------------------

--
-- Table structure for table `form_six`
--

CREATE TABLE `form_six` (
  `form_six_id` int(11) NOT NULL,
  `exam_year_a` varchar(250) NOT NULL,
  `subjects_a` varchar(250) NOT NULL,
  `grades_a` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_six`
--

INSERT INTO `form_six` (`form_six_id`, `exam_year_a`, `subjects_a`, `grades_a`) VALUES
(1, '2022', 'Mathematics, Physics, Mathematics', 'A, B, B'),
(2, '2022', 'Mathematics, Physics, Mathematics', 'A, B, B'),
(3, '2022', 'Mathematics, Physics, Mathematics', 'A, B, B');

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

CREATE TABLE `programme` (
  `program_id` int(11) NOT NULL,
  `program_name` varchar(250) NOT NULL,
  `duration` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programme`
--

INSERT INTO `programme` (`program_id`, `program_name`, `duration`) VALUES
(1, 'cybersecurity', '4 years');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fullname`, `email`, `password`, `phone`) VALUES
(1, 'Ester Mlahagwa', 'estermlahangwa@gmail.com', '$2y$10$j3FJKBMk.PtjFMVj6FZmG.fgH2X7DiE8rR0XwTpOPBV4cCh8LQQUq', '0745299753'),
(2, 'Happy Ntambi', 'happyntambi@gmail.com', '$2y$10$Ip40dfXtXcfCk2m2jICdEudQpwDO0l97Ex2xd1ciAJgfXVS02QWvK', '0745299753');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `app_user` (`user_id`),
  ADD KEY `app_four` (`form_four_id`),
  ADD KEY `app_six` (`form_six_id`),
  ADD KEY `app_program` (`program_id`);

--
-- Indexes for table `form_four`
--
ALTER TABLE `form_four`
  ADD PRIMARY KEY (`form_four_id`);

--
-- Indexes for table `form_six`
--
ALTER TABLE `form_six`
  ADD PRIMARY KEY (`form_six_id`);

--
-- Indexes for table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`program_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `form_four`
--
ALTER TABLE `form_four`
  MODIFY `form_four_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `form_six`
--
ALTER TABLE `form_six`
  MODIFY `form_six_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `programme`
--
ALTER TABLE `programme`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `app_four` FOREIGN KEY (`form_four_id`) REFERENCES `form_four` (`form_four_id`),
  ADD CONSTRAINT `app_program` FOREIGN KEY (`program_id`) REFERENCES `programme` (`program_id`),
  ADD CONSTRAINT `app_six` FOREIGN KEY (`form_six_id`) REFERENCES `form_six` (`form_six_id`),
  ADD CONSTRAINT `app_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
