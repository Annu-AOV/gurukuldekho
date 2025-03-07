-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2025 at 01:01 PM
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
-- Database: `gurukuldekho`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_userchild`
--

CREATE TABLE `add_userchild` (
  `id` int(11) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `child_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `applying_for` varchar(255) NOT NULL,
  `class_applying_for` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_userchild`
--

INSERT INTO `add_userchild` (`id`, `user_id`, `child_name`, `date_of_birth`, `gender`, `applying_for`, `class_applying_for`, `created_at`) VALUES
(2, '9234693132', 'piya', '2003-01-28', 'Female', 'delhi', '5', '2025-02-26 06:49:51'),
(3, '7217676540', 'ramesh', '2003-01-28', 'Male', 'any other city', '6', '2025-02-26 07:23:26'),
(4, '7217676540', 'priya', '2003-01-15', 'Female', 'delhi', '6', '2025-02-26 07:47:25'),
(5, '9205018713', 'susil', '2025-02-07', 'Male', 'delhi', '3', '2025-02-26 07:50:01'),
(6, '7217676540', 'siya', '2010-07-24', 'Female', 'Any Other City', '3', '2025-02-26 08:38:31'),
(7, '7217676540', 'ruhi', '2025-02-18', 'Female', 'Delhi', 'Toddler', '2025-02-26 08:50:37'),
(8, '7217676540', 'nitish', '2011-07-30', 'Male', 'Any Other City', 'Class 4', '2025-02-26 09:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'apnaonlinevyapar@gmail.com', '$2y$10$trUGgV4hBBCLOTWAZijZrONjW9GQDq7vw/voE.rI2a0kXVX5QDm1e');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  `session` varchar(50) NOT NULL,
  `last_application_date` date NOT NULL,
  `application_fee` decimal(10,2) NOT NULL,
  `admission_process` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `school_id`, `class`, `session`, `last_application_date`, `application_fee`, `admission_process`, `start_date`, `end_date`) VALUES
(1, 57, '1', '2025-2026', '2025-03-19', 500.00, '1. Admission Notification\r\nSchool ki website aur notice board par admission ka announcement kiya jata hai.\r\nApplication start date aur end date mention hoti hai.\r\n2. Eligibility Criteria\r\nMinimum age requirement (Example: Class 1 ke liye 5+ years).\r\nPrevious class ka passing certificate required.\r\nSpecial entrance test (agar applicable ho toh).\r\n3. Admission Form Submission\r\nAdmission form school website ya office se milega.\r\nForm ke saath yeh documents attach karne honge:\r\nBirth Certificate\r\nPrevious School Marksheet\r\nTransfer Certificate (TC)\r\nPassport Size Photos\r\nAadhaar Card (if applicable)\r\n4. Entrance Exam (if required)\r\nKuch schools entrance test rakhte hain.\r\nTest me English, Mathematics aur General Knowledge ke questions hote hain.\r\n5. Interview & Interaction (if required)\r\nParent aur student ka school administration ke saath interaction hota hai.\r\nClass 1 ke liye sirf student interaction hota hai.\r\n6. Admission Fee Payment\r\nSelection hone ke baad admission fee pay karni hoti hai.\r\nFee cash, online ya demand draft (DD) ke through submit hoti hai.\r\nFee refund policy bhi school ke rules ke according hoti hai.\r\n7. Final Admission Confirmation\r\nFee payment hone ke baad admission confirm ho jata hai.\r\nStudent ko ID card aur syllabus provide kiya jata hai.\r\nClass start date aur timetable share kiya jata hai.\r\n', '2025-02-06', '2025-03-01'),
(2, 1, '1', '2025-2026', '2025-03-31', 500.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai.\r\n\r\n 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh).\r\n\r\n 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) \r\n\r\n4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain.\r\n\r\n 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai.\r\n\r\n 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai.\r\n\r\n 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '2025-02-01', '2025-03-01'),
(3, 1, '2', '2025-2026', '2025-01-31', 500.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '2025-03-01', '2025-04-01'),
(4, 1, '3', '2025-2026', '2025-03-31', 500.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '0000-00-00', '0000-00-00'),
(5, 1, '4', '2025-2026', '2025-03-31', 1000.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '0000-00-00', '0000-00-00'),
(6, 1, '5', '2025-2026', '2025-01-31', 1050.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '0000-00-00', '0000-00-00'),
(7, 1, '6', '2025-2026', '2025-03-31', 1100.00, '', '0000-00-00', '0000-00-00'),
(9, 1, '7', '2025-2026', '2025-03-31', 1200.00, '', '0000-00-00', '0000-00-00'),
(10, 1, '8', '2025-2026', '2025-03-31', 1250.00, '', '0000-00-00', '0000-00-00'),
(11, 1, '9', '2025-2026', '2025-03-29', 1500.00, '', '0000-00-00', '0000-00-00'),
(12, 52, '1', '2025-2026', '2025-01-31', 500.00, '', '0000-00-00', '0000-00-00'),
(13, 6, '1', '2025-2026', '2025-01-31', 500.00, '', '0000-00-00', '0000-00-00'),
(14, 8, '1', '2025-2026', '2025-01-31', 500.00, '', '0000-00-00', '0000-00-00'),
(18, 26, '1', '2025-2026', '2025-01-31', 500.00, '', '0000-00-00', '0000-00-00'),
(19, 64, '1', '2025-2026', '2025-02-13', 300.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '2025-02-01', '2025-03-01'),
(20, 61, '1', '2025-2026', '2025-03-31', 500.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '2025-02-01', '2025-02-28'),
(21, 53, '10', '2025-2026', '2025-04-30', 600.00, '1. Admission Notification School ki website aur notice board par admission ka announcement kiya jata hai. Application start date aur end date mention hoti hai. 2. Eligibility Criteria Minimum age requirement (Example: Class 1 ke liye 5+ years). Previous class ka passing certificate required. Special entrance test (agar applicable ho toh). 3. Admission Form Submission Admission form school website ya office se milega. Form ke saath yeh documents attach karne honge: Birth Certificate Previous School Marksheet Transfer Certificate (TC) Passport Size Photos Aadhaar Card (if applicable) 4. Entrance Exam (if required) Kuch schools entrance test rakhte hain. Test me English, Mathematics aur General Knowledge ke questions hote hain. 5. Interview & Interaction (if required) Parent aur student ka school administration ke saath interaction hota hai. Class 1 ke liye sirf student interaction hota hai. 6. Admission Fee Payment Selection hone ke baad admission fee pay karni hoti hai. Fee cash, online ya demand draft (DD) ke through submit hoti hai. Fee refund policy bhi school ke rules ke according hoti hai. 7. Final Admission Confirmation Fee payment hone ke baad admission confirm ho jata hai. Student ko ID card aur syllabus provide kiya jata hai. Class start date aur timetable share kiya jata hai.', '2025-02-01', '2025-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `city_name`, `pincode`, `state`, `created_at`) VALUES
(1, 'Noida', '784512', 'Delhi', '2025-01-24 06:28:38'),
(2, 'Mumbai', '123456', 'Mumbai', '2025-01-24 07:03:47'),
(3, 'pune', '784512', 'Gujrat', '2025-01-24 11:04:19'),
(4, 'Gopalganj', '459863', 'Bihar', '2025-01-24 11:05:15'),
(5, 'Vanaras', '159647', 'Lucknow', '2025-02-08 05:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `registration_fee` int(11) DEFAULT NULL,
  `admission_fee` int(11) DEFAULT NULL,
  `annual_fee` int(11) DEFAULT NULL,
  `tuition_fee` int(11) DEFAULT NULL,
  `exam_fee` int(11) DEFAULT NULL,
  `lab_fee` int(11) DEFAULT NULL,
  `activity_fee` int(11) DEFAULT NULL,
  `library_fee` int(11) DEFAULT NULL,
  `study_material_fee` int(11) DEFAULT NULL,
  `transport_fee` int(11) DEFAULT NULL,
  `technology_fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `registration_fee`, `admission_fee`, `annual_fee`, `tuition_fee`, `exam_fee`, `lab_fee`, `activity_fee`, `library_fee`, `study_material_fee`, `transport_fee`, `technology_fee`) VALUES
(8, 'class1', 89, 56, 23, 95, 45, 85, 75, 26, 95, 85, 45),
(9, 'class2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'class3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'class4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'class5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'class6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'class7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'class8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'class9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'class 10', 58, 41, 44, 96, 46, 77, 22, 32, 33, 99, 88);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `registration_fee` int(11) DEFAULT NULL,
  `admission_fee` int(11) DEFAULT NULL,
  `annual_fee` int(11) DEFAULT NULL,
  `tuition_fee` int(11) DEFAULT NULL,
  `exam_fee` int(11) DEFAULT NULL,
  `library_fee` int(11) DEFAULT NULL,
  `laboratory_fee` int(11) DEFAULT NULL,
  `hostel_fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `description`, `duration`, `created_at`, `registration_fee`, `admission_fee`, `annual_fee`, `tuition_fee`, `exam_fee`, `library_fee`, `laboratory_fee`, `hostel_fee`) VALUES
(1, 'Finance management', 'wsdfvbnmoihgfdszxcvgbhjiuhyg', 6, '2025-01-17 09:32:36', 265, 852, 963, 741, 123, 958, 752, 753),
(2, 'Accountant', 'rsxfcghuiolkjhtresdfghuiyt', 9, '2025-01-17 09:33:48', 987, 963, 951, 987, 954, 921, 365, 951),
(3, 'medical', 'sjdnjbfdjrgdfnjkdsmx', 5, '2025-01-14 10:48:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'commerce', 'tigjhgdgxcfhgjolgv', 4, '2025-01-15 05:03:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Law', 'dfgcbvgdrfrdfsfghtrewdgftrghmjythjmkuytrghtfrdghjy', 10, '2025-01-16 05:32:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Data Management', 'cftvgbhnjufhjuhdfbvchufdxjvnijfnc fjkdcbn ', 9, '2025-01-16 05:33:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Enginering', 'jgngcbkmvwgrnbgmlkoafsdv', 15, '2025-01-16 05:33:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Data Analyatic', 'tgrhdfghjndkfjsdxc', 6, '2025-01-16 05:34:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'BCA', 'sdfgv', 12, '2025-01-16 05:35:08', 45, 11, 4141, 223, 545, 531, 54, 554),
(10, 'Bsc', 'yghjkikh', 7, '2025-01-16 05:35:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Bachelor Of Dental Surgery(Bds)', 'vbnnmn miuyhg', 18, '2025-01-16 05:36:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Bachelor Of Final Arts(Bfa)', 'rthjhgfdfgh', 20, '2025-01-16 05:36:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Mbbs', 'dftgyhubjkdtfgyhu', 36, '2025-01-16 05:37:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Automobile Engineering', 'dxcfgvbhnj', 12, '2025-01-16 05:37:44', 963, 951, 852, 456, 741, 123, 753, 789),
(15, 'Nursing', 'srdftghj', 10, '2025-01-16 05:38:07', 753, 951, 456, 123, 951, 753, 456, 789),
(16, 'Mass Communication', 'ghbjnkyuhijk', 14, '2025-01-16 05:38:33', 536, 456, 123, 741, 852, 963, 789, 753),
(17, 'Data Management', 'fghn', 5, '2025-01-25 12:53:17', 45, 44, 44, 22, 11, 33, 785, 96);

-- --------------------------------------------------------

--
-- Table structure for table `fee_structure`
--

CREATE TABLE `fee_structure` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `session` varchar(50) NOT NULL,
  `batch` varchar(50) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `security_fee` decimal(10,2) NOT NULL,
  `registration_fee` decimal(10,2) NOT NULL,
  `admission_fee` decimal(10,2) NOT NULL,
  `annual_fee` decimal(10,2) NOT NULL,
  `tuition_fee` decimal(10,2) NOT NULL,
  `examination_fee` decimal(10,2) NOT NULL,
  `library_fee` decimal(10,2) NOT NULL,
  `sports_fee` decimal(10,2) NOT NULL,
  `hostel_fee` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `frequency` varchar(50) NOT NULL DEFAULT 'Monthly',
  `refundable` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_structure`
--

INSERT INTO `fee_structure` (`id`, `school_id`, `class`, `session`, `batch`, `course`, `security_fee`, `registration_fee`, `admission_fee`, `annual_fee`, `tuition_fee`, `examination_fee`, `library_fee`, `sports_fee`, `hostel_fee`, `created_at`, `frequency`, `refundable`) VALUES
(1, 1, '1', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-01-31 10:33:24', 'Monthly', 'No'),
(2, 6, '1', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-01-31 12:28:22', 'Monthly', 'No'),
(3, 1, '2', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-01-31 12:28:35', 'Monthly', 'No'),
(4, 6, '2', '2025-2026', '', '', 500.00, 500.00, 800.00, 400.00, 600.00, 800.00, 500.00, 600.00, 500.00, '2025-01-31 12:28:51', 'Onetime', 'No'),
(5, 6, '3', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 07:40:19', 'Monthly', 'No'),
(6, 6, '4', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 07:40:33', 'Monthly', 'No'),
(7, 1, '3', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 09:41:03', 'Monthly', 'No'),
(8, 1, '4', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 09:41:16', 'Monthly', 'No'),
(9, 1, '5', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 09:41:28', 'Monthly', 'No'),
(10, 1, '6', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 09:43:34', 'Monthly', 'No'),
(11, 1, '7', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-01 09:43:48', 'Monthly', 'No'),
(12, 6, '5', '2025-2026', NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-02-03 09:33:38', 'Monthly', 'No'),
(14, 62, '1', '2025-2026', '', '', 200.00, 500.00, 400.00, 2000.00, 5000.00, 4000.00, 6000.00, 800.00, 5000.00, '2025-02-25 07:52:05', 'Monthly', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `review_date` date DEFAULT curdate(),
  `overall_rating` float NOT NULL CHECK (`overall_rating` between 1 and 5),
  `review_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `school_id`, `reviewer_name`, `review_date`, `overall_rating`, `review_text`) VALUES
(13, 64, 'riya', '2025-02-11', 4, 'EARSTGDHJFKGH.LKGFDYTSEGRHDJF'),
(35, 8, 'annu', '2025-02-11', 4, 'dsdftghszhjxhfjkgdhj'),
(36, 8, 'neha', '2025-02-11', 5, 'fegrwtheyjrhndgbfs'),
(38, 1, 'annu', '2025-02-11', 4, 'wartsyduil;rteyufdseydtufigiyw63tythretrtghmjrtr'),
(40, 1, 'suhani', '2025-02-11', 5, 'edrtfgyuhinjmkjnihbugvfycdxsedrftguyhi'),
(41, 67, 'Saurabh', '2025-02-11', 5, 'sghdfmgfsgfghdm,kuwy4eshfjmrderyhfjgm,rkjeysdxhfjk,kdrxdhfjkdjsyedzgxhfjmjsyzdxhjkfdxhjhd'),
(42, 67, 'annu', '2025-02-11', 5, 'xsdfghyujikl,mnbvcxzdfgh'),
(43, 67, 'Bhawna', '2025-02-11', 4, 'agdhsjkcvgsudkasvhcszkjdgvclsdhbfl.sehs.k,vhgbfgvmjhsb,x'),
(44, 67, 'gita', '2025-02-11', 5, 'wdafgbhnhwsegdfhgnhredtnetdgfhrtgfb'),
(45, 67, ' miya', '2025-02-11', 5, 'gzxfcgv,hgvcdfzggxshdfnvbcvxfgdhythg'),
(46, 67, 'rema', '2025-02-11', 4, 'zgxhcv xmtngnkmjnfchmgkdch'),
(47, 67, 'sahil', '2025-02-11', 5, 'vmxgjxfchvjcfvcfnvmbvgbcvnbmgxcvbhgjgcbvnhjvbghnm,'),
(48, 29, 'Rohit', '2025-02-11', 4, 'fdsfdsfdsgds'),
(49, 6, 'ruhi', '2025-02-12', 5, 'wasgbfdghmrfdcvmhfgcxcfszashdnfgxcbfxdngc'),
(50, 6, 'riya', '2025-02-12', 4, 'agrsfbzdsFRgtHAQWTNGBEDVFWERTYU4J5URHYETRWdwf'),
(51, 1, 'shikha', '2025-02-12', 5, 'zsxhdtjshazgdxsfgarfsgdfrtsgxdhfkjeysrhdfg'),
(52, 6, 'seema', '2025-02-12', 5, 'fsghdfmgjmfzfddghjt,teghfmg'),
(53, 6, 'annu', '2025-02-12', 5, 'adfgshnjm,khmghfndbssgdshdfgt'),
(54, 6, 'rema', '2025-02-12', 5, 'ilukujehwagzdfxgchvgO:?Il.uky,tmrenwagzdcbxm,n.jrshhbnjgkhlil.j,hṁvcvfsgrhejytku,hnmb vcgdhtryukilbn vcxdsertyukjnmb vcfgrtyukjhnmbvcfdrtyujknmbvfgtyuikjn'),
(55, 6, 'prachi', '2025-02-17', 5, 'xgfhjhhgfrasrhterngrfastdffmjhdgzfdhxfg'),
(56, 6, 'prachi', '2025-02-17', 5, 'xgfhjhhgfrasrhterngrfastdffmjhdgzfdhxfg'),
(57, 48, 'siya', '2025-02-18', 5, 'fgshdjfkgutjystearwtsydjkgtuy54rWATSHDJKTUY54NVBGSGDXFCVMJHJVHUSYDHFCVDHFJGHTUJGVHB,GJUHYVB,GYRSGXCVBHHXGHCGJVHJDGXFZGXHCMNHGF'),
(58, 1, 'Tanu', '2025-02-19', 5, 'astkkjsgthxjm,jsyarzsgdxhfmfjuyredhjm,mjeszfgxhndmmszz'),
(59, 1, 'anupama', '2025-02-20', 5, 'bdngfmnhgfdfgjhxjdfg'),
(60, 15, 'manshi', '2025-02-21', 5, 'tcjgvfmfvgthdryhsdxhfnvnbfhcvtvhyugbnryfsdgxcjykhmgb'),
(61, 15, 'manu', '2025-02-21', 4, 'yrtffghfgjnfvghsdfvdhbbfgjnfdbhfdxsgbvsedgbvsxdfcndfchbfgjmnfg'),
(62, 15, 'sila', '2025-02-21', 5, 'cgjhjnzsdxfghbjn,m.zsxdfghnmAZSdxfghxdcfvb'),
(63, 15, 'mukul', '2025-02-21', 5, 'sxdfghjkl,.mnbgfdsueirtli.gcbxderiolt,kmgnyu7ickmgdfghjkiuytrtyuioiuyttyuioiuyttyuiklb'),
(64, 15, 'susil', '2025-02-21', 5, 'asdhfjghgtredRFAGhdehgtrqwatgshdjfytsgxhcjfkuryedutjfkygu,jshyxgdfh'),
(65, 19, 'sunil', '2025-02-25', 5, 'dfgdhgbvbjmnmnvhygfjudfertgujkijygfthdefrhgwsedftrwsdfgbbjhygvb');

-- --------------------------------------------------------

--
-- Table structure for table `review_categories`
--

CREATE TABLE `review_categories` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_rating` float NOT NULL CHECK (`category_rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_categories`
--

INSERT INTO `review_categories` (`id`, `review_id`, `school_id`, `category_name`, `category_rating`) VALUES
(31, 13, 1, 'Infrastructure', 3),
(32, 13, 1, 'Admission Process', 4),
(33, 13, 1, 'Value for Money', 4),
(34, 13, 1, 'Sports', 4),
(35, 13, 1, 'Extra Curricular', 3),
(61, 35, 8, 'Infrastructure', 3),
(62, 35, 8, 'Admission Process', 3),
(63, 35, 8, 'Value for Money', 4),
(64, 35, 8, 'Sports', 3),
(65, 35, 8, 'Extra Curricular', 4),
(66, 36, 8, 'Infrastructure', 4),
(67, 36, 8, 'Admission Process', 3),
(68, 36, 8, 'Value for Money', 4),
(69, 36, 8, 'Sports', 3),
(70, 36, 8, 'Extra Curricular', 3),
(76, 38, 1, 'Infrastructure', 4),
(77, 38, 1, 'Admission Process', 4),
(78, 38, 1, 'Value for Money', 3),
(79, 38, 1, 'Sports', 4),
(80, 38, 1, 'Extra Curricular', 3),
(86, 40, 1, 'Infrastructure', 4),
(87, 40, 1, 'Admission Process', 3),
(88, 40, 1, 'Value for Money', 4),
(89, 40, 1, 'Sports', 3),
(90, 40, 1, 'Extra Curricular', 4),
(91, 41, 67, 'Infrastructure', 4),
(92, 41, 67, 'Admission Process', 4),
(93, 41, 67, 'Value for Money', 3),
(94, 41, 67, 'Sports', 4),
(95, 41, 67, 'Extra Curricular', 3),
(96, 42, 67, 'Infrastructure', 4),
(97, 42, 67, 'Admission Process', 3),
(98, 42, 67, 'Value for Money', 4),
(99, 42, 67, 'Sports', 3),
(100, 42, 67, 'Extra Curricular', 4),
(101, 43, 67, 'Infrastructure', 3),
(102, 43, 67, 'Admission Process', 4),
(103, 43, 67, 'Value for Money', 4),
(104, 43, 67, 'Sports', 3),
(105, 43, 67, 'Extra Curricular', 4),
(106, 44, 67, 'Infrastructure', 4),
(107, 44, 67, 'Admission Process', 4),
(108, 44, 67, 'Value for Money', 4),
(109, 44, 67, 'Sports', 3),
(110, 44, 67, 'Extra Curricular', 3),
(111, 45, 67, 'Infrastructure', 4),
(112, 45, 67, 'Admission Process', 4),
(113, 45, 67, 'Value for Money', 5),
(114, 45, 67, 'Sports', 4),
(115, 45, 67, 'Extra Curricular', 5),
(116, 46, 67, 'Infrastructure', 5),
(117, 46, 67, 'Admission Process', 3),
(118, 46, 67, 'Value for Money', 4),
(119, 46, 67, 'Sports', 4),
(120, 46, 67, 'Extra Curricular', 3),
(121, 47, 67, 'Infrastructure', 4),
(122, 47, 67, 'Admission Process', 4),
(123, 47, 67, 'Value for Money', 5),
(124, 47, 67, 'Sports', 4),
(125, 47, 67, 'Extra Curricular', 4),
(126, 48, 29, 'Infrastructure', 2),
(127, 48, 29, 'Admission Process', 5),
(128, 48, 29, 'Value for Money', 3),
(129, 48, 29, 'Sports', 5),
(130, 48, 29, 'Extra Curricular', 5),
(131, 49, 6, 'Infrastructure', 4),
(132, 49, 6, 'Admission Process', 5),
(133, 49, 6, 'Value for Money', 4),
(134, 49, 6, 'Sports', 5),
(135, 49, 6, 'Extra Curricular', 4),
(136, 50, 6, 'Infrastructure', 3),
(137, 50, 6, 'Admission Process', 3),
(138, 50, 6, 'Value for Money', 3),
(139, 50, 6, 'Sports', 4),
(140, 50, 6, 'Extra Curricular', 3),
(141, 51, 1, 'Infrastructure', 4),
(142, 51, 1, 'Admission Process', 5),
(143, 51, 1, 'Value for Money', 4),
(144, 51, 1, 'Sports', 4),
(145, 51, 1, 'Extra Curricular', 5),
(146, 52, 6, 'Infrastructure', 4),
(147, 52, 6, 'Admission Process', 5),
(148, 52, 6, 'Value for Money', 4),
(149, 52, 6, 'Sports', 4),
(150, 52, 6, 'Extra Curricular', 4),
(151, 53, 6, 'Infrastructure', 5),
(152, 53, 6, 'Admission Process', 4),
(153, 53, 6, 'Value for Money', 4),
(154, 53, 6, 'Sports', 5),
(155, 53, 6, 'Extra Curricular', 4),
(156, 54, 6, 'Infrastructure', 4),
(157, 54, 6, 'Admission Process', 5),
(158, 54, 6, 'Value for Money', 4),
(159, 54, 6, 'Sports', 5),
(160, 54, 6, 'Extra Curricular', 4),
(161, 55, 6, 'Infrastructure', 4),
(162, 55, 6, 'Admission Process', 5),
(163, 55, 6, 'Value for Money', 4),
(164, 55, 6, 'Sports', 5),
(165, 55, 6, 'Extra Curricular', 5),
(166, 56, 6, 'Infrastructure', 4),
(167, 56, 6, 'Admission Process', 5),
(168, 56, 6, 'Value for Money', 4),
(169, 56, 6, 'Sports', 5),
(170, 56, 6, 'Extra Curricular', 5),
(171, 57, 48, 'Infrastructure', 4),
(172, 57, 48, 'Admission Process', 4),
(173, 57, 48, 'Value for Money', 4),
(174, 57, 48, 'Sports', 5),
(175, 57, 48, 'Extra Curricular', 5),
(176, 58, 1, 'Infrastructure', 5),
(177, 58, 1, 'Admission Process', 4),
(178, 58, 1, 'Value for Money', 5),
(179, 58, 1, 'Sports', 4),
(180, 58, 1, 'Extra Curricular', 5),
(181, 59, 1, 'Infrastructure', 4),
(182, 59, 1, 'Admission Process', 5),
(183, 59, 1, 'Value for Money', 4),
(184, 59, 1, 'Sports', 5),
(185, 59, 1, 'Extra Curricular', 4),
(186, 60, 15, 'Infrastructure', 4),
(187, 60, 15, 'Admission Process', 5),
(188, 60, 15, 'Value for Money', 4),
(189, 60, 15, 'Sports', 5),
(190, 60, 15, 'Extra Curricular', 5),
(191, 61, 15, 'Infrastructure', 4),
(192, 61, 15, 'Admission Process', 4),
(193, 61, 15, 'Value for Money', 3),
(194, 61, 15, 'Sports', 4),
(195, 61, 15, 'Extra Curricular', 4),
(196, 62, 15, 'Infrastructure', 4),
(197, 62, 15, 'Admission Process', 5),
(198, 62, 15, 'Value for Money', 4),
(199, 62, 15, 'Sports', 5),
(200, 62, 15, 'Extra Curricular', 5),
(201, 63, 15, 'Infrastructure', 4),
(202, 63, 15, 'Admission Process', 5),
(203, 63, 15, 'Value for Money', 5),
(204, 63, 15, 'Sports', 4),
(205, 63, 15, 'Extra Curricular', 5),
(206, 64, 15, 'Infrastructure', 5),
(207, 64, 15, 'Admission Process', 4),
(208, 64, 15, 'Value for Money', 5),
(209, 64, 15, 'Sports', 5),
(210, 64, 15, 'Extra Curricular', 4),
(211, 65, 19, 'Infrastructure', 4),
(212, 65, 19, 'Admission Process', 5),
(213, 65, 19, 'Value for Money', 4),
(214, 65, 19, 'Sports', 5),
(215, 65, 19, 'Extra Curricular', 4);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `admission_status` enum('Open','Close') NOT NULL,
  `address` varchar(255) NOT NULL,
  `affiliate` varchar(255) DEFAULT NULL,
  `estd` int(11) DEFAULT NULL,
  `school_mail` varchar(255) NOT NULL,
  `primary_mob` varchar(15) NOT NULL,
  `secondary_mob` varchar(15) DEFAULT NULL,
  `description` text NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `class` text DEFAULT NULL,
  `class_minimum` varchar(50) NOT NULL,
  `class_maximum` varchar(50) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `map_embed_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `admission_status`, `address`, `affiliate`, `estd`, `school_mail`, `primary_mob`, `secondary_mob`, `description`, `photo`, `created_at`, `class`, `class_minimum`, `class_maximum`, `city_id`, `views`, `latitude`, `longitude`, `map_embed_code`) VALUES
(1, 'Mahavir senior model school', 'Open', 'Ashok Vihar, North West Delhi', 'cbse', 2005, 'dxdf@gmail.com', '1452369874', '7523694125', 'Introduction: Mahavir senior model school, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\r\n\r\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\r\n\r\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\r\n\r\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\r\n\r\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\r\n\r\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\r\n\r\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\r\n\r\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\r\n\r\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\r\n\r\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\r\n\r\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\r\n\r\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\r\n\r\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\r\n\r\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\r\n\r\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\r\n\r\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\r\n\r\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\r\n\r\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\r\n\r\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\r\n\r\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\r\n\r\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\r\n\r\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\r\n\r\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\r\n\r\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/school.jpg', '2025-01-28 06:44:59', '', 'Nursery', '12', 1, 43, 28.6, 77.085, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.983810966387!2d77.18910757550292!3d28.690130875633283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d020ad592ae07%3A0x6288b49db0fc1b93!2sMahavir%20Senior%20Model%20School!5e0!3m2!1sen!2sin!4v1740042927833!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>'),
(6, 'test school', 'Open', 'f67, delhi india', 'cbse', 2018, 'testschool@gmail.com', '1223698744', '9067556843', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/school.jpg', '2025-01-11 11:17:58', '8,9,10,11,12,19,20,21', 'Nursery', '10', 2, 25, 0, 0, NULL),
(8, 'trhgfhgf', 'Open', 'Ashok Vihar, North West Delhi', 'ghnghgh', 2017, 'hfhgfghf@gmail.com', '8977453465', '9067556843', 'Introduction: trhgfhgf, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\r\n\r\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\r\n\r\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\r\n\r\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\r\n\r\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\r\n\r\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\r\n\r\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\r\n\r\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\r\n\r\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\r\n\r\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\r\n\r\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\r\n\r\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\r\n\r\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\r\n\r\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\r\n\r\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\r\n\r\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\r\n\r\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\r\n\r\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\r\n\r\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\r\n\r\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\r\n\r\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\r\n\r\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\r\n\r\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\r\n\r\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.\r\n\r\n', '../admin/uploads/school_photos/school.jpg', '2025-01-11 11:20:56', NULL, '1', '12', 4, 14, 28.737536, 77.1948544, NULL),
(9, 'trhgfhgf', 'Open', 'hjghjghjnbvnbf gfgfghf', 'ghnghgh', 2017, 'hfhgfghf@gmail.com', '8977453465', '9067556843', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/school.jpg', '2025-01-11 11:21:04', NULL, 'Nursery', '5', 3, 5, 0, 0, NULL),
(11, 'trhgfhgf', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 2004, 'hfhgfghf@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s1.jpeg', '2025-01-11 11:27:24', NULL, 'Nursery', '10', 3, 6, 0, 0, NULL),
(12, 'trhgfhgf', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 2004, 'hfhgfghf@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s2.jpg', '2025-01-11 11:29:23', NULL, '5', '10', 3, 5, 0, 0, NULL),
(13, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2009, 'testschool@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\r\n\r\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\r\n\r\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\r\n\r\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\r\n\r\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\r\n\r\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\r\n\r\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\r\n\r\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\r\n\r\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\r\n\r\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\r\n\r\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\r\n\r\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\r\n\r\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\r\n\r\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\r\n\r\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\r\n\r\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\r\n\r\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\r\n\r\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\r\n\r\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\r\n\r\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\r\n\r\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\r\n\r\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\r\n\r\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\r\n\r\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s2.jpg', '2025-01-11 11:51:17', NULL, '1', '10', 4, 8, 0, 0, NULL);
INSERT INTO `schools` (`id`, `name`, `admission_status`, `address`, `affiliate`, `estd`, `school_mail`, `primary_mob`, `secondary_mob`, `description`, `photo`, `created_at`, `class`, `class_minimum`, `class_maximum`, `city_id`, `views`, `latitude`, `longitude`, `map_embed_code`) VALUES
(14, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2009, 'testschool@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s4.jpg', '2025-01-11 11:51:45', NULL, 'KG', '8', 4, 2, 0, 0, NULL),
(15, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2009, 'testschool@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s1.jpeg', '2025-01-11 11:51:50', NULL, 'LKG', '8', 3, 7, 0, 0, NULL),
(17, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2009, 'testschool@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s2.jpg', '2025-01-11 11:51:51', NULL, '5', '12', 3, 2, 0, 0, NULL),
(18, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2009, 'testschool@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s1.jpeg', '2025-01-11 11:51:52', NULL, '11', '12', 4, 4, 0, 0, NULL),
(19, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2009, 'testschool@gmail.com', '8977453465', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s4.jpg', '2025-01-11 11:51:58', NULL, '6', '12', 2, 3, 0, 0, NULL),
(20, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2005, 'testschool@gmail.com', '1223698744', '7878675655', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s5.jpg', '2025-01-11 11:55:57', NULL, '1', '12', 2, 1, 0, 0, NULL),
(21, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2005, 'testschool@gmail.com', '1223698744', '7878675655', 'ghfdcvbn', '../admin/uploads/school_photos/s5.jpg', '2025-01-11 12:31:05', NULL, '5', '10', 2, 2, 0, 0, NULL),
(22, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2005, 'testschool@gmail.com', '1223698744', '7878675655', 'ghfdcvbn', '../admin/uploads/school_photos/s4.jpg', '2025-01-12 09:15:24', NULL, '1', '10', 1, 6, 12.9505, 77.5673, NULL),
(24, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2005, 'sdf@gamil.com', '6789787865', '7878675655', 'cbvnggffg', '../admin/uploads/school_photos/s2.jpg', '2025-01-13 06:03:12', NULL, 'KG ', '5', 1, 7, 28.57, 77.07, NULL),
(25, 'GPS school', 'Open', 'cd road delhi', 'cbse', 2005, 'sdf@gamil.com', '6789787865', '7878675655', 'cbvnggffg', '../admin/uploads/school_photos/s2.jpg', '2025-01-13 06:05:52', '10', '10', '10', 1, 2, 0, 0, NULL),
(26, 'newton public school', 'Open', 'bvxghiuytrewasdfg', 'bseb', 2009, 'hfhgfghf@gmail.com', '1458723695', '9067556843', 'drftgyhjnbvcxdrtygh', '../admin/uploads/school_photos/s4.jpg', '2025-01-16 08:38:32', 'Array', '1', '10', 1, 9, 0, 0, NULL),
(27, 'newton public school', 'Open', 'bvxghiuytrewasdfg', 'bseb', 2009, 'hfhgfghf@gmail.com', '1458723695', '9067556843', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/school.jpg', '2025-01-16 08:40:51', '', '1', '5', 4, 3, 0, 0, NULL),
(28, 'newton public school', 'Open', 'bvxghiuytrewasdfg', 'bseb', 2009, 'hfhgfghf@gmail.com', '1458723695', '9067556843', 'drftgyhjnbvcxdrtygh', '../admin/uploads/school_photos/s3.webp', '2025-01-16 08:44:12', '', 'Nursery', '12', 1, 4, 0, 0, NULL),
(29, 'newton public school', 'Open', 'bvxghiuytrewasdfg', 'bseb', 2009, 'hfhgfghf@gmail.com', '1458723695', '9067556843', 'drftgyhjnbvcxdrtygh', '../admin/uploads/school_photos/s1.jpeg', '2025-01-16 08:48:21', '8,9,10,11', '1', '10', 2, 5, 0, 0, NULL);
INSERT INTO `schools` (`id`, `name`, `admission_status`, `address`, `affiliate`, `estd`, `school_mail`, `primary_mob`, `secondary_mob`, `description`, `photo`, `created_at`, `class`, `class_minimum`, `class_maximum`, `city_id`, `views`, `latitude`, `longitude`, `map_embed_code`) VALUES
(30, 'newton public school', 'Open', 'bvxghiuytrewasdfg', 'bseb', 2009, 'hfhgfghf@gmail.com', '1458723695', '9067556843', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s5.jpg', '2025-01-16 08:48:24', '8,9,10,11', '5', '12', 4, 1, 0, 0, NULL),
(31, 'test school', 'Open', 'cd road delhi', 'cbse', 2005, 'testschool@gmail.com', '8596471236', '3456789321', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s3.webp', '2025-01-16 08:49:30', '21', '1', '5', 3, 0, 0, 0, NULL),
(32, 'test school', 'Open', 'cd road delhi', 'cbse', 2005, 'testschool@gmail.com', '8596471236', '3456789321', 'afgsdhfdsfghjtresdfg', '../admin/uploads/school_photos/s2.jpg', '2025-01-16 08:57:38', '8,9,10,11,12', 'KG', '5', 2, 2, 0, 0, NULL),
(36, 'josheps school', 'Open', 'ring road', 'bseb', 2005, 'js@gmail.com', '9546871235', '8657493215', 'bcnxm,cdnvc', '../admin/uploads/school_photos/s2.jpg', '2025-01-21 10:50:20', '8,9,10', '5', '10', 2, 2, 0, 0, NULL),
(37, 'josheps school', 'Open', 'ring road', 'bseb', 2005, 'js@gmail.com', '9546871235', '8657493215', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s2.jpg', '2025-01-21 10:50:21', '8,9,10', '1', '5', 4, 1, 0, 0, NULL),
(38, 'josheps school', 'Open', 'ring road', 'bseb', 2005, 'js@gmail.com', '9546871235', '8657493215', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:50:21', '8,9,10', '8', '12', 3, 0, 0, 0, NULL),
(39, 'josheps school', 'Open', 'ring road', 'bseb', 2005, 'js@gmail.com', '9546871235', '8657493215', 'bcnxm,cdnvc', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:50:22', '8,9,10', '1', '10', 2, 0, 0, 0, NULL),
(40, 'josheps school', 'Open', 'ring road', 'bseb', 2005, 'js@gmail.com', '9546871235', '8657493215', 'bcnxm,cdnvc', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:50:22', '8,9,10', '5', '10', 1, 3, 0, 0, NULL),
(41, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'gfjdmfds', '../admin/uploads/school_photos/s2.jpg', '2025-01-21 10:51:51', '8,9,10', '1', '5', 2, 2, 0, 0, NULL),
(42, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s4.jpg', '2025-01-21 10:54:46', '8,9,10', '1', '12', 3, 1, 0, 0, NULL),
(43, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s2.jpg', '2025-01-21 10:54:47', '8,9,10', '1', '12', 4, 0, 0, 0, NULL),
(44, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'gfjdmfds', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:54:48', '8,9,10', '5', '10', 1, 1, 0, 0, NULL),
(45, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'gfjdmfds', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:54:48', '8,9,10', '5', '12', 2, 1, 0, 0, NULL),
(46, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:54:49', '8,9,10', '6', '12', 3, 0, 0, 0, NULL);
INSERT INTO `schools` (`id`, `name`, `admission_status`, `address`, `affiliate`, `estd`, `school_mail`, `primary_mob`, `secondary_mob`, `description`, `photo`, `created_at`, `class`, `class_minimum`, `class_maximum`, `city_id`, `views`, `latitude`, `longitude`, `map_embed_code`) VALUES
(47, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s2.jpg', '2025-01-21 10:54:49', '8,9,10,11,12,19,20,21', '3', '10', 4, 1, 0, 0, NULL),
(48, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'gfjdmfds', '../admin/uploads/school_photos/s4.jpg', '2025-01-21 10:54:49', '8,9,10', '3', '8', 1, 4, 0, 0, NULL),
(49, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'gfjdmfds', '../admin/uploads/school_photos/s3.webp', '2025-01-21 10:54:50', '8,9,10', '5', '10', 1, 2, 0, 0, NULL),
(50, 'arc public school', 'Open', 'erfdes', 'bses', 2003, 'sed@gmail.com', '8977453465', '4532254536', 'gfjdmfds', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:54:56', '8,9,10', '2', '10', 1, 1, 0, 0, NULL),
(51, 'arc public school', 'Open', 'cd road delhi', 'bseb', 2003, 'gfd@gmail.com', '8596321475', '7896541236', 'xfcgvhbjnkvgbnm,', '../admin/uploads/school_photos/s1.jpeg', '2025-01-21 10:56:16', '8,9,10,11,12', 'Nursery', '8', 1, 0, 0, 0, NULL),
(52, 'Gaziyabad school', 'Open', 'f67, delhi india', 'ncert', 2009, 'asd@gmail.com', '8977453465', '3456789321', 'Introduction: XYZ International School, established in 2005, is a renowned educational institution dedicated to providing high-quality education, fostering critical thinking, creativity, and leadership in students. Located in the heart of the city, it offers a dynamic and nurturing environment that promotes academic excellence, personal growth, and holistic development. The school follows an international curriculum that ensures students are well-prepared for the challenges of the future.\n\nMission and Vision: At XYZ International School, our mission is to empower students to become responsible global citizens who demonstrate integrity, compassion, and respect. We envision creating an environment where learning is not limited to textbooks but extends beyond the classroom to include real-world experiences, fostering curiosity and a lifelong passion for learning.\n\nAcademics: Our academic program is designed to cater to students from Kindergarten to Grade 12. We offer a diverse range of subjects across various disciplines, ensuring that every student finds their passion and excels in it. The school follows the International Baccalaureate (IB) curriculum, providing students with a comprehensive, global perspective on education.\n\nEarly Years (Kindergarten to Grade 3): Our Early Years program focuses on developing foundational skills in literacy, numeracy, and social-emotional learning. Using inquiry-based methods, we encourage exploration and foster a love for learning.\n\nMiddle School (Grade 4 to Grade 8): During these years, we introduce a broad range of subjects, including languages, mathematics, science, social studies, arts, and physical education. Students are also encouraged to engage in extracurricular activities to build leadership, teamwork, and communication skills.\n\nHigh School (Grade 9 to Grade 12): In the senior years, students have the option to choose specialized subjects based on their career interests, such as sciences, humanities, business, and arts. Our highly qualified teachers guide students in preparing for various national and international examinations, including SAT, ACT, and IB Diploma.\n\nFacilities and Infrastructure: XYZ International School is equipped with state-of-the-art facilities to support both academic learning and extracurricular development. Our modern campus spans over 10 acres and includes:\n\nClassrooms: Spacious, well-lit, and equipped with interactive smart boards, projectors, and the latest learning tools. The classrooms are designed to encourage collaborative learning and are organized to provide students with a comfortable environment for focused learning.\n\nLaboratories: The school boasts specialized laboratories for Physics, Chemistry, Biology, and Computer Science, ensuring hands-on experience and practical learning in science and technology.\n\nLibrary: Our school library is home to thousands of books, journals, and digital resources, providing students with access to knowledge and research material on various subjects.\n\nSports Complex: A full-sized indoor gymnasium, swimming pool, football and basketball courts, tennis courts, and a running track make XYZ International School a hub for athletic excellence. Students are encouraged to participate in sports and fitness programs to maintain a balanced and healthy lifestyle.\n\nArts and Music Studio: We believe in nurturing creativity. The school has a well-equipped art studio and music room where students can engage in painting, sculpture, theater, and learning various musical instruments.\n\nCafeteria: The school offers a diverse range of healthy meals, catering to different dietary preferences, ensuring students have access to nutritious food throughout the day.\n\nExtracurricular Activities: Beyond academics, XYZ International School offers an array of extracurricular activities designed to enrich the lives of students. These include:\n\nSports Teams: Football, basketball, cricket, athletics, swimming, and other competitive sports, encouraging teamwork and discipline.\n\nClubs and Societies: From drama to debate, coding to robotics, students can join various clubs to hone their skills and explore their interests.\n\nCommunity Service: We place a strong emphasis on social responsibility, encouraging students to get involved in community service projects that make a positive impact on society.\n\nField Trips & Excursions: Our students participate in educational field trips, domestic and international exchanges, and excursions that complement classroom learning.\n\nFaculty: At XYZ International School, we are proud to have a team of highly qualified and passionate educators from around the world. Each teacher brings a unique perspective and teaching style to the classroom. Our faculty members are not just educators; they are mentors, role models, and guides who support students in their academic and personal development.\n\nParent Involvement: We believe in building a strong partnership with parents. Regular parent-teacher meetings, workshops, and school events ensure that parents are always involved in their children\'s educational journey. The school fosters open communication and encourages parents to actively participate in their child\'s growth and success.\n\nTechnology Integration: In today’s fast-paced world, technology plays a crucial role in education. At XYZ International School, we integrate technology in classrooms, allowing students to use digital tools for research, presentations, and projects. Our 1:1 laptop program ensures that every student has access to a personal device, enhancing the learning experience.\n\nAdmission Process: Admissions to XYZ International School are open year-round, with the primary intake occurring in the Month of January. We welcome students from diverse backgrounds and look for individuals who demonstrate curiosity, a desire to learn, and a commitment to personal growth. The process includes an application form, an entrance exam (if applicable), and an interview.\n\nConclusion: XYZ International School is not just a place of academic learning; it\'s a community that fosters the growth of young minds, preparing them to face the world with confidence, knowledge, and skills. With a commitment to excellence, innovation, and global awareness, we are dedicated to nurturing the leaders of tomorrow.\n\nWhether it\'s through our world-class academics, sports, arts, or community service initiatives, XYZ International School provides a well-rounded education that prepares students for success in all aspects of life.', '../admin/uploads/school_photos/s3.webp', '2025-01-22 11:44:11', '8,9,10,11,12', '5', '10', 3, 1, 0, 0, NULL),
(53, 'Gaziyabad school', 'Open', 'f67, delhi india', 'ncert', 2009, 'asd@gmail.com', '8977453465', '3456789321', 'dxfcgvhjkgfdxjkl,mjgfhjngsdfxghbjgfdxghbgfdcghbjbgfdgh', '../admin/uploads/school_photos/s2.jpg', '2025-01-22 11:44:36', '8,9,10,11,12', 'Nursery', '10', 1, 4, 0, 0, NULL),
(55, 'rs school', 'Open', 'edfr gaerde', 'ICSE', 2002, 'sxg@gmail.com', '8977453465', '3456789321', 'fdgchdugcusduwdsh', '../admin/uploads/school_photos/s3.webp', '2025-01-22 12:32:42', NULL, '1', '10', 1, 0, 0, 0, NULL),
(56, 'rs school', 'Open', 'edfr gaerde', 'icse', 2002, 'sxg@gmail.com', '8977453465', '3456789321', 'fdgchdugcusduwdsh', '../admin/uploads/school_photos/s5.jpg', '2025-01-22 12:33:33', NULL, '1', '10', 1, 0, 0, 0, NULL),
(57, 'rs school', 'Open', 'edfr gaerde', 'icse', 2002, 'sxg@gmail.com', '8977453465', '3456789321', 'fdgchdugcusduwdsh', '../admin/uploads/school_photos/s5.jpg', '2025-01-22 12:42:39', NULL, '1', '10', 1, 2, 28, 77, NULL),
(61, 'gyanda public school', 'Open', 'f67, delhi india', 'cbse', 2005, 'hfhgfghf@gmail.com', '7896541236', '4532254536', 'afsghdjfkglhyoieuwsyawtgdhfgjfkut7i46u8357426q35rEADfszGDSHXFJCGKHGLHJKJRYETWRQEAFSGHJKLHMGNFBDXSZDTRYFTHKUJLJYHTRERETHJYKYJHFRGTHJTRAGDHF', '../admin/uploads/school_photos/s1.jpeg', '2025-02-11 05:13:28', NULL, 'KG', '10', 2, 0, 0, 0, NULL),
(62, 'gyanda public school', 'Open', 'f67, delhi india', 'cbse', 2005, 'hfhgfghf@gmail.com', '7896541236', '4532254536', 'afsghdjfkglhyoieuwsyawtgdhfgjfkut7i46u8357426q35rEADfszGDSHXFJCGKHGLHJKJRYETWRQEAFSGHJKLHMGNFBDXSZDTRYFTHKUJLJYHTRERETHJYKYJHFRGTHJTRAGDHF', '../admin/uploads/school_photos/s1.jpeg', '2025-02-11 05:18:02', NULL, 'KG', '10', 2, 0, 0, 0, NULL),
(63, 'ramayan school ', 'Open', 'shikohabad', 'cbse', 2003, 'school@gmail.com', '6789787865', '7688490732', 'djcnxvlvjsndxvksdxjkvla.sznx', '../admin/uploads/school_photos/s1.jpeg', '2025-02-11 05:19:11', NULL, '1', '12', 5, 3, 0, 0, NULL),
(64, 'ramayan school ', 'Open', 'shikohabad', 'cbse', 2003, 'school@gmail.com', '6789787865', '7688490732', 'djcnxvlvjsndxvksdxjkvla.sznx', '../admin/uploads/school_photos/s1.jpeg', '2025-02-11 05:23:17', NULL, '1', '12', 5, 1, 0, 0, NULL),
(65, 'abc school', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 2003, 'asd@gmail.com', '7896541236', '4532254536', 'Asfgdmcxjncm mdgszxbcnvmdhfncgvb', '../admin/uploads/school_photos/s1.jpeg', '2025-02-11 05:24:20', NULL, 'Nursery', '12', 5, 1, 0, 0, NULL),
(66, 'abc school', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 2003, 'asd@gmail.com', '7896541236', '4532254536', 'Asfgdmcxjncm mdgszxbcnvmdhfncgvb', '../admin/uploads/school_photos/s1.jpeg', '2025-02-11 05:25:19', NULL, 'Nursery', '12', 5, 0, 0, 0, NULL),
(67, 'abcd school', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 2006, 'hfgdgfdfgd@gmail.com', '1523647895', '3456789321', 'ADSFGNM DJSHAZGXDHFNFTGMHJ GVBNHFGFSFDGHJBMHHGfszgHGFRDEA', '../admin/uploads/school_photos/s5.jpg', '2025-02-11 05:26:20', NULL, 'UKG', '12', 5, 1, 0, 0, NULL),
(68, 'arc public school', 'Open', 'f67, delhi india', 'cbse', 2005, 'hfgdgfdfgd@gmail.com', '1523647895', '7688490732', 'xfhcgjmrtfgjndxcygnxfnfhcvzdzfxvbcnv mbmjehrsgfz', '../admin/uploads/school_photos/s4.jpg', '2025-02-11 05:44:10', NULL, '1', '10', 5, 0, 0, 0, NULL),
(69, 'Rosary Senior Secondary School', 'Open', 'cd road delhi', '', 2004, 'dfgh@345gmail.com', '9563214875', '8569321475', 'fdcxthghbvdhudsgjkbnhxusyjngsvz', '../admin/uploads/school_photos/s5.jpg', '2025-02-20 09:22:44', NULL, '1', '10', 5, 1, 0, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.1935759047938!2d77.19728977352135!3d28.713760426526722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfe076c01632f%3A0x61e9951f3358259f!2sRosary%20Senior%20Secondary%20School!5e0!3m2!1sen!2sin!4v1740043316622!5m2!1sen!2sin\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `school_admission_enquiries`
--

CREATE TABLE `school_admission_enquiries` (
  `id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `class` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_admission_enquiries`
--

INSERT INTO `school_admission_enquiries` (`id`, `school_name`, `name`, `email`, `phone`, `class`, `created_at`) VALUES
(1, 'Mahavir senior model school', 'niya', 'anu@123gmail.com', '7217676540', '5', '2025-02-21 08:40:16'),
(2, 'Mahavir senior model school', 'niya', 'apnaonlinevyapar@gmail.com', '7217676540', '7', '2025-02-21 10:04:19'),
(3, 'Mahavir senior model school', 'Annu', 'annu.apnaonlinevyapar@gmail.com', '9234693132', '5', '2025-02-25 10:06:28'),
(4, 'Mahavir senior model school', 'Annu', 'annu.apnaonlinevyapar@gmail.com', '9234693132', '5', '2025-02-25 10:06:28'),
(5, 'Mahavir senior model school', 'Annu', 'annu.apnaonlinevyapar@gmail.com', '9234693132', '5', '2025-02-25 10:06:43'),
(6, 'Mahavir senior model school', 'Annu', 'annu.apnaonlinevyapar@gmail.com', '9234693132', '5', '2025-02-25 10:06:43'),
(7, 'Mahavir senior model school', 'niya', 'bngd123@gmail.com', '7217676540', '8', '2025-02-28 11:00:00'),
(8, 'Mahavir senior model school', 'niya', 'bngd123@gmail.com', '7217676540', '8', '2025-02-28 11:00:01'),
(9, 'Mahavir senior model school', 'niya', 'bngd123@gmail.com', '7217676540', '8', '2025-02-28 11:00:01'),
(10, 'Mahavir senior model school', 'niya', 'bngd123@gmail.com', '7217676540', '8', '2025-02-28 11:00:01'),
(11, 'Mahavir senior model school', 'niya', 'anu54@gmail.com', '7217676540', '3', '2025-02-28 11:36:03'),
(12, 'Mahavir senior model school', 'niya', 'anu54@gmail.com', '7217676540', '3', '2025-02-28 11:36:03'),
(13, 'Mahavir senior model school', 'niya', 'anu54@gmail.com', '7217676540', '3', '2025-02-28 11:36:03'),
(14, 'Mahavir senior model school', 'niya', 'anu54@gmail.com', '7217676540', '3', '2025-02-28 11:36:03'),
(15, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:41:08'),
(16, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:41:08'),
(17, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:41:08'),
(18, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:41:08'),
(19, 'trhgfhgf', 'niya', 'ak234@gmail.com', '7217676540', '1', '2025-02-28 11:42:29'),
(20, 'trhgfhgf', 'niya', 'ak234@gmail.com', '7217676540', '1', '2025-02-28 11:42:29'),
(21, 'trhgfhgf', 'niya', 'ak234@gmail.com', '7217676540', '1', '2025-02-28 11:42:29'),
(22, 'trhgfhgf', 'niya', 'ak234@gmail.com', '7217676540', '1', '2025-02-28 11:42:29'),
(23, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:45:57'),
(24, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:45:57'),
(25, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:45:57'),
(26, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:45:57'),
(27, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:46:30'),
(28, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:46:30'),
(29, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:46:30'),
(30, 'trhgfhgf', 'niya', 'bngd123@gmail.com', '7217676540', '1', '2025-02-28 11:46:31'),
(31, 'trhgfhgf', 'prachi', 'pov@GMAIL.COM', '9205018713', '1', '2025-02-28 11:48:03'),
(32, 'trhgfhgf', 'prachi', 'pov@GMAIL.COM', '9205018713', '1', '2025-02-28 11:48:03'),
(33, 'trhgfhgf', 'prachi', 'pov@GMAIL.COM', '9205018713', '1', '2025-02-28 11:48:03'),
(34, 'trhgfhgf', 'prachi', 'pov@GMAIL.COM', '9205018713', '1', '2025-02-28 11:48:03'),
(35, 'trhgfhgf', 'prachi', 'apnaonlinevyapar@gmail.com', '9205018713', '1', '2025-02-28 11:53:22'),
(36, 'trhgfhgf', 'prachi', 'apnaonlinevyapar@gmail.com', '9205018713', '1', '2025-02-28 11:53:22'),
(37, 'trhgfhgf', 'prachi', 'apnaonlinevyapar@gmail.com', '9205018713', '1', '2025-02-28 11:53:22'),
(38, 'trhgfhgf', 'prachi', 'apnaonlinevyapar@gmail.com', '9205018713', '1', '2025-02-28 11:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `school_documents`
--

CREATE TABLE `school_documents` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `address_proof` int(11) DEFAULT 0,
  `birth_certificate` int(11) DEFAULT 0,
  `medical_certificate` int(11) DEFAULT 0,
  `photo` int(11) DEFAULT 0,
  `caste_certificate` int(11) DEFAULT 0,
  `family_photo` int(11) DEFAULT 0,
  `last_school_details` int(11) DEFAULT 0,
  `parent_guardian_photo` int(11) DEFAULT 0,
  `religion_proof` int(11) DEFAULT 0,
  `report_card` int(11) DEFAULT 0,
  `differently_abled_proof` int(11) DEFAULT 0,
  `sibling_alumni_proof` int(11) DEFAULT 0,
  `first_girl_child` int(11) DEFAULT 0,
  `aadhaar_card` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_documents`
--

INSERT INTO `school_documents` (`id`, `school_id`, `address_proof`, `birth_certificate`, `medical_certificate`, `photo`, `caste_certificate`, `family_photo`, `last_school_details`, `parent_guardian_photo`, `religion_proof`, `report_card`, `differently_abled_proof`, `sibling_alumni_proof`, `first_girl_child`, `aadhaar_card`) VALUES
(1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 1),
(2, 6, 1, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1),
(3, 13, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1, 1),
(4, 8, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 1, 1),
(7, 15, 1, 1, 0, 1, 0, 1, 0, 1, 1, 1, 0, 0, 0, 1),
(8, 26, 1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `school_facility`
--

CREATE TABLE `school_facility` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `extra_curricular` varchar(255) DEFAULT NULL,
  `class_facilities` varchar(255) DEFAULT NULL,
  `infrastructure` varchar(255) DEFAULT NULL,
  `sports_fitness` varchar(255) DEFAULT NULL,
  `lab_facilities` varchar(255) DEFAULT NULL,
  `boarding` varchar(255) DEFAULT NULL,
  `disabled_friendly` varchar(255) DEFAULT NULL,
  `safety_security` varchar(255) DEFAULT NULL,
  `advanced_facilities` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_facility`
--

INSERT INTO `school_facility` (`id`, `school_id`, `extra_curricular`, `class_facilities`, `infrastructure`, `sports_fitness`, `lab_facilities`, `boarding`, `disabled_friendly`, `safety_security`, `advanced_facilities`, `created_at`, `updated_at`) VALUES
(1, 1, 'Art and Craft,Dance,Debate,Music', 'AC Classes,Wifi', 'Library/Reading Room,Playground,Cafeteria/Canteen', 'Indoor Sports,Karate,Yoga', 'Computer Lab,Language Lab', 'Boys Hostel,Girls Hostel', 'Washrooms', 'CCTV', 'Medical Room,Transportation', '2025-02-07 05:55:56', '2025-02-07 06:21:01'),
(2, 6, 'Art and Craft,Debate,Drama', 'AC Classes,Wifi', 'Library/Reading Room,Cafeteria/Canteen', 'Outdoor Sports,Yoga', 'Computer Lab,Language Lab', 'Girls Hostel', 'Washrooms', 'CCTV', 'Medical Room,Transportation', '2025-02-07 05:56:28', '2025-02-07 05:56:28'),
(4, 13, 'Dance,Debate,Drama', 'Smart Classes', 'Auditorium/Media Room,Cafeteria/Canteen', 'Outdoor Sports,Yoga', 'Science Lab', 'Girls Hostel', 'Elevators', 'CCTV', 'Day care', '2025-02-07 06:29:47', '2025-02-07 06:29:47'),
(5, 41, 'Art and Craft,Dance,Debate', 'AC Classes', 'Playground', 'Indoor Sports', 'Science Lab', 'Girls Hostel', 'Elevators', 'CCTV', 'Medical Room,Transportation', '2025-02-07 07:40:12', '2025-02-07 07:40:12'),
(8, 12, 'Art and Craft,Dance,Drama,Music', 'AC Classes,Wifi', 'Library/Reading Room,Auditorium/Media Room', 'Indoor Sports,Karate,Yoga', 'Computer Lab,Language Lab', 'Boys Hostel', 'Washrooms', 'CCTV', 'Medical Room,Transportation', '2025-02-12 06:29:08', '2025-02-12 06:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `school_language`
--

CREATE TABLE `school_language` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `english` tinyint(1) DEFAULT 0,
  `hindi` tinyint(1) DEFAULT 0,
  `french` tinyint(1) DEFAULT 0,
  `spanish` tinyint(1) DEFAULT 0,
  `german` tinyint(1) DEFAULT 0,
  `chinese` tinyint(1) DEFAULT 0,
  `japanese` tinyint(1) DEFAULT 0,
  `arabic` tinyint(1) DEFAULT 0,
  `russian` tinyint(1) DEFAULT 0,
  `portuguese` tinyint(1) DEFAULT 0,
  `italian` tinyint(1) DEFAULT 0,
  `korean` tinyint(1) DEFAULT 0,
  `bengali` tinyint(1) DEFAULT 0,
  `urdu` tinyint(1) DEFAULT 0,
  `turkish` tinyint(1) DEFAULT 0,
  `sanskrit` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_language`
--

INSERT INTO `school_language` (`id`, `school_id`, `english`, `hindi`, `french`, `spanish`, `german`, `chinese`, `japanese`, `arabic`, `russian`, `portuguese`, `italian`, `korean`, `bengali`, `urdu`, `turkish`, `sanskrit`) VALUES
(1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1),
(2, 6, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 1, 0, 1),
(3, 8, 1, 1, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0),
(4, 9, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 1, 1, 0, 1, 0, 1),
(5, 13, 1, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1),
(7, 61, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `school_medias`
--

CREATE TABLE `school_medias` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `sports` varchar(500) DEFAULT NULL,
  `classroom` varchar(500) DEFAULT NULL,
  `labs` varchar(500) DEFAULT NULL,
  `medical_facilities` varchar(500) DEFAULT NULL,
  `boarding` varchar(500) DEFAULT NULL,
  `campus_architecture` varchar(500) DEFAULT NULL,
  `activities` varchar(500) DEFAULT NULL,
  `extra_curricular` varchar(500) DEFAULT NULL,
  `cafeteria` varchar(500) DEFAULT NULL,
  `library` varchar(500) DEFAULT NULL,
  `other_photos` varchar(500) DEFAULT NULL,
  `videos` text DEFAULT NULL COMMENT 'Stores only video URLs, no images'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_medias`
--

INSERT INTO `school_medias` (`id`, `school_id`, `sports`, `classroom`, `labs`, `medical_facilities`, `boarding`, `campus_architecture`, `activities`, `extra_curricular`, `cafeteria`, `library`, `other_photos`, `videos`) VALUES
(1, 65, 'u1.jpeg,s5.jpg,s4.jpg', 's2.jpg,u5.jpg,u3.jpeg', 'slide2.jpeg', 'u1.jpeg,s5.jpg,s4.jpg,s3.webp', 'img8.jpeg,img7.jpeg,img6.jpeg', 'technology-7111798_1920.jpg,finance-8836903_1920.jpg,slide3.jpeg,slide2.jpeg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'img3.jpg,img1.jpg,p6.jpg', 'img3.webp,img2.jpeg,img1.jpeg', 's5.jpg,s4.jpg,s3.webp', 'u4.jpg,u3.jpeg,u2.jpg,u1.jpeg', 'ScreenRecorder_2025-02-06 15-17-28.mp4,https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3,https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3'),
(2, 6, 's5.jpg,s4.jpg,s3.webp,s2.jpg', 'img4.jpeg,img3.webp,img2.jpeg', 'slide1.jpg,img8.jpeg,img7.jpeg,img6.jpeg', 'img8.jpeg,img7.jpeg,img6.jpeg,img5.jpeg', 'img4.jpeg,img3.webp,img2.jpeg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'u2.jpg,u1.jpeg,s5.jpg', 's3.webp,s2.jpg,s1.jpeg', 's5.jpg,s4.jpg,s3.webp', 'step-2.b1bf1bf.webp,step-1.f573b7d.webp,startup story.e8f5741.webp,rec_single_Medium.dc2eca1.png', 's4.jpg,s3.webp,s2.jpg', 'https://www.youtube.com/watch?v=rjfsoSIexCg&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=4'),
(3, 1, 'u6.jpeg,u5.jpg,u4.jpg,u3.jpeg', 'u1.jpeg,s5.jpg,s4.jpg', 's3.webp,s2.jpg,s1.jpeg', 'u3.jpeg,u2.jpg,u1.jpeg', 's5.jpg,s4.jpg,s3.webp', 'steps-to-apply.64bd6c3.webp,step-5.0447484.webp', 'security-3742114_1920.jpg,office-4092613_1920.jpg,business-5475661_1920.jpg,technology-7111798_1920.jpg', 'u6.jpeg,u5.jpg,u4.jpg', 's2.jpg,s1.jpeg,school.jpg', 's1.jpeg,school.jpg,search2.d74b6b9.webp,mac-phone.webp', 'no_results_found11.b876ba2.webp,no_results_found1.2259692.webp,logo2.webp,img1.png', 'https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3,https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3'),
(4, 8, 'u3.jpeg,u2.jpg,u1.jpeg', 's5.jpg,s4.jpg,s3.webp,s2.jpg', 'u2.jpg,u1.jpeg,s5.jpg', 'u3.jpeg,u2.jpg,u1.jpeg,s5.jpg', 's4.jpg,s3.webp,s2.jpg', 's4.jpg,s3.webp,s2.jpg', 's3.webp,s2.jpg,s1.jpeg', 's5.jpg,s4.jpg,s3.webp,s2.jpg', 's4.jpg,s3.webp,s2.jpg,s1.jpeg', 'u1.jpeg,s5.jpg,s4.jpg', 'u5.jpg,u4.jpg,u3.jpeg', 'https://www.youtube.com/watch?v=bhseoSl3nLY&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=7'),
(5, 68, 'u4.jpg', 'img1.jpeg,finance-management.jpg', 'search2.d74b6b9.webp', 'step-3.37e4f80.webp,step-2.b1bf1bf.webp,step-1.f573b7d.webp,startup story.e8f5741.webp', 's3.webp,s2.jpg,school.jpg', 's3.webp,s2.jpg,s1.jpeg', 's5.jpg,s4.jpg,s3.webp', 'step-2.b1bf1bf.webp,u1.jpeg', 's4.jpg,s3.webp,s2.jpg', 's5.jpg,s4.jpg,s3.webp', 's3.webp,s2.jpg,s1.jpeg', 'https://www.youtube.com/watch?v=VZf7KzH40B8&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=9'),
(6, 40, 's4.jpg,s3.webp,s2.jpg,s1.jpeg', 's5.jpg,s4.jpg,s3.webp', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg,s3.webp', 's5.jpg,s4.jpg,s3.webp,s2.jpg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 's3.webp,s2.jpg,s1.jpeg', 's3.webp,s2.jpg,s1.jpeg,school.jpg', 'img4.jpeg,img3.webp,img2.jpeg,img1.jpeg', 'no_results_found11.b876ba2.webp,no_results_found1.2259692.webp,logo2.webp,img1.png', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'startup-849804_1920.jpg,man-791049_1920.jpg,blockchain-2853054_1920.jpg,the-labour-code-3520806_1920.jpg', 'https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3,https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3'),
(7, 63, 'u1.jpeg,s5.jpg,s4.jpg,s3.webp,s2.jpg', 's5.jpg,s4.jpg,s3.webp,s2.jpg,s1.jpeg', 's4.jpg,s3.webp,s2.jpg,s1.jpeg,school.jpg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg,s3.webp,s2.jpg', 's4.jpg,s3.webp,s2.jpg,s1.jpeg', 's4.jpg,s3.webp,s2.jpg', 'u6.jpeg,u5.jpg,u4.jpg,u3.jpeg,u2.jpg', 's5.jpg,s4.jpg,s3.webp,s2.jpg,s1.jpeg', 'slide3.jpeg,slide2.jpeg,slide1.jpg,img8.jpeg,img7.jpeg,img6.jpeg,img5.jpeg,img4.jpeg', 'technology-7111798_1920.jpg,finance-8836903_1920.jpg,slide3.jpeg,slide2.jpeg,slide1.jpg', 'the indian express.1b06c0a.webp,steps-to-apply.64bd6c3.webp,step-5.0447484.webp', 'https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3,https://www.youtube.com/watch?v=5ELyMRnEyDE&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=3'),
(8, 62, 'u1.jpeg,s5.jpg,s4.jpg,s3.webp', 'u1.jpeg,s5.jpg,s4.jpg,s3.webp,s2.jpg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'u3.jpeg,u2.jpg,u1.jpeg,s5.jpg', 's3.webp,s2.jpg,s1.jpeg,school.jpg', 'u3.jpeg,u2.jpg,u1.jpeg', 'u4.jpg,u3.jpeg,u2.jpg', 'laptop-3196481_1920.jpg,security-3742114_1920.jpg,office-4092613_1920.jpg,business-5475661_1920.jpg', 'laptop-3196481_1920.jpg,security-3742114_1920.jpg,office-4092613_1920.jpg,business-5475661_1920.jpg', 's5.jpg,s4.jpg,s3.webp,s2.jpg', 'u3.jpeg,u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'https://www.youtube.com/watch?v=VZf7KzH40B8&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=9'),
(9, 56, 'u3.jpeg,u2.jpg,u1.jpeg', 'u3.jpeg,u2.jpg,u1.jpeg,s5.jpg', 's2.jpg,s1.jpeg,school.jpg', 's3.webp,s2.jpg', 'img8.jpeg,img7.jpeg', 'slide1.jpg,img8.jpeg,img7.jpeg', 'u1.jpeg,s5.jpg,s4.jpg', 'u3.jpeg,u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'img8.jpeg,img7.jpeg,img6.jpeg', 's3.webp,s2.jpg,s1.jpeg', 'u1.jpeg,s5.jpg,s4.jpg,s3.webp', 'https://www.youtube.com/watch?v=rjfsoSIexCg&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=4'),
(11, 69, 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'u4.jpg,u3.jpeg,u2.jpg', 'u1.jpeg,s5.jpg,s4.jpg', 's3.webp,s2.jpg,s1.jpeg', 'img6.jpeg,img5.jpeg,img4.jpeg,img3.webp', 'img5.jpeg,img4.jpeg,img3.webp', 'img4.jpeg,img3.webp,img2.jpeg', 's5.jpg,s4.jpg,s3.webp,s2.jpg,s1.jpeg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'u1.jpeg,s5.jpg,s4.jpg', 's5.jpg,s4.jpg,s3.webp,s2.jpg', 'https://www.youtube.com/watch?v=cu5Z7j7FIhU&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=1'),
(33, 8, 'u3.jpeg,u2.jpg,u1.jpeg,s5.jpg', 'u1.jpeg,s5.jpg,s4.jpg', 's5.jpg,s4.jpg,s3.webp', 'u5.jpg,u4.jpg,u3.jpeg', 'u2.jpg,u1.jpeg,s5.jpg,s4.jpg', 'u4.jpg,u3.jpeg,u2.jpg,u1.jpeg', 'u1.jpeg,s5.jpg,s4.jpg,s3.webp', 's4.jpg,s3.webp,s2.jpg,s1.jpeg', 's3.webp,s2.jpg,s1.jpeg,school.jpg', 'u1.jpeg,s5.jpg,s4.jpg,s3.webp', 'slide2.jpeg,slide1.jpg,img8.jpeg,img7.jpeg', 'https://www.youtube.com/watch?v=cu5Z7j7FIhU&list=PLw79IvuHGRQCse9_F00Md5tNRbVopE0IB&index=1');

-- --------------------------------------------------------

--
-- Table structure for table `school_quickfact`
--

CREATE TABLE `school_quickfact` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `board` varchar(255) DEFAULT NULL,
  `gender` enum('Co-Ed','Boys','Girls') DEFAULT NULL,
  `class_min` int(11) NOT NULL,
  `academic_session` varchar(255) DEFAULT NULL,
  `medium` varchar(255) DEFAULT NULL,
  `student_teacher_ratio` varchar(50) DEFAULT NULL,
  `day_boarding` enum('Day School','Boarding School','Both') DEFAULT NULL,
  `campus_size` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `class_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_quickfact`
--

INSERT INTO `school_quickfact` (`id`, `school_id`, `board`, `gender`, `class_min`, `academic_session`, `medium`, `student_teacher_ratio`, `day_boarding`, `campus_size`, `created_at`, `updated_at`, `class_max`) VALUES
(1, 1, 'CBSE', 'Co-Ed', 1, '2025-2026', 'English', '30:1', 'Day School', '10 acer', '2025-02-04 06:07:14', '2025-02-04 06:07:14', 10),
(2, 6, 'ICSE', 'Co-Ed', 1, '2025-2026', 'English', '20:1', 'Day School', '15 acer', '2025-02-04 06:11:32', '2025-02-04 06:11:32', 12),
(3, 24, 'Cambridge', 'Boys', 1, '2025-2026', 'English', '30:1', 'Day School', '10 acer', '2025-02-11 16:25:44', '2025-02-11 16:25:44', 12),
(4, 9, 'CBSE', 'Girls', 1, '2025-2026', 'English', '30:1', 'Day School', '15 acer', '2025-02-11 16:26:32', '2025-02-11 16:26:32', 12),
(5, 41, 'CBSE', 'Boys', 1, '2025-2026', 'English', '10:1', 'Boarding School', '10 acer', '2025-02-11 16:27:21', '2025-02-11 16:48:26', 11),
(6, 67, 'State Board', 'Co-Ed', 1, '2025-2026', 'English', '30:1', 'Boarding School', '15 acer', '2025-02-11 16:28:14', '2025-02-11 16:28:14', 12);

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `university_name` varchar(255) NOT NULL,
  `admission_status` enum('Open','Close') NOT NULL,
  `address` varchar(255) NOT NULL,
  `affiliate` varchar(255) DEFAULT NULL,
  `class_minimum` int(11) NOT NULL,
  `class_maximum` int(11) NOT NULL,
  `estd` int(11) DEFAULT NULL,
  `university_mail` varchar(255) NOT NULL,
  `primary_mob` varchar(15) NOT NULL,
  `secondary_mob` varchar(15) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `courses` text DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `university_name`, `admission_status`, `address`, `affiliate`, `class_minimum`, `class_maximum`, `estd`, `university_mail`, `primary_mob`, `secondary_mob`, `overview`, `photo`, `created_at`, `courses`, `city_id`, `views`) VALUES
(2, 'JS University', 'Open', 'cd road delhi', 'cbse', 11, 12, 2006, 'ja123@gmail.com', '200656984252', '9067556843', 'ungyg', '../admin/uploads/university_photos/u1.jpeg', '2025-01-13 07:49:06', NULL, 1, 13),
(3, 'nalanda university', 'Open', 'f67, delhi india', '', 11, 12, 2005, 'js123@gmail.com', '1459632874', '1475826984', 'gkhlkgjfhgsfdgfd', '../admin/uploads/university_photos/u2.jpg', '2025-01-14 11:51:31', NULL, 1, 1),
(4, 'nalanda university', 'Open', 'f67, delhi india', '', 11, 12, 2005, 'js123@gmail.com', '1459632874', '1475826984', 'gkhlkgjfhgsfdgfd', '../admin/uploads/university_photos/u3.jpeg', '2025-01-14 12:04:11', NULL, 1, 0),
(5, 'nalanda university', 'Open', 'f67, delhi india', '', 11, 12, 2005, 'js123@gmail.com', '1459632874', '1475826984', 'gkhlkgjfhgsfdgfd', '../admin/uploads/university_photos/u4.jpg', '2025-01-14 12:04:12', NULL, 1, 0),
(6, 'nalanda university', 'Open', 'f67, delhi india', '', 11, 12, 2005, 'js123@gmail.com', '1459632874', '1475826984', 'gkhlkgjfhgsfdgfd', '../admin/uploads/university_photos/u5.jpg', '2025-01-14 12:04:12', NULL, 1, 0),
(7, 'nalanda university', 'Open', 'f67, delhi india', 'cbse', 11, 12, 2005, 'js123@gmail.com', '1596478236', '1592634875', 'rutfghvjytfgjhkhgvhuygfcy8uygfcyugfyui', '../admin/uploads/university_photos/u6.jpeg', '2025-01-14 12:05:30', NULL, 1, 0),
(8, 'nalanda university', 'Open', 'f67, delhi india', 'cbse', 11, 12, 2344, 'ja123@gmail.com', '6789787865', '3456789321', 'fegrdghjjhfgtyghdxszxsdfvc', '../admin/uploads/university_photos/u1.jpeg', '2025-01-14 12:17:34', NULL, 2, 2),
(9, 'nalanda university', 'Open', 'f67, delhi india', 'cbse', 11, 12, 2344, 'ja123@gmail.com', '6789787865', '3456789321', 'fegrdghjjhfgtyghdxszxsdfvc', '../admin/uploads/university_photos/u2.jpg', '2025-01-14 12:18:16', NULL, 1, 2),
(10, 'nalanda university', 'Open', 'f67, delhi india', 'cbse', 11, 12, 2344, 'ja123@gmail.com', '6789787865', '3456789321', 'fegrdghjjhfgtyghdxszxsdfvc', '../admin/uploads/university_photos/u3.jpeg', '2025-01-14 12:18:18', NULL, 2, 0),
(11, 'xyz university', 'Open', 'shikohabad', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '7896541236', '4596321875', 'jhgfcxdzghtxjyufjgmbnxdhgfch', '../admin/uploads/university_photos/u4.jpg', '2025-01-15 05:16:00', NULL, 3, 2),
(12, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u5.jpg', '2025-01-15 05:31:21', NULL, 4, 7),
(13, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u6.jpeg', '2025-01-15 05:50:11', NULL, 3, 5),
(14, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u1.jpeg', '2025-01-15 05:50:13', NULL, 2, 1),
(15, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u2.jpg', '2025-01-15 05:50:13', NULL, 3, 0),
(16, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u3.jpeg', '2025-01-15 05:50:35', NULL, 2, 0),
(17, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u4.jpg', '2025-01-15 05:50:36', NULL, 3, 0),
(18, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u4.jpg', '2025-01-15 05:53:03', NULL, 1, 0),
(19, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u5.jpg', '2025-01-15 05:53:05', NULL, 3, 3),
(20, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u3.jpeg', '2025-01-15 05:53:05', NULL, 4, 9),
(21, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u1.jpeg', '2025-01-15 05:53:06', NULL, 4, 0),
(22, 'xyz university', 'Open', 'hjghjghjnbvnbf gfgfghf', 'cbse', 11, 12, 2005, 'ja123@gmail.com', '156858252', '2555352525', 'dghvmbjhfcv', '../admin/uploads/university_photos/u2.jpg', '2025-01-15 05:53:30', NULL, 4, 6),
(23, 'xyz university', 'Open', 'shikohabad', 'cbse', 11, 12, 2009, 'kjhgg@gmail.com', '159632487', '5263417895', 'tudghfgkytrdfghvbnbvb', '../admin/uploads/university_photos/u3.jpeg', '2025-01-15 06:33:10', NULL, 4, 13),
(24, 'xyz university', 'Open', 'shikohabad', 'cbse', 11, 12, 2009, 'kjhgg@gmail.com', '159632487', '5263417895', 'tudghfgkytrdfghvbnbvb', '../admin/uploads/university_photos/u4.jpg', '2025-01-15 06:37:23', NULL, 4, 10),
(25, 'xyz university', 'Open', 'bnm,', 'cbse', 11, 12, 2004, 'ja123@gmail.com', '1524789632', '5214896378', ',mnbvnm,', '../admin/uploads/university_photos/u1.jpeg', '2025-01-16 05:30:09', '4', 2, 1),
(26, 'xyz university', 'Open', 'cd road delhi', 'cbse', 11, 12, 2005, 'kjhgg@gmail.com', '7458963215', '9632587412', 'sdxfcgvhbjnkm', '../admin/uploads/university_photos/u2.jpg', '2025-01-16 05:31:16', '3', 2, 1),
(27, 'xyz university', 'Open', 'shikohabad', '', 11, 12, 2006, 'xyz@gmail.com', '4785963215', '4569871236', 'cfvgbhnjmkyuhji', '../admin/uploads/university_photos/u3.jpeg', '2025-01-16 05:40:16', '15', 1, 0),
(28, 'nalanda university', 'Open', 'f67, delhi india', 'cbse', 1, 10, 2005, 'ja123@gmail.com', '1523647895', '7688490732', 'fgdvb', '	\n../admin/uploads/university_photos/g5.png', '2025-01-25 12:51:56', '2', 0, 0),
(29, 'ramayan university ', 'Open', 'hjghjghjnbvnbf gfgfghf', 'bseb', 11, 12, 2005, 'kjhgg@gmail.com', '1223698744', '7878675655', 'vsbxklsdnvso.gl.nf;bm/sf.vbs/lkjnb nsmad,vfiduhgbfgsdg nfmpasodfgjnmsldf;gbk', '../admin/uploads/university_photos/u5.jpg', '2025-02-11 05:58:17', '1,2,3,4', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `neighbourhood` text DEFAULT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Inactive',
  `school_type` enum('Day','Boarding','Online') NOT NULL,
  `monthly_budget` decimal(10,2) DEFAULT NULL,
  `area` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `name`, `photo`, `phone`, `email`, `date_of_birth`, `city`, `state`, `neighbourhood`, `pincode`, `password`, `status`, `school_type`, `monthly_budget`, `area`, `created_at`, `remember_token`) VALUES
(1, 'niya', NULL, '7217676540', 'bngd123@gmail.com', '2005-01-28', 'basai', 'delhi', NULL, '159647', NULL, 'Active', 'Boarding', 5000.00, '', '2025-02-17 10:18:13', '933f7e49a4cbf30f913004fdc83c9c7a6350c82bbabcfb1060b2155cd7c693db'),
(3, 'prachi', NULL, '9205018713', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Day', NULL, '', '2025-02-17 10:46:59', 'a84fc44bf3fcc36c1a40f00354415a860c14e63a3996fc209f52da98d1da0c5c'),
(4, 'Annu', NULL, '9234693132', NULL, NULL, 'Punjab', 'scv', NULL, '159647', NULL, 'Active', 'Boarding', 50000.00, '', '2025-02-17 11:33:54', '57dc3c23c55d2bda0ca87c19f5bdf073496db8ef6df92b527c41f28c64bcab47'),
(5, 'priya', NULL, '7701954154', NULL, NULL, 'nihalbihar', 'delhi', NULL, '234567', NULL, 'Active', 'Day', 20000.00, '', '2025-02-18 06:53:10', '8c304a98d6f676726c34525fc7010a0beed837bcc15884e45291bc8ee0754f92'),
(6, 'mayak', NULL, '9625014842', NULL, NULL, 'Delhi,india', 'haryana', NULL, '234567', NULL, 'Active', 'Day', NULL, '', '2025-02-18 10:25:36', '4de6ed5cdd99b782685ca31947181c6541c737c2545ef5624124dea8e1bc6672'),
(7, '', NULL, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 'Day', NULL, '', '2025-02-26 06:40:32', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_userchild`
--
ALTER TABLE `add_userchild`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_add_userchild_user` (`user_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_name` (`class_name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_structure`
--
ALTER TABLE `fee_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `review_categories`
--
ALTER TABLE `review_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_id` (`review_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_admission_enquiries`
--
ALTER TABLE `school_admission_enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_documents`
--
ALTER TABLE `school_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `school_facility`
--
ALTER TABLE `school_facility`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `school_language`
--
ALTER TABLE `school_language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `school_medias`
--
ALTER TABLE `school_medias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `school_quickfact`
--
ALTER TABLE `school_quickfact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_userchild`
--
ALTER TABLE `add_userchild`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `fee_structure`
--
ALTER TABLE `fee_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `review_categories`
--
ALTER TABLE `review_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `school_admission_enquiries`
--
ALTER TABLE `school_admission_enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `school_documents`
--
ALTER TABLE `school_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `school_facility`
--
ALTER TABLE `school_facility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `school_language`
--
ALTER TABLE `school_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `school_medias`
--
ALTER TABLE `school_medias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `school_quickfact`
--
ALTER TABLE `school_quickfact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_userchild`
--
ALTER TABLE `add_userchild`
  ADD CONSTRAINT `fk_add_userchild_user` FOREIGN KEY (`user_id`) REFERENCES `user_log` (`phone`) ON DELETE CASCADE;

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_categories`
--
ALTER TABLE `review_categories`
  ADD CONSTRAINT `review_categories_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_categories_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `fk_city_id` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `school_documents`
--
ALTER TABLE `school_documents`
  ADD CONSTRAINT `school_documents_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `school_facility`
--
ALTER TABLE `school_facility`
  ADD CONSTRAINT `school_facility_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_language`
--
ALTER TABLE `school_language`
  ADD CONSTRAINT `school_language_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_medias`
--
ALTER TABLE `school_medias`
  ADD CONSTRAINT `school_medias_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_quickfact`
--
ALTER TABLE `school_quickfact`
  ADD CONSTRAINT `school_quickfact_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
