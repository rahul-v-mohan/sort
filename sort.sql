-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2018 at 04:21 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sort`
--

-- --------------------------------------------------------

--
-- Table structure for table `donar_organs`
--

CREATE TABLE IF NOT EXISTS `donar_organs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organ_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT 'avil/unavil/'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donar_organs`
--

INSERT INTO `donar_organs` (`id`, `user_id`, `organ_id`, `status`) VALUES
(1, 8, 2, 0),
(2, 9, 1, 1),
(3, 9, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hosital_patient`
--

CREATE TABLE IF NOT EXISTS `hosital_patient` (
  `id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL COMMENT 'user_id',
  `patient_name` varchar(60) NOT NULL,
  `patient_id` varchar(60) NOT NULL,
  `dob` date NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `health_conditon` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hosital_patient`
--

INSERT INTO `hosital_patient` (`id`, `hospital_id`, `patient_name`, `patient_id`, `dob`, `mobile`, `gender`, `health_conditon`) VALUES
(1, 6, 'patient', 'patientid', '1991-12-23', '5555555555', 'Male', 'patienthealthcondition');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE IF NOT EXISTS `hospital` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(50) NOT NULL,
  `location` varchar(60) NOT NULL,
  `district` varchar(60) NOT NULL,
  `state` varchar(60) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `email_hospital` varchar(60) NOT NULL,
  `website_url` varchar(60) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`id`, `hospital_name`, `location`, `district`, `state`, `mobile`, `email_hospital`, `website_url`, `user_id`) VALUES
(2, 'etr', 'fghfg', 'fghr', 'erty', '4564564564', 'hospital@xxx.com', '456fghfg', 6);

-- --------------------------------------------------------

--
-- Table structure for table `organs`
--

CREATE TABLE IF NOT EXISTS `organs` (
  `id` int(11) NOT NULL,
  `organ` varchar(60) NOT NULL,
  `type` varchar(30) NOT NULL COMMENT 'before death/ after death'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organs`
--

INSERT INTO `organs` (`id`, `organ`, `type`) VALUES
(1, 'Heart', '1'),
(2, 'Kidney', '0'),
(3, 'Pancreas', '1'),
(4, 'Liver', '0');

-- --------------------------------------------------------

--
-- Table structure for table `patient_request`
--

CREATE TABLE IF NOT EXISTS `patient_request` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `organ_id` int(11) NOT NULL,
  `request` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_request`
--

INSERT INTO `patient_request` (`id`, `patient_id`, `organ_id`, `request`, `status`) VALUES
(3, 1, 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_details`
--

CREATE TABLE IF NOT EXISTS `personal_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `dob` date NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `gender` varchar(12) NOT NULL,
  `house_name` varchar(120) NOT NULL,
  `location` varchar(120) NOT NULL,
  `district` varchar(80) NOT NULL,
  `state` varchar(80) NOT NULL,
  `blood_group` varchar(6) NOT NULL,
  `height` decimal(6,2) NOT NULL,
  `weight` decimal(6,2) NOT NULL,
  `blood_donatewilling` tinyint(11) DEFAULT NULL COMMENT 'willingness',
  `health_remark` varchar(250) NOT NULL COMMENT 'general remark'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`id`, `user_id`, `name`, `dob`, `mobile`, `gender`, `house_name`, `location`, `district`, `state`, `blood_group`, `height`, `weight`, `blood_donatewilling`, `health_remark`) VALUES
(1, 7, 'Raul Donar', '2018-03-01', '3333333333', 'Male', 'hous', 'loc', 'dist', 'ker', 'A+', '170.00', '75.00', NULL, ''),
(2, 8, 'Donar', '2018-03-27', '9876543210', 'Male', 'testhouse', 'testlocation', 'testdist', 'teststat', 'AB+', '175.00', '60.00', NULL, 'Good health condition'),
(3, 9, 'Rahul V Mohan', '2018-04-03', '9744574436', 'Male', 'hou', 'loc', 'dist', 'stat', 'B+', '133.00', '44.00', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `requested_donar`
--

CREATE TABLE IF NOT EXISTS `requested_donar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `reply` varchar(300) NOT NULL,
  `requested_date` date NOT NULL,
  `reply_date` date NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`, `status`) VALUES
(2, 'admin@xxx.com', 'admin', 'admin', 1),
(3, 'rahul@x.com', 'admin', 'donar', 0),
(6, 'hospital@xxx.com', 'admin', 'hospital', 1),
(7, 'donar@xxx.com', 'admin', 'donar', 1),
(8, 'donartest@xxx.com', 'admin', 'donar', 1),
(9, 'donar1@xxx.com', 'admin', 'donar', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donar_organs`
--
ALTER TABLE `donar_organs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hosital_patient`
--
ALTER TABLE `hosital_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organs`
--
ALTER TABLE `organs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_request`
--
ALTER TABLE `patient_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_details`
--
ALTER TABLE `personal_details`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `requested_donar`
--
ALTER TABLE `requested_donar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donar_organs`
--
ALTER TABLE `donar_organs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hosital_patient`
--
ALTER TABLE `hosital_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `organs`
--
ALTER TABLE `organs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `patient_request`
--
ALTER TABLE `patient_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `personal_details`
--
ALTER TABLE `personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `requested_donar`
--
ALTER TABLE `requested_donar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `personal_details`
--
ALTER TABLE `personal_details`
ADD CONSTRAINT `personal_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
