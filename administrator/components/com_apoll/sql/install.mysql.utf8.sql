--
-- Table structure for table '#__apoll_polls'
--

CREATE TABLE IF NOT EXISTS `#__apoll_polls` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- 
-- Table structure for table '#__apoll_options'
-- 

CREATE TABLE IF NOT EXISTS `#__apoll_options` (
  `id` int(11) NOT NULL auto_increment,
  `poll_id` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `color` varchar(7)  NOT NULL,
  `ordering` int(11) NOT NULL,
  `votes` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`,`text`(1))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;