-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 11 月 14 日 20:53
-- 服务器版本: 5.5.47
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `pms`
--

-- --------------------------------------------------------

--
-- 表的结构 `album`
--
-- 创建时间: 2016 年 10 月 18 日 12:34
-- 最后更新: 2016 年 11 月 14 日 11:22
-- 最后检查: 2016 年 10 月 18 日 12:34
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `description` varchar(50) COLLATE utf8_bin NOT NULL,
  `addtime` date NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--
-- 创建时间: 2016 年 10 月 15 日 12:22
-- 最后更新: 2016 年 10 月 15 日 12:22
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoid` int(11) NOT NULL,
  `guestname` varchar(15) COLLATE utf8_bin NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `index`
--
-- 创建时间: 2016 年 10 月 15 日 12:15
-- 最后更新: 2016 年 10 月 15 日 12:15
--

CREATE TABLE IF NOT EXISTS `index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shareid` int(11) NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--
-- 创建时间: 2016 年 11 月 13 日 15:07
-- 最后更新: 2016 年 11 月 13 日 15:07
--

CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `description` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `photo`
--
-- 创建时间: 2016 年 11 月 14 日 12:46
-- 最后更新: 2016 年 11 月 14 日 12:46
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `albumid` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `filename` varchar(42) COLLATE utf8_bin NOT NULL,
  `description` varchar(50) COLLATE utf8_bin NOT NULL,
  `address` varchar(20) COLLATE utf8_bin NOT NULL,
  `addtime` date NOT NULL,
  `share` tinyint(1) NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `albumid` (`albumid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `share`
--
-- 创建时间: 2016 年 10 月 22 日 11:51
-- 最后更新: 2016 年 11 月 13 日 16:17
--

CREATE TABLE IF NOT EXISTS `share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoid` int(11) NOT NULL,
  `url` varchar(60) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--
-- 创建时间: 2016 年 10 月 18 日 12:13
-- 最后更新: 2016 年 10 月 22 日 12:55
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `pwd` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'md5',
  `email` varchar(20) COLLATE utf8_bin NOT NULL,
  `addtime` date NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- 表的结构 `user_log`
--
-- 创建时间: 2016 年 10 月 15 日 12:15
-- 最后更新: 2016 年 10 月 15 日 12:15
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
