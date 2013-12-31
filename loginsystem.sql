-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2013 at 04:56 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loginsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `connection`
--

CREATE TABLE IF NOT EXISTS `connection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projects_id` int(11) NOT NULL,
  `register_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`projects_id`,`register_id`),
  KEY `fk_connection_projects1_idx` (`projects_id`),
  KEY `fk_connection_register1_idx` (`register_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `connection`
--

INSERT INTO `connection` (`id`, `projects_id`, `register_id`) VALUES
(2, 14, 7),
(3, 14, 7),
(4, 14, 8),
(7, 14, 13),
(11, 14, 3),
(18, 14, 2),
(8, 15, 0),
(12, 15, 3),
(13, 16, 3),
(14, 17, 3),
(10, 18, 2),
(15, 18, 3),
(16, 19, 3),
(17, 20, 3),
(9, 22, 0),
(5, 25, 8),
(6, 29, 13);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summary` varchar(140) DEFAULT NULL,
  `details` text,
  `type` varchar(60) DEFAULT NULL,
  `box_price` varchar(45) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `ratio` int(11) DEFAULT NULL,
  `payment_plan` varchar(40) DEFAULT NULL,
  `agent_connection_count` tinyint(4) DEFAULT NULL,
  `agent_acc` int(5) NOT NULL,
  `buyer_seller_connection_count` tinyint(4) DEFAULT NULL,
  `buyer_seller_acc` int(5) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `summary`, `details`, `type`, `box_price`, `location`, `ratio`, `payment_plan`, `agent_connection_count`, `agent_acc`, `buyer_seller_connection_count`, `buyer_seller_acc`, `owner_id`) VALUES
(14, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 0),
(15, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(16, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(17, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(18, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(19, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(20, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(21, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(22, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(23, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(24, ' sdf', 'sdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 4),
(25, ' sfsdf', 'sdfsdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 7),
(26, ' sfsdf', 'sdfsdf', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 7),
(27, ' ravindra', 'singh', 'apartment', '', '', 0, 'construction_linked', 0, 0, 0, 0, 8),
(28, ' sdf', 'sdf', 'apartment', '', 'jaipur', 0, 'construction_linked', 0, 0, 0, 0, 12),
(29, ' testing connection notification', 'details', 'apartment', '', 'jaipur', 0, 'construction_linked', 0, 0, 0, 0, 13),
(30, ' test man', ' projects', 'apartment', '', 'jaipur', 23, 'construction_linked', 0, 0, 0, 0, 0),
(31, ' sas', ' sasa', 'apartment', '', 'jaipur', 25, 'flexi', 0, 0, 0, 0, 2),
(32, ' sas', ' sasa', 'apartment', '', 'jaipur', 25, 'flexi', 0, 0, 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE IF NOT EXISTS `register` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `passcode` varchar(100) NOT NULL,
  `loginwith` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`userid`, `firstname`, `lastname`, `email`, `password`, `passcode`, `loginwith`, `status`) VALUES
(2, 'Rituraj', 'Ratan', 'riturajratan@gmail.com', 'test@123', '', 'Main', 'active'),
(3, 'ravin', 'desire', 'test@gmail.com', 'test@123', '', 'Main', 'active'),
(4, 'rituraj', 'ratan', 'riturajratan@gmail.com', 'rDc3VWamlW', '', 'LinkedIn', 'active'),
(5, 'rituraj', 'ratan', 'riturajratan@gmail.com', 'rDc3VWamlW', '', 'LinkedIn', 'active'),
(6, 'rituraj', 'ratan', 'riturajratan@gmail.com', 'rDc3VWamlW', '', 'LinkedIn', 'active'),
(7, 'rituraj', 'ratan', 'riturajratan@gmail.com', 'rDc3VWamlW', '', 'LinkedIn', 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
