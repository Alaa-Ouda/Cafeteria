-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2015 at 02:38 AM
-- Server version: 5.5.37-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cafeteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `is_deleted`) VALUES
(1, 'Hot Drinks', '0'),
(2, 'Cold Drinks', '0');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` datetime NOT NULL,
  `order_status` enum('0','1','2') NOT NULL DEFAULT '0',
  `order_notes` varchar(200) NOT NULL,
  `room_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `fk_userOrder` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `order_status`, `order_notes`, `room_no`, `user_id`, `is_deleted`) VALUES
(1, '2015-04-11 15:57:15', '1', 'sssssssssssss', 1234, 3, '0'),
(2, '2015-04-11 15:58:15', '0', 'bbbbbbbbbbbbbbbbbbb', 1234, 2, '0'),
(3, '2015-04-11 16:59:53', '0', 'tea with suger', 1234, 3, '0'),
(4, '2015-04-11 17:17:50', '0', 'coffee with milk', 5678, 3, '0'),
(5, '2015-04-11 17:18:52', '0', 'coffee with milk', 1234, 2, '1'),
(6, '2015-04-11 19:14:10', '0', '', 1234, 2, '0'),
(7, '2015-04-11 19:32:07', '1', '', 1234, 3, '0'),
(8, '2015-04-11 19:35:15', '1', '', 1234, 3, '0'),
(9, '2015-04-11 23:00:31', '1', '', 5678, 2, '0'),
(10, '2015-04-11 23:01:29', '0', '', 5678, 2, '0'),
(12, '2015-04-12 14:48:19', '1', '', 1234, 2, '0'),
(13, '2015-04-12 18:37:02', '1', '', 1234, 3, '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE IF NOT EXISTS `order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_amount` int(11) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_proOrder` (`pro_id`),
  KEY `fk_order` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `pro_id`, `pro_amount`, `is_deleted`) VALUES
(1, 3, 3, 2, '0'),
(2, 3, 4, 2, '0'),
(3, 4, 3, 1, '0'),
(4, 4, 4, 2, '0'),
(5, 5, 4, 2, '0'),
(6, 5, 5, 1, '0'),
(7, 6, 5, 1, '0'),
(8, 6, 4, 2, '0'),
(9, 6, 3, 2, '0'),
(10, 7, 5, 1, '0'),
(11, 7, 4, 1, '0'),
(12, 8, 8, 2, '0'),
(13, 8, 7, 2, '0'),
(14, 9, 4, 2, '0'),
(15, 10, 3, 1, '0'),
(16, 12, 6, 2, '0'),
(17, 13, 5, 2, '0');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_name` varchar(30) NOT NULL,
  `pro_price` double NOT NULL,
  `pro_status` enum('0','1') NOT NULL,
  `pro_image` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`pro_id`),
  KEY `fk_catPro` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_price`, `pro_status`, `pro_image`, `cat_id`, `is_deleted`) VALUES
(3, 'tea', 5, '1', 'imgs/products/tea.jpeg', 1, '0'),
(4, 'coffee', 7, '1', 'imgs/products/coffee.jpeg', 1, '0'),
(5, 'greentea', 5, '1', 'imgs/products/greentea.jpeg', 1, '0'),
(6, 'nescafe', 7, '1', 'imgs/products/nescafe.jpeg', 1, '0'),
(7, 'cappuccino', 8, '1', 'imgs/products/cappuccino.jpeg', 1, '0'),
(8, 'lemon', 5, '1', 'imgs/products/lemon.jpeg', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_pass` char(32) NOT NULL,
  `user_mail` varchar(30) NOT NULL,
  `room_no` int(11) NOT NULL,
  `room_ext` varchar(10) NOT NULL,
  `user_type` enum('0','1') NOT NULL DEFAULT '0',
  `user_image` varchar(100) NOT NULL,
  `is_deleted` enum('0','1','','') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_mail`, `room_no`, `room_ext`, `user_type`, `user_image`, `is_deleted`) VALUES
(1, 'Alaa', '81dc9bdb52d04dc20036dbd8313ed055', 'alaaouda@gmail.com', 1234, '1010', '1', '104_png', '0'),
(2, 'Hoda', '81dc9bdb52d04dc20036dbd8313ed055', 'hoda@hoda.com', 5678, '2020', '0', '451_jpg', '0'),
(3, 'Yasmine', '81dc9bdb52d04dc20036dbd8313ed055', 'yas@yas.com', 9876, '3030', '0', '497_jpg', '0'),
(4, 'Noha', '81dc9bdb52d04dc20036dbd8313ed055', 'noha@noha.com', 6754, '4040', '0', '1428968168_jpg', '0');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_userOrder` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `fk_proOrder` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_catPro` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
