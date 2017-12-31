# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.0.21-MariaDB)
# Database: phalcon_rest_boilerplate
# Generation Time: 2016-02-28 12:01:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) DEFAULT '',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `token` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `user_id` integer unsigned,
  `role_id` integer unsigned,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(user_id)  references users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(role_id)  references roles(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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


DROP TABLE IF EXISTS `regions`;

CREATE TABLE `regions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `drivers`;

CREATE TABLE `drivers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` integer unsigned,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(user_id)  references users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `order_statuses`;

CREATE TABLE `order_statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `car_id` integer unsigned,
  `country_id` integer unsigned,
  `driver_id` integer unsigned,
  `passanger_id` integer unsigned,
  `region_id` integer unsigned,
  `status_id` integer unsigned,
   FOREIGN KEY(car_id)  references cars(id) ON UPDATE CASCADE ON DELETE CASCADE,
   FOREIGN KEY(driver_id)  references drivers(id) ON UPDATE CASCADE ON DELETE CASCADE,
   FOREIGN KEY(country_id)  references countries(id) ON UPDATE CASCADE ON DELETE CASCADE,
   FOREIGN KEY(passanger_id)  references user(id) ON UPDATE CASCADE ON DELETE CASCADE,
   FOREIGN KEY(region_id)  references regions(id) ON UPDATE CASCADE ON DELETE CASCADE,
   FOREIGN KEY(status_id)  references order_statuses(id) ON UPDATE CASCADE ON DELETE CASCADE,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `order_detail`;

CREATE TABLE `order_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` integer unsigned,
  `baby_chair` varchar(10) DEFAULT '',
  `duration` varchar(10) DEFAULT '',
  `callMe` ENUM('0','1') DEFAULT '0',
  `pets` ENUM('0','1') DEFAULT '0',
  `differed_payment` TINYINT(2) unsigned,
  `large` TINYINT(2) unsigned,
  `pass_count` TINYINT(2) unsigned,
  `pass_phone` varchar(255) NOT NULL,
  `extension` TIME DEFAULT NULL,
  `start_time` DATETIME DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  FOREIGN KEY(order_id)  references orders(id) ON UPDATE CASCADE ON DELETE CASCADE,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users_map_point_orders`;

CREATE TABLE `users_map_point_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` integer unsigned,
  `order_id` integer unsigned,
  `adress` varchar(255) NOT NULL,
  `lat` DECIMAL(9,6) NOT NULL,
  `lon` DECIMAL(9,6) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(user_id)  references users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(order_id)  references orders(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `orders_map_points`;

CREATE TABLE `orders_map_points` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` integer unsigned,
  `adress` varchar(255) NOT NULL,
  `lat` DECIMAL(9,6) NOT NULL,
  `lon` DECIMAL(9,6) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  FOREIGN KEY(order_id)  references orders(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
