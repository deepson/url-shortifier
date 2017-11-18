-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

DROP DATABASE IF EXISTS `zimalab_test`;
CREATE DATABASE `zimalab_test` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `zimalab_test`;

DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '#',
  `link` varchar(256) COLLATE utf8_unicode_ci NOT NULL COMMENT 'original link',
  `hash` char(6) COLLATE utf8_unicode_ci NOT NULL COMMENT 'original link hash',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT 'hash visits',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2017-11-18 00:38:49
