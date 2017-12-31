# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.0.21-MariaDB)
# Database: restTaxi
# Generation Time: 2016-02-28 12:01:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `wishes`;

CREATE TABLE `wishes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `wishes` WRITE;
/*!40000 ALTER TABLE `wishes` DISABLE KEYS */;

INSERT INTO `wishes` (`name`,  `created_at`)
VALUES
	('wish1', now()),
	('wish2', now());

/*!40000 ALTER TABLE `wishes` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `users_wishes`;

CREATE TABLE `users_wishes` (
  `user_id` integer unsigned,
  `wish_id` integer unsigned,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(user_id)  references users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(wish_id)  references wishes(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


LOCK TABLES `users_wishes` WRITE;
/*!40000 ALTER TABLE `users_wishes` DISABLE KEYS */;

INSERT INTO `users_wishes` (`user_id`, `wish_id`)
VALUES
	(1,1),
	(1,2);

/*!40000 ALTER TABLE `users_wishes` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `payment_types`;

CREATE TABLE `payment_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `payment_types` WRITE;
/*!40000 ALTER TABLE `payment_types` DISABLE KEYS */;

INSERT INTO `payment_types` (`name`,  `created_at`)
VALUES
	('cash', now()),
	('card', now());

/*!40000 ALTER TABLE `payment_types` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `orders_payments`;

CREATE TABLE `orders_payments` (
  `order_id` integer unsigned,
  `payment_type_id` integer unsigned,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(order_id)  references orders(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(payment_type_id)  references payment_types(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


LOCK TABLES `orders_payments` WRITE;
/*!40000 ALTER TABLE `orders_payments` DISABLE KEYS */;

INSERT INTO `orders_payments` (`order_id`, `payment_type_id`)
VALUES
	(1,1),
	(1,2);

/*!40000 ALTER TABLE `orders_payments` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `cars`;

CREATE TABLE `cars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` ENUM('0','1') DEFAULT '0',
  `color` varchar(255) NOT NULL,
  `reg_number` varchar(255) NOT NULL,
  `year` char(4) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `planting_costs` varchar(50) NOT NULL,
  `costs_per_1` varchar(50) NOT NULL,
  `car_photo` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;

INSERT INTO `cars` (`id`, `status`, `color`, `reg_number`, `year`, `brand`, `model`, `currency`, `planting_costs`, `costs_per_1`, `car_photo`, `created_at`)
VALUES
	(32, 1,'red', '13565', '1959', 'volvo', 'x5', 'ert', 'planting_costs', 'cost_per_1', '/public/images/photo/car32', now()),
	(12, 1,'red', '13565', '1959', 'volvo', 'x5', 'ert', 'planting_costs', 'cost_per_1', '/public/images/photo/car32', now());
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;

INSERT INTO `countries` (`id`, `name`, `created_at`, `code`)
VALUES
	(13, 'Ukraine', now(), 'UA'),
    (4, 'Moldova', now(), 'MD');
    	/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `drivers`;

CREATE TABLE `drivers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` integer unsigned,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(user_id)  references users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `drivers` WRITE;
/*!40000 ALTER TABLE `drivers` DISABLE KEYS */;

INSERT INTO `drivers` (`user_id`)
VALUES
	(1);
    	/*!40000 ALTER TABLE `drivers` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `regions`;

CREATE TABLE `regions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;

INSERT INTO `regions` (`name`)
VALUES
	('Dnipropetrovska');
    	/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
