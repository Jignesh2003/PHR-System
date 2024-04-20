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
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `id` int(10) NOT NULL,
  `Document` varchar(1000) NOT NULL,
  `lastAccessDate` date NOT NULL,
  `lastAccessTime` time NOT NULL,
  `accessLocation` varchar(1000) NOT NULL,
  `accessCount` int(10) NOT NULL,
  `accessReason` varchar(100) NOT NULL,
  `accessBy` varchar(100) NOT NULL,
  `accessGrant` varchar(100) NOT NULL,
  `byWhichTable` varchar(100) NOT NULL,
  `situationId` int(10) NOT NULL,
  `situationType` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `Document`, `lastAccessDate`, `lastAccessTime`, `accessLocation`, `accessCount`, `accessReason`, `accessBy`, `accessGrant`, `byWhichTable`, `situationId`, `situationType`) VALUES
(1, 'image.jpg', '2024-01-20', '15:39:00', 'Marina Del Rey', 30, 'Infection', '1', 'Default', 'reports', 1, 'Lab Test'),
(2, '5th_sem_syllabus.pdf', '2024-01-20', '15:39:00', 'Venice', 33, 'Wound care', '2', 'Default', 'reports', 1, 'Annual checkup'),
(3, 'banner_1.jpg', '2024-01-20', '15:39:00', 'Marina Del Rey', 22, 'Ankle sprain', '3', 'Default', 'reports', 1, 'Annual checkup'),
(4, 'elective_subjects_5th_sem.pdf', '2024-01-20', '15:39:00', 'Venice', 3, 'Heel pain', '4', 'Default', 'reports', 2, 'First time Visit'),
(5, 'ABC_Presentation_ppt.pdf', '2024-01-20', '15:39:00', 'Venice', 0, 'Injection', '5', 'Default', 'reports', 2, 'First time Visit'),
(6, 'image.jpg', '2024-01-20', '15:39:00', 'Venice', 0, 'Toe pain', '6', 'Default', 'reports', 2, 'First time Visit'),
(7, 'elective_subjects_5th_sem.pdf', '2024-01-20', '15:39:00', 'Brentwood', 8, 'Infection', '7', 'Default', 'reports', 1, 'Lab Test'),
(8, 'ABC_Presentation_ ppt.pdf', '2024-01-20', '15:54:00', 'Venice', 0, 'Wound care', '8', 'Default', 'reports', 2, 'First time Visit'),
(9, 'banner_3.jpg', '2024-01-20', '16:12:00', 'Santa Monica', 10, 'Fever', '1', 'Default', 'prescription', 3, 'Pharmacist Shop Visit'),
(10, 'elective_subjects_5th_sem.pdf', '2024-01-20', '16:12:00', 'Venice', 0, 'Fever', '2', 'Default', 'prescription', 3, 'Pharmacist Shop Visit'),
(11, '5th_sem_syllabus.pdf', '2024-01-20', '16:12:00', 'Marina Del Rey', 6, 'Fever', '3', 'Default', 'prescription', 3, 'Pharmacist Shop Visit'),
(12, 'image.jpg', '2024-01-20', '16:12:00', 'Culver City', 0, 'Fever', '4', 'Default', 'prescription', 3, 'Pharmacist Shop Visit'),
(13, 'banner_1.jpg', '2024-01-20', '16:12:00', 'Brentwood', 1, 'Fever', '5', 'Default', 'prescription', 3, 'Pharmacist Shop Visit'),
(14, '5th_sem_syllabus.pdf', '2024-01-20', '16:12:00', 'Culver City', 0, 'Fever', '6', 'Default', 'prescription', 3, 'Pharmacist Shop Visit'),
(15, '5th_sem_syllabus.pdf', '2024-01-20', '16:47:08', 'Culver City', 0, 'Fever', '14', 'Default', 'reports', 3, 'Pharmacist Shop Visit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
