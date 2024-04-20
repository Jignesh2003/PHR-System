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
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) NOT NULL,
  `DoctorName` varchar(100) NOT NULL,
  `Document` varchar(100) NOT NULL,
  `GiveRights` varchar(1000) NOT NULL,
  `DateOfPerformance` varchar(100) NOT NULL,
  `DocumentType` varchar(1000) NOT NULL,
  `DocumentPriority` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `DoctorName`, `Document`, `GiveRights`, `DateOfPerformance`, `DocumentType`, `DocumentPriority`) VALUES
(1, 'Dr. Abhijeet Varankar', 'image.jpg', 'Dr. Abhijeet Varankar, Dr. Amar Yadav', '10-12-2023', 'Clinic Report', 2),
(2, 'Dr. Amar Yadav', '5th_sem_syllabus.pdf', 'Dr. Amar Yadav, Dr. Abhijeet Varankar', '11-01-2023', 'Diagnosis Report', 1),
(3, 'Dr. Jigyasa Verma', 'banner_1.jpg', 'Dr. Amar Yadav, Dr. Jigyasa Verma', '04-05-2022', 'Last Visit Report', 1),
(4, 'Dr. Nikita', 'banner_1.jpg', 'Dr.Nikita', '27-12-2013', 'Sonography Report', 1),
(5, 'Dr. Nitin', 'ABC_Presentation_ppt.pdf', '', '27-12-2014', 'Xray Report', 1),
(6, 'Dr. Vinayak More', 'elective_subjects_5th_sem.pdf', '', '15-02-2020', 'MRI Report', 1),
(7, 'Dr. Goenka Arnav', 'ABC_Presentation_ ppt.pdf', 'Dr. Goenka Arnav, Dr. Amar Yadav, Dr. Vinayak Raut, Dr. Bharat Rana', '15-01-2021', 'Test Requirement', 3),
(8, 'Dr. Abhishek', 'image.jpg', 'Dr. Abhishek', '15-01-2021', 'Clinic Report', 2),
(9, 'Dr. Viraj', 'banner_1.jpg', 'Dr. Viraj', '15-01-2021', 'Clinic Report', 2),
(10, 'Dr. Viraj', 'banner_1.jpg', 'Dr. Viraj', '15-01-2021', 'Diagnosis Report', 1),
(11, 'Dr. Sandeep', 'banner_1.jpg', 'Dr. Sandeep', '15-01-2021', 'Test Requirement', 3),
(12, 'Dr. Sandeep', 'banner_1.jpg', 'Dr. Sandeep', '15-01-2021', 'Clinic Report', 2),
(13, 'Dr. Shukla', 'banner_1.jpg', 'Dr. Shukla', '15-01-2022', 'Test Requirement', 2),
(14, 'Dr. Mohan', '5th_sem_syllabus.pdf', 'Dr. Mohan', '15-01-2023', 'Diagnisis Report', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
