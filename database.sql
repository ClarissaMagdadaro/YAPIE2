-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for arte_db
CREATE DATABASE IF NOT EXISTS `arte_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `arte_db`;

-- Dumping structure for table arte_db.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `product_id` varchar(20) NOT NULL,
  `price` int(50) NOT NULL,
  `qty` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_cart_users` (`user_id`),
  CONSTRAINT `FK_cart_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.cart: ~19 rows (approximately)
INSERT INTO `cart` (`id`, `user_id`, `product_id`, `price`, `qty`) VALUES
	(14, 4, '9', 20, '5'),
	(17, 9, '8', 20, '7'),
	(18, 8, '9', 20, '1'),
	(21, 14, '19', 50, '1'),
	(27, 17, '15', 20, '7'),
	(28, 17, '23', 20, '2'),
	(29, 18, '9', 20, '4'),
	(30, 19, '9', 20, '3'),
	(31, 20, '8', 20, '4'),
	(32, 21, '12', 30, '1'),
	(33, 22, '8', 20, '6'),
	(34, 22, '9', 20, '1'),
	(37, 26, '8', 20, '1'),
	(38, 27, '8', 20, '5'),
	(42, 29, '9', 20, '6'),
	(43, 29, '12', 30, '1'),
	(44, 30, '30', 12, '6'),
	(45, 32, '8', 20, '2'),
	(46, 32, '30', 12, '1');

-- Dumping structure for table arte_db.message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_message_users` (`user_id`),
  CONSTRAINT `FK_message_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.message: ~3 rows (approximately)
INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `subject`, `message`) VALUES
	(2, 3, 'Shan', 'shannonalysonpo831@gmail.com', 'what', 'sasfdasfsd'),
	(3, 3, 'Gian', '', 'adasda', 'asdasda'),
	(4, 3, 'Gian', 'gian@gmail.com', 'asdasd', 'asfsgdfgdh');

-- Dumping structure for table arte_db.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `seller_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `address_type` varchar(10) NOT NULL,
  `method` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `price` int(10) NOT NULL,
  `qty` int(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'in progress',
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `FK_orders_users` (`user_id`),
  KEY `FK_orders_sellers` (`seller_id`),
  KEY `FK_orders_products` (`product_id`),
  CONSTRAINT `FK_orders_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_orders_sellers` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.orders: ~28 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`, `payment_status`) VALUES
	(4, 3, 1, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 8, 20, 1, '2024-11-16', 'in progress', 'pending'),
	(5, 3, 2, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 12, 30, 1, '2024-11-16', 'in progress', 'pending'),
	(6, 3, 3, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 14, 20, 1, '2024-11-16', 'cancelled', 'pending'),
	(7, 3, 4, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 15, 20, 1, '2024-11-16', 'in progress', 'pending'),
	(8, 3, 3, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Taculing, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 14, 20, 1, '2024-11-17', 'in progress', 'pending'),
	(9, 3, 3, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Taculing, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 14, 20, 1, '2024-11-17', 'in progress', 'pending'),
	(10, 2, 5, 'Shannon Alyson Po', '1232345', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 17, 100, 10, '2024-11-20', 'in progress', 'pending'),
	(11, 2, 1, 'Shannon Alyson Po', '1232345', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 9, 20, 1, '2024-11-20', 'in progress', 'pending'),
	(12, 2, 1, 'Shannon Alyson Po', '1232345', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 8, 20, 1, '2024-11-20', 'in progress', 'pending'),
	(13, 2, 3, 'Shannon Alyson Po', '1232345', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 14, 20, 1, '2024-11-20', 'cancelled', 'pending'),
	(14, 5, 1, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 9, 20, 12, '2024-11-22', 'in progress', 'pending'),
	(15, 5, 2, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 12, 30, 6, '2024-11-22', 'in progress', 'pending'),
	(16, 10, 2, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 12, 30, 2, '2024-11-22', 'in progress', 'pending'),
	(17, 10, 5, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 17, 100, 12, '2024-11-22', 'in progress', 'pending'),
	(18, 11, 1, 'h', '1273894', 'ymajusta@gmail.com', 'asdf, asdf, asdfgh, Philippines, 6100', 'Home', 'Cash on Delivery', 8, 20, 1, '2024-11-22', 'in progress', 'pending'),
	(19, 15, 8, 'Shannon Alyson Po', '0956322952', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 20, 90, 15, '2024-11-22', 'in progress', 'pending'),
	(20, 16, 1, 'Shannon Alyson Po', '1234567890', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 8, 20, 1, '2024-11-22', 'cancelled', 'pending'),
	(21, 16, 1, 'Shannon Alyson Po', '1234567890', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 9, 20, 8, '2024-11-22', 'in progress', 'pending'),
	(22, 16, 3, 'Shannon Alyson Po', '1234567890', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 14, 20, 7, '2024-11-22', 'in progress', 'pending'),
	(23, 16, 9, 'Shannon Alyson Po', '1234567890', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 21, 90, 1, '2024-11-22', 'in progress', 'pending'),
	(24, 17, 10, 'Shannon Alyson Po', '12356789', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 23, 20, 1, '2024-11-22', 'in progress', 'pending'),
	(25, 23, 11, 'Shannon Alyson Po', '1234567890', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 27, 34, 14, '2024-11-22', 'in progress', 'pending'),
	(26, 23, 1, 'Shannon Alyson Po', '1234567890', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 9, 20, 5, '2024-11-22', 'in progress', 'pending'),
	(27, 28, 12, 'Shannon Alyson Po', '2678909876', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 28, 50, 6, '2024-11-22', 'in progress', 'pending'),
	(28, 28, 1, 'Shannon Alyson Po', '2678909876', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 8, 20, 8, '2024-11-22', 'in progress', 'pending'),
	(29, 28, 5, 'Shannon Alyson Po', '2678909876', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 17, 100, 6, '2024-11-22', 'in progress', 'pending'),
	(31, 31, 1, 'DM', '0912345678', 'any@any.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, Philippines, 6100', 'Home', 'Cash on Delivery', 8, 20, 1, '2024-11-22', 'in progress', 'pending'),
	(32, 33, 14, 'Shannon Alyson Po', '0977318110', 'shannonalysonpo831@gmail.com', 'St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, St. John St. Anthony, Dona Juliana Subd., Brgy. Ta, Bacolod City, PH, 6100', 'Home', 'Cash on Delivery', 33, 30, 1, '2024-11-22', 'cancelled', 'pending');

-- Dumping structure for table arte_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `seller_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_products_sellers` (`seller_id`),
  CONSTRAINT `FK_products_sellers` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.products: ~22 rows (approximately)
INSERT INTO `products` (`id`, `seller_id`, `name`, `price`, `image`, `stock`, `product_detail`, `status`) VALUES
	(8, 1, 'Lumine', 20, 'lumine.png', 20, 'Sticker of Lumine from Genshin Impact', 'active'),
	(9, 1, 'Venti', 20, 'venti.png', 20, 'Sticker of Venti from Genshin Impact', 'active'),
	(12, 2, 'venti', 30, 'venti.png', 100, 'bbboi', 'active'),
	(13, 2, 'New jeans', 25, 'supershy logo.png', 20, 'balbalbaa', 'deactive'),
	(14, 3, 'Zhongli', 20, 'Bees.jpg', 100, 'kajdsbfvksdkvbsajhafadf&#39;', 'active'),
	(15, 4, 'Amber', 20, 'amber.png', 100, 'anzmnam', 'active'),
	(16, 4, 'Lumine', 30, 'lumine.png', 20, 'smhkgcbjsbdc', 'deactive'),
	(17, 5, 'sdgsfg', 100, 'Encore.png', 12, 'asdasfafd', 'active'),
	(18, 6, 'Lumine', 20, 'F_Rover.png', 0, '&#39;o', 'active'),
	(19, 7, 'Gian', 50, 'gian.jpg', 100, 'cfghfgj', 'active'),
	(20, 8, 'Furina', 90, 'furina.png', 80, 'sdfghjk', 'active'),
	(21, 9, 'Venti', 90, 'venti.png', 2, 'asdfghj', 'active'),
	(23, 10, 'ganyu', 60, 'ganyu.png', 2, 'dsfdgfh', 'active'),
	(24, 10, 'gh', 12, 'albedo.png', 3, 'nkbhj', 'active'),
	(25, 10, '120', 90, 'baizhu.png', 5, 'njbj', 'active'),
	(26, 10, 'gh', 12, 'ayaka.png', 6, 'dsrdft', 'deactive'),
	(27, 11, 'Shannon', 34, 'Kamiyo.png', 56, 'dgcfhfgh', 'active'),
	(28, 12, 'Dandadan', 50, 'dandadan.jpg', 6, 'asfddhfghhgh', 'active'),
	(29, 12, 'Lumine', 30, 'love.jpg', 30, 'afdg', 'deactive'),
	(30, 12, 'as', 12, 'clarissa.jpg', 6, 'asr', 'active'),
	(32, 13, 'Diluc', 99999, 'diluc.png', 999, 'Diluc the Pyro Swordsman Dark Knight', 'active'),
	(33, 14, 'asd', 30, 'diona.png', 6, 'asd', 'active');

-- Dumping structure for table arte_db.sellers
CREATE TABLE IF NOT EXISTS `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.sellers: ~14 rows (approximately)
INSERT INTO `sellers` (`id`, `name`, `email`, `password`, `image`) VALUES
	(1, 'Shannon', 's2121441@usls.edu.ph', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6728ecd16fc86.png'),
	(2, 'Shannon', 's@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '672aca2d5098a.jpg'),
	(3, 'Shannon', 's21@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '672c1ea8cc824.png'),
	(4, 'Shannon Po', 's@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '672c291d2e35d.png'),
	(5, 'ClarissaMagdadaro', 'clarissamagdadaro@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673d42b2e6431.jpg'),
	(6, 'Shannon', 's2121@usls.edu.ph', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673d55b708eff.png'),
	(7, 'boy bwang', 's2120174@usls.edu.ph', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fe82d1b215.jpg'),
	(8, 'bruno', 'k2@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '673fef90ddb77.jpg'),
	(9, 'Gian', 'SFG@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673ff56eb0642.png'),
	(10, 'aydel', 'han@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673ff80ead4e0.png'),
	(11, 'nasd', 'el@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '674005ae43ee5.png'),
	(12, 'Paul', 'paul@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '67400f2a0e1b6.png'),
	(13, 'MrCrawling', 'MrCrawlingIsBaby@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '674016638a03a.jpg'),
	(14, 'm', 'm1@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '67403910b6fe3.png');

-- Dumping structure for table arte_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.users: ~33 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
	(1, 'Shannon Po', 'spo@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'furina.png'),
	(2, 'Kamiyo', 'k@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'venti.png'),
	(3, 'Gian', 'gian@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6733759216773.jpg'),
	(4, 'Shannon', 'tuyonko@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fa2b5563d2.jpg'),
	(5, 'blue', 'blue@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fb241bed9d.jpg'),
	(6, 'shannon po', 'po@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fdf92c9560.jpg'),
	(7, 'Shannon Alyson Po', 'popo@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fdfd81fcef.webp'),
	(8, 'Clarissa', 'cla10@gmaiil.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fe442adedc.jpg'),
	(9, 'Li', 'lifelish99@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fe571beaaf.jpg'),
	(10, 'boy bawang', 's2120174@usls.edu.ph', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fe7b35eed6.jpg'),
	(11, 'mj', 'ymajusta@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fe9506cb5a.jpg'),
	(12, 'Mab', 's2300919@usls.edu.ph', '542378b27970dd14a8b9cfaeea24ee77952e234a', '673fea7c66fbd.jpg'),
	(13, 'wd', 's1920250@usls.edu.ph', '2766c00e9e8e0f5f5c50df0fcb36cf65bfe74857', '673feca76b4a6.png'),
	(14, 'j', 'j@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fed42e0c51.jpg'),
	(15, 'bruno', 'k1@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673fef4aa67b5.jpg'),
	(16, 'Gian', '12@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673ff5cbc45d7.png'),
	(17, 'Venti', 'venti@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673ff8616e2e4.png'),
	(18, 'roed', 's2121526@usls.edu.ph', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673ffae8ba6a8.png'),
	(19, 'Venus ', 'angel.strassert@gmail.com', 'c9b359951c09c5d04de4f852746671ab2b2d0994', '673ffcf016254.png'),
	(20, 'fi', 'gi@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '673ffe2e1b41d.png'),
	(21, 'aydel', 'aydel@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '674000a7aeb07.png'),
	(22, 'Alvin', 'a@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6740032a5b34c.png'),
	(23, 'Shannon', 'sha@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6740062748259.png'),
	(24, 'Kirby', 'kirby@gmail.com', 'c3ca1b10701e96cbe6fa29bd0758afe289dd98d8', '674007f1159ae.jpg'),
	(25, 'KIrby', 'kirby1@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '6740082b80d56.jpg'),
	(26, 'roger', 'r.intong@usls.edu.ph', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '67400cb29c3e4.png'),
	(27, 'nadia', 'nads@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '67400d59577ad.jpg'),
	(28, 'mika', 'mika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6740101aaefb2.jpg'),
	(29, 'as', 'as@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '6740130d2ae7f.png'),
	(30, 'Mr Hood', 'MrCrawlingIsBaby@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '674017c9abec2.webp'),
	(31, 'Dee Em', 'dmdcade@gmail.com', '5cec175b165e3d5e62c9e13ce848ef6feac81bff', '67401e9b4e119.jpg'),
	(32, 'Mark', 'm@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', '67402967b53b7.png'),
	(33, 'qw', 'qw@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '67403966a9091.png');

-- Dumping structure for table arte_db.wishlist
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `price` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_wishlist_users` (`user_id`),
  KEY `FK_wishlist_products` (`product_id`),
  CONSTRAINT `FK_wishlist_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_wishlist_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table arte_db.wishlist: ~15 rows (approximately)
INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
	(1, 3, 8, 20),
	(2, 3, 12, 30),
	(3, 3, 14, 20),
	(5, 2, 9, 20),
	(6, 5, 14, 20),
	(7, 5, 12, 30),
	(8, 5, 15, 20),
	(9, 15, 12, 30),
	(10, 17, 8, 20),
	(12, 21, 9, 20),
	(13, 27, 9, 20),
	(14, 28, 14, 20),
	(15, 28, 17, 100),
	(16, 29, 14, 20),
	(17, 32, 9, 20);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    media VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    email VARCHAR(50),
    profile_pic VARCHAR(255)
);

ALTER TABLE posts
ADD COLUMN starting_price DECIMAL(10, 2) NOT NULL,
ADD COLUMN bidding_end_date DATETIME NOT NULL;

