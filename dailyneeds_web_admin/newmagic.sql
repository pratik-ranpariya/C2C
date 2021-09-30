-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 01, 2020 at 07:01 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newmagic`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_adminpanel`
--

DROP TABLE IF EXISTS `login_adminpanel`;
CREATE TABLE IF NOT EXISTS `login_adminpanel` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_adminpanel`
--

INSERT INTO `login_adminpanel` (`username`, `password`) VALUES
('magictshirt', 'Server@786');

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

DROP TABLE IF EXISTS `qr_codes`;
CREATE TABLE IF NOT EXISTS `qr_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qr_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `qr_code`) VALUES
(1, '1111'),
(2, '2222'),
(3, '3333'),
(4, '4444'),
(5, '55555');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `device_id` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `mobile_number`, `device_id`, `is_active`) VALUES
(23, 'Akash', '8460772313', 'f5e93dbd04f5b936', 0),
(22, 'Hitarth', '7990947625', 'e03a85d9436b3ed8', 1),
(20, 'Shail', '9510978321', '138a49c89287756d', 1),
(4, 'vasu', '4651652460', 'fsd435rsdf', 1),
(24, 'vasu', '4651652460', 'fsd435rsdf', 1),
(25, 'vasu', '4651652460', 'fsd435rsdf', 1),
(26, 'vasu', '4651652460', 'fsd435rsdf', 1),
(27, 'vasu', '4651652460', 'fsd435rsdf', 1),
(28, 'vasu', '4651652460', 'fsd435rsdf', 0),
(29, 'vasu', '4651652460', 'fsd435rsdf', 0),
(30, 'vasu', '4651652460', 'fsd435rsdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_to_qr_codes`
--

DROP TABLE IF EXISTS `users_to_qr_codes`;
CREATE TABLE IF NOT EXISTS `users_to_qr_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `qr_code_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_to_qr_codes`
--

INSERT INTO `users_to_qr_codes` (`id`, `user_id`, `qr_code_id`) VALUES
(19, 22, 4),
(18, 23, 1),
(17, 22, 2),
(15, 20, 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
