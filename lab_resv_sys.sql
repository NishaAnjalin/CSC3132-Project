-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 11:31 AM
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
-- Database: `lab_resv_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `timetable_slots`
--

CREATE TABLE `timetable_slots` (
  `id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `lab_id` int(11) NOT NULL,
  `subject_code` varchar(8) DEFAULT NULL,
  `status` enum('available','reserved','cancelled') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable_slots`
--

INSERT INTO `timetable_slots` (`id`, `day_of_week`, `start_time`, `end_time`, `lab_id`, `subject_code`, `status`) VALUES
(11, 'Monday', '08:30:00', '09:30:00', 1, 'CSC3122', 'available'),
(12, 'Tuesday', '08:30:00', '09:30:00', 1, 'CSC3132', 'reserved'),
(13, 'Wednesday', '08:30:00', '09:30:00', 1, 'CSH3123', 'reserved'),
(14, 'Thursday', '08:30:00', '09:30:00', 1, 'IT2123', 'cancelled'),
(15, 'Friday', '08:30:00', '09:30:00', 1, 'IT3122', 'available'),
(21, 'Monday', '09:30:00', '10:30:00', 1, 'IT2123', 'available'),
(22, 'Tuesday', '09:30:00', '10:30:00', 1, 'CSC3122', 'reserved'),
(23, 'Wednesday', '09:30:00', '10:30:00', 1, 'IT3122', 'reserved'),
(24, 'Thursday', '09:30:00', '10:30:00', 1, 'CSH3123', 'cancelled'),
(25, 'Friday', '09:30:00', '10:30:00', 1, 'CSC3132', 'available'),
(31, 'Monday', '10:30:00', '11:30:00', 1, 'CSC3132', 'available'),
(32, 'Tuesday', '10:30:00', '11:30:00', 1, 'CSH3123', 'reserved'),
(33, 'Wednesday', '10:30:00', '11:30:00', 1, 'CSC3122', 'reserved'),
(34, 'Thursday', '10:30:00', '11:30:00', 1, 'IT3122', 'cancelled'),
(35, 'Friday', '10:30:00', '11:30:00', 1, 'IT2123', 'available'),
(41, 'Monday', '11:30:00', '12:30:00', 1, 'CSH3123', 'available'),
(42, 'Tuesday', '11:30:00', '12:30:00', 1, 'IT2123', 'reserved'),
(43, 'Wednesday', '11:30:00', '12:30:00', 1, 'CSC3122', 'reserved'),
(44, 'Thursday', '11:30:00', '12:30:00', 1, 'CSC3132', 'cancelled'),
(45, 'Friday', '11:30:00', '12:30:00', 1, 'IT3122', 'available'),
(51, 'Monday', '12:30:00', '13:30:00', 1, 'IT3122', 'available'),
(52, 'Tuesday', '12:30:00', '13:30:00', 1, 'CSC3122', 'reserved'),
(53, 'Wednesday', '12:30:00', '13:30:00', 1, 'CSH3123', 'reserved'),
(54, 'Thursday', '12:30:00', '13:30:00', 1, 'CSC3132', 'cancelled'),
(55, 'Friday', '12:30:00', '13:30:00', 1, 'IT2123', 'available'),
(61, 'Monday', '13:30:00', '14:30:00', 1, 'CSC3132', 'available'),
(62, 'Tuesday', '13:30:00', '14:30:00', 1, 'CSH3123', 'reserved'),
(63, 'Wednesday', '13:30:00', '14:30:00', 1, 'CSC3122', 'reserved'),
(64, 'Thursday', '13:30:00', '14:30:00', 1, 'IT2123', 'cancelled'),
(65, 'Friday', '13:30:00', '14:30:00', 1, 'IT3122', 'available'),
(71, 'Monday', '14:30:00', '15:30:00', 1, 'IT2123', 'available'),
(72, 'Tuesday', '14:30:00', '15:30:00', 1, 'CSC3132', 'reserved'),
(73, 'Wednesday', '14:30:00', '15:30:00', 1, 'IT3122', 'reserved'),
(74, 'Thursday', '14:30:00', '15:30:00', 1, 'CSC3122', 'cancelled'),
(75, 'Friday', '14:30:00', '15:30:00', 1, 'CSH3123', 'available'),
(81, 'Monday', '15:30:00', '16:30:00', 1, 'CSH3123', 'available'),
(82, 'Tuesday', '15:30:00', '16:30:00', 1, 'CSC3132', 'reserved'),
(83, 'Wednesday', '15:30:00', '16:30:00', 1, 'IT2123', 'reserved'),
(84, 'Thursday', '15:30:00', '16:30:00', 1, 'IT3122', 'cancelled'),
(85, 'Friday', '15:30:00', '16:30:00', 1, 'CSC3122', 'reserved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
