-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-11-02 00:08:37
-- 服务器版本: 5.5.53-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `albumphoto`
--
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
--

CREATE TABLE IF NOT EXISTS `albumphoto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `albumid` int(11) NOT NULL,
  `photoid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `albumid` (`albumid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoid` int(11) NOT NULL,
  `guestname` varchar(15) COLLATE utf8_bin NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `index`
--
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
--

CREATE TABLE IF NOT EXISTS `index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shareid` int(11) NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `photo`
--
-- 创建时间: 2016-11-01 16:00:39
-- 最后更新: 2016-11-01 16:07:33
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `albumid` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `filename` varchar(20) COLLATE utf8_bin NOT NULL,
  `description` varchar(50) COLLATE utf8_bin NOT NULL,
  `address` varchar(20) COLLATE utf8_bin NOT NULL,
  `addtime` date NOT NULL,
  `share` tinyint(1) NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `albumid` (`albumid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `share`
--
-- 创建时间: 2016-11-01 16:00:20
-- 最后更新: 2016-11-01 16:07:33
--

CREATE TABLE IF NOT EXISTS `share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoid` int(11) NOT NULL,
  `url` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `pwd` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'md5',
  `email` varchar(20) COLLATE utf8_bin NOT NULL,
  `addtime` date NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `useralbum`
--
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
--

CREATE TABLE IF NOT EXISTS `useralbum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `albumid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `user_log`
--
-- 创建时间: 2016-10-21 07:35:53
-- 最后更新: 2016-10-21 07:35:53
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `info` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
