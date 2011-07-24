
ALTER TABLE `jos_users` ADD COLUMN `user_type` INT(3) NOT NULL DEFAULT 0  AFTER `params` ;


CREATE TABLE `jos_hp_business_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) DEFAULT NULL,
  `content` varchar(1000) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


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


CREATE  TABLE `jos_hp_order` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `username` VARCHAR(200) NULL ,
  `total_price` INT NOT NULL DEFAULT 0 ,
  `price` INT NOT NULL DEFAULT 0 ,
  `payment_method` INT NOT NULL DEFAULT 0 ,
  `payment_method_name` VARCHAR(200) NULL ,
  `payment_info` VARCHAR(1000) NULL ,
  `order_note` VARCHAR(5000) NULL ,
  `ipaddress` VARCHAR(20) NULL ,
  `address` VARCHAR(500) NULL ,
  `city` VARCHAR(200) NULL ,
  `district` VARCHAR(250) NULL ,
  `phone` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `state` INT(3) NOT NULL DEFAULT 0 ,
  `checked_out` DATETIME NULL ,
  `checked_out_by` INT NULL ,
  `created` DATETIME NULL ,
  `created_by` INT NULL ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) )
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


CREATE  TABLE `jos_hp_order_items` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `order_id` INT NOT NULL ,
  `item_id` INT NOT NULL ,
  `qty` INT(3) NULL ,
  `origin_price` INT NOT NULL DEFAULT 0 ,
  `price` INT NOT NULL DEFAULT 0 ,
  `created` DATETIME NULL ,
  `created_by` INT NULL ,
  `modified` DATETIME NULL ,
  `modified_by` INT NULL ,
  PRIMARY KEY (`id`) )
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
