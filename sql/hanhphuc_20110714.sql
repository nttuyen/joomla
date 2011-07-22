CREATE DATABASE  IF NOT EXISTS `joomla_dev_hanhphuc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `joomla_dev_hanhphuc`;
-- MySQL dump 10.13  Distrib 5.1.40, for Win32 (ia32)
--
-- Host: 127.0.0.1    Database: joomla_dev_hanhphuc
-- ------------------------------------------------------
-- Server version	5.5.8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jos_user_profiles`
--

DROP TABLE IF EXISTS `jos_user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_user_profiles`
--

LOCK TABLES `jos_user_profiles` WRITE;
/*!40000 ALTER TABLE `jos_user_profiles` DISABLE KEYS */;
INSERT INTO `jos_user_profiles` VALUES (43,'profile.aboutme','',10),(43,'profile.address1','',1),(43,'profile.address2','',2),(43,'profile.business_address','Business address 1',14),(43,'profile.business_banner','',24),(43,'profile.business_city','Hà Nội',15),(43,'profile.business_director','Business director 1',12),(43,'profile.business_district','Ba Đình',16),(43,'profile.business_fax','',19),(43,'profile.business_logo','',21),(43,'profile.business_name','Business name 1',13),(43,'profile.business_phone','0123456789',18),(43,'profile.business_sitename','business 1',22),(43,'profile.business_slogan','business 1 slogan',23),(43,'profile.business_village','Business village 1',17),(43,'profile.business_website','http://business1.com',20),(43,'profile.city','',3),(43,'profile.country','',5),(43,'profile.dob','',11),(43,'profile.favoritebook','',9),(43,'profile.phone','',7),(43,'profile.postal_code','',6),(43,'profile.region','',4),(43,'profile.website','',8),(44,'profile.business_address','Business address 2',3),(44,'profile.business_banner','',13),(44,'profile.business_city','Hà Nội',4),(44,'profile.business_director','Business director 2',1),(44,'profile.business_district','Ba Đình',5),(44,'profile.business_fax','',8),(44,'profile.business_logo','',10),(44,'profile.business_name','Business name 2',2),(44,'profile.business_phone','0123456798',7),(44,'profile.business_sitename','',11),(44,'profile.business_slogan','',12),(44,'profile.business_village','Business village 2',6),(44,'profile.business_website','',9),(45,'profile.business_address','user address',3),(45,'profile.business_banner','',13),(45,'profile.business_city','Hà Nội',4),(45,'profile.business_director','user name 1',1),(45,'profile.business_district','Ba Đình',5),(45,'profile.business_fax','',8),(45,'profile.business_logo','',10),(45,'profile.business_name','user name 2',2),(45,'profile.business_phone','0123456789',7),(45,'profile.business_sitename','',11),(45,'profile.business_slogan','',12),(45,'profile.business_village','user village',6),(45,'profile.business_website','',9);
/*!40000 ALTER TABLE `jos_user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_content`
--

DROP TABLE IF EXISTS `jos_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title_alias` varchar(255) NOT NULL DEFAULT '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(10) unsigned NOT NULL DEFAULT '0',
  `mask` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_content`
--

LOCK TABLES `jos_content` WRITE;
/*!40000 ALTER TABLE `jos_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_hp_business_service`
--

DROP TABLE IF EXISTS `jos_hp_business_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_hp_business_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `state` int(3) NOT NULL DEFAULT '1',
  `name` varchar(200) NOT NULL DEFAULT '',
  `number` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `current_price` int(11) DEFAULT '0',
  `promotion` varchar(500) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `payment_type` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_hp_business_service`
--

LOCK TABLES `jos_hp_business_service` WRITE;
/*!40000 ALTER TABLE `jos_hp_business_service` DISABLE KEYS */;
INSERT INTO `jos_hp_business_service` VALUES (7,8,43,1,'Dịch vụ cho thuê váy cô dâu',1,5000000,5000000,'Trang điểm miễn phí','[\"www.easyvn.net--80-beautiful-asia-girl-mm-wallpapers-hd--004.jpg\"]','<p class=\"Normal\">Vụ tàu Bình Minh 02 đã được đưa vào phát biểu chính  thức tại Hội nghị. Bên cạnh đó, Bộ trưởng Phùng Quang Thanh cũng trả lời  câu hỏi của nhiều đại biểu, khẳng định sự sai trái của Trung Quốc trong  sự việc này. Việc tàu hải giám của Trung Quốc xâm phạm chủ quyền vào  sâu tới hơn 80 hải lý trong vùng đặc quyền kinh tế là điều không chấp  nhận được trong bất cứ văn bản luật pháp nào. Đồng thời, Bộ trưởng Phùng  Quang Thanh nhắc lại chủ trương Việt Nam trên biển Đông là kiên trì  giải quyết bằng biện pháp hòa bình, dựa trên luật pháp quốc tế và công  khai minh bạch để cộng đồng thế giới phân biệt đúng sai.</p>\r\n<p class=\"Normal\"> </p>','[\"1\",\"2\"]',NULL,NULL);
/*!40000 ALTER TABLE `jos_hp_business_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_newsfeeds`
--

DROP TABLE IF EXISTS `jos_newsfeeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(100) NOT NULL DEFAULT '',
  `link` varchar(200) NOT NULL DEFAULT '',
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(10) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(10) unsigned NOT NULL DEFAULT '3600',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_newsfeeds`
--

LOCK TABLES `jos_newsfeeds` WRITE;
/*!40000 ALTER TABLE `jos_newsfeeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_newsfeeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_session`
--

DROP TABLE IF EXISTS `jos_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_session` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `guest` tinyint(4) unsigned DEFAULT '1',
  `time` varchar(14) DEFAULT '',
  `data` varchar(20480) DEFAULT NULL,
  `userid` int(11) DEFAULT '0',
  `username` varchar(150) DEFAULT '',
  `usertype` varchar(50) DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_session`
--

LOCK TABLES `jos_session` WRITE;
/*!40000 ALTER TABLE `jos_session` DISABLE KEYS */;
INSERT INTO `jos_session` VALUES ('co5bepot74lj56jh782er38r30',0,0,'1310511818','__default|a:10:{s:15:\"session.counter\";i:20;s:19:\"session.timer.start\";i:1310482910;s:18:\"session.timer.last\";i:1310508217;s:17:\"session.timer.now\";i:1310511817;s:22:\"session.client.browser\";s:63:\"Mozilla/5.0 (Windows NT 6.1; rv:5.0) Gecko/20100101 Firefox/5.0\";s:8:\"registry\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":2:{s:16:\"com_jnt_hanhphuc\";O:8:\"stdClass\":1:{s:8:\"services\";O:8:\"stdClass\":1:{s:8:\"ordercol\";N;}}s:5:\"users\";O:8:\"stdClass\":1:{s:5:\"login\";O:8:\"stdClass\":1:{s:4:\"form\";O:8:\"stdClass\":1:{s:4:\"data\";a:0:{}}}}}}s:4:\"user\";O:5:\"JUser\":24:{s:9:\"\0*\0isRoot\";b:1;s:2:\"id\";s:2:\"42\";s:4:\"name\";s:10:\"Super User\";s:8:\"username\";s:7:\"nttuyen\";s:5:\"email\";s:20:\"nttuyen_it@yahoo.com\";s:8:\"password\";s:65:\"336cd6ced12f4281dd7423d332135b01:ZXnIywmfw88OChYELOZcjtsOgehHlFzL\";s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";s:10:\"deprecated\";s:5:\"block\";s:1:\"0\";s:9:\"sendEmail\";s:1:\"1\";s:12:\"registerDate\";s:19:\"2011-05-15 06:59:57\";s:13:\"lastvisitDate\";s:19:\"2011-07-12 15:01:49\";s:10:\"activation\";s:0:\"\";s:6:\"params\";s:0:\"\";s:6:\"groups\";a:1:{s:11:\"Super Users\";s:1:\"8\";}s:5:\"guest\";i:0;s:10:\"\0*\0_params\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":0:{}}s:14:\"\0*\0_authGroups\";a:2:{i:0;i:1;i:1;i:8;}s:14:\"\0*\0_authLevels\";a:4:{i:0;i:1;i:1;i:1;i:2;i:2;i:3;i:3;}s:15:\"\0*\0_authActions\";N;s:12:\"\0*\0_errorMsg\";N;s:10:\"\0*\0_errors\";a:0:{}s:3:\"aid\";i:0;s:9:\"user_type\";s:1:\"0\";}s:13:\"session.token\";s:32:\"68c2d83843fd65c751cda19ad735027a\";s:21:\"session.shopping_cart\";a:1:{i:7;i:1;}s:28:\"jnt_hanhphuc.cart.pay_method\";i:1;}',42,'nttuyen','');
/*!40000 ALTER TABLE `jos_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_weblinks`
--

DROP TABLE IF EXISTS `jos_weblinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_weblinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_weblinks`
--

LOCK TABLES `jos_weblinks` WRITE;
/*!40000 ALTER TABLE `jos_weblinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_weblinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_messages`
--

DROP TABLE IF EXISTS `jos_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_messages`
--

LOCK TABLES `jos_messages` WRITE;
/*!40000 ALTER TABLE `jos_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_hp_order_items`
--

DROP TABLE IF EXISTS `jos_hp_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_hp_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `business_name` varchar(500) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `service_name` varchar(500) DEFAULT NULL,
  `qty` int(3) DEFAULT NULL,
  `origin_price` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_hp_order_items`
--

LOCK TABLES `jos_hp_order_items` WRITE;
/*!40000 ALTER TABLE `jos_hp_order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_hp_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_banner_tracks`
--

DROP TABLE IF EXISTS `jos_banner_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_banner_tracks`
--

LOCK TABLES `jos_banner_tracks` WRITE;
/*!40000 ALTER TABLE `jos_banner_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_banner_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_extensions`
--

DROP TABLE IF EXISTS `jos_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `protected` tinyint(3) NOT NULL DEFAULT '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0',
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10006 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_extensions`
--

LOCK TABLES `jos_extensions` WRITE;
/*!40000 ALTER TABLE `jos_extensions` DISABLE KEYS */;
INSERT INTO `jos_extensions` VALUES (1,'com_mailto','component','com_mailto','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(2,'com_wrapper','component','com_wrapper','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(3,'com_admin','component','com_admin','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(4,'com_banners','component','com_banners','',1,1,1,0,'','{\"purchase_type\":\"3\",\"track_impressions\":\"0\",\"track_clicks\":\"0\",\"metakey_prefix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(5,'com_cache','component','com_cache','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(6,'com_categories','component','com_categories','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(7,'com_checkin','component','com_checkin','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(8,'com_contact','component','com_contact','',1,1,1,0,'','{\"show_contact_category\":\"hide\",\"show_contact_list\":\"0\",\"presentation_style\":\"sliders\",\"show_name\":\"1\",\"show_position\":\"1\",\"show_email\":\"0\",\"show_street_address\":\"1\",\"show_suburb\":\"1\",\"show_state\":\"1\",\"show_postcode\":\"1\",\"show_country\":\"1\",\"show_telephone\":\"1\",\"show_mobile\":\"1\",\"show_fax\":\"1\",\"show_webpage\":\"1\",\"show_misc\":\"1\",\"show_image\":\"1\",\"image\":\"\",\"allow_vcard\":\"0\",\"show_articles\":\"0\",\"show_profile\":\"0\",\"show_links\":\"0\",\"linka_name\":\"\",\"linkb_name\":\"\",\"linkc_name\":\"\",\"linkd_name\":\"\",\"linke_name\":\"\",\"contact_icons\":\"0\",\"icon_address\":\"\",\"icon_email\":\"\",\"icon_telephone\":\"\",\"icon_mobile\":\"\",\"icon_fax\":\"\",\"icon_misc\":\"\",\"show_headings\":\"1\",\"show_position_headings\":\"1\",\"show_email_headings\":\"0\",\"show_telephone_headings\":\"1\",\"show_mobile_headings\":\"0\",\"show_fax_headings\":\"0\",\"allow_vcard_headings\":\"0\",\"show_suburb_headings\":\"1\",\"show_state_headings\":\"1\",\"show_country_headings\":\"1\",\"show_email_form\":\"1\",\"show_email_copy\":\"1\",\"banned_email\":\"\",\"banned_subject\":\"\",\"banned_text\":\"\",\"validate_session\":\"1\",\"custom_reply\":\"0\",\"redirect\":\"\",\"show_category_crumb\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(9,'com_cpanel','component','com_cpanel','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(10,'com_installer','component','com_installer','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(11,'com_languages','component','com_languages','',1,1,1,1,'','{\"administrator\":\"en-GB\",\"site\":\"en-GB\"}','','',0,'0000-00-00 00:00:00',0,0),(12,'com_login','component','com_login','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(13,'com_media','component','com_media','',1,1,0,1,'','{\"upload_extensions\":\"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\",\"upload_maxsize\":\"10\",\"file_path\":\"images\",\"image_path\":\"images\",\"restrict_uploads\":\"1\",\"allowed_media_usergroup\":\"3\",\"check_mime\":\"1\",\"image_extensions\":\"bmp,gif,jpg,png\",\"ignore_extensions\":\"\",\"upload_mime\":\"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip\",\"upload_mime_illegal\":\"text\\/html\",\"enable_flash\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(14,'com_menus','component','com_menus','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(15,'com_messages','component','com_messages','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(16,'com_modules','component','com_modules','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(17,'com_newsfeeds','component','com_newsfeeds','',1,1,1,0,'','{\"show_feed_image\":\"1\",\"show_feed_description\":\"1\",\"show_item_description\":\"1\",\"feed_word_count\":\"0\",\"show_headings\":\"1\",\"show_name\":\"1\",\"show_articles\":\"0\",\"show_link\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"1\",\"display_num\":\"\",\"show_pagination_limit\":\"1\",\"show_pagination\":\"1\",\"show_pagination_results\":\"1\",\"show_cat_items\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(18,'com_plugins','component','com_plugins','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(19,'com_search','component','com_search','',1,1,1,1,'','{\"enabled\":\"0\",\"show_date\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(20,'com_templates','component','com_templates','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(21,'com_weblinks','component','com_weblinks','',1,1,1,0,'','{\"show_comp_description\":\"1\",\"comp_description\":\"\",\"show_link_hits\":\"1\",\"show_link_description\":\"1\",\"show_other_cats\":\"0\",\"show_headings\":\"0\",\"show_numbers\":\"0\",\"show_report\":\"1\",\"count_clicks\":\"1\",\"target\":\"0\",\"link_icons\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(22,'com_content','component','com_content','',1,1,0,1,'','{\"article_layout\":\"_:default\",\"show_title\":\"1\",\"link_titles\":\"1\",\"show_intro\":\"1\",\"show_category\":\"1\",\"link_category\":\"1\",\"show_parent_category\":\"0\",\"link_parent_category\":\"0\",\"show_author\":\"1\",\"link_author\":\"0\",\"show_create_date\":\"0\",\"show_modify_date\":\"0\",\"show_publish_date\":\"1\",\"show_item_navigation\":\"1\",\"show_vote\":\"0\",\"show_readmore\":\"1\",\"show_readmore_title\":\"1\",\"readmore_limit\":\"100\",\"show_icons\":\"1\",\"show_print_icon\":\"1\",\"show_email_icon\":\"1\",\"show_hits\":\"1\",\"show_noauth\":\"0\",\"category_layout\":\"_:blog\",\"show_category_title\":\"0\",\"show_description\":\"0\",\"show_description_image\":\"0\",\"maxLevel\":\"1\",\"show_empty_categories\":\"0\",\"show_no_articles\":\"1\",\"show_subcat_desc\":\"1\",\"show_cat_num_articles\":\"0\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_num_articles_cat\":\"1\",\"num_leading_articles\":\"1\",\"num_intro_articles\":\"4\",\"num_columns\":\"2\",\"num_links\":\"4\",\"multi_column_order\":\"0\",\"orderby_pri\":\"order\",\"orderby_sec\":\"rdate\",\"order_date\":\"published\",\"show_pagination_limit\":\"1\",\"filter_field\":\"hide\",\"show_headings\":\"1\",\"list_show_date\":\"0\",\"date_format\":\"\",\"list_show_hits\":\"1\",\"list_show_author\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_feed_link\":\"1\",\"feed_summary\":\"0\",\"filters\":{\"1\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"6\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"7\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"2\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"3\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"4\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"5\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"10\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"12\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"8\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"}}}','','',0,'0000-00-00 00:00:00',0,0),(23,'com_config','component','com_config','',1,1,0,1,'','','','',0,'0000-00-00 00:00:00',0,0),(24,'com_redirect','component','com_redirect','',1,1,0,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(25,'com_users','component','com_users','',1,1,0,1,'','{\"allowUserRegistration\":\"1\",\"new_usertype\":\"2\",\"useractivation\":\"1\",\"frontend_userparams\":\"1\",\"mailSubjectPrefix\":\"\",\"mailBodySuffix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(100,'PHPMailer','library','phpmailer','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(101,'SimplePie','library','simplepie','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(102,'phputf8','library','phputf8','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(103,'Joomla! Web Application Framework','library','joomla','',0,1,1,1,'{\"legacy\":false,\"name\":\"Joomla! Web Application Framework\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"Joomla\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"http:\\/\\/www.joomla.org\",\"version\":\"1.6.0\",\"description\":\"The Joomla! Web Application Framework is the Core of the Joomla! Content Management System\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(200,'mod_articles_archive','module','mod_articles_archive','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(201,'mod_articles_latest','module','mod_articles_latest','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(202,'mod_articles_popular','module','mod_articles_popular','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(203,'mod_banners','module','mod_banners','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(204,'mod_breadcrumbs','module','mod_breadcrumbs','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(205,'mod_custom','module','mod_custom','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(206,'mod_feed','module','mod_feed','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(207,'mod_footer','module','mod_footer','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(208,'mod_login','module','mod_login','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(209,'mod_menu','module','mod_menu','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(210,'mod_articles_news','module','mod_articles_news','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(211,'mod_random_image','module','mod_random_image','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(212,'mod_related_items','module','mod_related_items','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(213,'mod_search','module','mod_search','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(214,'mod_stats','module','mod_stats','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(215,'mod_syndicate','module','mod_syndicate','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(216,'mod_users_latest','module','mod_users_latest','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(217,'mod_weblinks','module','mod_weblinks','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(218,'mod_whosonline','module','mod_whosonline','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(219,'mod_wrapper','module','mod_wrapper','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(220,'mod_articles_category','module','mod_articles_category','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(221,'mod_articles_categories','module','mod_articles_categories','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(222,'mod_languages','module','mod_languages','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(300,'mod_custom','module','mod_custom','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(301,'mod_feed','module','mod_feed','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(302,'mod_latest','module','mod_latest','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(303,'mod_logged','module','mod_logged','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(304,'mod_login','module','mod_login','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(305,'mod_menu','module','mod_menu','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(306,'mod_online','module','mod_online','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(307,'mod_popular','module','mod_popular','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(308,'mod_quickicon','module','mod_quickicon','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(309,'mod_status','module','mod_status','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(310,'mod_submenu','module','mod_submenu','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(311,'mod_title','module','mod_title','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(312,'mod_toolbar','module','mod_toolbar','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(313,'mod_unread','module','mod_unread','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(400,'plg_authentication_gmail','plugin','gmail','authentication',0,0,1,0,'','{\"applysuffix\":\"0\",\"suffix\":\"\",\"verifypeer\":\"1\",\"user_blacklist\":\"\"}','','',0,'0000-00-00 00:00:00',1,0),(401,'plg_authentication_joomla','plugin','joomla','authentication',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(402,'plg_authentication_ldap','plugin','ldap','authentication',0,0,1,0,'','{\"host\":\"\",\"port\":\"389\",\"use_ldapV3\":\"0\",\"negotiate_tls\":\"0\",\"no_referrals\":\"0\",\"auth_method\":\"bind\",\"base_dn\":\"\",\"search_string\":\"\",\"users_dn\":\"\",\"username\":\"admin\",\"password\":\"bobby7\",\"ldap_fullname\":\"fullName\",\"ldap_email\":\"mail\",\"ldap_uid\":\"uid\"}','','',0,'0000-00-00 00:00:00',3,0),(404,'plg_content_emailcloak','plugin','emailcloak','content',0,1,1,0,'','{\"mode\":\"1\"}','','',0,'0000-00-00 00:00:00',1,0),(405,'plg_content_geshi','plugin','geshi','content',0,0,1,0,'','{}','','',0,'0000-00-00 00:00:00',2,0),(406,'plg_content_loadmodule','plugin','loadmodule','content',0,1,1,0,'','{\"style\":\"none\"}','','',0,'0000-00-00 00:00:00',0,0),(407,'plg_content_pagebreak','plugin','pagebreak','content',0,1,1,1,'','{\"title\":\"1\",\"multipage_toc\":\"1\",\"showall\":\"1\"}','','',0,'0000-00-00 00:00:00',4,0),(408,'plg_content_pagenavigation','plugin','pagenavigation','content',0,1,1,1,'','{\"position\":\"1\"}','','',0,'0000-00-00 00:00:00',5,0),(409,'plg_content_vote','plugin','vote','content',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',6,0),(410,'plg_editors_codemirror','plugin','codemirror','editors',0,1,1,1,'','{\"linenumbers\":\"0\",\"tabmode\":\"indent\"}','','',0,'0000-00-00 00:00:00',1,0),(411,'plg_editors_none','plugin','none','editors',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',2,0),(412,'plg_editors_tinymce','plugin','tinymce','editors',0,1,1,1,'','{\"mode\":\"1\",\"skin\":\"0\",\"compressed\":\"0\",\"cleanup_startup\":\"0\",\"cleanup_save\":\"2\",\"entity_encoding\":\"raw\",\"lang_mode\":\"0\",\"lang_code\":\"en\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"extended_elements\":\"\",\"toolbar\":\"top\",\"toolbar_align\":\"left\",\"html_height\":\"550\",\"html_width\":\"750\",\"element_path\":\"1\",\"fonts\":\"1\",\"paste\":\"1\",\"searchreplace\":\"1\",\"insertdate\":\"1\",\"format_date\":\"%Y-%m-%d\",\"inserttime\":\"1\",\"format_time\":\"%H:%M:%S\",\"colors\":\"1\",\"table\":\"1\",\"smilies\":\"1\",\"media\":\"1\",\"hr\":\"1\",\"directionality\":\"1\",\"fullscreen\":\"1\",\"style\":\"1\",\"layer\":\"1\",\"xhtmlxtras\":\"1\",\"visualchars\":\"1\",\"nonbreaking\":\"1\",\"template\":\"1\",\"blockquote\":\"1\",\"wordcount\":\"1\",\"advimage\":\"1\",\"advlink\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"inlinepopups\":\"1\",\"safari\":\"0\",\"custom_plugin\":\"\",\"custom_button\":\"\"}','','',0,'0000-00-00 00:00:00',3,0),(413,'plg_editors-xtd_article','plugin','article','editors-xtd',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',1,0),(414,'plg_editors-xtd_image','plugin','image','editors-xtd',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',2,0),(415,'plg_editors-xtd_pagebreak','plugin','pagebreak','editors-xtd',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',3,0),(416,'plg_editors-xtd_readmore','plugin','readmore','editors-xtd',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',4,0),(417,'plg_search_categories','plugin','categories','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(418,'plg_search_contacts','plugin','contacts','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(419,'plg_search_content','plugin','content','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(420,'plg_search_newsfeeds','plugin','newsfeeds','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(421,'plg_search_weblinks','plugin','weblinks','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(422,'plg_system_languagefilter','plugin','languagefilter','system',0,0,1,1,'','{}','','',0,'0000-00-00 00:00:00',1,0),(423,'plg_system_p3p','plugin','p3p','system',0,1,1,1,'','{\"headers\":\"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM\"}','','',0,'0000-00-00 00:00:00',2,0),(424,'plg_system_cache','plugin','cache','system',0,0,1,1,'','{\"browsercache\":\"0\",\"cachetime\":\"15\"}','','',0,'0000-00-00 00:00:00',9,0),(425,'plg_system_debug','plugin','debug','system',0,1,1,0,'','{\"profile\":\"1\",\"queries\":\"1\",\"memory\":\"1\",\"language_files\":\"1\",\"language_strings\":\"1\",\"strip-first\":\"1\",\"strip-prefix\":\"\",\"strip-suffix\":\"\"}','','',0,'0000-00-00 00:00:00',4,0),(426,'plg_system_log','plugin','log','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',5,0),(427,'plg_system_redirect','plugin','redirect','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',6,0),(428,'plg_system_remember','plugin','remember','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',7,0),(429,'plg_system_sef','plugin','sef','system',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',8,0),(430,'plg_system_logout','plugin','logout','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',3,0),(431,'plg_user_contactcreator','plugin','contactcreator','user',0,0,1,1,'','{\"autowebpage\":\"\",\"category\":\"34\",\"autopublish\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(432,'plg_user_joomla','plugin','joomla','user',0,1,1,0,'','{\"autoregister\":\"1\"}','','',0,'0000-00-00 00:00:00',2,0),(433,'plg_user_profile','plugin','profile','user',0,1,1,1,'','{\"register-require_address1\":\"0\",\"register-require_address2\":\"0\",\"register-require_city\":\"0\",\"register-require_region\":\"0\",\"register-require_country\":\"0\",\"register-require_postal_code\":\"0\",\"register-require_phone\":\"0\",\"register-require_website\":\"0\",\"register-require_favoritebook\":\"0\",\"register-require_aboutme\":\"0\",\"register-require_tos\":\"0\",\"register-require_dob\":\"0\",\"profile-require_address1\":\"0\",\"profile-require_address2\":\"0\",\"profile-require_city\":\"0\",\"profile-require_region\":\"0\",\"profile-require_country\":\"0\",\"profile-require_postal_code\":\"0\",\"profile-require_phone\":\"0\",\"profile-require_website\":\"0\",\"profile-require_favoritebook\":\"0\",\"profile-require_aboutme\":\"0\",\"profile-require_tos\":\"0\",\"profile-require_dob\":\"0\",\"register-require_business_director\":\"2\",\"register-require_business_name\":\"2\",\"register-require_business_address\":\"2\",\"register-require_business_city\":\"2\",\"register-require_business_district\":\"2\",\"register-require_business_village\":\"2\",\"register-require_business_phone\":\"2\",\"register-require_business_fax\":\"1\",\"register-require_business_website\":\"1\",\"register-require_business_logo\":\"1\",\"register-require_business_sitename\":\"1\",\"register-require_business_slogan\":\"1\",\"register-require_business_banner\":\"1\",\"profile-require_business_director\":\"2\",\"profile-require_business_name\":\"2\",\"profile-require_business_address\":\"2\",\"profile-require_business_city\":\"2\",\"profile-require_business_district\":\"2\",\"profile-require_business_village\":\"2\",\"profile-require_business_phone\":\"2\",\"profile-require_business_fax\":\"1\",\"profile-require_business_website\":\"1\",\"profile-require_business_logo\":\"1\",\"profile-require_business_sitename\":\"1\",\"profile-require_business_slogan\":\"1\",\"profile-require_business_banner\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(434,'plg_extension_joomla','plugin','joomla','extension',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',1,0),(435,'plg_content_joomla','plugin','joomla','content',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',0,0),(500,'atomic','template','atomic','',0,1,1,0,'{\"legacy\":false,\"name\":\"atomic\",\"type\":\"template\",\"creationDate\":\"10\\/10\\/09\",\"author\":\"Ron Severdia\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"contact@kontentdesign.com\",\"authorUrl\":\"http:\\/\\/www.kontentdesign.com\",\"version\":\"1.6.0\",\"description\":\"TPL_ATOMIC_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(502,'bluestork','template','bluestork','',1,1,1,0,'{\"legacy\":false,\"name\":\"bluestork\",\"type\":\"template\",\"creationDate\":\"07\\/02\\/09\",\"author\":\"Ron Severdia\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"contact@kontentdesign.com\",\"authorUrl\":\"http:\\/\\/www.kontentdesign.com\",\"version\":\"1.6.0\",\"description\":\"TPL_BLUESTORK_XML_DESCRIPTION\",\"group\":\"\"}','{\"useRoundedCorners\":\"1\",\"showSiteName\":\"0\",\"textBig\":\"0\",\"highContrast\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(503,'beez_20','template','beez_20','',0,1,1,0,'{\"legacy\":false,\"name\":\"beez_20\",\"type\":\"template\",\"creationDate\":\"25 November 2009\",\"author\":\"Angie Radtke\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"a.radtke@derauftritt.de\",\"authorUrl\":\"http:\\/\\/www.der-auftritt.de\",\"version\":\"1.6.0\",\"description\":\"TPL_BEEZ2_XML_DESCRIPTION\",\"group\":\"\"}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"\",\"sitedescription\":\"\",\"navposition\":\"center\",\"templatecolor\":\"nature\"}','','',0,'0000-00-00 00:00:00',0,0),(504,'hathor','template','hathor','',1,1,1,0,'{\"legacy\":false,\"name\":\"hathor\",\"type\":\"template\",\"creationDate\":\"May 2010\",\"author\":\"Andrea Tarr\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"hathor@tarrconsulting.com\",\"authorUrl\":\"http:\\/\\/www.tarrconsulting.com\",\"version\":\"1.6.0\",\"description\":\"TPL_HATHOR_XML_DESCRIPTION\",\"group\":\"\"}','{\"showSiteName\":\"0\",\"colourChoice\":\"0\",\"boldText\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(505,'beez5','template','beez5','',0,1,1,0,'{\"legacy\":false,\"name\":\"beez5\",\"type\":\"template\",\"creationDate\":\"21 May 2010\",\"author\":\"Angie Radtke\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.\",\"authorEmail\":\"a.radtke@derauftritt.de\",\"authorUrl\":\"http:\\/\\/www.der-auftritt.de\",\"version\":\"1.6.0\",\"description\":\"TPL_BEEZ5_XML_DESCRIPTION\",\"group\":\"\"}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"\",\"sitedescription\":\"\",\"navposition\":\"center\",\"html5\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(600,'English (United Kingdom)','language','en-GB','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(601,'English (United Kingdom)','language','en-GB','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(700,'Joomla! CMS','file','joomla','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(10000,'aPoll','component','com_apoll','',1,1,1,0,'{\"legacy\":false,\"name\":\"aPoll\",\"type\":\"component\",\"creationDate\":\"January 2011\",\"author\":\"Hristo Genev\",\"copyright\":\"Hristo Genev. All rights reserved.\",\"authorEmail\":\"harrygg@gmail.com\",\"authorUrl\":\"http:\\/\\/www.afactory.org\",\"version\":\"3.0.0\",\"description\":\"aPoll lite is a component for creating polls. Enjoy it!\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(10002,'aPoll Module','module','mod_apoll','',0,1,1,0,'{\"legacy\":false,\"name\":\"aPoll Module\",\"type\":\"module\",\"creationDate\":\"January 2011\",\"author\":\"Hristo Genev\",\"copyright\":\"Copyright (C) 2009\",\"authorEmail\":\"harrygg@gmail.com\",\"authorUrl\":\"www.afactory.org\",\"version\":\"3.0.0\",\"description\":\"MOD_APOLL_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_poll_title\":\"1\",\"show_total\":\"1\",\"show_msg\":\"1\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(10003,'mod_hanhphuc_service_categories','module','mod_hanhphuc_service_categories','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_hanhphuc_service_categories\",\"type\":\"module\",\"creationDate\":\"May 2011\",\"author\":\"nttuyen\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters. All rights reserved.\",\"authorEmail\":\"contact@nttuyen.com\",\"authorUrl\":\"www.nttuyen.com\",\"version\":\"1.6.0\",\"description\":\"MOD_HANHPHUC_SERVICE_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10004,'mod_hanhphuc_usermenu','module','mod_hanhphuc_usermenu','',0,1,1,0,'{\"legacy\":false,\"name\":\"mod_hanhphuc_usermenu\",\"type\":\"module\",\"creationDate\":\"May 2011\",\"author\":\"nttuyen\",\"copyright\":\"Copyright (C) 2005 - 2011 Open Source Matters. All rights reserved.\",\"authorEmail\":\"contact@nttuyen.com\",\"authorUrl\":\"www.nttuyen.com\",\"version\":\"1.6.0\",\"description\":\"MOD_HANHPHUC_USERMENU_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10005,'com_jnt_hanhphuc','component','com_jnt_hanhphuc','',1,1,1,0,'{\"legacy\":false,\"name\":\"com_jnt_hanhphuc\",\"type\":\"component\",\"creationDate\":\"May 2011\",\"author\":\"nttuyen\",\"copyright\":\"(C) 2005 - 2011 Open Source Matters. All rights reserved.\\n\\t\",\"authorEmail\":\"contact@nttuyen.com\",\"authorUrl\":\"www.nttuyen.com\",\"version\":\"1.6.0\",\"description\":\"COM_JNT_HANHPHUC_XML_DESCRIPTION\",\"group\":\"\"}','{}','','',0,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `jos_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cron_data`
--

DROP TABLE IF EXISTS `jos_cron_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_cron_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AGENT_REF` varchar(200) DEFAULT NULL,
  `ADDRESS_1` varchar(200) DEFAULT NULL,
  `POSTCODE1` varchar(200) DEFAULT NULL,
  `POSTCODE2` varchar(200) DEFAULT NULL,
  `FEATURE1` varchar(200) DEFAULT NULL,
  `FEATURE2` varchar(200) DEFAULT NULL,
  `FEATURE3` varchar(200) DEFAULT NULL,
  `FEATURE4` varchar(200) DEFAULT NULL,
  `FEATURE5` varchar(200) DEFAULT NULL,
  `FEATURE6` varchar(200) DEFAULT NULL,
  `FEATURE7` varchar(200) DEFAULT NULL,
  `FEATURE8` varchar(200) DEFAULT NULL,
  `FEATURE9` varchar(200) DEFAULT NULL,
  `FEATURE10` varchar(200) DEFAULT NULL,
  `SUMMARY` varchar(200) DEFAULT NULL,
  `DESCRIPTION` varchar(200) DEFAULT NULL,
  `BRANCH_ID` varchar(200) DEFAULT NULL,
  `STATUS_ID` varchar(200) DEFAULT NULL,
  `BEDROOMS` varchar(200) DEFAULT NULL,
  `PRICE` varchar(200) DEFAULT NULL,
  `PROP_SUB_ID` varchar(200) DEFAULT NULL,
  `CREATE_DATE` varchar(200) DEFAULT NULL,
  `UPDATE_DATE` varchar(200) DEFAULT NULL,
  `DISPLAY_ADDRESS` varchar(200) DEFAULT NULL,
  `PUBLISHED_FLAG` varchar(200) DEFAULT NULL,
  `LET_DATE_AVAILABLE` varchar(200) DEFAULT NULL,
  `LET_FURN_ID` varchar(200) DEFAULT NULL,
  `LET_RENT_FREQUENCY` varchar(200) DEFAULT NULL,
  `TRANS_TYPE_ID` varchar(200) DEFAULT NULL,
  `LET_TYPE_ID` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_00` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_01` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_02` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_03` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_04` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_05` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_06` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_07` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_08` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_09` varchar(200) DEFAULT NULL,
  `MEDIA_DOCUMENT_00` varchar(200) DEFAULT NULL,
  `MEDIA_DOCUMENT_01` varchar(200) DEFAULT NULL,
  `MEDIA_DOCUMENT_TEXT_01` varchar(200) DEFAULT NULL,
  `MEDIA_DOCUMENT_50` varchar(200) DEFAULT NULL,
  `MEDIA_DOCUMENT_TEXT_50` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_60` varchar(200) DEFAULT NULL,
  `MEDIA_IMAGE_TEXT_60` varchar(200) DEFAULT NULL,
  `state` int(3) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_cron_data`
--

LOCK TABLES `jos_cron_data` WRITE;
/*!40000 ALTER TABLE `jos_cron_data` DISABLE KEYS */;
INSERT INTO `jos_cron_data` VALUES (1,'vtuktest_5','14 High Street','OX28','9GH','','','','','','','','','','','','','vtuktest','0','0','1000','0','','','14 High Street, Witney, Oxon, OX28 9GH','1','2010-04-28 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:13',NULL,NULL,NULL),(2,'vtuktest_VTUKPJM3','Flat 3','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','0','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2009-11-18 00:00:00','0','1','2','0','vtuktest_VTUKPJM3_IMG_00.jpg','vtuktest_VTUKPJM3_IMG_01.jpg','vtuktest_VTUKPJM3_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:49',NULL,NULL,NULL),(3,'vtuktest_VTUKPJM5','Flat 5','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','25','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2010-01-08 00:00:00','0','1','2','0','vtuktest_VTUKPJM5_IMG_00.jpg','vtuktest_VTUKPJM5_IMG_01.jpg','vtuktest_VTUKPJM5_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:49',NULL,NULL,NULL),(4,'vtuktest_PDA12','Flat 1 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','8','','','','1','2009-12-01 00:00:00','2','0','2','1','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:49',NULL,NULL,NULL),(5,'vtuktest_PDA12','Flat 2 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2010-01-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:49',NULL,NULL,NULL),(6,'vtuktest_PDA12','Flat 3 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2009-11-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:49',NULL,NULL,NULL),(7,'vtuktest_5','14 High Street','OX28','9GH','','','','','','','','','','','','','vtuktest','0','0','1000','0','','','14 High Street, Witney, Oxon, OX28 9GH','1','2010-04-28 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:52:49',NULL,NULL,NULL),(8,'vtuktest_VTUKPJM3','Flat 3','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','0','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2009-11-18 00:00:00','0','1','2','0','vtuktest_VTUKPJM3_IMG_00.jpg','vtuktest_VTUKPJM3_IMG_01.jpg','vtuktest_VTUKPJM3_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:12',NULL,NULL,NULL),(9,'vtuktest_VTUKPJM5','Flat 5','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','25','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2010-01-08 00:00:00','0','1','2','0','vtuktest_VTUKPJM5_IMG_00.jpg','vtuktest_VTUKPJM5_IMG_01.jpg','vtuktest_VTUKPJM5_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:12',NULL,NULL,NULL),(10,'vtuktest_PDA12','Flat 1 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','8','','','','1','2009-12-01 00:00:00','2','0','2','1','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:12',NULL,NULL,NULL),(11,'vtuktest_PDA12','Flat 2 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2010-01-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:12',NULL,NULL,NULL),(12,'vtuktest_PDA12','Flat 3 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2009-11-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:12',NULL,NULL,NULL),(13,'vtuktest_5','14 High Street','OX28','9GH','','','','','','','','','','','','','vtuktest','0','0','1000','0','','','14 High Street, Witney, Oxon, OX28 9GH','1','2010-04-28 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:12',NULL,NULL,NULL),(14,'vtuktest_VTUKPJM3','Flat 3','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','0','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2009-11-18 00:00:00','0','1','2','0','vtuktest_VTUKPJM3_IMG_00.jpg','vtuktest_VTUKPJM3_IMG_01.jpg','vtuktest_VTUKPJM3_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:46',NULL,NULL,NULL),(15,'vtuktest_VTUKPJM5','Flat 5','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','25','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2010-01-08 00:00:00','0','1','2','0','vtuktest_VTUKPJM5_IMG_00.jpg','vtuktest_VTUKPJM5_IMG_01.jpg','vtuktest_VTUKPJM5_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:46',NULL,NULL,NULL),(16,'vtuktest_PDA12','Flat 1 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','8','','','','1','2009-12-01 00:00:00','2','0','2','1','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:46',NULL,NULL,NULL),(17,'vtuktest_PDA12','Flat 2 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2010-01-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:46',NULL,NULL,NULL),(18,'vtuktest_PDA12','Flat 3 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2009-11-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:46',NULL,NULL,NULL),(19,'vtuktest_5','14 High Street','OX28','9GH','','','','','','','','','','','','','vtuktest','0','0','1000','0','','','14 High Street, Witney, Oxon, OX28 9GH','1','2010-04-28 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:53:46',NULL,NULL,NULL),(20,'vtuktest_VTUKPJM3','Flat 3','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','0','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2009-11-18 00:00:00','0','1','2','0','vtuktest_VTUKPJM3_IMG_00.jpg','vtuktest_VTUKPJM3_IMG_01.jpg','vtuktest_VTUKPJM3_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:55:22',NULL,NULL,NULL),(21,'vtuktest_VTUKPJM5','Flat 5','OX28','6GQ','','','','','','','','','','','','A Spacious Two bedroom apartment within walking distance of Witney Town Centre. Fitted Kitchen, Lounge, Bathroom with shower. Allocated Parking Easy access to A40 and Oxford.','vtuktest','0','2','750','25','','','Jacobs Mill, Early Road, Witney, Oxfordshire, OX28','1','2010-01-08 00:00:00','0','1','2','0','vtuktest_VTUKPJM5_IMG_00.jpg','vtuktest_VTUKPJM5_IMG_01.jpg','vtuktest_VTUKPJM5_IMG_02.jpg','','','','','','','','','','','','','','',NULL,'2011-06-07 16:55:22',NULL,NULL,NULL),(22,'vtuktest_PDA12','Flat 1 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','8','','','','1','2009-12-01 00:00:00','2','0','2','1','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:55:22',NULL,NULL,NULL),(23,'vtuktest_PDA12','Flat 2 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2010-01-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:55:22',NULL,NULL,NULL),(24,'vtuktest_PDA12','Flat 3 Draycott Avenue','OX28','2JD','','','','','','','','','','','','','vtuktest','0','1','0','0','','','','1','2009-11-01 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:55:22',NULL,NULL,NULL),(25,'vtuktest_5','14 High Street','OX28','9GH','','','','','','','','','','','','','vtuktest','0','0','1000','0','','','14 High Street, Witney, Oxon, OX28 9GH','1','2010-04-28 00:00:00','2','1','2','0','','','','','','','','','','','','','','','','','',NULL,'2011-06-07 16:55:22',NULL,NULL,NULL);
/*!40000 ALTER TABLE `jos_cron_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_apoll_options`
--

DROP TABLE IF EXISTS `jos_apoll_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_apoll_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `color` varchar(7) NOT NULL,
  `ordering` int(11) NOT NULL,
  `votes` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_id` (`poll_id`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_apoll_options`
--

LOCK TABLES `jos_apoll_options` WRITE;
/*!40000 ALTER TABLE `jos_apoll_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_apoll_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_hp_order`
--

DROP TABLE IF EXISTS `jos_hp_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_hp_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `total_price` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `payment_method` int(11) NOT NULL DEFAULT '0',
  `payment_method_name` varchar(200) DEFAULT NULL,
  `payment_info` varchar(1000) DEFAULT NULL,
  `order_note` varchar(5000) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `district` varchar(250) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `state` int(3) NOT NULL DEFAULT '0',
  `checked_out` datetime DEFAULT NULL,
  `checked_out_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_hp_order`
--

LOCK TABLES `jos_hp_order` WRITE;
/*!40000 ALTER TABLE `jos_hp_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_hp_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_content_frontpage`
--

DROP TABLE IF EXISTS `jos_content_frontpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_content_frontpage`
--

LOCK TABLES `jos_content_frontpage` WRITE;
/*!40000 ALTER TABLE `jos_content_frontpage` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_content_frontpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_languages`
--

DROP TABLE IF EXISTS `jos_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_languages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_languages`
--

LOCK TABLES `jos_languages` WRITE;
/*!40000 ALTER TABLE `jos_languages` DISABLE KEYS */;
INSERT INTO `jos_languages` VALUES (1,'en-GB','English (UK)','English (UK)','en','en','','','',1);
/*!40000 ALTER TABLE `jos_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_menu`
--

DROP TABLE IF EXISTS `jos_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL DEFAULT '',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias` (`client_id`,`parent_id`,`alias`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(255)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_menu`
--

LOCK TABLES `jos_menu` WRITE;
/*!40000 ALTER TABLE `jos_menu` DISABLE KEYS */;
INSERT INTO `jos_menu` VALUES (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,0,'0000-00-00 00:00:00',0,0,'',0,'',0,51,0,'*',0),(2,'menu','com_banners','Banners','','Banners','index.php?option=com_banners','component',0,1,1,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',1,10,0,'*',1),(3,'menu','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',2,3,0,'*',1),(4,'menu','com_banners_categories','Categories','','Banners/Categories','index.php?option=com_categories&extension=com_banners','component',0,2,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:banners-cat',0,'',4,5,0,'*',1),(5,'menu','com_banners_clients','Clients','','Banners/Clients','index.php?option=com_banners&view=clients','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners-clients',0,'',6,7,0,'*',1),(6,'menu','com_banners_tracks','Tracks','','Banners/Tracks','index.php?option=com_banners&view=tracks','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners-tracks',0,'',8,9,0,'*',1),(7,'menu','com_contact','Contacts','','Contacts','index.php?option=com_contact','component',0,1,1,8,0,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',11,16,0,'*',1),(8,'menu','com_contact','Contacts','','Contacts/Contacts','index.php?option=com_contact','component',0,7,2,8,0,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',12,13,0,'*',1),(9,'menu','com_contact_categories','Categories','','Contacts/Categories','index.php?option=com_categories&extension=com_contact','component',0,7,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:contact-cat',0,'',14,15,0,'*',1),(10,'menu','com_messages','Messaging','','Messaging','index.php?option=com_messages','component',0,1,1,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages',0,'',17,22,0,'*',1),(11,'menu','com_messages_add','New Private Message','','Messaging/New Private Message','index.php?option=com_messages&task=message.add','component',0,10,2,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages-add',0,'',18,19,0,'*',1),(12,'menu','com_messages_read','Read Private Message','','Messaging/Read Private Message','index.php?option=com_messages','component',0,10,2,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages-read',0,'',20,21,0,'*',1),(13,'menu','com_newsfeeds','News Feeds','','News Feeds','index.php?option=com_newsfeeds','component',0,1,1,17,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',23,28,0,'*',1),(14,'menu','com_newsfeeds_feeds','Feeds','','News Feeds/Feeds','index.php?option=com_newsfeeds','component',0,13,2,17,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',24,25,0,'*',1),(15,'menu','com_newsfeeds_categories','Categories','','News Feeds/Categories','index.php?option=com_categories&extension=com_newsfeeds','component',0,13,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds-cat',0,'',26,27,0,'*',1),(16,'menu','com_redirect','Redirect','','Redirect','index.php?option=com_redirect','component',0,1,1,24,0,0,'0000-00-00 00:00:00',0,0,'class:redirect',0,'',37,38,0,'*',1),(17,'menu','com_search','Search','','Search','index.php?option=com_search','component',0,1,1,19,0,0,'0000-00-00 00:00:00',0,0,'class:search',0,'',29,30,0,'*',1),(18,'menu','com_weblinks','Weblinks','','Weblinks','index.php?option=com_weblinks','component',0,1,1,21,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',31,36,0,'*',1),(19,'menu','com_weblinks_links','Links','','Weblinks/Links','index.php?option=com_weblinks','component',0,18,2,21,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',32,33,0,'*',1),(20,'menu','com_weblinks_categories','Categories','','Weblinks/Categories','index.php?option=com_categories&extension=com_weblinks','component',0,18,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks-cat',0,'',34,35,0,'*',1),(101,'mainmenu','Home','home','','home','index.php?option=com_content&view=featured','component',1,1,1,22,0,0,'0000-00-00 00:00:00',0,1,'',0,'{\"num_leading_articles\":\"1\",\"num_intro_articles\":\"3\",\"num_columns\":\"3\",\"num_links\":\"0\",\"orderby_pri\":\"\",\"orderby_sec\":\"front\",\"order_date\":\"\",\"multi_column_order\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_noauth\":\"\",\"article-allow_ratings\":\"\",\"article-allow_comments\":\"\",\"show_feed_link\":\"1\",\"feed_summary\":\"\",\"show_title\":\"\",\"link_titles\":\"\",\"show_intro\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_readmore\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_hits\":\"\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"show_page_heading\":1,\"page_title\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',39,40,1,'*',0),(102,'main','APOLL','apoll','','apoll','index.php?option=com_apoll','component',0,1,1,10000,0,0,'0000-00-00 00:00:00',0,1,'administrator/components/com_apoll/assets/apoll.png',0,'',41,46,0,'',1),(103,'main','COM_APOLL_POLLS','comapollpolls','','apoll/comapollpolls','index.php?option=com_apoll&view=polls','component',0,102,2,10000,0,0,'0000-00-00 00:00:00',0,1,'administrator/components/com_apoll/assets/apoll.png',0,'',42,43,0,'',1),(104,'main','COM_APOLL_CATEGORIES','comapollcategories','','apoll/comapollcategories','index.php?option=com_categories&extension=com_apoll','component',0,102,2,10000,0,0,'0000-00-00 00:00:00',0,1,'class:categories',0,'',44,45,0,'',1),(107,'main','hanhphuc.vn','hanhphucvn','','hanhphucvn','index.php?option=com_jnt_hanhphuc','component',0,1,1,10005,0,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',47,50,0,'',1),(108,'main','Service categories','service-categories','','hanhphucvn/service-categories','index.php?option=com_categories&extension=com_jnt_hanhphuc','component',0,107,2,10005,0,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',48,49,0,'',1);
/*!40000 ALTER TABLE `jos_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_usergroups`
--

DROP TABLE IF EXISTS `jos_usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_usergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_usergroups`
--

LOCK TABLES `jos_usergroups` WRITE;
/*!40000 ALTER TABLE `jos_usergroups` DISABLE KEYS */;
INSERT INTO `jos_usergroups` VALUES (1,0,1,20,'Public'),(2,1,6,17,'Registered'),(3,2,7,14,'Author'),(4,3,8,11,'Editor'),(5,4,9,10,'Publisher'),(6,1,2,5,'Manager'),(7,6,3,4,'Administrator'),(8,1,18,19,'Super Users');
/*!40000 ALTER TABLE `jos_usergroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_updates`
--

DROP TABLE IF EXISTS `jos_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_site_id` int(11) DEFAULT '0',
  `extension_id` int(11) DEFAULT '0',
  `categoryid` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT '',
  `description` text NOT NULL,
  `element` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `folder` varchar(20) DEFAULT '',
  `client_id` tinyint(3) DEFAULT '0',
  `version` varchar(10) DEFAULT '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Available Updates';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_updates`
--

LOCK TABLES `jos_updates` WRITE;
/*!40000 ALTER TABLE `jos_updates` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_apoll_polls`
--

DROP TABLE IF EXISTS `jos_apoll_polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_apoll_polls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `catid` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime DEFAULT '0000-00-00 00:00:00',
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_apoll_polls`
--

LOCK TABLES `jos_apoll_polls` WRITE;
/*!40000 ALTER TABLE `jos_apoll_polls` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_apoll_polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_modules_menu`
--

DROP TABLE IF EXISTS `jos_modules_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_modules_menu`
--

LOCK TABLES `jos_modules_menu` WRITE;
/*!40000 ALTER TABLE `jos_modules_menu` DISABLE KEYS */;
INSERT INTO `jos_modules_menu` VALUES (1,0),(2,0),(3,0),(4,0),(6,0),(7,0),(8,0),(9,0),(10,0),(12,0),(13,0),(14,0),(15,0),(16,0),(17,0),(18,0),(19,0),(20,0);
/*!40000 ALTER TABLE `jos_modules_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_template_styles`
--

DROP TABLE IF EXISTS `jos_template_styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_template_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(50) NOT NULL DEFAULT '',
  `client_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `home` char(7) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_template_styles`
--

LOCK TABLES `jos_template_styles` WRITE;
/*!40000 ALTER TABLE `jos_template_styles` DISABLE KEYS */;
INSERT INTO `jos_template_styles` VALUES (2,'bluestork',1,'1','Bluestork - Default','{\"useRoundedCorners\":\"1\",\"showSiteName\":\"0\"}'),(3,'atomic',0,'0','Atomic - Default','{}'),(4,'beez_20',0,'1','Beez2 - Default','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/joomla_black.gif\",\"sitetitle\":\"Joomla!\",\"sitedescription\":\"Open Source Content Management\",\"navposition\":\"left\",\"templatecolor\":\"personal\",\"html5\":\"0\"}'),(5,'hathor',1,'0','Hathor - Default','{\"showSiteName\":\"0\",\"colourChoice\":\"\",\"boldText\":\"0\"}'),(6,'beez5',0,'0','Beez5 - Default-Fruit Shop','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/sampledata\\/fruitshop\\/fruits.gif\",\"sitetitle\":\"Matuna Market \",\"sitedescription\":\"Fruit Shop Sample Site\",\"navposition\":\"left\",\"html5\":\"0\"}');
/*!40000 ALTER TABLE `jos_template_styles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_redirect_links`
--

DROP TABLE IF EXISTS `jos_redirect_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_redirect_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(150) NOT NULL,
  `new_url` varchar(150) NOT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_redirect_links`
--

LOCK TABLES `jos_redirect_links` WRITE;
/*!40000 ALTER TABLE `jos_redirect_links` DISABLE KEYS */;
INSERT INTO `jos_redirect_links` VALUES (1,'http://localhost/hanhphuc/index.php?option=com_jnt_hanhphuc&view=intro&bid=43','','http://localhost/hanhphuc/index.php?option=com_users&view=profile','',0,'2011-06-06 13:49:32','0000-00-00 00:00:00'),(4,'http://localhost/hanhphuc/index.php?option=com_user&view=login','','','',0,'2011-06-06 14:47:43','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `jos_redirect_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_users`
--

DROP TABLE IF EXISTS `jos_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `user_type` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_users`
--

LOCK TABLES `jos_users` WRITE;
/*!40000 ALTER TABLE `jos_users` DISABLE KEYS */;
INSERT INTO `jos_users` VALUES (42,'Super User','nttuyen','nttuyen_it@yahoo.com','336cd6ced12f4281dd7423d332135b01:ZXnIywmfw88OChYELOZcjtsOgehHlFzL','deprecated',0,1,'2011-05-15 06:59:57','2011-07-12 15:03:22','','',0),(43,'business1','business1','business1@business.com','4346cde67ba5a0e4a25acecd0ee5bb24:JzO4CIY4ljD5dD1mo9zA6z2IliCrIQKb','',0,0,'2011-06-06 13:37:09','2011-06-19 07:05:28','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}',2),(44,'business2','business2','business2@business.com','be5588f876b0e3eb08c99bdde07a605d:IMx1qoNnHExVM7NGKskm9iV5reiFJwpT','',0,0,'2011-06-06 13:41:43','0000-00-00 00:00:00','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}',2),(45,'user1','user1','user1@user.com','cfb15c239ed3927d2964f0c0a27f503e:x0VQYF2UEFzso1H81KFdYcAgl9jJzEIa','',0,0,'2011-06-06 13:43:20','0000-00-00 00:00:00','','{\"admin_style\":\"\",\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"\"}',1);
/*!40000 ALTER TABLE `jos_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_menu_types`
--

DROP TABLE IF EXISTS `jos_menu_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_menu_types`
--

LOCK TABLES `jos_menu_types` WRITE;
/*!40000 ALTER TABLE `jos_menu_types` DISABLE KEYS */;
INSERT INTO `jos_menu_types` VALUES (1,'mainmenu','Main Menu','The main menu for the site');
/*!40000 ALTER TABLE `jos_menu_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_hp_business_promotion`
--

DROP TABLE IF EXISTS `jos_hp_business_promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_hp_business_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `discount_percent` int(11) DEFAULT '0',
  `discount_absolute` int(11) DEFAULT '0',
  `content` varchar(500) DEFAULT NULL,
  `state` int(3) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_hp_business_promotion`
--

LOCK TABLES `jos_hp_business_promotion` WRITE;
/*!40000 ALTER TABLE `jos_hp_business_promotion` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_hp_business_promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_update_categories`
--

DROP TABLE IF EXISTS `jos_update_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_update_categories` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '',
  `description` text NOT NULL,
  `parent` int(11) DEFAULT '0',
  `updatesite` int(11) DEFAULT '0',
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Update Categories';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_update_categories`
--

LOCK TABLES `jos_update_categories` WRITE;
/*!40000 ALTER TABLE `jos_update_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_update_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_update_sites`
--

DROP TABLE IF EXISTS `jos_update_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_update_sites` (
  `update_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `location` text NOT NULL,
  `enabled` int(11) DEFAULT '0',
  PRIMARY KEY (`update_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Update Sites';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_update_sites`
--

LOCK TABLES `jos_update_sites` WRITE;
/*!40000 ALTER TABLE `jos_update_sites` DISABLE KEYS */;
INSERT INTO `jos_update_sites` VALUES (1,'Joomla Core','collection','http://update.joomla.org/core/list.xml',1),(2,'Joomla Extension Directory','collection','http://update.joomla.org/jed/list.xml',1);
/*!40000 ALTER TABLE `jos_update_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_hp_business_info`
--

DROP TABLE IF EXISTS `jos_hp_business_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_hp_business_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) DEFAULT NULL,
  `content` varchar(1000) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_hp_business_info`
--

LOCK TABLES `jos_hp_business_info` WRITE;
/*!40000 ALTER TABLE `jos_hp_business_info` DISABLE KEYS */;
INSERT INTO `jos_hp_business_info` VALUES (3,43,'Được rồi đấy, giới thiệu về doanh nghiệp ở đây. Đi kiếm cái gì đó copy về xem nào.\r\nHội nghị An ninh Châu Á lần này có sự tham dự của một Tổng thống, 2 Thủ  tướng, 28 Bộ trưởng Quốc phòng và gần 2.000 quan chức quốc phòng, học  giả… Tại diễn đàn, Đại tướng Phùng Quang Thanh đã có bài phát biểu ở  phiên thứ 5 về “Đối phó thách thức an ninh mới trên biển”. Dư luận đánh  giá đây là bài phát biểu tốt, ở tầm cao chiến lược và đóng góp tích cực  vào quá trình phát triển, ổn định của khu vực.',NULL,NULL);
/*!40000 ALTER TABLE `jos_hp_business_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_modules`
--

DROP TABLE IF EXISTS `jos_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) DEFAULT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_modules`
--

LOCK TABLES `jos_modules` WRITE;
/*!40000 ALTER TABLE `jos_modules` DISABLE KEYS */;
INSERT INTO `jos_modules` VALUES (1,'Main Menu','','',1,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',1,1,'{\"menutype\":\"mainmenu\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"0\",\"tag_id\":\"\",\"class_sfx\":\"\",\"window_open\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"_menu\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(2,'Login','','',1,'login',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'',1,'*'),(3,'Popular Articles','','',3,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_popular',3,1,'{\"count\":\"5\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(4,'Recently Added Articles','','',4,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_latest',3,1,'{\"count\":\"5\",\"ordering\":\"c_dsc\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(6,'Unread Messages','','',1,'header',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_unread',3,1,'',1,'*'),(7,'Online Users','','',2,'header',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_online',3,1,'',1,'*'),(8,'Toolbar','','',1,'toolbar',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_toolbar',3,1,'',1,'*'),(9,'Quick Icons','','',1,'icon',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_quickicon',3,1,'',1,'*'),(10,'Logged-in Users','','',2,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_logged',3,1,'{\"count\":\"5\",\"name\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\",\"automatic_title\":\"1\"}',1,'*'),(12,'Admin Menu','','',1,'menu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',3,1,'{\"layout\":\"\",\"moduleclass_sfx\":\"\",\"shownew\":\"1\",\"showhelp\":\"1\",\"cache\":\"0\"}',1,'*'),(13,'Admin Submenu','','',1,'submenu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_submenu',3,1,'',1,'*'),(14,'User Status','','',1,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_status',3,1,'',1,'*'),(15,'Title','','',1,'title',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_title',3,1,'',1,'*'),(16,'Login Form','','',7,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'{\"greeting\":\"1\",\"name\":\"0\"}',0,'*'),(17,'Breadcrumbs','','',1,'position-2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_breadcrumbs',1,1,'{\"moduleclass_sfx\":\"\",\"showHome\":\"1\",\"homeText\":\"Home\",\"showComponent\":\"1\",\"separator\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(18,'Banners','','',1,'position-5',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_banners',1,1,'{\"target\":\"1\",\"count\":\"1\",\"cid\":\"1\",\"catid\":[\"27\"],\"tag_search\":\"0\",\"ordering\":\"0\",\"header_text\":\"\",\"footer_text\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\"}',0,'*'),(19,'Danh mục dịch vụ','','',0,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_hanhphuc_service_categories',1,1,'{\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(20,'Quản lý tài khoản','','',0,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_hanhphuc_usermenu',1,1,'{\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*');
/*!40000 ALTER TABLE `jos_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_user_usergroup_map`
--

DROP TABLE IF EXISTS `jos_user_usergroup_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_user_usergroup_map`
--

LOCK TABLES `jos_user_usergroup_map` WRITE;
/*!40000 ALTER TABLE `jos_user_usergroup_map` DISABLE KEYS */;
INSERT INTO `jos_user_usergroup_map` VALUES (42,8),(43,2),(44,2),(45,2);
/*!40000 ALTER TABLE `jos_user_usergroup_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_contact_details`
--

DROP TABLE IF EXISTS `jos_contact_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_contact_details`
--

LOCK TABLES `jos_contact_details` WRITE;
/*!40000 ALTER TABLE `jos_contact_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_contact_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_update_sites_extensions`
--

DROP TABLE IF EXISTS `jos_update_sites_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL DEFAULT '0',
  `extension_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`update_site_id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_update_sites_extensions`
--

LOCK TABLES `jos_update_sites_extensions` WRITE;
/*!40000 ALTER TABLE `jos_update_sites_extensions` DISABLE KEYS */;
INSERT INTO `jos_update_sites_extensions` VALUES (1,700),(2,700);
/*!40000 ALTER TABLE `jos_update_sites_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_schemas`
--

DROP TABLE IF EXISTS `jos_schemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY (`extension_id`,`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_schemas`
--

LOCK TABLES `jos_schemas` WRITE;
/*!40000 ALTER TABLE `jos_schemas` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_schemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_banner_clients`
--

DROP TABLE IF EXISTS `jos_banner_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_banner_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_banner_clients`
--

LOCK TABLES `jos_banner_clients` WRITE;
/*!40000 ALTER TABLE `jos_banner_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_banner_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_content_rating`
--

DROP TABLE IF EXISTS `jos_content_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_content_rating`
--

LOCK TABLES `jos_content_rating` WRITE;
/*!40000 ALTER TABLE `jos_content_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_content_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_core_log_searches`
--

DROP TABLE IF EXISTS `jos_core_log_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_core_log_searches`
--

LOCK TABLES `jos_core_log_searches` WRITE;
/*!40000 ALTER TABLE `jos_core_log_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_core_log_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_assets`
--

DROP TABLE IF EXISTS `jos_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_assets`
--

LOCK TABLES `jos_assets` WRITE;
/*!40000 ALTER TABLE `jos_assets` DISABLE KEYS */;
INSERT INTO `jos_assets` VALUES (1,0,1,428,0,'root.1','Root Asset','{\"core.login.site\":{\"6\":1,\"2\":1},\"core.login.admin\":{\"6\":1},\"core.admin\":{\"8\":1},\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(2,1,1,2,1,'com_admin','com_admin','{}'),(3,1,3,6,1,'com_banners','com_banners','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(4,1,7,8,1,'com_cache','com_cache','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(5,1,9,10,1,'com_checkin','com_checkin','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(6,1,11,12,1,'com_config','com_config','{}'),(7,1,13,16,1,'com_contact','com_contact','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(8,1,17,20,1,'com_content','com_content','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),(9,1,21,22,1,'com_cpanel','com_cpanel','{}'),(10,1,23,24,1,'com_installer','com_installer','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1},\"core.delete\":[],\"core.edit.state\":[]}'),(11,1,25,26,1,'com_languages','com_languages','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(12,1,27,28,1,'com_login','com_login','{}'),(13,1,29,30,1,'com_mailto','com_mailto','{}'),(14,1,31,32,1,'com_massmail','com_massmail','{}'),(15,1,33,34,1,'com_media','com_media','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":{\"5\":1}}'),(16,1,35,36,1,'com_menus','com_menus','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(17,1,37,38,1,'com_messages','com_messages','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(18,1,39,40,1,'com_modules','com_modules','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(19,1,41,44,1,'com_newsfeeds','com_newsfeeds','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(20,1,45,46,1,'com_plugins','com_plugins','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(21,1,47,48,1,'com_redirect','com_redirect','{\"core.admin\":{\"7\":1},\"core.manage\":[]}'),(22,1,49,50,1,'com_search','com_search','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(23,1,51,52,1,'com_templates','com_templates','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(24,1,53,54,1,'com_users','com_users','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.own\":{\"6\":1},\"core.edit.state\":[]}'),(25,1,55,58,1,'com_weblinks','com_weblinks','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),(26,1,59,60,1,'com_wrapper','com_wrapper','{}'),(27,8,18,19,2,'com_content.category.2','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(28,3,4,5,2,'com_banners.category.3','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(29,7,14,15,2,'com_contact.category.4','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(30,19,42,43,2,'com_newsfeeds.category.5','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(31,25,56,57,2,'com_weblinks.category.6','Uncategorised','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),(32,1,414,421,1,'com_jnt_hanhphuc.category.7','Áo cưới','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(33,32,415,416,2,'com_jnt_hanhphuc.category.8','Váy cô dâu','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(34,32,417,418,2,'com_jnt_hanhphuc.category.9','Áo dài','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(35,32,419,420,2,'com_jnt_hanhphuc.category.10','Comple','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(36,1,422,427,1,'com_jnt_hanhphuc.category.11','Xe hoa','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(37,36,423,424,2,'com_jnt_hanhphuc.category.12','Xe tự lái','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(38,36,425,426,2,'com_jnt_hanhphuc.category.13','Xe có lái','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}');
/*!40000 ALTER TABLE `jos_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_messages_cfg`
--

DROP TABLE IF EXISTS `jos_messages_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_messages_cfg`
--

LOCK TABLES `jos_messages_cfg` WRITE;
/*!40000 ALTER TABLE `jos_messages_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_messages_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_banners`
--

DROP TABLE IF EXISTS `jos_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_banners`
--

LOCK TABLES `jos_banners` WRITE;
/*!40000 ALTER TABLE `jos_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_categories`
--

DROP TABLE IF EXISTS `jos_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `extension` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(5120) NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_categories`
--

LOCK TABLES `jos_categories` WRITE;
/*!40000 ALTER TABLE `jos_categories` DISABLE KEYS */;
INSERT INTO `jos_categories` VALUES (1,0,0,0,25,0,'','system','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'{}','','','',0,'2009-10-18 16:07:09',0,'0000-00-00 00:00:00',0,'*'),(2,27,1,1,2,1,'uncategorised','com_content','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:26:37',0,'0000-00-00 00:00:00',0,'*'),(3,28,1,3,4,1,'uncategorised','com_banners','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\",\"foobar\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:27:35',0,'0000-00-00 00:00:00',0,'*'),(4,29,1,5,6,1,'uncategorised','com_contact','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:27:57',0,'0000-00-00 00:00:00',0,'*'),(5,30,1,7,8,1,'uncategorised','com_newsfeeds','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:15',0,'0000-00-00 00:00:00',0,'*'),(6,31,1,9,10,1,'uncategorised','com_weblinks','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:33',0,'0000-00-00 00:00:00',0,'*'),(7,32,1,11,18,1,'ao-cuoi','com_jnt_hanhphuc','Áo cưới','ao-cuoi','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:45:42',0,'0000-00-00 00:00:00',0,'*'),(8,33,7,12,13,2,'ao-cuoi/vay-co-dau','com_jnt_hanhphuc','Váy cô dâu','vay-co-dau','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:45:56',0,'0000-00-00 00:00:00',0,'*'),(9,34,7,14,15,2,'ao-cuoi/ao-dai','com_jnt_hanhphuc','Áo dài','ao-dai','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:46:21',0,'0000-00-00 00:00:00',0,'*'),(10,35,7,16,17,2,'ao-cuoi/comple','com_jnt_hanhphuc','Comple','comple','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:46:33',0,'0000-00-00 00:00:00',0,'*'),(11,36,1,19,24,1,'xe-hoa','com_jnt_hanhphuc','Xe hoa','xe-hoa','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:46:44',0,'0000-00-00 00:00:00',0,'*'),(12,37,11,20,21,2,'xe-hoa/xe-tu-lai','com_jnt_hanhphuc','Xe tự lái','xe-tu-lai','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:47:01',0,'0000-00-00 00:00:00',0,'*'),(13,38,11,22,23,2,'xe-hoa/xe-co-lai','com_jnt_hanhphuc','Xe có lái','xe-co-lai','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',42,'2011-06-06 13:47:13',0,'0000-00-00 00:00:00',0,'*');
/*!40000 ALTER TABLE `jos_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_viewlevels`
--

DROP TABLE IF EXISTS `jos_viewlevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jos_viewlevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jos_viewlevels`
--

LOCK TABLES `jos_viewlevels` WRITE;
/*!40000 ALTER TABLE `jos_viewlevels` DISABLE KEYS */;
INSERT INTO `jos_viewlevels` VALUES (1,'Public',0,'[1]'),(2,'Registered',1,'[6,2,8]'),(3,'Special',2,'[6,3,8]');
/*!40000 ALTER TABLE `jos_viewlevels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-07-14  7:01:10
