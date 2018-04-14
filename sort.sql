-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2018 at 04:56 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donar_organs`
--

INSERT INTO `donar_organs` (`id`, `user_id`, `organ_id`, `status`) VALUES
(1, 17, 1, 1),
(2, 17, 2, 1),
(4, 17, 3, 0),
(5, 17, 4, 0),
(6, 19, 1, 0),
(7, 19, 2, 1),
(8, 19, 3, 1),
(9, 19, 4, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hosital_patient`
--

INSERT INTO `hosital_patient` (`id`, `hospital_id`, `patient_name`, `patient_id`, `dob`, `mobile`, `gender`, `health_conditon`) VALUES
(1, 20, 'Patient One hospital One ', '111111', '2018-04-04', '8765432345', 'Male', 'Health is totally weak'),
(2, 21, 'Patient Two', '2222', '2018-04-09', '5434673652', 'Female', '');

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
(1, 'Hospital One', 'loctn hos one', 'dist hos one', 'state  hos one', '9876543212', 'hospitalone@xxxx.com', 'www.hospitalone.com', 20),
(2, 'Hospital Two', 'loc hospital two', 'dist hospital two', 'stat hospital two', '9876543234', 'hospitaltwo@xxx.com', 'hospitaltwo.com', 21);

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
(1, 'Kidney', ''),
(2, 'Liver', ''),
(3, 'Lungs', ''),
(4, 'Pancreas', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_request`
--

INSERT INTO `patient_request` (`id`, `patient_id`, `organ_id`, `request`, `status`) VALUES
(1, 1, 1, '', 1),
(2, 1, 2, '', 1),
(3, 2, 1, '', 1),
(4, 2, 2, '', 1),
(5, 2, 3, '', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_details`
--

INSERT INTO `personal_details` (`id`, `user_id`, `name`, `dob`, `mobile`, `gender`, `house_name`, `location`, `district`, `state`, `blood_group`, `height`, `weight`, `blood_donatewilling`, `health_remark`) VALUES
(2, 17, 'Donar One', '2018-04-04', '9744574436', 'Male', 'House donar one ', 'Loctn  donar one ', 'Dist  donar one ', 'state  donar one ', 'A+', '180.00', '50.00', NULL, 'Good Health'),
(4, 19, 'Donar Two', '2018-04-13', '9876543211', 'Female', 'hou donar two', 'loc donar two', 'dist donar two', 'stat donar two', 'A-', '178.00', '79.00', NULL, 'healthy');

-- --------------------------------------------------------

--
-- Table structure for table `requested_donar`
--

CREATE TABLE IF NOT EXISTS `requested_donar` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `reply` varchar(300) NOT NULL,
  `requested_date` date NOT NULL,
  `reply_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `donar_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requested_donar`
--

INSERT INTO `requested_donar` (`id`, `request_id`, `reply`, `requested_date`, `reply_date`, `status`, `donar_id`) VALUES
(3, 5, '', '2018-04-14', '0000-00-00', 0, 19),
(4, 4, '', '2018-04-14', '0000-00-00', 0, 17);

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`, `status`) VALUES
(1, 'admin@xxx.com', 'admin', 'admin', 1),
(17, 'rahul.mohan@ipsrsolutions.com', 'ZYREKZCB', 'donar', 1),
(19, 'rahul.vmohan@gmail.com', 'BZVQSAKR', 'donar', 1),
(20, 'adminhospitalone@xxx.com', 'QICSZEUR', 'hospital', 1),
(21, 'adminhospitaltwo@xxx.com', 'LYDKBQLO', 'hospital', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donar_organs`
--
ALTER TABLE `donar_organs`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hosital_patient`
--
ALTER TABLE `hosital_patient`
  ADD PRIMARY KEY (`id`), ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `organs`
--
ALTER TABLE `organs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_request`
--
ALTER TABLE `patient_request`
  ADD PRIMARY KEY (`id`), ADD KEY `patient_id` (`patient_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `hosital_patient`
--
ALTER TABLE `hosital_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `personal_details`
--
ALTER TABLE `personal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `requested_donar`
--
ALTER TABLE `requested_donar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `donar_organs`
--
ALTER TABLE `donar_organs`
ADD CONSTRAINT `donar_organs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hosital_patient`
--
ALTER TABLE `hosital_patient`
ADD CONSTRAINT `hosital_patient_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
ADD CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_request`
--
ALTER TABLE `patient_request`
ADD CONSTRAINT `patient_request_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `hosital_patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `personal_details`
--
ALTER TABLE `personal_details`
ADD CONSTRAINT `personal_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
