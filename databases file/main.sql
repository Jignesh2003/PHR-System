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
-- Table structure for table `main`
--

CREATE TABLE `main` (
  `id` int(11) NOT NULL,
  `Role` varchar(1000) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `SituationType` varchar(1000) NOT NULL,
  `DocumentId` int(10) NOT NULL,
  `DocumentName` varchar(1000) NOT NULL,
  `DocumentType` varchar(1000) NOT NULL,
  `ByWhichTable` varchar(1000) NOT NULL,
  `RBAC` varchar(20) NOT NULL,
  `documentConfidentiality` int(11) NOT NULL,
  `roleReliablity` int(11) NOT NULL,
  `situationReliablity` int(11) NOT NULL,
  `accessReliability` int(11) NOT NULL,
  `consentAuthority` int(11) NOT NULL,
  `TF` int(11) NOT NULL,
  `RBAC_TF` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main`
--

INSERT INTO `main` (`id`, `Role`, `Name`, `SituationType`, `DocumentId`, `DocumentName`, `DocumentType`, `ByWhichTable`, `RBAC`, `documentConfidentiality`, `roleReliablity`, `situationReliablity`, `accessReliability`, `consentAuthority`, `TF`, `RBAC_TF`) VALUES
(1, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 0, '', '', '', 'Yes', 0, 1, 1, 1, 0, 0, ''),
(2, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 0, '', '', '', 'Yes', 0, 3, 3, 1, 0, 0, ''),
(3, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 0, '', '', '', 'Yes', 0, 1, 1, 1, 0, 0, ''),
(4, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 1, 'image.jpg', 'Clinic Report', 'reports', 'Yes', 2, 1, 1, 1, 0, 0, ''),
(5, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 3, 'banner_1.jpg', 'Last Visit Report', 'reports', 'Yes', 1, 1, 1, 1, 0, 0, ''),
(6, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 0, '', '', '', 'Yes', 0, 3, 3, 1, 0, 0, ''),
(7, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 3, '5th_sem_syllabus.pdf', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 0, ''),
(8, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 5, 'banner_1.jpg', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 0, ''),
(9, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 2, '5th_sem_syllabus.pdf', 'Diagnosis Report', 'reports', 'Yes', 1, 1, 1, 1, 0, 0, ''),
(10, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 7, 'ABC_Presentation_ ppt.pdf', 'Test Requirement', 'reports', 'Yes', 3, 1, 1, 1, 0, 0, ''),
(11, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 7, 'ABC_Presentation_ ppt.pdf', 'Test Requirement', 'reports', 'Yes', 3, 1, 1, 1, 0, 1, 'Yes'),
(12, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 1, 'image.jpg', 'Clinic Report', 'reports', 'Yes', 2, 1, 1, 1, 0, 1, 'Yes'),
(13, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 3, '5th_sem_syllabus.pdf', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 1, 'Yes'),
(14, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 1, 'banner_3.jpg', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 1, 'Yes'),
(15, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 1, 'banner_3.jpg', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 1, 'Yes'),
(16, 'Doctor', 'Dr. Amar Yadav', 'Pharmacist Shop Visit', 1, 'banner_3.jpg', 'Last Visit Report', 'reports', 'Yes', 2, 1, 3, 2, 0, 0, 'No'),
(17, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 1, 'image.jpg', 'Clinic Report', 'reports', 'Yes', 2, 1, 1, 1, 0, 1, 'Yes'),
(18, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 1, 'banner_3.jpg', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 1, 'Yes'),
(19, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 2, '5th_sem_syllabus.pdf', 'Diagnosis Report', 'reports', 'Yes', 1, 1, 1, 1, 0, 1, 'Yes'),
(20, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 1, 'image.jpg', 'Clinic Report', 'reports', 'Yes', 2, 1, 1, 1, 0, 1, 'Yes'),
(21, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 7, 'ABC_Presentation_ ppt.pdf', 'Test Requirement', 'reports', 'Yes', 3, 1, 1, 1, 0, 1, 'Yes'),
(22, 'Doctor', 'Dr. Amar Yadav', 'First Time Visit', 3, 'banner_1.jpg', 'Last Visit Report', 'reports', 'Yes', 1, 1, 2, 1, 0, 1, 'Yes'),
(23, 'Doctor', 'Dr. Amar Yadav', 'First Time Visit', 2, '5th_sem_syllabus.pdf', 'Diagnosis Report', 'reports', 'Yes', 1, 1, 2, 1, 0, 1, 'Yes'),
(24, 'Doctor', 'Dr. Amar Yadav', 'OPD Visit', 1, 'image.jpg', 'Clinic Report', 'reports', 'Yes', 2, 1, 1, 1, 0, 1, 'Yes'),
(25, 'Pharmacist', 'Vijay Chavan', 'Pharmacist Shop Visit', 3, '5th_sem_syllabus.pdf', 'Prescription', 'prescription', 'Yes', 2, 3, 3, 1, 0, 1, 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `main`
--
ALTER TABLE `main`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `main`
--
ALTER TABLE `main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
