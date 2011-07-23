-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 30, 2010 at 01:27 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `j16`
--

-- --------------------------------------------------------

--
-- Table structure for table `#__wedding_album`
--

CREATE TABLE IF NOT EXISTS `#__wedding_albums` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `default` tinyint(4) NOT NULL default '0',
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__wedding_album`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__wedding_album_photos`
--

CREATE TABLE IF NOT EXISTS `#__wedding_album_photos` (
  `id` int(11) NOT NULL auto_increment,
  `album_id` int(11) NOT NULL,
  `photos` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__wedding_album_photos`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__wedding_apps`
--

CREATE TABLE IF NOT EXISTS `#__wedding_apps` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__wedding_apps`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__wedding_templates`
--

CREATE TABLE IF NOT EXISTS `#__wedding_templates` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(127) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__wedding_templates`
--


-- --------------------------------------------------------

--
-- Table structure for table `#__wedding_users`
--

CREATE TABLE IF NOT EXISTS `#__wedding_users` (
  `user_id` int(11) NOT NULL,
  `man_name` varchar(255) NOT NULL,
  `woman_name` varchar(255) NOT NULL,
  `template_id` int(11) NOT NULL,
  `apps` varchar(255) NOT NULL,
  `passwords` varchar(255) NOT NULL,
  `visitors_number` int(11) NOT NULL,
  `show_counter` tinyint(4) NOT NULL default '0',
  `email_subscribe` tinyint(4) NOT NULL default '1',
  `type` int(11) NOT NULL,
  `country` varchar(127) NOT NULL default 'Việt Nam',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__wedding_users`
--

