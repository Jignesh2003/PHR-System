-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 10:50 AM
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
-- Database: `researchpaper`
--

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(10) NOT NULL,
  `DoctorName` varchar(100) NOT NULL,
  `Document` varchar(1000) NOT NULL,
  `GiveRights` varchar(10000) NOT NULL,
  `DateOfPerformance` varchar(100) NOT NULL,
  `DocumentType` varchar(1000) NOT NULL,
  `DocumentPriority` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `DoctorName`, `Document`, `GiveRights`, `DateOfPerformance`, `DocumentType`, `DocumentPriority`) VALUES
(1, 'Dr. Amar Yadav', 'banner_3.jpg', 'Dr. Amar Yadav, Vijay Chavan', '12-12-2023', 'Prescription', 2),
(2, 'Dr.Pratik Agrawal', 'elective_subjects_5th_sem.pdf', 'Ankit Mishra', '02-12-2023', 'Prescription', 2),
(3, 'Dr. V.H. Virurkhar', '5th_sem_syllabus.pdf', 'Ankit Mishra, Vijay Chavan', '05-05-2022', 'Prescription', 2),
(4, 'Dr. Mohan', 'image.jpg', '', '07-04-2014', 'Prescription', 2),
(5, 'Dr. drName2', 'banner_1.jpg', 'Vijay Chavan', '10-04-2023', 'Prescription', 2),
(6, 'Dr. Samyank Madvankar', '5th_sem_syllabus.pdf', 'Dr. Samyank Madvankar, Ankit Mishra', '20-05-2024', 'Prescription', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
