-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `cviceni02a` /*!40100 DEFAULT CHARACTER SET utf16 COLLATE utf16_czech_ci */;
USE `cviceni02a`;

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf16_czech_ci NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `order` (`id`, `name`, `price`, `quantity`, `user_id`) VALUES
(2,	'Rum',	20,	10,	5);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` text COLLATE utf16_czech_ci NOT NULL,
  `firstname` text COLLATE utf16_czech_ci NOT NULL,
  `registered` datetime NOT NULL,
  `is_admin` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `user` (`id`, `surname`, `firstname`, `registered`, `is_admin`) VALUES
(3,	'Big',	'Brother',	'0000-00-00 00:00:00',	1),
(4,	'Breburda',	'Kvana',	'0000-00-00 00:00:00',	0),
(5,	'Gogo',	'Ochlastovic',	'0000-00-00 00:00:00',	0);
