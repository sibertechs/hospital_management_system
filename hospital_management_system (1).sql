-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 22, 2024 at 07:10 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_id` int DEFAULT NULL,
  `hospital_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `appointment_date`, `doctor_name`, `status`, `created_at`, `doctor_id`, `hospital_id`) VALUES
(19, 14, '2024-09-09', NULL, 'Completed', '2024-09-09 08:21:22', 3, NULL),
(18, 14, '2024-09-13', NULL, 'Completed', '2024-09-09 05:22:26', 5, NULL),
(17, 14, '2024-09-11', NULL, 'Completed', '2024-09-09 04:51:00', 6, NULL),
(16, 4, '2024-09-17', NULL, 'Completed', '2024-09-08 23:40:45', 6, NULL),
(15, 4, '2024-09-17', NULL, 'Completed', '2024-09-08 23:40:33', 6, NULL),
(14, 7, '2024-09-14', NULL, 'Completed', '2024-09-08 23:30:13', 5, NULL),
(13, 6, '2024-09-09', NULL, 'Completed', '2024-09-08 22:03:51', 3, NULL),
(12, 1, '2024-09-08', NULL, 'Completed', '2024-09-08 22:02:38', 1, NULL),
(24, 11, '2024-12-02', NULL, 'Completed', '2024-09-14 04:04:02', 6, 2),
(23, 11, '2024-09-16', NULL, '', '2024-09-13 23:55:50', 6, 1),
(22, 11, '2024-09-13', NULL, 'Completed', '2024-09-13 20:42:12', 1, 1),
(25, 11, '2024-12-02', NULL, 'Completed', '2024-09-14 04:04:19', 6, 2),
(26, 13, '2024-09-20', NULL, '', '2024-09-15 09:06:15', 2, 1),
(27, 13, '2024-09-15', NULL, 'Completed', '2024-09-15 09:10:02', 7, 1),
(28, 17, '1696-12-01', NULL, 'Completed', '2024-09-15 09:19:01', 1, 1),
(29, 18, '2024-09-19', NULL, 'Completed', '2024-09-16 01:53:41', 7, 2),
(30, 18, '2024-09-15', NULL, 'Completed', '2024-09-16 01:54:21', 5, 1),
(31, 18, '2024-09-16', NULL, 'Completed', '2024-09-16 07:20:07', 6, 4),
(32, 18, '2024-09-16', NULL, 'Completed', '2024-09-16 07:21:16', 8, 3),
(33, 11, '2024-09-11', NULL, 'Completed', '2024-09-18 01:06:53', 11, 4),
(34, 21, '2024-09-06', NULL, 'Completed', '2024-09-21 21:00:48', 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `dob` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `country_of_origin` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default_profile',
  `hospital_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password_changed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `dob`, `country_of_origin`, `phone`, `email`, `password`, `profile_picture`, `hospital_id`, `created_at`, `password_changed`) VALUES
(1, 'Dr. Imath Siber', 'Medical Doctor', '0000-00-00 00:00:00', '', '0543529284', 'imathsiber@gmail.com', '', 'default_profile', 1, '2024-09-08 14:52:47', 0),
(2, 'Dr. Alfred Ahaya Akuliba', 'Medical Doctor', '0000-00-00 00:00:00', '', '0506897158', 'alfredahaya@gmail.com', '', 'default_profile', 4, '2024-09-08 15:46:24', 0),
(3, 'Dr. Alfred Ahaya Akuliba', 'Medical Doctor', '0000-00-00 00:00:00', '', '0506897158', 'alfredahaya@gmail.com', '', 'default_profile', 4, '2024-09-08 15:49:51', 0),
(4, 'Dr. Alfred Ahaya Akuliba', 'Medical Doctor', '0000-00-00 00:00:00', '', '0506897158', 'alfredahaya@gmail.com', '', 'default_profile', 4, '2024-09-08 15:52:52', 0),
(5, 'Dr. Ebenezer', 'Psychiatrist', '0000-00-00 00:00:00', '', '0506897158', 'ebenezertiroug@gmail.com', '', 'default_profile', 2, '2024-09-08 23:29:26', 0),
(6, 'Dr. Nyarko', 'Cardiologist', '0000-00-00 00:00:00', '', '0236879645', 'nyarko023@gmail.com', '', 'default_profile', 8, '2024-09-08 23:39:45', 0),
(7, 'Dr. Paa George', 'Neurologist', '0000-00-00 00:00:00', '', '0543529284', 'paageorge12@gmail.com', '', 'default_profile', 2, '2024-09-08 23:44:17', 0),
(8, 'Dr. Ampim Yeboah Frank', 'Medical Doctor', '0000-00-00 00:00:00', '', '0507353819', 'ampimyeboahfrank012@gmail.com', 'S123456', 'uploads/author.jpg', 4, '2024-09-16 04:25:34', 1),
(9, 'Dr. Sika Boafour', 'Medical Doctor', '1990-01-16 08:00:00', 'Ghana', '0241586301', 'sikaboafour@gmail.com', 'AOA123456', 'uploads/author.jpg', 3, '2024-09-16 12:17:42', 1),
(10, 'Dr. Enock Ohene Amoako', 'Medical Doctor', '1996-12-02 08:00:00', 'Ghana', '0557120314', 'enockoheneamoako120@gmail.com', 'AOA123', 'uploads/WhatsApp Image 2024-09-16 at 15.51.08_893b600b.jpg', 4, '2024-09-17 20:52:02', 1),
(11, 'Dr. Nimo Andrew', 'Medical Doctor', '1992-01-05 08:00:00', 'Ghana', '0248123601', 'nimoandrew110@gmail.com', '123456', 'uploads/default-profile.png', 4, '2024-09-17 22:47:13', 1),
(12, 'Dr. Kwaku Sika', 'Medical Doctor', '2024-09-21 07:00:00', 'Ghana', '0550719923', 'kwakusika@gmail.com', '123456', 'uploads/default-profile.png', 9, '2024-09-21 23:35:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
CREATE TABLE IF NOT EXISTS `drugs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `drug_name` varchar(255) NOT NULL,
  `drug_type` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`id`, `drug_name`, `drug_type`, `price`) VALUES
(1, 'Amoxicillin', 'Antibiotic', 12.00),
(2, 'Paracetamol', 'Antipyretic', 5.00),
(3, 'Ibuprofen', 'Analgesic', 7.00),
(4, 'Loratadine', 'Antihistamine', 8.00),
(5, 'Diazepam', 'Sedative', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `drug_type`
--

DROP TABLE IF EXISTS `drug_type`;
CREATE TABLE IF NOT EXISTS `drug_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

DROP TABLE IF EXISTS `finance`;
CREATE TABLE IF NOT EXISTS `finance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`id`, `name`, `email`, `password`) VALUES
(1, 'Finance Department', 'financedepartment12@gmail.com', 'Finance12');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

DROP TABLE IF EXISTS `hospitals`;
CREATE TABLE IF NOT EXISTS `hospitals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `address`, `phone`, `created_at`) VALUES
(5, 'Daboya Hospital', 'North Gonja District, Savannah Region', '0302229576', '2024-09-18 16:08:11'),
(10, 'Daboya Hospital', 'NoNorth Gonja District, Savannah Region', '0302229576', '2024-09-18 16:49:50'),
(9, 'Daboya Hospital', 'NoNorth Gonja District, Savannah Region', '0302229576', '2024-09-18 16:43:17'),
(14, 'Daboya Hospital', 'North Gonja District, Savannah Region', '0248745922', '2024-09-22 19:09:35'),
(12, 'Daboya Hospital', 'NoNorth Gonja District, Savannah Region', '0302229576', '2024-09-18 16:50:27'),
(13, 'Daboya Hospital', 'NoNorth Gonja District, Savannah Region', '0302229576', '2024-09-18 16:50:38');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `drug_name` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `drug_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `drug_name`, `quantity`, `price`, `created_at`, `drug_type`) VALUES
(1, 'GJR', 52, 88.00, '2024-09-19 08:21:46', NULL),
(2, 'Amoxicillin', 44, 12.00, '2024-09-19 11:39:41', 'Antibiotic'),
(3, 'Loratadine', 12, 8.00, '2024-09-19 11:40:33', 'Antihistamine'),
(4, 'Paracetamol', 45, 5.00, '2024-09-19 11:41:41', 'Antipyretic'),
(5, 'Ibuprofen', 12, 7.00, '2024-09-22 07:37:18', 'Analgesic'),
(6, 'Amoxicillin', 12, 12.00, '2024-09-22 07:46:28', 'Antibiotic');

-- --------------------------------------------------------

--
-- Table structure for table `lab_messages`
--

DROP TABLE IF EXISTS `lab_messages`;
CREATE TABLE IF NOT EXISTS `lab_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lab_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `role` enum('lab','doctor') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lab_id` (`lab_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lab_messages`
--

INSERT INTO `lab_messages` (`id`, `message`, `created_at`, `lab_id`, `doctor_id`, `role`) VALUES
(1, 'Hi', '2024-09-17 07:40:38', 0, 0, 'lab'),
(2, 'Hello Lab', '2024-09-17 08:09:08', 0, 1, 'doctor'),
(3, 'Hello Lab', '2024-09-17 08:13:52', 0, 1, 'doctor'),
(4, 'Hello Lab', '2024-09-17 16:37:40', 0, 1, 'doctor'),
(5, 'Yes Sir', '2024-09-17 17:22:07', 0, 1, 'lab'),
(6, 'Hello\r\n', '2024-09-21 01:12:24', 0, 1, 'doctor');

-- --------------------------------------------------------

--
-- Table structure for table `lab_staff`
--

DROP TABLE IF EXISTS `lab_staff`;
CREATE TABLE IF NOT EXISTS `lab_staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lab_staff`
--

INSERT INTO `lab_staff` (`id`, `name`, `email`, `password`) VALUES
(1, 'Laboratory Department', 'labdepartment1@gmail.com', 'Lab123'),
(2, 'Laboratory Department1', 'labdepartment10@gmail.com', '123456'),
(3, 'Lab Department', 'labdepartment100@gmail.com', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `medical_history`
--

DROP TABLE IF EXISTS `medical_history`;
CREATE TABLE IF NOT EXISTS `medical_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `visit_date` date NOT NULL,
  `diagnosis` text NOT NULL,
  `treatment` text NOT NULL,
  `visit_notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doctor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

DROP TABLE IF EXISTS `medical_records`;
CREATE TABLE IF NOT EXISTS `medical_records` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `date` date NOT NULL,
  `details` text,
  PRIMARY KEY (`record_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `drug_id` int NOT NULL,
  `quantity` int NOT NULL,
  `status` enum('Pending','Completed','Cancelled') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `drug_id` (`drug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_registration`
--

DROP TABLE IF EXISTS `patient_registration`;
CREATE TABLE IF NOT EXISTS `patient_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `membership_id` int NOT NULL,
  `'issued_date` date NOT NULL,
  `issued_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `country_of_origin` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default-profile.png',
  `password_changed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_registration`
--

INSERT INTO `patient_registration` (`id`, `name`, `phone`, `email`, `dob`, `membership_id`, `'issued_date`, `issued_date`, `expiry_date`, `country_of_origin`, `password`, `profile_picture`, `password_changed`) VALUES
(1, 'Kwame Obra', '0236879645', 'kwameobra@gmail.com', '2024-09-18', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '$2y$10$QSkeoF4dW6GkTzu6N.iEt.oLsaPFzZ8OM8VOpLbhct/mQnMlZ3XLC', 'default-profile.png', 0),
(2, 'Alfred Ahaya Akuliba', '0506897158', 'alfredahaya@gmail.com', '1989-04-08', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Egypt', '$2y$10$Eeul.M34WS9OmqOk5ScLhuOiooAsCW/pTnuERUgFwF5L5s2YqSGNG', 'default-profile.png', 0),
(3, 'Alfred Ahaya Akuliba', '0506897158', 'alfredahaya01@gmail.com', '1989-04-08', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Egypt', '$2y$10$1P1MKLHLN49FXtZ6sowAeOkS7mM2B9CxnkBqK1Wcqmna9LOIt5hee', 'default-profile.png', 0),
(4, 'Kwaku Bonsu', '0302859712', 'kwakubonsu@gmail.com', '1989-04-13', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Egypt', '$2y$10$qrC4XOvc5TJ2yME6vbrga.VT4LgwE6iKlv/BbrHDQkWohGvZPpPc6', 'team1.jpeg', 0),
(5, 'Kofi Oduro', '0236879645', 'kofioduro@gmail.com', '2024-09-10', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '$2y$10$N5WT.RGCf1Qsh1gn8FGOlu3f1uGHL8iTv8yUrGPeuColNe1pG2j5G', 'team2.png', 0),
(6, 'Kwame Ampim Yeboah Bonsu', '0236879645', 'kwameyeboah@gmail.com', '2024-09-05', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Nigeria', '$2y$10$tju9ORc4Xtr44TNd7Mlvl.T1r9iwRWrG9w6Y6cR2SWTdC0/Qkf.Pi', 'default-profile.png', 0),
(7, 'Dwamena Akenten', '0245639812', 'dwamenaakenten@gmail.com', '2024-09-02', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '$2y$10$a5066i2ayjCP.WOPHaSg8.6ZTraqXi6tvzG8ApZSS.7vARqLi7zla', 'team1.jpeg', 0),
(8, 'Kofi Jones', '0302654178', 'kofijones@gmail.com', '2024-09-25', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Togo', '$2y$10$MPHyJq88WUQR9XTlXdLVkes83/tngb0T3ldsli97oMAnA7yim1moC', 'default-profile.png', 0),
(10, 'Koo Poku', '0302654178', 'koopoku@gmail.com', '2024-09-08', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'USA', '000000', 'author.jpg', 0),
(11, 'Koo Poku1', '0302654178', 'koopoku1@gmail.com', '2024-09-08', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'USA', '123456', 'me1__2_-removebg-preview.png', 0),
(12, 'Kwadwo Boafour', '0244968752', 'kwadwoboafour@gmail.com', '2024-09-10', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Kenya', '123456789', 'artificial.jpg', 0),
(13, 'Kwame Despite', '002559687', 'kwamedespite@ymail.com', '1983-10-09', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Benin', '123456789', 'team1.jpeg', 0),
(14, 'Paa Gyamfi', '0235987412', 'paagyamfi@gmail.com', '2024-09-25', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '123456', '66de67ae45468-AboutImage.jpg', 0),
(15, 'Quamina Kolog', '0300548971', 'quaminakolog@gmail.com', '2024-09-19', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '123456', 'uploads/team1.jpeg', 0),
(16, 'Grat Dimafa', '0247968412', 'gratdimafa@gmail.com', '1993-05-12', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Spain', '000000', 'uploads/team2.png', 0),
(17, 'Kofi Peemu', '0245968736', 'kofipeemu@gmail.com', '1998-12-02', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '123456789', 'author.jpg', 0),
(18, 'Paul Owusu Ansah', '0245369812', 'paulowusuansah123@gmail.com', '2024-09-18', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', 'A123456789', 'author.jpg', 1),
(19, 'Kwame Amor Danso', '0248745621', 'kwamedanso12@gmail.com', '1997-12-01', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '1234567890', 'uploads/ID CARD.jpg', 0),
(20, 'Kwabena Amo Owusu', '0241361207', 'kwabenaamoowusu@gmail.com', '1999-01-19', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '1234567890', 'uploads/ID CARD.jpg', 0),
(21, 'Kwabena Jones', '0245960127', 'kwabenajones@gmail.com', '1998-12-01', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '1234567890', 'WhatsApp Image 2024-09-18 at 14.59.19_ad89e231.jpg', 0),
(22, 'Joseph Bonsu', '0245213608', 'josephebonsu@gmail.com', '1992-12-01', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '123456', 'id.jpg', 0),
(23, 'Samuel Jones', '0214968701', 'samuel12@gmail.com', '1992-01-02', 0, '0000-00-00', '0000-00-00', '0000-00-00', 'Ghana', '0123', 'ARAFAT-removebg-preview.png', 0),
(24, 'Hamza Apambila Biggie', '0547201489', 'hamzaapambila@gmail.com', '2000-12-02', 1205812, '0000-00-00', '2024-12-02', '2025-12-02', 'Ghana', '123456', 'WhatsApp Image 2024-09-16 at 15.51.08_893b600b.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacists`
--

DROP TABLE IF EXISTS `pharmacists`;
CREATE TABLE IF NOT EXISTS `pharmacists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pharmacists`
--

INSERT INTO `pharmacists` (`id`, `name`, `email`, `password`) VALUES
(1, 'Pharmacist', 'pharmacist01@gmail.com', 'Pharmacist12');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

DROP TABLE IF EXISTS `prescriptions`;
CREATE TABLE IF NOT EXISTS `prescriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) DEFAULT NULL,
  `drug_name` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `instructions` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `drug_id` int DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `patient_id`, `drug_name`, `dosage`, `duration`, `instructions`, `created_at`, `drug_id`, `status`) VALUES
(1, '12', 'JKJFV', 'NKBNX', 'DFBJI', 'SDFNJ', '2024-09-19 08:50:25', NULL, ''),
(2, '1', 'nkn', 'kmkl', NULL, NULL, '2000-12-01 08:00:00', NULL, ''),
(3, '1', 'Paracetamol', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '0000-00-00 00:00:00', NULL, ''),
(4, '1', 'Paracetamol', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '0000-00-00 00:00:00', NULL, ''),
(5, '6', NULL, 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '0000-00-00 00:00:00', 3, ''),
(6, '4', NULL, 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '0000-00-00 00:00:00', 2, ''),
(7, '5', 'Paracetamol', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '0000-00-00 00:00:00', 2, ''),
(8, '11', 'Ibuprofen', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '2024-12-02 08:00:00', 3, ''),
(9, '11', 'Ibuprofen', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '2024-12-02 08:00:00', 3, ''),
(10, '11', 'Diazepam', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '0000-00-00 00:00:00', 5, ''),
(11, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:08:07', NULL, ''),
(12, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:11:12', NULL, ''),
(13, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:11:50', NULL, ''),
(14, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:13:35', NULL, ''),
(15, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:16:17', NULL, ''),
(16, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:17:44', NULL, ''),
(17, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:19:57', NULL, ''),
(18, '12', 'JKJFV', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:23:10', NULL, ''),
(19, '15', 'Paracetamol', 'Adults: 2 pills daily, Children: 1 pill daily', 'DFBJI', '12', '2024-09-20 17:41:35', NULL, ''),
(20, '4', 'Paracetamol', 'Adults: 2 pills daily, Children: 1 pill daily', NULL, NULL, '2024-12-09 08:00:00', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `samples`
--

DROP TABLE IF EXISTS `samples`;
CREATE TABLE IF NOT EXISTS `samples` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sample_name` varchar(255) NOT NULL,
  `sample_type` varchar(255) NOT NULL,
  `description` text,
  `collected_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `samples`
--

INSERT INTO `samples` (`id`, `sample_name`, `sample_type`, `description`, `collected_date`, `created_at`) VALUES
(1, 'Blood', 'Routine', 'kksrk', '2024-09-18', '2024-09-19 05:53:59'),
(2, 'Blood', 'Routine', 'kksrk', '2024-09-18', '2024-09-19 05:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
CREATE TABLE IF NOT EXISTS `test_results` (
  `test_id` int NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(255) NOT NULL,
  `test_type` varchar(255) NOT NULL,
  `test_date` date NOT NULL,
  `result` text NOT NULL,
  `patient_id` int NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `test_results`
--

INSERT INTO `test_results` (`test_id`, `patient_name`, `test_type`, `test_date`, `result`, `patient_id`) VALUES
(1, '', 'hello', '1998-12-01', 'kjkjl', 0),
(2, '', 'hello', '1998-12-01', 'kjkjl', 0),
(3, '', 'hello', '1998-12-01', 'kjkjl', 0),
(4, '', 'hello', '1998-12-01', 'kjkjl', 0),
(5, '', 'hello', '1998-12-01', 'kjkjl', 0),
(6, '', 'hello', '1222-12-12', 'kjkjk', 12),
(7, '', 'hello', '1222-12-12', 'kjkjk', 12),
(8, '', 'hello', '1222-12-12', 'kjkjk', 12),
(9, '', 'hello', '1222-12-12', 'kjkjk', 12),
(10, '', 'hello', '1222-12-12', 'kjkjk', 12),
(11, 'Kwadwo Boafour', 'hello', '1222-12-12', 'kjkjk', 12),
(12, 'Kwadwo Boafour', 'hello', '1958-12-12', 'dkckls', 12),
(13, 'Kwadwo Boafour', 'hello', '1958-12-12', 'dkckls', 12),
(14, 'Quamina Kolog', 'hello', '0000-00-00', 'yeah sir', 15);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('Credit','Debit') NOT NULL,
  `description` text,
  `drug_id` int NOT NULL,
  `drug_price` decimal(10,2) DEFAULT NULL,
  `patient_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_date`, `amount`, `type`, `description`, `drug_id`, `drug_price`, `patient_id`) VALUES
(1, '2024-09-20', 20.00, 'Debit', 'd', 0, NULL, 0),
(2, '2020-12-01', 12.00, 'Credit', 'cjdsj', 1, 12.00, 0),
(3, '2024-12-01', 12.00, 'Credit', 'hello', 1, 12.00, 11),
(4, '2024-12-01', 12.00, 'Credit', 'hello', 1, 12.00, 11),
(5, '1996-12-02', 12.00, 'Credit', 'jo', 5, 15.00, 12);

-- --------------------------------------------------------

--
-- Table structure for table `units_messages`
--

DROP TABLE IF EXISTS `units_messages`;
CREATE TABLE IF NOT EXISTS `units_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_id` int NOT NULL,
  `lab_staff_id` int NOT NULL,
  `pharmacist_id` int NOT NULL,
  `finance_staff_id` int NOT NULL,
  `unit` varchar(100) NOT NULL,
  `staff_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `units_messages`
--

INSERT INTO `units_messages` (`id`, `message`, `created_at`, `doctor_id`, `lab_staff_id`, `pharmacist_id`, `finance_staff_id`, `unit`, `staff_id`) VALUES
(1, 'Hello', '2024-09-17 17:56:06', 1, 0, 0, 0, 'Pharmacy', NULL),
(2, 'Hello', '2024-09-17 18:47:13', 1, 0, 0, 0, 'Pharmacy', NULL),
(3, 'Hello Sir', '2024-09-17 18:47:40', 1, 0, 0, 0, 'Laboratory', NULL),
(4, 'Alright', '2024-09-17 18:48:01', 1, 0, 0, 0, 'Finance', NULL),
(5, 'hi', '2024-09-17 19:07:38', 9, 0, 0, 0, 'Finance', NULL),
(6, 'loo', '2024-09-17 19:07:50', 9, 0, 0, 0, 'Finance', NULL),
(7, 'How are you doing', '2024-09-17 19:08:14', 1, 0, 0, 0, 'Finance', NULL),
(8, 'loo', '2024-09-17 19:08:39', 9, 0, 0, 0, 'Finance', NULL),
(9, 'Please i am good ooo Sir', '2024-09-17 19:09:02', 9, 0, 0, 0, 'Finance', NULL),
(10, 'Hu', '2024-09-17 19:21:30', 1, 0, 0, 0, 'Finance', NULL),
(11, '02452639812', '2024-09-17 19:21:50', 1, 0, 0, 0, 'Finance', NULL),
(12, '0242960642', '2024-09-17 19:23:17', 9, 0, 0, 0, 'Finance', NULL),
(13, '000000000', '2024-09-17 19:31:31', 1, 0, 0, 0, 'Finance', NULL),
(14, '000000000', '2024-09-17 19:35:55', 1, 0, 0, 0, 'Finance', NULL),
(15, '123hjjjjlhlk', '2024-09-17 19:36:56', 9, 0, 0, 0, 'Finance', NULL),
(16, 'Good morning Sir', '2024-09-17 19:47:37', 9, 0, 0, 0, 'pharmacist', NULL),
(17, 'Good morning Sir', '2024-09-17 19:48:46', 9, 0, 0, 0, 'pharmacist', NULL),
(18, 'Hello Sir', '2024-09-17 19:49:05', 9, 0, 0, 0, 'pharmacist', NULL),
(19, 'Yoo Chairman', '2024-09-17 19:52:57', 9, 0, 0, 0, 'pharmacist', NULL),
(20, 'Kwame', '2024-09-17 20:04:38', 1, 0, 0, 0, 'Pharmacy', NULL),
(21, 'Hi', '2024-09-17 20:13:45', 1, 0, 0, 0, 'Pharmacy', NULL),
(22, 'Yo Kwabena', '2024-09-17 20:27:33', 1, 0, 0, 0, 'Laboratory', NULL),
(23, 'Hello Pharmacy', '2024-09-18 01:08:06', 1, 0, 0, 0, 'Pharmacy', NULL),
(24, 'Yes Sir Dr. Nimo', '2024-09-18 01:08:49', 1, 0, 0, 0, 'Pharmacy', NULL),
(25, 'Yes Sir Dr. Nimo', '2024-09-18 01:09:07', 1, 0, 0, 0, 'Pharmacy', NULL),
(26, 'Biggie Brain', '2024-09-18 01:27:09', 11, 0, 0, 0, 'Pharmacy', NULL),
(27, 'Biggie Brain', '2024-09-18 01:41:21', 11, 0, 0, 0, 'Pharmacy', NULL),
(28, 'Yes Sir', '2024-09-18 01:47:33', 11, 0, 0, 0, 'Pharmacy', NULL),
(29, 'dfvndsjfvnvjsd', '2024-09-18 01:48:41', 11, 0, 0, 0, 'Finance', NULL),
(30, 'Hello Today is Friday', '2024-09-20 20:28:48', 11, 0, 0, 0, 'Pharmacy', NULL),
(31, 'Hi', '2024-09-21 06:35:33', 11, 0, 0, 0, 'Pharmacy', NULL),
(32, 'Hello', '2024-09-21 07:49:38', 0, 3, 0, 0, 'Pharmacy', NULL),
(33, 'Hello', '2024-09-21 07:58:28', 0, 3, 0, 0, 'Pharmacy', NULL),
(34, 'jjj', '2024-09-21 08:04:11', 0, 3, 0, 0, 'Laboratory', NULL),
(35, 'Yoo ma gee', '2024-09-21 08:28:21', 0, 0, 1, 0, 'Laboratory', NULL),
(36, 'Grat Dimafa', '2024-09-21 08:41:16', 0, 3, 0, 0, 'Finance', NULL),
(37, 'Grt Siber', '2024-09-21 09:06:28', 0, 0, 0, 1, 'Laboratory', NULL),
(38, 'kl', '2024-09-21 14:26:30', 0, 0, 0, 1, 'Doctor', NULL),
(39, 'adfk456', '2024-09-21 14:35:05', 11, 0, 0, 0, 'Finance', NULL),
(40, 'adfk456', '2024-09-21 14:39:54', 11, 0, 0, 0, 'Finance', NULL),
(41, 'XSDJJD41253635', '2024-09-21 14:51:49', 11, 0, 0, 0, 'Pharmacy', NULL),
(42, 'jgksdfk452', '2024-09-21 14:54:05', 0, 0, 1, 0, 'Doctor', NULL),
(43, 'YO COMMON WAGUAN', '2024-09-21 14:54:28', 0, 0, 1, 0, 'Doctor', NULL),
(44, 'hg', '2024-09-21 14:55:31', 11, 0, 0, 0, 'Pharmacy', NULL),
(45, 'hg', '2024-09-21 15:00:17', 11, 0, 0, 0, 'Pharmacy', NULL),
(46, 'COME HERE', '2024-09-21 15:00:35', 11, 0, 0, 0, 'Pharmacy', NULL),
(47, 'good', '2024-09-21 15:00:56', 0, 0, 1, 0, 'Doctor', NULL),
(48, 'COME HERE', '2024-09-21 15:01:20', 0, 0, 1, 0, 'Doctor', NULL),
(49, 'HO THIS IS DOCTOR ENOCK', '2024-09-21 15:27:28', 10, 0, 0, 0, 'Finance', NULL),
(50, 'ALRIGHT', '2024-09-21 15:28:39', 0, 0, 0, 1, 'Doctor', NULL),
(51, 'HO THIS IS DOCTOR ENOCK', '2024-09-21 15:28:54', 10, 0, 0, 0, 'Finance', NULL),
(52, 'ALRIGHT', '2024-09-21 15:29:53', 0, 0, 0, 1, 'Doctor', NULL),
(53, 'Hello', '2024-09-21 23:36:03', 12, 0, 0, 0, 'Laboratory', NULL),
(54, 'Hi Kwame Bediako', '2024-09-22 16:28:35', 0, 3, 0, 0, 'Doctor', NULL),
(55, 'Yeah', '2024-09-22 16:29:54', 11, 0, 0, 0, 'Laboratory', NULL),
(56, 'Yeah', '2024-09-22 16:30:30', 11, 0, 0, 0, 'Laboratory', NULL),
(57, 'Yeah', '2024-09-22 16:51:40', 11, 1, 0, 0, 'Laboratory', NULL),
(58, 'Hello I am here oo', '2024-09-22 16:52:40', 11, 0, 0, 0, 'lab', NULL),
(59, 'Hi Dok', '2024-09-22 16:57:38', 0, 3, 0, 0, 'Doctor', NULL),
(60, 'Yeah Fin', '2024-09-22 17:01:24', 11, 1, 0, 0, 'Laboratory', NULL),
(61, 'Yo', '2024-09-22 17:02:34', 0, 3, 0, 0, 'Doctor', NULL),
(62, 'YO', '2024-09-22 17:06:58', 11, 0, 0, 0, 'Laboratory', 1),
(63, 'YO', '2024-09-22 17:10:14', 11, 1, 0, 0, 'Laboratory', NULL),
(64, 'Yeah Biggie Lb', '2024-09-22 17:16:17', 11, 1, 0, 0, 'Laboratory', NULL),
(65, 'Yeah  Mr. Fin', '2024-09-22 17:24:01', 0, 3, 0, 0, 'Finance', NULL),
(66, 'Alright', '2024-09-22 17:24:26', 11, 1, 0, 0, 'Laboratory', NULL),
(67, 'Yeah  Mr. Fin', '2024-09-22 17:24:40', 0, 3, 0, 0, 'Finance', NULL),
(68, 'Yeah  Mr. Fin', '2024-09-22 17:27:22', 0, 3, 0, 0, 'Finance', NULL),
(69, 'Yeah i am not receiving your repies\r\n', '2024-09-22 17:27:55', 0, 3, 0, 0, 'Doctor', NULL),
(70, 'Oh sorry', '2024-09-22 17:28:45', 11, 1, 0, 0, 'Laboratory', NULL),
(71, 'Oh sorry', '2024-09-22 17:29:35', 11, 1, 0, 0, 'Laboratory', NULL),
(72, 'Yeah', '2024-09-22 17:30:07', 0, 3, 0, 0, 'Doctor', NULL),
(73, 'Yeah', '2024-09-22 17:30:32', 0, 3, 0, 0, 'Doctor', NULL),
(74, 'Nice one', '2024-09-22 17:34:52', 11, 0, 0, 0, 'Laboratory', 1),
(75, 'Nice one', '2024-09-22 17:38:55', 11, 0, 0, 0, 'Laboratory', 1),
(76, 'Yo Papa Labs', '2024-09-22 17:39:17', 11, 0, 0, 0, 'Laboratory', 1),
(77, 'Hey', '2024-09-22 17:45:21', 0, 3, 0, 0, 'Doctor', NULL),
(78, 'Yeah me gee', '2024-09-22 17:49:27', 11, 0, 0, 0, 'Laboratory', 1),
(79, 'Yes Sir', '2024-09-22 17:53:54', 0, 3, 0, 0, 'Doctor', NULL),
(80, 'HDCHJDSHJD', '2024-09-22 18:01:59', 0, 3, 0, 0, 'Doctor', NULL),
(81, 'jcvdjfbfsjb YEAH', '2024-09-22 18:10:31', 0, 3, 0, 0, 'Finance', NULL),
(82, 'Yeah i am here', '2024-09-22 18:19:00', 11, 0, 0, 0, 'Laboratory', 1),
(83, 'Yeah i am here', '2024-09-22 18:19:45', 11, 0, 0, 0, 'Laboratory', 1),
(84, 'kjnkj', '2024-09-22 18:25:01', 11, 0, 0, 0, 'Laboratory', 1),
(85, 'dfvadfm', '2024-09-22 18:25:23', 0, 3, 0, 0, 'Doctor', NULL),
(86, '000022125kjh', '2024-09-22 18:28:55', 11, 0, 0, 0, 'Laboratory', 1),
(87, 'Since when', '2024-09-22 18:35:21', 11, 0, 0, 0, 'Laboratory', 1),
(88, 'Since when', '2024-09-22 18:40:19', 11, 0, 0, 0, 'Laboratory', 1),
(89, 'Since when', '2024-09-22 18:45:22', 11, 0, 0, 0, 'Laboratory', 1),
(90, 'Today', '2024-09-22 18:45:33', 11, 0, 0, 0, 'Laboratory', 1),
(91, 'Okay', '2024-09-22 18:50:30', 0, 3, 0, 0, 'Doctor', NULL),
(92, 'Okay', '2024-09-22 18:52:32', 0, 3, 0, 0, 'Doctor', NULL),
(93, 'Okay', '2024-09-22 18:54:09', 0, 3, 0, 0, 'Doctor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

DROP TABLE IF EXISTS `user_registration`;
CREATE TABLE IF NOT EXISTS `user_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','patient') DEFAULT 'patient',
  `is_approved` tinyint(1) DEFAULT '0',
  `profile_picture` varchar(255) DEFAULT NULL,
  `bio` text,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `country_of_origin` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`id`, `name`, `email`, `password`, `role`, `is_approved`, `profile_picture`, `bio`, `phone`, `dob`, `country_of_origin`) VALUES
(1, 'Kwame Bones', 'kwamebones@gmail.com', '$2y$10$iSPrkUuFlwW3oNR7Up6asuffowYSsaDHBf89rAKstp7jz8OIiXipi', 'patient', 0, NULL, NULL, '', '0000-00-00', ''),
(2, 'Winny Bless Cobby', 'winnbless@gmail.com', '$2y$10$Uc4ygdyFjSqw3WJ6hvYqMOi/ltNxR1EQ7N4BWUWxDNV/fOp3CwRyC', 'admin', 0, NULL, NULL, '', '0000-00-00', ''),
(3, 'Tiroug Boadzie Ebenezer', 'ebenezertiroug@gmail.com', '$2y$10$xmboJ6keGBQJJc6LCJahyeJU4nzgEp60CpvxhhfOUbsVquwL.bx2m', 'admin', 0, 'default-profile.png', NULL, '0543529284', '1996-01-26', 'Ghana'),
(4, 'Kamaldeen Mohammed', 'kamaldeenmoh45@gmail.com', '$2y$10$5nIKpTLTFSFOAI2Vhe3gu.Frk8nFCxwLvbrmb6eflzcc7xSNJ7pmu', 'admin', 0, './uploads/66dd02396d12c.png', NULL, '0550719923', '1998-06-08', 'Ghana'),
(5, 'Apambila Hamza', 'apambilahamza@gmail.com', '$2y$10$S4jA.Mm7oirUZ9rYWyT9xeKvE1l56.NOIGWpRMkHngjR5dQoC.5FC', 'admin', 0, './uploads/66dd03ab02b51.png', NULL, '0244968752', '2024-09-04', 'Ghana'),
(6, 'Winny Bless', 'winnbless02@gmail.com', '$2y$10$Pwqp.6fTYid8/KYLGadcy.TuugzS/taJvzR7Y.w8C6iM9iu5nGTtO', 'admin', 0, './uploads/66dd052398720.png', NULL, '0506897158', '2024-09-19', 'Nigeria'),
(7, 'Paa George', 'paageorge12@gmail.com', '$2y$10$LfRTq7R514qqbq665RCDE.vpYbdTd5crguG6BgV2kKhwd9BggeQwm', 'admin', 0, 'default-profile.png', NULL, '0506897158', '2024-09-25', 'Ghana'),
(8, 'Kwame Ampim Yeboah Bonsu', 'kwameyeboah@gmail.com', '$2y$10$YOVQ46df2QL8QbpYof0hUOXldCeC2/OToFf7DFp0iSKQQj6EwLD1C', 'admin', 0, './uploads/66dd61d1db317.jpg', NULL, '0247562136', '1989-05-20', 'Ghana'),
(9, 'Kofi Sika', 'kofisika@gmail.com', '$2y$10$2grQ34pXhwHycKzso0gby.DyiNE9FDPhYAJ3qj7plNENayw/y7keu', 'admin', 0, './uploads/66de5cc5f37d4.jpg', NULL, '0248960642', '2024-09-10', 'Ghana'),
(10, 'Osei Kuffour', 'oseikuffour@gmail.com', '$2y$10$fT1OihujbtQnwk5Ii.yIR.SRl0SPeWjSHfUszbMfXwzkOFSZvZQNm', 'admin', 0, './uploads/66de5f10e41ab.jpg', NULL, '0254879603', '2024-09-09', 'Ghana'),
(11, 'Osei Bediako', 'oseibediako@gmail.com', '$2y$10$KvLKpvW8Ay7BS.9edb1KWuqJ1F2zNdswNU9oUWdaC29G1WxIfksO.', 'admin', 0, './uploads/66de60fb3dd9f.jpg', NULL, '0506897158', '2024-09-11', 'Ghana'),
(12, 'Preko Kwame', 'prekokwame@gmail.com', '$2y$10$UR3I6prdjkBKzeETvkRC6ecB1oEze2PJMM5eGbGiDzcsfIHXWwZBm', 'admin', 0, './uploads/66de6880ce2b3.jpg', NULL, '0245968745', '1984-06-09', 'Ghana'),
(13, 'Alfred Ahaya Akuliba', 'alfredahaya01@gmail.com', '$2y$10$75N7pRnbWZgL1T4MQ.9tuu8XuO/ZL0WGU0pKvmg6OM2XQfEVb6pV.', 'admin', 0, './uploads/66deaf08c4b76.jpg', NULL, '0240506368', '1993-09-09', 'Ghana'),
(14, 'Kwabena Fosu', 'kwabenafosu@gmail.com', '123456789', 'admin', 0, './uploads/66e6c4ab416e8.jpg', NULL, '0555069871', '1997-02-12', 'Ghana'),
(15, 'Paa Jones', 'paajones@gmail.com', '123456', 'admin', 0, './uploads/66e6d5da6a724.jpg', NULL, '0248745922', '1995-12-19', 'Ghana'),
(16, 'Emmamnuel Odogwu', 'emmanuel@gmail.com', '12345', 'admin', 0, './uploads/66efaf1ea8583.png', NULL, '0245369802', '1998-12-02', 'Ghana'),
(17, 'Kwame Danso', 'kwamedanso02@gmail.com', '$2y$10$sIeJJPqX7ds0R5NMwwPW1edlA5gEfn8.VFNiKLU3wmFCt7lpIIEza', 'admin', 0, 'uploads/default-profile.png', NULL, '0241230298', '1997-12-02', 'Ghana'),
(18, 'Kwame Sika', 'kwamesika@gmail.com', '0123', 'admin', 0, 'uploads/default-profile.png', NULL, '0304201287', '1995-12-02', 'Ghana'),
(19, 'Ofori Amponsah', 'oforiamponsah@gmail.com', '0123456', 'admin', 0, './uploads/66efc2c1a3eba.png', NULL, '0245321202', '1992-12-02', 'Sudan'),
(20, 'Abraham', 'abraham@gmail.com', '000000', 'admin', 0, NULL, NULL, '0247520136', '1993-02-01', 'Ghana'),
(21, 'Asamoah Gyan', 'asamoahgyan2@gmail.com', '123', 'admin', 0, 'uploads/default-profile.png', '', '0248740231', '4587-01-23', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
