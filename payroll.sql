-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2014 at 04:12 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE IF NOT EXISTS `deductions` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `Amount` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `pid`, `Amount`) VALUES
(1, 1, 50),
(2, 1, 50),
(3, 1, 50),
(1, 2, 0),
(2, 2, 100),
(3, 2, 0),
(1, 6, 0),
(2, 6, 0),
(3, 6, 0),
(1, 7, 100),
(2, 7, 100),
(3, 7, 100),
(1, 26, 0),
(2, 26, 50),
(3, 26, 0),
(1, 27, 50),
(2, 27, 50),
(3, 27, 50),
(1, 29, 0),
(2, 29, 0),
(3, 29, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deduction_names`
--

CREATE TABLE IF NOT EXISTS `deduction_names` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `deduc_name` varchar(20) NOT NULL,
  PRIMARY KEY (`did`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `deduction_names`
--

INSERT INTO `deduction_names` (`did`, `deduc_name`) VALUES
(1, 'SSS'),
(2, 'Philhealth'),
(3, 'Pag-ibig');

-- --------------------------------------------------------

--
-- Table structure for table `dtr`
--

CREATE TABLE IF NOT EXISTS `dtr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empid` varchar(20) NOT NULL,
  `am_in` varchar(11) NOT NULL,
  `am_out` varchar(11) NOT NULL,
  `pm_in` varchar(11) NOT NULL,
  `pm_out` varchar(11) NOT NULL,
  `jDay` varchar(11) NOT NULL,
  `jYear` varchar(11) NOT NULL,
  `jMonth` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `dtr`
--

INSERT INTO `dtr` (`id`, `empid`, `am_in`, `am_out`, `pm_in`, `pm_out`, `jDay`, `jYear`, `jMonth`) VALUES
(8, '2014-L8171OP', '09:00 am', '12:05 pm', '12:58 pm', '17:00', '18', '2014', '04'),
(9, '2014-K4110SJ', '08:00 am', '12:05 pm', '12:58 pm', '17:00', '18', '2014', '05'),
(10, '2014-D2259MA', '08:30 am', '12:05 pm', '12:58 pm', '17:00', '18', '2014', '05'),
(11, '2014-O1527JA', '08:30 am', '12:05 pm', '12:58 pm', '17:00', '18', '2014', '04'),
(13, '2014-O1527JA', '08:00 am', '12:05 pm', '13:05 pm', '17:00', '18', '2014', '04'),
(15, '2014-P6403KA', '08:30', '12:05 pm', '12:48', '16:50', '19', '2014', '05'),
(21, '2014-P6403KA', '03:50', '0', '0', '0', '02', '2014', '05'),
(22, '2014-D2259MA', '03:51', '03:52', '0', '0', '02', '2014', '05');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `empID` varchar(20) NOT NULL,
  `Fname` varchar(20) NOT NULL,
  `Mname` varchar(20) NOT NULL,
  `Lname` varchar(20) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Position` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `empID`, `Fname`, `Mname`, `Lname`, `Address`, `Position`, `status`) VALUES
(3, '2014-K4110SJ', 'Wang Lo', 'Jung', 'Kim', 'Korea, Eastern Samar', '2', 'Active'),
(4, '2014-L8171OP', 'Oliver', 'Pelenio', 'Lacabe', 'San Miguel, Leyte', '1', 'Active'),
(5, '2014-D2259MA', 'Mary Jude Wanda', 'Ambot', 'Deguito', 'San Jose, Tacloban City', '27', 'Active'),
(6, '2014-O1527JA', 'Joy', 'Ambot', 'Octaviano', 'San Jose, Tacloban City', '7', 'Active'),
(7, '2014-P6403KA', 'Kristel Jane', 'Ambot', 'Pesidas', 'Baybay, Leyte', '6', 'Active'),
(8, '2014-L7124WA', 'Willam', 'Abellanosa', 'Lopez', 'Palo, Leyte', '26', 'Active'),
(9, '2014-M5854KG', 'Kimberly', 'Gobangco', 'Moreno', 'Dulag, Leyte', '1', 'Active'),
(10, '2014-B9019RE', 'Rolaine', 'Estopin', 'Bedua', 'Sta. Fe, Leyte', '26', 'Active'),
(11, '2014-S8232GP', 'Gregorio', 'Pesidas', 'Sonit', 'Eschooner', '29', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `Pname` varchar(20) NOT NULL,
  `Salary` decimal(20,0) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`pid`, `Pname`, `Salary`) VALUES
(1, 'Manager', 400),
(2, 'Promodizer', 260),
(6, 'Clerk', 260),
(7, 'Supervisor', 450),
(26, 'Boy', 260),
(27, 'Driver', 270),
(29, 'Security guard', 300);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `empID` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `position` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `empID`, `username`, `password`, `position`) VALUES
(1, '4', 'vladz', 'vladz', 'Manager'),
(3, '6', 'Joy', 'joy', 'Supervisor');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
