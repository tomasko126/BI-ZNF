-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `tarotoma5`;

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
(2,	'Rum',	20,	10,	5),
(3,	'Kapesnky',	1000,	10,	3),
(4,	'Hebky',	121,	22,	3);

DROP TABLE IF EXISTS `pid`;
CREATE TABLE `pid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pid` (`id`, `name`) VALUES
(1,	'7603164353'),
(2,	'7659191432'),
(4,	'123456789');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` text COLLATE utf16_czech_ci NOT NULL,
  `firstname` text COLLATE utf16_czech_ci NOT NULL,
  `registered` datetime NOT NULL,
  `is_admin` tinyint(3) unsigned NOT NULL,
  `pid_id` int(11) DEFAULT NULL,
  `phone` varchar(12) COLLATE utf16_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid_id` (`pid_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`pid_id`) REFERENCES `pid` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci;

INSERT INTO `user` (`id`, `surname`, `firstname`, `registered`, `is_admin`, `pid_id`, `phone`) VALUES
(3,	'Big',	'Brother',	'2017-20-03 12:00:00',	1,	4,	'123456789'),
(4,	'Breburda',	'Kvana',	'2017-20-03 13:00:00',	0,	1,	'123456789'),
(5,	'Gogo',	'Ochlastovic',	'2017-20-03 14:00:00',	0,	2,	'');

-- 2017-03-20 10:45:01