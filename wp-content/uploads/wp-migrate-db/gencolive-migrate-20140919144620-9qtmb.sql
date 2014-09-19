# WordPress MySQL database migration
#
# Generated: Friday 19. September 2014 14:46 UTC
# Hostname: localhost
# Database: `gencoLive`
# --------------------------------------------------------

/*!40101 SET NAMES utf8 */;

SET sql_mode='NO_AUTO_VALUE_ON_ZERO';



#
# Delete any existing table `wp_commentmeta`
#

DROP TABLE IF EXISTS `wp_commentmeta`;


#
# Table structure of table `wp_commentmeta`
#

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_commentmeta`
#
INSERT INTO `wp_commentmeta` ( `meta_id`, `comment_id`, `meta_key`, `meta_value`) VALUES
(5, 4, 'is_customer_note', '0'),
(6, 5, 'is_customer_note', '0'),
(7, 6, 'is_customer_note', '0'),
(8, 7, 'is_customer_note', '0'),
(9, 8, 'is_customer_note', '0'),
(10, 9, 'is_customer_note', '0'),
(11, 10, 'is_customer_note', '0'),
(12, 11, 'is_customer_note', '0'),
(13, 12, 'is_customer_note', '0'),
(14, 13, 'is_customer_note', '0'),
(15, 14, 'rating', '5'),
(16, 15, 'is_customer_note', '0'),
(17, 16, 'is_customer_note', '0'),
(18, 17, 'is_customer_note', '0'),
(19, 18, 'is_customer_note', '0'),
(20, 19, 'is_customer_note', '0'),
(21, 20, 'is_customer_note', '0') ;

#
# End of data contents of table `wp_commentmeta`
# --------------------------------------------------------



#
# Delete any existing table `wp_comments`
#

DROP TABLE IF EXISTS `wp_comments`;


#
# Table structure of table `wp_comments`
#

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_comments`
#
INSERT INTO `wp_comments` ( `comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(4, 1364, 'WooCommerce', 'woocommerce@dev.genco.tv', '', '', '2014-09-16 13:04:32', '2014-09-16 17:04:32', 'IPN payment completed', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(5, 1364, 'WooCommerce', 'woocommerce@dev.genco.tv', '', '', '2014-09-16 13:04:32', '2014-09-16 17:04:32', 'Order status changed from pending to processing.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(6, 1364, 'WooCommerce', 'woocommerce@dev.genco.tv', '', '', '2014-09-16 13:04:32', '2014-09-16 17:04:32', 'Order item stock reduced successfully.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(7, 1416, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-16 22:15:13', '2014-09-17 02:15:13', 'Unpaid order cancelled - time limit reached. Order status changed from pending to cancelled.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(8, 1417, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-16 23:22:41', '2014-09-17 03:22:41', 'Unpaid order cancelled - time limit reached. Order status changed from pending to cancelled.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(9, 1418, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-17 05:32:00', '2014-09-17 09:32:00', 'Order cancelled by customer. Order status changed from pending to cancelled.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(10, 1458, 'chris', 'chris@genco.tv', '', '', '2014-09-18 11:39:11', '2014-09-18 15:39:11', 'PDT payment completed', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(11, 1458, 'chris', 'chris@genco.tv', '', '', '2014-09-18 11:39:12', '2014-09-18 15:39:12', 'Order status changed from pending to processing.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(12, 1458, 'chris', 'chris@genco.tv', '', '', '2014-09-18 11:39:12', '2014-09-18 15:39:12', 'Order item stock reduced successfully.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(13, 1458, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 11:39:20', '2014-09-18 15:39:20', 'IPN payment completed', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(14, 455, 'Cindy Dwyer', 'Cindyb.dwyer@gmail.com', '', '70.215.70.98', '2014-09-18 12:27:57', '2014-09-18 16:27:57', 'Great shirt, great logo', 0, '1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '', 0, 0),
(15, 1461, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 12:35:32', '2014-09-18 16:35:32', 'PDT payment completed', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(16, 1461, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 12:35:33', '2014-09-18 16:35:33', 'Order status changed from pending to processing.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(17, 1461, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 12:35:33', '2014-09-18 16:35:33', 'Order item stock reduced successfully.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(18, 1461, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 12:35:39', '2014-09-18 16:35:39', 'IPN payment completed', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(19, 1460, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 13:17:38', '2014-09-18 17:17:38', 'Unpaid order cancelled - time limit reached. Order status changed from pending to cancelled.', 0, '1', 'WooCommerce', 'order_note', 0, 0),
(20, 1477, 'WooCommerce', 'woocommerce@genco.tv', '', '', '2014-09-18 16:18:14', '2014-09-18 20:18:14', 'Unpaid order cancelled - time limit reached. Order status changed from pending to cancelled.', 0, '1', 'WooCommerce', 'order_note', 0, 0) ;

#
# End of data contents of table `wp_comments`
# --------------------------------------------------------



#
# Delete any existing table `wp_em_modal_metas`
#

DROP TABLE IF EXISTS `wp_em_modal_metas`;


#
# Table structure of table `wp_em_modal_metas`
#

CREATE TABLE `wp_em_modal_metas` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `modal_id` mediumint(9) unsigned NOT NULL,
  `display` longtext,
  `close` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_em_modal_metas`
#

#
# End of data contents of table `wp_em_modal_metas`
# --------------------------------------------------------



#
# Delete any existing table `wp_em_modals`
#

DROP TABLE IF EXISTS `wp_em_modals`;


#
# Table structure of table `wp_em_modals`
#

CREATE TABLE `wp_em_modals` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` mediumint(9) unsigned NOT NULL DEFAULT '1',
  `name` varchar(150) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_sitewide` tinyint(1) NOT NULL DEFAULT '0',
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_trash` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_em_modals`
#

#
# End of data contents of table `wp_em_modals`
# --------------------------------------------------------



#
# Delete any existing table `wp_em_theme_metas`
#

DROP TABLE IF EXISTS `wp_em_theme_metas`;


#
# Table structure of table `wp_em_theme_metas`
#

CREATE TABLE `wp_em_theme_metas` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` mediumint(9) unsigned NOT NULL,
  `overlay` longtext,
  `container` longtext,
  `close` longtext,
  `title` longtext,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_em_theme_metas`
#
INSERT INTO `wp_em_theme_metas` ( `id`, `theme_id`, `overlay`, `container`, `close`, `title`, `content`) VALUES
(1, 1, 'a:1:{s:10:"background";a:2:{s:5:"color";s:7:"#ffffff";s:7:"opacity";i:100;}}', 'a:4:{s:7:"padding";i:18;s:10:"background";a:2:{s:5:"color";s:7:"#f9f9f9";s:7:"opacity";i:100;}s:6:"border";a:4:{s:5:"style";s:4:"none";s:5:"color";s:7:"#000000";s:5:"width";i:1;s:6:"radius";i:0;}s:9:"boxshadow";a:7:{s:5:"inset";s:2:"no";s:10:"horizontal";i:1;s:8:"vertical";i:1;s:4:"blur";i:3;s:6:"spread";i:0;s:5:"color";s:7:"#020202";s:7:"opacity";i:23;}}', 'a:9:{s:4:"text";s:5:"CLOSE";s:8:"location";s:8:"topright";s:8:"position";a:4:{s:3:"top";i:0;s:4:"left";i:0;s:6:"bottom";i:0;s:5:"right";i:0;}s:7:"padding";i:8;s:10:"background";a:2:{s:5:"color";s:7:"#00b7cd";s:7:"opacity";i:100;}s:4:"font";a:3:{s:5:"color";s:7:"#ffffff";s:4:"size";i:12;s:6:"family";s:15:"Times New Roman";}s:6:"border";a:4:{s:5:"style";s:4:"none";s:5:"color";s:7:"#ffffff";s:5:"width";i:1;s:6:"radius";i:0;}s:9:"boxshadow";a:7:{s:5:"inset";s:2:"no";s:10:"horizontal";i:0;s:8:"vertical";i:0;s:4:"blur";i:0;s:6:"spread";i:0;s:5:"color";s:7:"#020202";s:7:"opacity";i:0;}s:10:"textshadow";a:5:{s:10:"horizontal";i:0;s:8:"vertical";i:0;s:4:"blur";i:0;s:5:"color";s:7:"#000000";s:7:"opacity";i:0;}}', 'a:3:{s:4:"font";a:3:{s:5:"color";s:7:"#000000";s:4:"size";i:32;s:6:"family";s:6:"Tahoma";}s:4:"text";a:1:{s:5:"align";s:4:"left";}s:10:"textshadow";a:5:{s:10:"horizontal";i:0;s:8:"vertical";i:0;s:4:"blur";i:0;s:5:"color";s:7:"#020202";s:7:"opacity";i:0;}}', 'a:1:{s:4:"font";a:2:{s:5:"color";s:7:"#8c8c8c";s:6:"family";s:15:"Times New Roman";}}') ;

#
# End of data contents of table `wp_em_theme_metas`
# --------------------------------------------------------



#
# Delete any existing table `wp_em_themes`
#

DROP TABLE IF EXISTS `wp_em_themes`;


#
# Table structure of table `wp_em_themes`
#

CREATE TABLE `wp_em_themes` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_trash` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_em_themes`
#
INSERT INTO `wp_em_themes` ( `id`, `name`, `created`, `modified`, `is_system`, `is_active`, `is_trash`) VALUES
(1, 'Default', '2014-09-02 16:27:54', '2014-09-02 16:27:54', 0, 1, 0) ;

#
# End of data contents of table `wp_em_themes`
# --------------------------------------------------------



#
# Delete any existing table `wp_layerslider`
#

DROP TABLE IF EXISTS `wp_layerslider`;


#
# Table structure of table `wp_layerslider`
#

CREATE TABLE `wp_layerslider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `author` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `data` mediumtext NOT NULL,
  `date_c` int(10) NOT NULL,
  `date_m` int(11) NOT NULL,
  `flag_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `flag_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


#
# Data contents of table `wp_layerslider`
#
INSERT INTO `wp_layerslider` ( `id`, `author`, `name`, `slug`, `data`, `date_c`, `date_m`, `flag_hidden`, `flag_deleted`) VALUES
(1, 1, 'Carousel demo', '', '{"properties":{"title":"Carousel demo","width":"1280","height":"720","responsive":"on","responsiveunder":"0","sublayercontainer":"0","pauseonhover":"on","firstlayer":"1","animatefirstlayer":"on","twowayslideshow":"on","loops":"0","forceloopnum":"on","autoplayvideos":"on","autopauseslideshow":"auto","youtubepreview":"maxresdefault.jpg","keybnav":"on","touchnav":"on","skin":"carousel","backgroundcolor":"transparent","backgroundimage":"","sliderstyle":"margin-bottom: 50px;","navprevnext":"on","navbuttons":"on","thumb_nav":"always","thumb_width":"100","thumb_height":"60","thumb_container_width":"60%","thumb_active_opacity":"35","thumb_inactive_opacity":"100","imgpreload":"on","yourlogo":"","yourlogostyle":"left: 10px; top: 10px;","yourlogolink":"","yourlogotarget":"_self","cbinit":"function(element) { }","cbstart":"function(data) { }","cbstop":"function(data) { }","cbpause":"function(data) { }","cbanimstart":"function(data) { }","cbanimstop":"function(data) { }","cbprev":"function(data) { }","cbnext":"function(data) { }"},"layers":[{"properties":{"3d_transitions":"","2d_transitions":"73","custom_3d_transitions":"","custom_2d_transitions":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Carousel-demo\\/tablet.png","thumbnail":"","slidedelay":"4000","new_transitions":"on","slidedirection":"right","timeshift":"0","durationin":"1500","easingin":"easeInOutQuint","delayin":"0","durationout":"1500","easingout":"easeInOutQuint","delayout":"0","layer_link":"","layer_link_target":"_self","id":"","deeplink":"","backgroundId":"","thumbnailId":""},"sublayers":[{"subtitle":"Price","type":"h6","image":"","html":"only $499","slidedirection":"fade","durationin":"500","easingin":"easeInOutQuint","delayin":"600","rotatein":"30","scalein":".1","slideoutdirection":"fade","durationout":"500","easingout":"easeInOutQuint","delayout":"0","rotateout":"0","scaleout":".1","level":"-1","showuntil":"0","url":"","target":"_self","styles":"{\\\\\\"padding-top\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"20\\\\\\",\\\\\\"padding-bottom\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"20\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Oswald\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#ff7700\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"5\\\\\\"}","top":"70%","left":"25%","style":"font-weight: 400; box-shadow: 0px 2px 8px -2px black;","id":"","class":"","title":"","alt":"","rel":"","imageId":""},{"subtitle":"Sample price","type":"h6","image":"","html":"Sample price","slidedirection":"fade","durationin":"500","easingin":"easeInOutQuint","delayin":"500","rotatein":"-30","scalein":".1","slideoutdirection":"fade","durationout":"500","easingout":"easeInOutQuint","delayout":"0","rotateout":"0","scaleout":".1","level":"-1","showuntil":"0","url":"","target":"_self","styles":"{\\\\\\"padding-top\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"20\\\\\\",\\\\\\"padding-bottom\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"20\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Oswald\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#000000\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"5\\\\\\"}","top":"63%","left":"25%","style":"font-weight: 400; box-shadow: 0px 2px 8px -2px black;","id":"","class":"","title":"","alt":"","rel":"","imageId":""}]},{"properties":{"3d_transitions":"","2d_transitions":"73","custom_3d_transitions":"","custom_2d_transitions":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Carousel-demo\\/computer.png","thumbnail":"","slidedelay":"4000","new_transitions":"on","slidedirection":"right","timeshift":"0","durationin":"1500","easingin":"easeInOutQuint","delayin":"0","durationout":"1500","easingout":"easeInOutQuint","delayout":"0","layer_link":"","layer_link_target":"_self","id":"","deeplink":"","backgroundId":"","thumbnailId":""},"sublayers":[{"subtitle":"Price","type":"h6","image":"","html":"only $1299","slidedirection":"fade","durationin":"500","easingin":"easeInOutQuint","delayin":"600","rotatein":"30","scalein":".1","slideoutdirection":"fade","durationout":"500","easingout":"easeInOutQuint","delayout":"0","rotateout":"0","scaleout":".1","level":"-1","showuntil":"0","url":"","target":"_self","styles":"{\\\\\\"padding-top\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"20\\\\\\",\\\\\\"padding-bottom\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"20\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Oswald\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#ff7700\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"5\\\\\\"}","top":"80%","left":"20%","style":"font-weight: 400; box-shadow: 0px 2px 8px -2px black;","id":"","class":"","title":"","alt":"","rel":"","imageId":""},{"subtitle":"Sample price","type":"h6","image":"","html":"Sample price","slidedirection":"fade","durationin":"500","easingin":"easeInOutQuint","delayin":"500","rotatein":"-30","scalein":".1","slideoutdirection":"fade","durationout":"500","easingout":"easeInOutQuint","delayout":"0","rotateout":"0","scaleout":".1","level":"-1","showuntil":"0","url":"","target":"_self","styles":"{\\\\\\"padding-top\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"20\\\\\\",\\\\\\"padding-bottom\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"20\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Oswald\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#000000\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"5\\\\\\"}","top":"73%","left":"20%","style":"font-weight: 400; box-shadow: 0px 2px 8px -2px black;","id":"","class":"","title":"","alt":"","rel":"","imageId":""}]},{"properties":{"3d_transitions":"","2d_transitions":"73","custom_3d_transitions":"","custom_2d_transitions":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Carousel-demo\\/phone.png","thumbnail":"","slidedelay":"4000","new_transitions":"on","slidedirection":"right","timeshift":"0","durationin":"1500","easingin":"easeInOutQuint","delayin":"0","durationout":"1500","easingout":"easeInOutQuint","delayout":"0","layer_link":"","layer_link_target":"_self","id":"","deeplink":"","backgroundId":"","thumbnailId":""},"sublayers":[{"subtitle":"Price","type":"h6","image":"","html":"only $199","slidedirection":"fade","durationin":"500","easingin":"easeInOutQuint","delayin":"600","rotatein":"30","scalein":".1","slideoutdirection":"fade","durationout":"500","easingout":"easeInOutQuint","delayout":"0","rotateout":"0","scaleout":".1","level":"-1","showuntil":"0","url":"","target":"_self","styles":"{\\\\\\"padding-top\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"20\\\\\\",\\\\\\"padding-bottom\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"20\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Oswald\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#ff7700\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"5\\\\\\"}","top":"50%","left":"80%","style":"font-weight: 400; box-shadow: 0px 2px 8px -2px black;","id":"","class":"","title":"","alt":"","rel":"","imageId":""},{"subtitle":"Sample price","type":"h6","image":"","html":"Sample price","slidedirection":"fade","durationin":"500","easingin":"easeInOutQuint","delayin":"500","rotatein":"-30","scalein":".1","slideoutdirection":"fade","durationout":"500","easingout":"easeInOutQuint","delayout":"0","rotateout":"0","scaleout":".1","level":"-1","showuntil":"0","url":"","target":"_self","styles":"{\\\\\\"padding-top\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"20\\\\\\",\\\\\\"padding-bottom\\\\\\":\\\\\\"5\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"20\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Oswald\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#000000\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"5\\\\\\"}","top":"43%","left":"80%","style":"font-weight: 400; box-shadow: 0px 2px 8px -2px black;","id":"","class":"","title":"","alt":"","rel":"","imageId":""}]}]}', 1409936827, 1409936827, 0, 0),
(2, 1, 'Full width demo slider', '', '{"properties":{"post_type":["attachment"],"post_taxonomy":"0","post_orderby":"date","post_order":"DESC","post_offset":"-1","title":"Full width demo slider","width":"100%","height":"500px","maxwidth":"","forceresponsive":"on","responsiveunder":"1280","sublayercontainer":"1280","autostart":"on","pauseonhover":"on","firstlayer":"1","animatefirstlayer":"on","keybnav":"on","touchnav":"on","loops":"0","forceloopnum":"on","skin":"noskin","backgroundcolor":"transparent","backgroundimage":"","sliderstyle":"margin-bottom: 0px;","navprevnext":"on","navstartstop":"on","navbuttons":"on","circletimer":"on","thumb_nav":"hover","thumb_container_width":"60%","thumb_width":"100","thumb_height":"60","thumb_active_opacity":"35","thumb_inactive_opacity":"100","autopauseslideshow":"auto","youtubepreview":"maxresdefault.jpg","imgpreload":"on","lazyload":"on","yourlogoId":"","yourlogo":"","yourlogostyle":"left: 10px; top: 10px;","yourlogolink":"","yourlogotarget":"_self","cbinit":"function(element) { }","cbstart":"function(data) { }","cbstop":"function(data) { }","cbpause":"function(data) { }","cbanimstart":"function(data) { }","cbanimstop":"function(data) { }","cbprev":"function(data) { }","cbnext":"function(data) { }"},"layers":[{"properties":{"post_offset":"-1","3d_transitions":"","2d_transitions":"1","custom_3d_transitions":"","custom_2d_transitions":"","backgroundId":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/fw-1.jpg","thumbnailId":"","thumbnail":"","slidedelay":"4000","timeshift":"-1000","layer_link":"","layer_link_target":"_self","id":"","deeplink":""},"sublayers":[{"subtitle":"salad side","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s1.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"300\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"220\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuart\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"280px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"salad side close blur","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s2.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"30\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1720\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\".9\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\".9\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"300\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% bottom  0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\".5\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\".5\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"230px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"salad","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s2.jpg","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"250\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"950\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"-8\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"270\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuart\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"65%","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"salad","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s1.jpg","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1720\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuart\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\".7\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\".7\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-800\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"195px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"freas features","media":"text","type":"p","imageId":"","image":"","html":"FRESH FEATURES","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"-90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"height\\\\\\":\\\\\\"40px\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"Lato, \\\\\'Open Sans\\\\\', sans-serif\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"line-height\\\\\\":\\\\\\"37px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#82d10c\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"3px\\\\\\"}","top":"150px","left":"116px","style":"font-weight: 300;","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"for starter","media":"text","type":"p","imageId":"","image":"","html":"for starter","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Indie Flower\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"31px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#6db509\\\\\\"}","top":"190px","left":"125px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow left","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/left.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"-40\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"-40\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#3","target":"_self","styles":"{}","top":"460px","left":"610px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow right","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/right.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#2","target":"_self","styles":"{}","top":"460px","left":"650px","style":"","id":"","class":"","title":"","alt":"","rel":""}]},{"properties":{"post_offset":"-1","3d_transitions":"","2d_transitions":"1","custom_3d_transitions":"","custom_2d_transitions":"","backgroundId":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/fw-1.jpg","thumbnailId":"","thumbnail":"","slidedelay":"4000","timeshift":"-1000","layer_link":"","layer_link_target":"_self","id":"","deeplink":""},"sublayers":[{"subtitle":"lamb far","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/l1.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"300\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-300\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"-1\\\\\\"}","url":"","target":"_self","styles":"{}","top":"157px","left":"284px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"lamb middle","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/l2.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"600\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-600\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"1\\\\\\"}","url":"","target":"_self","styles":"{}","top":"20px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"lamb close","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/l3.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"900\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-900\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"4\\\\\\"}","url":"","target":"_self","styles":"{}","top":"37px","left":"564px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"spicy parallax","media":"text","type":"p","imageId":"","image":"","html":"SPICY PARALLAX EFFECT","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"-90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"10\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"height\\\\\\":\\\\\\"40px\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"Lato, \\\\\'Open Sans\\\\\', sans-serif\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"line-height\\\\\\":\\\\\\"37px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#f04705\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"3px\\\\\\"}","top":"170px","left":"174px","style":"font-weight: 300;","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"for main course","media":"text","type":"p","imageId":"","image":"","html":"for main course","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"8\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Indie Flower\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"31px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#f04705\\\\\\"}","top":"210px","left":"183px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow left","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/left.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"3\\\\\\"}","url":"#1","target":"_self","styles":"{}","top":"430px","left":"210px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow right","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/right.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"3\\\\\\"}","url":"#3","target":"_self","styles":"{}","top":"430px","left":"250px","style":"","id":"","class":"","title":"","alt":"","rel":""}]},{"properties":{"post_offset":"-1","3d_transitions":"","2d_transitions":"1","custom_3d_transitions":"","custom_2d_transitions":"","backgroundId":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/fw-1.jpg","thumbnailId":"","thumbnail":"","slidedelay":"4000","timeshift":"-1000","layer_link":"","layer_link_target":"_self","id":"","deeplink":""},"sublayers":[{"subtitle":"cake far","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/d1.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"400\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"129px","left":"487px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"cake close","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/d2.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"104px","left":"70px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"sweet transitions","media":"text","type":"p","imageId":"","image":"","html":"SWEET TRANSITIONS","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"-90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"height\\\\\\":\\\\\\"40px\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"Lato, \\\\\'Open Sans\\\\\', sans-serif\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"line-height\\\\\\":\\\\\\"37px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#544f8c\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"3px\\\\\\"}","top":"320px","left":"830px","style":"font-weight: 300;","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"for dessert","media":"text","type":"p","imageId":"","image":"","html":"for dessert","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-600\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Indie Flower\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"31px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#544f8c\\\\\\"}","top":"360px","left":"836px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow left","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/left.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#2","target":"_self","styles":"{}","top":"430px","left":"960px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow right","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/right.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#1","target":"_self","styles":"{}","top":"430px","left":"1000px","style":"","id":"","class":"","title":"","alt":"","rel":""}]}]}', 1409936874, 1409936874, 0, 0) ;
INSERT INTO `wp_layerslider` ( `id`, `author`, `name`, `slug`, `data`, `date_c`, `date_m`, `flag_hidden`, `flag_deleted`) VALUES
(3, 0, 'Full width demo slider copy', '', '{"properties":{"post_type":["attachment"],"post_taxonomy":"0","post_orderby":"date","post_order":"DESC","post_offset":"-1","title":"Full width demo slider copy","width":"100%","height":"500px","maxwidth":"","forceresponsive":"on","responsiveunder":"1280","sublayercontainer":"1280","autostart":"on","pauseonhover":"on","firstlayer":"1","animatefirstlayer":"on","keybnav":"on","touchnav":"on","loops":"0","forceloopnum":"on","skin":"noskin","backgroundcolor":"transparent","backgroundimage":"","sliderstyle":"margin-bottom: 0px;","navprevnext":"on","navstartstop":"on","navbuttons":"on","circletimer":"on","thumb_nav":"hover","thumb_container_width":"60%","thumb_width":"100","thumb_height":"60","thumb_active_opacity":"35","thumb_inactive_opacity":"100","autopauseslideshow":"auto","youtubepreview":"maxresdefault.jpg","imgpreload":"on","lazyload":"on","yourlogoId":"","yourlogo":"","yourlogostyle":"left: 10px; top: 10px;","yourlogolink":"","yourlogotarget":"_self","cbinit":"function(element) { }","cbstart":"function(data) { }","cbstop":"function(data) { }","cbpause":"function(data) { }","cbanimstart":"function(data) { }","cbanimstop":"function(data) { }","cbprev":"function(data) { }","cbnext":"function(data) { }"},"layers":[{"properties":{"post_offset":"-1","3d_transitions":"","2d_transitions":"1","custom_3d_transitions":"","custom_2d_transitions":"","backgroundId":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/fw-1.jpg","thumbnailId":"","thumbnail":"","slidedelay":"4000","timeshift":"-1000","layer_link":"","layer_link_target":"_self","id":"","deeplink":""},"sublayers":[{"subtitle":"salad side","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s1.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"300\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"220\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuart\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"280px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"salad side close blur","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s2.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"30\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1720\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\".9\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\".9\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"300\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% bottom  0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\".5\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\".5\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"230px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"salad","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s2.jpg","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"250\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"950\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"-8\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"270\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuart\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1.2\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"65%","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"salad","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/s1.jpg","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1720\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuart\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\".7\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\".7\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-800\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"195px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"freas features","media":"text","type":"p","imageId":"","image":"","html":"FRESH FEATURES","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"-90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"height\\\\\\":\\\\\\"40px\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"Lato, \\\\\'Open Sans\\\\\', sans-serif\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"line-height\\\\\\":\\\\\\"37px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#82d10c\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"3px\\\\\\"}","top":"150px","left":"116px","style":"font-weight: 300;","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"for starter","media":"text","type":"p","imageId":"","image":"","html":"for starter","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Indie Flower\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"31px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#6db509\\\\\\"}","top":"190px","left":"125px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow left","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/left.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"-40\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"-40\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#3","target":"_self","styles":"{}","top":"460px","left":"610px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow right","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/right.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#2","target":"_self","styles":"{}","top":"460px","left":"650px","style":"","id":"","class":"","title":"","alt":"","rel":""}]},{"properties":{"post_offset":"-1","3d_transitions":"","2d_transitions":"1","custom_3d_transitions":"","custom_2d_transitions":"","backgroundId":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/fw-1.jpg","thumbnailId":"","thumbnail":"","slidedelay":"4000","timeshift":"-1000","layer_link":"","layer_link_target":"_self","id":"","deeplink":""},"sublayers":[{"subtitle":"lamb far","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/l1.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"300\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-300\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"-1\\\\\\"}","url":"","target":"_self","styles":"{}","top":"157px","left":"284px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"lamb middle","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/l2.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"600\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-600\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"1\\\\\\"}","url":"","target":"_self","styles":"{}","top":"20px","left":"50%","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"lamb close","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/l3.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"900\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-900\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"4\\\\\\"}","url":"","target":"_self","styles":"{}","top":"37px","left":"564px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"spicy parallax","media":"text","type":"p","imageId":"","image":"","html":"SPICY PARALLAX EFFECT","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"-90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"10\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"height\\\\\\":\\\\\\"40px\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"Lato, \\\\\'Open Sans\\\\\', sans-serif\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"line-height\\\\\\":\\\\\\"37px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#f04705\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"3px\\\\\\"}","top":"170px","left":"174px","style":"font-weight: 300;","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"for main course","media":"text","type":"p","imageId":"","image":"","html":"for main course","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"8\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Indie Flower\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"31px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#f04705\\\\\\"}","top":"210px","left":"183px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow left","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/left.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"3\\\\\\"}","url":"#1","target":"_self","styles":"{}","top":"430px","left":"210px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow right","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/right.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"3\\\\\\"}","url":"#3","target":"_self","styles":"{}","top":"430px","left":"250px","style":"","id":"","class":"","title":"","alt":"","rel":""}]},{"properties":{"post_offset":"-1","3d_transitions":"","2d_transitions":"1","custom_3d_transitions":"","custom_2d_transitions":"","backgroundId":"","background":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/fw-1.jpg","thumbnailId":"","thumbnail":"","slidedelay":"4000","timeshift":"-1000","layer_link":"","layer_link_target":"_self","id":"","deeplink":""},"sublayers":[{"subtitle":"cake far","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/d1.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"400\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"129px","left":"487px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"cake close","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/d2.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-200\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{}","top":"104px","left":"70px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"sweet transitions","media":"text","type":"p","imageId":"","image":"","html":"SWEET TRANSITIONS","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1500\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"-90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-400\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"height\\\\\\":\\\\\\"40px\\\\\\",\\\\\\"padding-right\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"padding-left\\\\\\":\\\\\\"10px\\\\\\",\\\\\\"font-family\\\\\\":\\\\\\"Lato, \\\\\'Open Sans\\\\\', sans-serif\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"30px\\\\\\",\\\\\\"line-height\\\\\\":\\\\\\"37px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#ffffff\\\\\\",\\\\\\"background\\\\\\":\\\\\\"#544f8c\\\\\\",\\\\\\"border-radius\\\\\\":\\\\\\"3px\\\\\\"}","top":"320px","left":"830px","style":"font-weight: 300;","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"for dessert","media":"text","type":"p","imageId":"","image":"","html":"for dessert","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"2000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeOutElastic\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"90\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% top 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-600\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"","target":"_self","styles":"{\\\\\\"font-family\\\\\\":\\\\\\"\\\\\'Indie Flower\\\\\'\\\\\\",\\\\\\"font-size\\\\\\":\\\\\\"31px\\\\\\",\\\\\\"color\\\\\\":\\\\\\"#544f8c\\\\\\"}","top":"360px","left":"836px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow left","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/left.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"-50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#2","target":"_self","styles":"{}","top":"430px","left":"960px","style":"","id":"","class":"","title":"","alt":"","rel":""},{"subtitle":"arrow right","media":"img","type":"p","imageId":"","image":"http:\\/\\/development.genco.tv\\/wp-content\\/uploads\\/layerslider\\/Full-width-demo-slider\\/right.png","html":"","post_text_length":"","transition":"{\\\\\\"offsetxin\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"delayin\\\\\\":\\\\\\"1000\\\\\\",\\\\\\"easingin\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadein\\\\\\":true,\\\\\\"rotatein\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginin\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyin\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyin\\\\\\":\\\\\\"1\\\\\\",\\\\\\"offsetxout\\\\\\":\\\\\\"50\\\\\\",\\\\\\"offsetyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"durationout\\\\\\":\\\\\\"400\\\\\\",\\\\\\"showuntil\\\\\\":\\\\\\"0\\\\\\",\\\\\\"easingout\\\\\\":\\\\\\"easeInOutQuint\\\\\\",\\\\\\"fadeout\\\\\\":true,\\\\\\"rotateout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotatexout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"rotateyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"transformoriginout\\\\\\":\\\\\\"50% 50% 0\\\\\\",\\\\\\"skewxout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"skewyout\\\\\\":\\\\\\"0\\\\\\",\\\\\\"scalexout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"scaleyout\\\\\\":\\\\\\"1\\\\\\",\\\\\\"parallaxlevel\\\\\\":\\\\\\"0\\\\\\"}","url":"#1","target":"_self","styles":"{}","top":"430px","left":"1000px","style":"","id":"","class":"","title":"","alt":"","rel":""}]}]}', 1409939508, 1409939508, 0, 0) ;

#
# End of data contents of table `wp_layerslider`
# --------------------------------------------------------



#
# Delete any existing table `wp_links`
#

DROP TABLE IF EXISTS `wp_links`;


#
# Table structure of table `wp_links`
#

CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_links`
#

#
# End of data contents of table `wp_links`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_communications`
#

DROP TABLE IF EXISTS `wp_m_communications`;


#
# Table structure of table `wp_m_communications`
#

CREATE TABLE `wp_m_communications` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sub_id` bigint(20) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `message` text,
  `periodunit` int(11) DEFAULT NULL,
  `periodtype` varchar(5) DEFAULT NULL,
  `periodprepost` varchar(5) DEFAULT NULL,
  `lastupdated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `active` int(11) DEFAULT '0',
  `periodstamp` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_communications`
#

#
# End of data contents of table `wp_m_communications`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_coupons`
#

DROP TABLE IF EXISTS `wp_m_coupons`;


#
# Table structure of table `wp_m_coupons`
#

CREATE TABLE `wp_m_coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) DEFAULT '0',
  `couponcode` varchar(250) DEFAULT NULL,
  `discount` decimal(11,2) DEFAULT '0.00',
  `discount_type` varchar(5) DEFAULT NULL,
  `discount_currency` varchar(5) DEFAULT NULL,
  `coupon_startdate` datetime DEFAULT NULL,
  `coupon_enddate` datetime DEFAULT NULL,
  `coupon_sub_id` bigint(20) DEFAULT '0',
  `coupon_uses` int(11) DEFAULT '0',
  `coupon_used` int(11) DEFAULT '0',
  `coupon_apply_to` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `couponcode` (`couponcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_coupons`
#

#
# End of data contents of table `wp_m_coupons`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_levelmeta`
#

DROP TABLE IF EXISTS `wp_m_levelmeta`;


#
# Table structure of table `wp_m_levelmeta`
#

CREATE TABLE `wp_m_levelmeta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level_id` bigint(20) DEFAULT NULL,
  `meta_key` varchar(250) DEFAULT NULL,
  `meta_value` text,
  `meta_stamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_id` (`level_id`,`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_levelmeta`
#
INSERT INTO `wp_m_levelmeta` ( `id`, `level_id`, `meta_key`, `meta_value`, `meta_stamp`) VALUES
(1, 2, 'joining_ping', '', NULL),
(2, 2, 'leaving_ping', '', NULL),
(3, 2, 'associated_wp_role', '', NULL),
(4, 1, 'joining_ping', '', NULL),
(5, 1, 'leaving_ping', '', NULL),
(6, 1, 'associated_wp_role', '', NULL) ;

#
# End of data contents of table `wp_m_levelmeta`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_member_payments`
#

DROP TABLE IF EXISTS `wp_m_member_payments`;


#
# Table structure of table `wp_m_member_payments`
#

CREATE TABLE `wp_m_member_payments` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) DEFAULT NULL,
  `sub_id` bigint(20) DEFAULT NULL,
  `level_id` bigint(20) DEFAULT NULL,
  `level_order` int(11) DEFAULT NULL,
  `paymentmade` datetime DEFAULT NULL,
  `paymentexpires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_member_payments`
#

#
# End of data contents of table `wp_m_member_payments`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_membership_levels`
#

DROP TABLE IF EXISTS `wp_m_membership_levels`;


#
# Table structure of table `wp_m_membership_levels`
#

CREATE TABLE `wp_m_membership_levels` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level_title` varchar(250) DEFAULT NULL,
  `level_slug` varchar(250) DEFAULT NULL,
  `level_active` int(11) DEFAULT '0',
  `level_count` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_membership_levels`
#

#
# End of data contents of table `wp_m_membership_levels`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_membership_news`
#

DROP TABLE IF EXISTS `wp_m_membership_news`;


#
# Table structure of table `wp_m_membership_news`
#

CREATE TABLE `wp_m_membership_news` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `newsitem` mediumtext,
  `newsdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_membership_news`
#

#
# End of data contents of table `wp_m_membership_news`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_membership_relationships`
#

DROP TABLE IF EXISTS `wp_m_membership_relationships`;


#
# Table structure of table `wp_m_membership_relationships`
#

CREATE TABLE `wp_m_membership_relationships` (
  `rel_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT '0',
  `sub_id` bigint(20) DEFAULT '0',
  `level_id` bigint(20) DEFAULT '0',
  `startdate` datetime DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `expirydate` datetime DEFAULT NULL,
  `order_instance` bigint(20) DEFAULT '0',
  `usinggateway` varchar(50) DEFAULT 'admin',
  PRIMARY KEY (`rel_id`),
  KEY `user_id` (`user_id`),
  KEY `sub_id` (`sub_id`),
  KEY `usinggateway` (`usinggateway`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_membership_relationships`
#

#
# End of data contents of table `wp_m_membership_relationships`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_membership_rules`
#

DROP TABLE IF EXISTS `wp_m_membership_rules`;


#
# Table structure of table `wp_m_membership_rules`
#

CREATE TABLE `wp_m_membership_rules` (
  `level_id` bigint(20) NOT NULL DEFAULT '0',
  `rule_ive` varchar(20) NOT NULL DEFAULT '',
  `rule_area` varchar(20) NOT NULL DEFAULT '',
  `rule_value` text,
  `rule_order` int(11) DEFAULT '0',
  PRIMARY KEY (`level_id`,`rule_ive`,`rule_area`),
  KEY `rule_area` (`rule_area`),
  KEY `rule_ive` (`rule_ive`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_membership_rules`
#

#
# End of data contents of table `wp_m_membership_rules`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_ping_history`
#

DROP TABLE IF EXISTS `wp_m_ping_history`;


#
# Table structure of table `wp_m_ping_history`
#

CREATE TABLE `wp_m_ping_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ping_id` bigint(20) DEFAULT NULL,
  `ping_sent` timestamp NULL DEFAULT NULL,
  `ping_info` text,
  `ping_return` text,
  PRIMARY KEY (`id`),
  KEY `ping_id` (`ping_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_ping_history`
#

#
# End of data contents of table `wp_m_ping_history`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_pings`
#

DROP TABLE IF EXISTS `wp_m_pings`;


#
# Table structure of table `wp_m_pings`
#

CREATE TABLE `wp_m_pings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pingname` varchar(250) DEFAULT NULL,
  `pingurl` varchar(250) DEFAULT NULL,
  `pinginfo` text,
  `pingtype` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_pings`
#

#
# End of data contents of table `wp_m_pings`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_subscription_transaction`
#

DROP TABLE IF EXISTS `wp_m_subscription_transaction`;


#
# Table structure of table `wp_m_subscription_transaction`
#

CREATE TABLE `wp_m_subscription_transaction` (
  `transaction_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_subscription_ID` bigint(20) NOT NULL DEFAULT '0',
  `transaction_user_ID` bigint(20) NOT NULL DEFAULT '0',
  `transaction_sub_ID` bigint(20) DEFAULT '0',
  `transaction_paypal_ID` varchar(30) DEFAULT NULL,
  `transaction_payment_type` varchar(20) DEFAULT NULL,
  `transaction_stamp` bigint(35) NOT NULL DEFAULT '0',
  `transaction_total_amount` bigint(20) DEFAULT NULL,
  `transaction_currency` varchar(35) DEFAULT NULL,
  `transaction_status` varchar(35) DEFAULT NULL,
  `transaction_duedate` date DEFAULT NULL,
  `transaction_gateway` varchar(50) DEFAULT NULL,
  `transaction_note` text,
  `transaction_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`transaction_ID`),
  KEY `transaction_gateway` (`transaction_gateway`),
  KEY `transaction_subscription_ID` (`transaction_subscription_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_subscription_transaction`
#

#
# End of data contents of table `wp_m_subscription_transaction`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_subscriptionmeta`
#

DROP TABLE IF EXISTS `wp_m_subscriptionmeta`;


#
# Table structure of table `wp_m_subscriptionmeta`
#

CREATE TABLE `wp_m_subscriptionmeta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sub_id` bigint(20) DEFAULT NULL,
  `meta_key` varchar(250) DEFAULT NULL,
  `meta_value` text,
  `meta_stamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sub_id` (`sub_id`,`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_subscriptionmeta`
#
INSERT INTO `wp_m_subscriptionmeta` ( `id`, `sub_id`, `meta_key`, `meta_value`, `meta_stamp`) VALUES
(1, 0, 'joining_ping', '', NULL),
(2, 0, 'leaving_ping', '', NULL),
(3, 1, 'joining_ping', '', NULL),
(4, 1, 'leaving_ping', '', NULL) ;

#
# End of data contents of table `wp_m_subscriptionmeta`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_subscriptions`
#

DROP TABLE IF EXISTS `wp_m_subscriptions`;


#
# Table structure of table `wp_m_subscriptions`
#

CREATE TABLE `wp_m_subscriptions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sub_name` varchar(200) DEFAULT NULL,
  `sub_active` int(11) DEFAULT '0',
  `sub_public` int(11) DEFAULT '0',
  `sub_count` bigint(20) DEFAULT '0',
  `sub_description` text,
  `sub_pricetext` varchar(200) DEFAULT NULL,
  `order_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_subscriptions`
#

#
# End of data contents of table `wp_m_subscriptions`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_subscriptions_levels`
#

DROP TABLE IF EXISTS `wp_m_subscriptions_levels`;


#
# Table structure of table `wp_m_subscriptions_levels`
#

CREATE TABLE `wp_m_subscriptions_levels` (
  `sub_id` bigint(20) DEFAULT NULL,
  `level_id` bigint(20) DEFAULT NULL,
  `level_period` int(11) DEFAULT NULL,
  `sub_type` varchar(20) DEFAULT NULL,
  `level_price` decimal(11,2) DEFAULT '0.00',
  `level_currency` varchar(5) DEFAULT NULL,
  `level_order` bigint(20) DEFAULT '0',
  `level_period_unit` varchar(1) DEFAULT 'd',
  KEY `sub_id` (`sub_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_subscriptions_levels`
#

#
# End of data contents of table `wp_m_subscriptions_levels`
# --------------------------------------------------------



#
# Delete any existing table `wp_m_urlgroups`
#

DROP TABLE IF EXISTS `wp_m_urlgroups`;


#
# Table structure of table `wp_m_urlgroups`
#

CREATE TABLE `wp_m_urlgroups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(250) DEFAULT NULL,
  `groupurls` text,
  `isregexp` int(11) DEFAULT '0',
  `stripquerystring` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_m_urlgroups`
#
INSERT INTO `wp_m_urlgroups` ( `id`, `groupname`, `groupurls`, `isregexp`, `stripquerystring`) VALUES
(1, '_pages-2', 'https?://development.genco.tv/coming-soon(/.*)\nhttps?://development.genco.tv/protected(/.*)\nhttps?://development.genco.tv/account(/.*)\nhttps?://development.genco.tv/register(/.*)\nhttps?://development.genco.tv/test(/.*)\nhttps?://development.genco.tv/news(/.*)\nhttps?://development.genco.tv/sample-page(/.*)\nhttps?://development.genco.tv/my-account(/.*)\nhttps?://development.genco.tv/checkout(/.*)\nhttps?://development.genco.tv/cart(/.*)\nhttps?://development.genco.tv(/.*)\nhttps?://development.genco.tv/landing(/.*)\nhttps?://development.genco.tv/shop/accessories(/.*)\nhttps?://development.genco.tv/shop/clothing(/.*)\nhttps?://development.genco.tv/shop/extra-virgin-olive-oil(/.*)\nhttps?://development.genco.tv/movies/this-thing-of-ours(/.*)\nhttps?://development.genco.tv/shows/apollo-unplugged(/.*)\nhttps?://development.genco.tv/shows/bareknuckle-boxing(/.*)\nhttps?://development.genco.tv/shows/wiseguys-wackjobs(/.*)\nhttps?://development.genco.tv/shows/manhattan-kansas(/.*)\nhttps?://development.genco.tv/shop(/.*)\nhttps?://development.genco.tv/movies(/.*)\nhttps?://development.genco.tv/shows(/.*)\nhttps?://development.genco.tv/home(/.*)\nhttps?://development.genco.tv/sample-page-2(/.*)', 1, 1),
(2, '_posts-2', 'https?://development.genco.tv/2014/08/what-happens-in-vegas-9(/.*)\nhttps?://development.genco.tv/2014/08/news-item-1-4(/.*)\nhttps?://development.genco.tv/2014/08/what-happens-in-vegas-7(/.*)\nhttps?://development.genco.tv/2014/08/what-happens-in-vegas-8(/.*)\nhttps?://development.genco.tv/2014/08/news-item-1-5(/.*)\nhttps?://development.genco.tv/2014/08/news-item-1-6(/.*)\nhttps?://development.genco.tv/2014/08/news-item-1-7(/.*)\nhttps?://development.genco.tv/2014/08/what-happens-in-vegas-5(/.*)\nhttps?://development.genco.tv/2014/08/what-happens-in-vegas-6(/.*)\nhttps?://development.genco.tv/2014/08/news-item-1-3(/.*)\nhttps?://development.genco.tv/2014/08/what-happens-in-vegas-4(/.*)\nhttps?://development.genco.tv/2014/08/news-item-1-2(/.*)\nhttps?://development.genco.tv/2014/08/hello-world-2(/.*)', 1, 1) ;

#
# End of data contents of table `wp_m_urlgroups`
# --------------------------------------------------------



#
# Delete any existing table `wp_options`
#

DROP TABLE IF EXISTS `wp_options`;


#
# Table structure of table `wp_options`
#

CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8310 DEFAULT CHARSET=utf8;


#
# Data contents of table `wp_options`
#
INSERT INTO `wp_options` ( `option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://development.genco.tv', 'yes'),
(2, 'blogname', 'Genco Olive Oil Co.', 'yes'),
(3, 'blogdescription', '', 'yes'),
(4, 'users_can_register', '1', 'yes'),
(5, 'admin_email', 'chris@genco.tv', 'yes'),
(6, 'start_of_week', '1', 'yes'),
(7, 'use_balanceTags', '0', 'yes'),
(8, 'use_smilies', '1', 'yes'),
(9, 'require_name_email', '1', 'yes'),
(10, 'comments_notify', '1', 'yes'),
(11, 'posts_per_rss', '10', 'yes'),
(12, 'rss_use_excerpt', '0', 'yes'),
(13, 'mailserver_url', 'mail.example.com', 'yes'),
(14, 'mailserver_login', 'login@example.com', 'yes'),
(15, 'mailserver_pass', 'password', 'yes'),
(16, 'mailserver_port', '110', 'yes'),
(17, 'default_category', '1', 'yes'),
(18, 'default_comment_status', 'open', 'yes'),
(19, 'default_ping_status', 'open', 'yes'),
(20, 'default_pingback_flag', '1', 'yes'),
(21, 'posts_per_page', '10', 'yes'),
(22, 'date_format', 'F j, Y', 'yes'),
(23, 'time_format', 'g:i a', 'yes'),
(24, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(25, 'comment_moderation', '0', 'yes'),
(26, 'moderation_notify', '1', 'yes'),
(27, 'permalink_structure', '/%year%/%monthnum%/%postname%/', 'yes'),
(28, 'gzipcompression', '0', 'yes'),
(29, 'hack_file', '0', 'yes'),
(30, 'blog_charset', 'UTF-8', 'yes'),
(31, 'moderation_keys', '', 'no'),
(32, 'active_plugins', 'a:36:{i:0;s:27:"LayerSlider/layerslider.php";i:1;s:25:"add-to-any/add-to-any.php";i:2;s:43:"anps_vc_woocommerce/anps_vc_woocommerce.php";i:3;s:45:"arscode-ninja-popups/arscode-ninja-popups.php";i:4;s:28:"category-posts/cat-posts.php";i:5;s:36:"contact-form-7/wp-contact-form-7.php";i:6;s:26:"css-hero/css-hero-main.php";i:7;s:37:"custom-login-url/custom-login-url.php";i:8;s:33:"duplicate-post/duplicate-post.php";i:9;s:44:"expandcollapse-funk/expand-collapse-funk.php";i:10;s:41:"flexi-pages-widget/flexi-pages-widget.php";i:11;s:50:"google-analytics-for-wordpress/googleanalytics.php";i:12;s:54:"jetpack-sharing-butttons-shortcode/jp-sd-shortcode.php";i:13;s:19:"jetpack/jetpack.php";i:14;s:27:"js_composer/js_composer.php";i:15;s:38:"menu-items-visibility-control/init.php";i:16;s:27:"modal-login/modal-login.php";i:17;s:50:"otw-sidebar-widget-manager/otw_sidebar_manager.php";i:18;s:47:"post-tags-and-categories-for-pages/post-tag.php";i:19;s:47:"post-thumbnail-editor/post-thumbnail-editor.php";i:20;s:47:"post-thumbnail-extras/post-thumbnail-extras.php";i:21;s:37:"recent-posts-widget-extended/rpwe.php";i:22;s:47:"regenerate-thumbnails/regenerate-thumbnails.php";i:23;s:23:"revslider/revslider.php";i:24;s:39:"simple-pull-quote/simple-pull-quote.php";i:25;s:47:"sublimevideo-official/sublimevideo-official.php";i:26;s:33:"theme-my-login/theme-my-login.php";i:27;s:27:"tpc-memory-usage/tpcmem.php";i:28;s:47:"ultimate-posts-widget/ultimate-posts-widget.php";i:29;s:49:"woocommerce-customizer/woocommerce-customizer.php";i:30;s:27:"woocommerce/woocommerce.php";i:31;s:24:"wordpress-seo/wp-seo.php";i:32;s:25:"wp-better-emails/wpbe.php";i:33;s:39:"wp-migrate-db-pro/wp-migrate-db-pro.php";i:34;s:27:"wp-showhide/wp-showhide.php";i:35;s:40:"wpmudev-updates/update-notifications.php";}', 'yes'),
(33, 'home', 'http://development.genco.tv', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'advanced_edit', '0', 'yes'),
(37, 'comment_max_links', '2', 'yes'),
(38, 'gmt_offset', '', 'yes'),
(39, 'default_email_category', '1', 'yes'),
(40, 'recently_edited', 'a:5:{i:0;s:85:"/home/czucker/public_html/development/wp-content/themes/HighendWP-child/functions.php";i:1;s:81:"/home/czucker/public_html/development/wp-content/themes/HighendWP-child/style.css";i:3;s:100:"/home/czucker/public_html/development/wp-content/plugins/simple-pull-quote/css/simple-pull-quote.css";i:4;s:96:"/home/czucker/public_html/development/wp-content/plugins/simple-pull-quote/simple-pull-quote.php";i:5;s:94:"/home/czucker/public_html/development/wp-content/plugins/advanced-excerpt/advanced-excerpt.php";}', 'no'),
(41, 'template', 'HighendWP', 'yes'),
(42, 'stylesheet', 'HighendWP-child', 'yes'),
(43, 'comment_whitelist', '1', 'yes'),
(44, 'blacklist_keys', '', 'no'),
(45, 'comment_registration', '0', 'yes'),
(46, 'html_type', 'text/html', 'yes'),
(47, 'use_trackback', '0', 'yes'),
(48, 'default_role', 'subscriber', 'yes'),
(49, 'db_version', '29630', 'yes'),
(50, 'uploads_use_yearmonth_folders', '1', 'yes'),
(51, 'upload_path', '', 'yes'),
(52, 'blog_public', '1', 'yes'),
(53, 'default_link_category', '2', 'yes'),
(54, 'show_on_front', 'page', 'yes'),
(55, 'tag_base', '', 'yes'),
(56, 'show_avatars', '1', 'yes'),
(57, 'avatar_rating', 'G', 'yes'),
(58, 'upload_url_path', '', 'yes'),
(59, 'thumbnail_size_w', '150', 'yes'),
(60, 'thumbnail_size_h', '150', 'yes'),
(61, 'thumbnail_crop', '', 'yes'),
(62, 'medium_size_w', '300', 'yes'),
(63, 'medium_size_h', '300', 'yes'),
(64, 'avatar_default', 'mystery', 'yes'),
(65, 'large_size_w', '1024', 'yes'),
(66, 'large_size_h', '1024', 'yes'),
(67, 'image_default_link_type', '', 'yes'),
(68, 'image_default_size', '', 'yes'),
(69, 'image_default_align', '', 'yes'),
(70, 'close_comments_for_old_posts', '0', 'yes'),
(71, 'close_comments_days_old', '14', 'yes'),
(72, 'thread_comments', '1', 'yes'),
(73, 'thread_comments_depth', '5', 'yes'),
(74, 'page_comments', '0', 'yes'),
(75, 'comments_per_page', '50', 'yes'),
(76, 'default_comments_page', 'newest', 'yes'),
(77, 'comment_order', 'asc', 'yes'),
(78, 'sticky_posts', 'a:0:{}', 'yes'),
(79, 'widget_categories', 'a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(80, 'widget_text', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(81, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(82, 'uninstall_plugins', 'a:3:{s:27:"LayerSlider/layerslider.php";s:29:"layerslider_uninstall_scripts";s:35:"rename-wp-login/rename-wp-login.php";a:2:{i:0;s:15:"Rename_WP_Login";i:1;s:9:"uninstall";}s:33:"theme-my-login/theme-my-login.php";a:2:{i:0;s:20:"Theme_My_Login_Admin";i:1;s:9:"uninstall";}}', 'no'),
(83, 'timezone_string', 'America/New_York', 'yes'),
(85, 'page_on_front', '758', 'yes'),
(86, 'default_post_format', '0', 'yes'),
(87, 'link_manager_enabled', '0', 'yes'),
(88, 'initial_db_version', '27916', 'yes'),
(89, 'wp_user_roles', 'a:7:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:121:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:9:"add_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;s:18:"manage_woocommerce";b:1;s:24:"view_woocommerce_reports";b:1;s:12:"edit_product";b:1;s:12:"read_product";b:1;s:14:"delete_product";b:1;s:13:"edit_products";b:1;s:20:"edit_others_products";b:1;s:16:"publish_products";b:1;s:21:"read_private_products";b:1;s:15:"delete_products";b:1;s:23:"delete_private_products";b:1;s:25:"delete_published_products";b:1;s:22:"delete_others_products";b:1;s:21:"edit_private_products";b:1;s:23:"edit_published_products";b:1;s:20:"manage_product_terms";b:1;s:18:"edit_product_terms";b:1;s:20:"delete_product_terms";b:1;s:20:"assign_product_terms";b:1;s:15:"edit_shop_order";b:1;s:15:"read_shop_order";b:1;s:17:"delete_shop_order";b:1;s:16:"edit_shop_orders";b:1;s:23:"edit_others_shop_orders";b:1;s:19:"publish_shop_orders";b:1;s:24:"read_private_shop_orders";b:1;s:18:"delete_shop_orders";b:1;s:26:"delete_private_shop_orders";b:1;s:28:"delete_published_shop_orders";b:1;s:25:"delete_others_shop_orders";b:1;s:24:"edit_private_shop_orders";b:1;s:26:"edit_published_shop_orders";b:1;s:23:"manage_shop_order_terms";b:1;s:21:"edit_shop_order_terms";b:1;s:23:"delete_shop_order_terms";b:1;s:23:"assign_shop_order_terms";b:1;s:16:"edit_shop_coupon";b:1;s:16:"read_shop_coupon";b:1;s:18:"delete_shop_coupon";b:1;s:17:"edit_shop_coupons";b:1;s:24:"edit_others_shop_coupons";b:1;s:20:"publish_shop_coupons";b:1;s:25:"read_private_shop_coupons";b:1;s:19:"delete_shop_coupons";b:1;s:27:"delete_private_shop_coupons";b:1;s:29:"delete_published_shop_coupons";b:1;s:26:"delete_others_shop_coupons";b:1;s:25:"edit_private_shop_coupons";b:1;s:27:"edit_published_shop_coupons";b:1;s:24:"manage_shop_coupon_terms";b:1;s:22:"edit_shop_coupon_terms";b:1;s:24:"delete_shop_coupon_terms";b:1;s:24:"assign_shop_coupon_terms";b:1;s:10:"copy_posts";b:1;s:9:"edit_post";b:1;s:9:"read_post";b:1;s:11:"delete_post";b:1;s:15:"wpseo_bulk_edit";b:1;s:20:"modal_login_settings";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:36:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:10:"copy_posts";b:1;s:15:"wpseo_bulk_edit";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:11:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;s:15:"wpseo_bulk_edit";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}s:8:"customer";a:2:{s:4:"name";s:8:"Customer";s:12:"capabilities";a:3:{s:4:"read";b:1;s:10:"edit_posts";b:0;s:12:"delete_posts";b:0;}}s:12:"shop_manager";a:2:{s:4:"name";s:12:"Shop Manager";s:12:"capabilities";a:93:{s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:4:"read";b:1;s:18:"read_private_pages";b:1;s:18:"read_private_posts";b:1;s:10:"edit_users";b:1;s:10:"edit_posts";b:1;s:10:"edit_pages";b:1;s:20:"edit_published_posts";b:1;s:20:"edit_published_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"edit_private_posts";b:1;s:17:"edit_others_posts";b:1;s:17:"edit_others_pages";b:1;s:13:"publish_posts";b:1;s:13:"publish_pages";b:1;s:12:"delete_posts";b:1;s:12:"delete_pages";b:1;s:20:"delete_private_pages";b:1;s:20:"delete_private_posts";b:1;s:22:"delete_published_pages";b:1;s:22:"delete_published_posts";b:1;s:19:"delete_others_posts";b:1;s:19:"delete_others_pages";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:17:"moderate_comments";b:1;s:15:"unfiltered_html";b:1;s:12:"upload_files";b:1;s:6:"export";b:1;s:6:"import";b:1;s:10:"list_users";b:1;s:18:"manage_woocommerce";b:1;s:24:"view_woocommerce_reports";b:1;s:12:"edit_product";b:1;s:12:"read_product";b:1;s:14:"delete_product";b:1;s:13:"edit_products";b:1;s:20:"edit_others_products";b:1;s:16:"publish_products";b:1;s:21:"read_private_products";b:1;s:15:"delete_products";b:1;s:23:"delete_private_products";b:1;s:25:"delete_published_products";b:1;s:22:"delete_others_products";b:1;s:21:"edit_private_products";b:1;s:23:"edit_published_products";b:1;s:20:"manage_product_terms";b:1;s:18:"edit_product_terms";b:1;s:20:"delete_product_terms";b:1;s:20:"assign_product_terms";b:1;s:15:"edit_shop_order";b:1;s:15:"read_shop_order";b:1;s:17:"delete_shop_order";b:1;s:16:"edit_shop_orders";b:1;s:23:"edit_others_shop_orders";b:1;s:19:"publish_shop_orders";b:1;s:24:"read_private_shop_orders";b:1;s:18:"delete_shop_orders";b:1;s:26:"delete_private_shop_orders";b:1;s:28:"delete_published_shop_orders";b:1;s:25:"delete_others_shop_orders";b:1;s:24:"edit_private_shop_orders";b:1;s:26:"edit_published_shop_orders";b:1;s:23:"manage_shop_order_terms";b:1;s:21:"edit_shop_order_terms";b:1;s:23:"delete_shop_order_terms";b:1;s:23:"assign_shop_order_terms";b:1;s:16:"edit_shop_coupon";b:1;s:16:"read_shop_coupon";b:1;s:18:"delete_shop_coupon";b:1;s:17:"edit_shop_coupons";b:1;s:24:"edit_others_shop_coupons";b:1;s:20:"publish_shop_coupons";b:1;s:25:"read_private_shop_coupons";b:1;s:19:"delete_shop_coupons";b:1;s:27:"delete_private_shop_coupons";b:1;s:29:"delete_published_shop_coupons";b:1;s:26:"delete_others_shop_coupons";b:1;s:25:"edit_private_shop_coupons";b:1;s:27:"edit_published_shop_coupons";b:1;s:24:"manage_shop_coupon_terms";b:1;s:22:"edit_shop_coupon_terms";b:1;s:24:"delete_shop_coupon_terms";b:1;s:24:"assign_shop_coupon_terms";b:1;}}}', 'yes'),
(90, 'widget_search', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(91, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(92, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(93, 'widget_archives', 'a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(94, 'widget_meta', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(95, 'sidebars_widgets', 'a:9:{s:19:"wp_inactive_widgets";a:0:{}s:18:"hb-default-sidebar";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:15:"custom-sidebar0";a:1:{i:0;s:12:"flexipages-4";}s:15:"custom-sidebar1";a:1:{i:0;s:32:"woocommerce_product_categories-2";}s:15:"custom-sidebar2";a:1:{i:0;s:19:"hb_soc_net_widget-2";}s:15:"custom-sidebar3";a:0:{}s:29:"hb-custom-sidebar-newssidebar";a:1:{i:0;s:16:"category-posts-2";}s:26:"hb-custom-sidebar-products";a:1:{i:0;s:22:"woocommerce_products-2";}s:13:"array_version";i:3;}', 'yes'),
(96, 'cron', 'a:13:{i:1411138027;a:1:{s:40:"membership_perform_cron_processes_hourly";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1411140230;a:1:{s:20:"jetpack_clean_nonces";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1411140439;a:1:{s:32:"woocommerce_cancel_unpaid_orders";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:2:{s:8:"schedule";b:0;s:4:"args";a:0:{}}}}i:1411143355;a:1:{s:22:"wpmudev_scheduled_jobs";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1411144810;a:1:{s:14:"yoast_tracking";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1411147973;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1411148004;a:1:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1411150271;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1411152189;a:1:{s:28:"woocommerce_cleanup_sessions";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1411156260;a:1:{s:20:"wp_maybe_auto_update";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1411171200;a:1:{s:27:"woocommerce_scheduled_sales";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1411223031;a:1:{s:20:"jetpack_v2_heartbeat";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}s:7:"version";i:2;}', 'yes'),
(127, 'theme_mods_twentyfourteen', 'a:1:{s:16:"sidebars_widgets";a:2:{s:4:"time";i:1407519378;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";a:0:{}}}}', 'yes'),
(128, 'current_theme', 'Highend Child', 'yes'),
(129, 'theme_mods_HighendWP', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1407520473;s:4:"data";a:6:{s:19:"wp_inactive_widgets";a:0:{}s:18:"hb-default-sidebar";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:15:"custom-sidebar0";a:0:{}s:15:"custom-sidebar1";a:0:{}s:15:"custom-sidebar2";N;s:15:"custom-sidebar3";N;}}}', 'yes'),
(130, 'theme_switched', '', 'yes'),
(133, 'hb_highend_option', 'a:320:{s:20:"hb_general_notebox_5";s:0:"";s:10:"hb_favicon";s:77:"http://www.whenshitgoesmadmax.com/test/wp-content/uploads/2014/08/favicon.gif";s:13:"hb_apple_icon";s:0:"";s:16:"hb_apple_icon_72";s:0:"";s:17:"hb_apple_icon_114";s:0:"";s:17:"hb_apple_icon_144";s:0:"";s:21:"hb_ios_bookmark_title";s:0:"";s:13:"hb_responsive";s:1:"1";s:19:"hb_smooth_scrolling";s:0:"";s:14:"hb_queryloader";s:1:"1";s:24:"hb_disable_page_comments";s:0:"";s:21:"hb_enable_breadcrumbs";s:0:"";s:16:"hb_to_top_button";s:1:"1";s:19:"hb_pagination_style";s:4:"ajax";s:19:"hb_back_to_top_icon";s:18:"hb-moon-arrow-up-4";s:17:"hb_analytics_code";s:0:"";s:16:"hb_custom_script";s:0:"";s:13:"hb_custom_css";s:0:"";s:16:"hb_global_layout";s:15:"hb-boxed-layout";s:20:"hb_boxed_layout_type";s:24:"hb_boxed_layout_attached";s:15:"hb_boxed_shadow";s:1:"1";s:29:"hb_upload_or_predefined_image";s:18:"predefined-texture";s:23:"hb_predefined_bg_texure";s:98:"http://development.genco.tv/wp-content/themes/HighendWP/admin/assets/images/textures/dark_wood.png";s:27:"hb_default_background_image";s:83:"http://www.whenshitgoesmadmax.com/test/wp-content/uploads/2014/08/AwningTexture.jpg";s:20:"hb_background_repeat";s:9:"no-repeat";s:24:"hb_background_attachment";s:5:"fixed";s:22:"hb_background_position";s:10:"center top";s:21:"hb_background_stretch";s:1:"1";s:16:"hb_content_width";s:6:"1140px";s:19:"hb_header_notebox_1";s:0:"";s:17:"hb_top_header_bar";s:1:"1";s:23:"hb_top_header_container";s:9:"container";s:23:"hb_top_header_info_text";s:0:"";s:17:"hb_top_header_map";s:0:"";s:22:"hb_top_header_map_text";s:14:"Find us on Map";s:19:"hb_top_header_email";s:13:"info@genco.tv";s:28:"hb_top_header_socials_enable";s:1:"1";s:21:"hb_top_header_socials";a:1:{i:0;s:8:"facebook";}s:19:"hb_top_header_login";s:1:"1";s:23:"hb_top_header_languages";s:0:"";s:22:"hb_top_header_checkout";s:1:"1";s:18:"hb_top_header_link";s:0:"";s:23:"hb_top_header_link_icon";s:12:"hb-moon-user";s:22:"hb_top_header_link_txt";s:5:"Login";s:23:"hb_top_header_link_link";s:51:"http://www.whenshitgoesmadmax.com/test/wp-login.php";s:24:"hb_main_header_container";s:9:"container";s:22:"hb_header_layout_style";s:10:"nav-type-1";s:17:"hb_logo_alignment";s:0:"";s:20:"hb_sticky_header_alt";s:1:"1";s:16:"hb_sticky_header";s:0:"";s:23:"hb_sticky_header_height";s:2:"60";s:24:"hb_regular_header_height";s:2:"60";s:28:"hb_enable_sticky_shop_button";s:0:"";s:20:"hb_header_right_text";s:55:"Ultimate WordPress Theme<br/>With Powerful Page Builder";s:21:"hb_header_layout_skin";s:12:"minimal-skin";s:23:"hb_navigation_animation";s:11:"hb-effect-1";s:17:"hb_search_in_menu";s:1:"1";s:14:"hb_ajax_search";s:1:"1";s:24:"hb_main_navigation_color";s:19:"light-menu-dropdown";s:25:"hb_enable_pre_footer_area";s:0:"";s:18:"hb_pre_footer_text";s:72:"Experience something completely different. The most powerful theme ever.";s:25:"hb_pre_footer_button_text";s:10:"Buy Today!";s:25:"hb_pre_footer_button_link";s:20:"http://hb-themes.com";s:25:"hb_pre_footer_button_icon";s:0:"";s:27:"hb_pre_footer_button_target";s:5:"_self";s:24:"hb_enable_footer_widgets";s:1:"1";s:27:"hb_enable_footer_separators";s:1:"1";s:27:"hb_enable_footer_background";s:0:"";s:16:"hb_footer_layout";s:7:"style-5";s:26:"hb_enable_footer_copyright";s:1:"1";s:18:"hb_enable_backlink";s:0:"";s:18:"hb_copyright_style";s:16:"normal-copyright";s:22:"hb_copyright_line_text";s:25:"© [the-year] · Genco TV";s:22:"hb_fixed_footer_effect";s:0:"";s:27:"hb_default_settings_notebox";s:0:"";s:22:"hb_page_layout_sidebar";s:9:"fullwidth";s:17:"hb_choose_sidebar";s:0:"";s:18:"hb_page_title_type";s:4:"none";s:30:"hb_page_title_background_color";s:7:"#222222";s:30:"hb_page_title_background_image";s:0:"";s:39:"hb_page_title_background_image_parallax";s:1:"1";s:19:"hb_page_title_style";s:12:"simple-title";s:23:"hb_page_title_alignment";s:11:"aligncenter";s:20:"hb_page_title_height";s:14:"normal-padding";s:19:"hb_page_title_color";s:10:"light-text";s:23:"hb_page_title_animation";s:0:"";s:32:"hb_page_title_subtitle_animation";s:0:"";s:14:"hb_logo_option";s:72:"http://development.genco.tv/wp-content/uploads/2014/08/gencoLogoType.png";s:21:"hb_logo_option_retina";s:78:"http://development.genco.tv/wp-content/uploads/2014/08/gencoLogoTypeRetina.png";s:17:"hb_wordpress_logo";s:80:"http://www.whenshitgoesmadmax.com/test/wp-content/uploads/2014/08/GencoPaper.png";s:25:"hb_contact_settings_email";s:14:"chris@genco.tv";s:27:"hb_enable_quick_contact_box";s:1:"1";s:26:"hb_quick_contact_box_title";s:10:"Contact Us";s:25:"hb_quick_contact_box_text";s:28:"Feel free to drop us a line!";s:33:"hb_quick_contact_box_button_title";s:12:"Send Message";s:32:"hb_quick_contact_box_button_icon";s:19:"hb-moon-paper-plane";s:23:"hb_general_notebox_blog";s:0:"";s:22:"hb_blog_excerpt_length";s:2:"35";s:24:"hb_blog_enable_by_author";s:1:"1";s:19:"hb_blog_enable_date";s:1:"1";s:23:"hb_blog_enable_comments";s:0:"";s:25:"hb_blog_enable_categories";s:0:"";s:19:"hb_blog_enable_tags";s:0:"";s:28:"hb_blog_enable_related_posts";s:0:"";s:24:"hb_blog_enable_next_prev";s:0:"";s:20:"hb_blog_enable_likes";s:1:"1";s:29:"hb_blog_enable_featured_image";s:1:"1";s:20:"hb_blog_image_height";s:3:"525";s:19:"hb_blog_author_info";s:0:"";s:20:"hb_blog_enable_share";s:1:"1";s:20:"hb_comment_form_text";s:27:"Your email is safe with us.";s:17:"hb_archives_title";s:7:"Archive";s:28:"hb_general_notebox_portfolio";s:0:"";s:19:"hb_portfolio_layout";s:9:"fullwidth";s:25:"hb_portfolio_sidebar_side";s:13:"right-sidebar";s:27:"hb_portfolio_content_layout";s:14:"totalfullwidth";s:25:"hb_portfolio_enable_likes";s:1:"1";s:33:"hb_portfolio_enable_related_posts";s:1:"1";s:29:"hb_portfolio_enable_next_prev";s:1:"1";s:25:"hb_portfolio_enable_share";s:1:"1";s:28:"hb_portfolio_taxonomy_filter";s:1:"1";s:28:"hb_portfolio_taxonomy_sorter";s:1:"1";s:29:"hb_portfolio_taxonomy_columns";s:1:"3";s:33:"hb_portfolio_taxonomy_orientation";s:9:"landscape";s:27:"hb_portfolio_taxonomy_ratio";s:6:"ratio1";s:15:"hb_staff_layout";s:11:"metasidebar";s:21:"hb_staff_sidebar_side";s:12:"left-sidebar";s:29:"hb_staff_enable_related_posts";s:1:"1";s:25:"hb_staff_enable_next_prev";s:1:"1";s:12:"hb_woo_count";s:2:"12";s:19:"hb_woo_enable_likes";s:1:"1";s:21:"hb_woo_layout_sidebar";s:9:"fullwidth";s:21:"hb_woo_choose_sidebar";s:18:"hb-default-sidebar";s:24:"hb_woo_sp_layout_sidebar";s:9:"fullwidth";s:24:"hb_woo_sp_choose_sidebar";s:18:"hb-default-sidebar";s:19:"hb_woo_enable_share";s:1:"1";s:20:"hb_soc_links_new_tab";s:1:"1";s:15:"hb_twitter_link";s:0:"";s:16:"hb_facebook_link";s:45:"https://www.facebook.com/GencoOliveOilCompany";s:17:"hb_vkontakte_link";s:0:"";s:13:"hb_skype_link";s:0:"";s:17:"hb_instagram_link";s:0:"";s:17:"hb_pinterest_link";s:0:"";s:19:"hb_google-plus_link";s:0:"";s:16:"hb_dribbble_link";s:0:"";s:12:"hb_digg_link";s:0:"";s:12:"hb_xing_link";s:0:"";s:15:"hb_myspace_link";s:0:"";s:18:"hb_soundcloud_link";s:0:"";s:15:"hb_youtube_link";s:0:"";s:13:"hb_vimeo_link";s:0:"";s:14:"hb_flickr_link";s:0:"";s:14:"hb_tumblr_link";s:0:"";s:13:"hb_yahoo_link";s:0:"";s:18:"hb_foursquare_link";s:0:"";s:15:"hb_blogger_link";s:0:"";s:17:"hb_wordpress_link";s:0:"";s:14:"hb_lastfm_link";s:0:"";s:14:"hb_github_link";s:0:"";s:16:"hb_linkedin_link";s:0:"";s:12:"hb_yelp_link";s:0:"";s:14:"hb_forrst_link";s:0:"";s:18:"hb_deviantart_link";s:0:"";s:19:"hb_stumbleupon_link";s:0:"";s:17:"hb_delicious_link";s:0:"";s:14:"hb_reddit_link";s:0:"";s:15:"hb_behance_link";s:0:"";s:12:"hb_mail_link";s:0:"";s:14:"hb_feed-2_link";s:0:"";s:18:"hb_custom-url_link";s:0:"";s:20:"hb_twitter_notebox_1";s:0:"";s:23:"hb_twitter_consumer_key";s:0:"";s:26:"hb_twitter_consumer_secret";s:0:"";s:23:"hb_twitter_access_token";s:0:"";s:30:"hb_twitter_access_token_secret";s:0:"";s:17:"hb_share_facebook";s:1:"1";s:16:"hb_share_twitter";s:1:"1";s:14:"hb_share_gplus";s:1:"1";s:17:"hb_share_linkedin";s:0:"";s:18:"hb_share_pinterest";s:1:"1";s:15:"hb_share_tumblr";s:1:"1";s:18:"hb_share_vkontakte";s:0:"";s:15:"hb_share_reddit";s:0:"";s:14:"hb_share_email";s:1:"1";s:16:"hb_map_notebox_1";s:0:"";s:11:"hb_map_zoom";s:2:"16";s:15:"hb_map_latitude";s:9:"48.856614";s:16:"hb_map_longitude";s:8:"2.352222";s:20:"hb_enable_custom_pin";s:0:"";s:22:"hb_custom_marker_image";s:0:"";s:19:"hb_enable_map_color";s:1:"1";s:18:"hb_map_focus_color";s:7:"#ff6838";s:17:"hb_map_1_latitude";s:9:"48.856614";s:18:"hb_map_1_longitude";s:8:"2.352222";s:18:"hb_location_1_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_2";s:0:"";s:17:"hb_map_2_latitude";s:9:"48.856614";s:18:"hb_map_2_longitude";s:8:"2.352227";s:18:"hb_location_2_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_3";s:0:"";s:17:"hb_map_3_latitude";s:9:"48.856615";s:18:"hb_map_3_longitude";s:8:"2.352221";s:18:"hb_location_3_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_4";s:0:"";s:17:"hb_map_4_latitude";s:9:"48.856619";s:18:"hb_map_4_longitude";s:8:"2.352229";s:18:"hb_location_4_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_5";s:0:"";s:17:"hb_map_5_latitude";s:9:"48.856610";s:18:"hb_map_5_longitude";s:8:"2.352220";s:18:"hb_location_5_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_6";s:0:"";s:17:"hb_map_6_latitude";s:9:"48.856610";s:18:"hb_map_6_longitude";s:8:"2.352220";s:18:"hb_location_6_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_7";s:0:"";s:17:"hb_map_7_latitude";s:9:"48.856610";s:18:"hb_map_7_longitude";s:8:"2.352220";s:18:"hb_location_7_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_8";s:0:"";s:17:"hb_map_8_latitude";s:9:"48.856610";s:18:"hb_map_8_longitude";s:8:"2.352220";s:18:"hb_location_8_info";s:39:"Enter your info here or leave it empty.";s:20:"hb_enable_location_9";s:0:"";s:17:"hb_map_9_latitude";s:9:"48.856610";s:18:"hb_map_9_longitude";s:8:"2.352220";s:18:"hb_location_9_info";s:39:"Enter your info here or leave it empty.";s:21:"hb_enable_location_10";s:0:"";s:18:"hb_map_10_latitude";s:9:"48.856610";s:19:"hb_map_10_longitude";s:8:"2.352220";s:19:"hb_location_10_info";s:39:"Enter your info here or leave it empty.";s:12:"hb_font_body";s:14:"hb_font_custom";s:17:"hb_font_body_face";s:4:"Arvo";s:20:"hb_font_body_subsets";a:1:{i:0;s:5:"latin";}s:17:"hb_font_body_size";s:2:"13";s:19:"hb_font_body_weight";s:6:"normal";s:24:"hb_font_body_line_height";s:2:"22";s:27:"hb_font_body_letter_spacing";s:1:"0";s:18:"hb_font_navigation";s:14:"hb_font_custom";s:23:"hb_font_navigation_face";s:4:"Arvo";s:19:"hb_font_nav_subsets";a:0:{}s:23:"hb_font_navigation_size";s:2:"13";s:18:"hb_font_nav_weight";s:3:"700";s:30:"hb_font_navigation_line_height";s:2:"22";s:33:"hb_font_navigation_letter_spacing";s:1:"0";s:17:"hb_font_copyright";s:14:"hb_font_custom";s:22:"hb_font_copyright_face";s:4:"Arvo";s:25:"hb_font_copyright_subsets";a:1:{i:0;s:5:"latin";}s:22:"hb_font_copyright_size";s:2:"12";s:24:"hb_font_copyright_weight";s:6:"normal";s:29:"hb_font_copyright_line_height";s:2:"22";s:32:"hb_font_copyright_letter_spacing";s:1:"0";s:10:"hb_font_h1";s:14:"hb_font_custom";s:15:"hb_font_h1_face";s:4:"Arvo";s:18:"hb_font_h1_subsets";a:1:{i:0;s:5:"latin";}s:15:"hb_font_h1_size";s:2:"30";s:17:"hb_font_h1_weight";s:3:"700";s:22:"hb_font_h1_line_height";s:2:"36";s:25:"hb_font_h1_letter_spacing";s:1:"0";s:10:"hb_font_h2";s:14:"hb_font_custom";s:15:"hb_font_h2_face";s:4:"Arvo";s:18:"hb_font_h2_subsets";a:0:{}s:15:"hb_font_h2_size";s:2:"24";s:17:"hb_font_h2_weight";s:3:"700";s:22:"hb_font_h2_line_height";s:2:"30";s:25:"hb_font_h2_letter_spacing";s:1:"0";s:10:"hb_font_h3";s:14:"hb_font_custom";s:15:"hb_font_h3_face";s:4:"Arvo";s:18:"hb_font_h3_subsets";a:0:{}s:15:"hb_font_h3_size";s:2:"20";s:17:"hb_font_h3_weight";s:3:"700";s:22:"hb_font_h3_line_height";s:2:"26";s:25:"hb_font_h3_letter_spacing";s:1:"0";s:10:"hb_font_h4";s:14:"hb_font_custom";s:15:"hb_font_h4_face";s:4:"Arvo";s:18:"hb_font_h4_subsets";a:0:{}s:15:"hb_font_h4_size";s:2:"18";s:17:"hb_font_h4_weight";s:6:"normal";s:22:"hb_font_h4_line_height";s:2:"24";s:25:"hb_font_h4_letter_spacing";s:1:"0";s:10:"hb_font_h5";s:14:"hb_font_custom";s:15:"hb_font_h5_face";s:4:"Arvo";s:18:"hb_font_h5_subsets";a:0:{}s:15:"hb_font_h5_size";s:2:"16";s:17:"hb_font_h5_weight";s:3:"700";s:22:"hb_font_h5_line_height";s:2:"22";s:25:"hb_font_h5_letter_spacing";s:1:"0";s:10:"hb_font_h6";s:14:"hb_font_custom";s:15:"hb_font_h6_face";s:4:"Arvo";s:18:"hb_font_h6_subsets";a:0:{}s:15:"hb_font_h6_size";s:2:"16";s:17:"hb_font_h6_weight";s:3:"700";s:22:"hb_font_h6_line_height";s:2:"22";s:25:"hb_font_h6_letter_spacing";s:1:"0";s:18:"hb_pre_footer_font";s:14:"hb_font_custom";s:23:"hb_pre_footer_font_face";s:4:"Arvo";s:26:"hb_font_pre_footer_subsets";a:0:{}s:23:"hb_pre_footer_font_size";s:2:"13";s:25:"hb_font_pre_footer_weight";s:3:"700";s:25:"hb_pre_footer_line_height";s:2:"22";s:28:"hb_pre_footer_letter_spacing";s:1:"0";s:21:"hb_color_manager_type";s:33:"hb_color_manager_color_customizer";s:22:"hb_general_notebox_991";s:0:"";s:19:"hb_customizer_field";s:171:"<div class="hb-buttons"><a href="http://www.whenshitgoesmadmax.com/test/wp-admin/customize.php" class="vp-button button button-primary">Run Live Color Customizer</a></div>";s:17:"hb_scheme_chooser";s:13:"dark_elegance";s:18:"hb_maint_notebox_2";s:0:"";s:21:"hb_enable_maintenance";s:0:"";s:30:"hb_maintenance_layout_position";s:16:"center-alignment";s:19:"hb_maintenance_logo";s:0:"";s:31:"hb_maintenance_enable_countdown";s:0:"";s:17:"hb_countdown_date";s:0:"";s:18:"hb_countdown_hours";s:1:"8";s:20:"hb_countdown_minutes";s:2:"30";s:18:"hb_countdown_style";s:0:"";s:22:"hb_maintenance_content";s:194:"<p>[countdown date="16 spetember 2014 20:00:00"]</p>\r\n<p>[fullwidth_section text_color="dark" background_type="color" bg_color="" margin_top="0"][rev_slider comingSoon][/fullwidth_section]</p>\r\n";s:23:"hb_maintenance_bg_color";s:7:"#ffffff";s:23:"hb_maintenance_bg_image";s:0:"";s:19:"hb_diagnostic_field";s:3256:"<p>Below information is useful to diagnose some of the possible reasons to malfunctions, performance issues or any errors.<br />You can faciliate the process of support by providing below information to our support staff.<br /><br />You need to reset the Theme Options (Backup Settings > Restore Default) in order to see changes.<br /><br /><strong>If Highend Options are not saving changes - you need to increase your WP_MEMORY_LIMIT. Please follow <a href="http://hb-themes.com/forum/all/topic/theme-options-not-saving-changes-resolved-fix/" target="_blank">these steps.</a></strong></p><div class="vp-section"><div class="vp-controls"><div class="vp-field"><div class="label"><strong>Theme Name:</strong></div><div class="field">Highend</div></div><div class="vp-field"><div class="label"><strong>Theme Version:</strong></div><div class="field">1.5</div></div><div class="vp-field"><div class="label"><strong>Theme Author:</strong></div><div class="field">HB-Themes</div></div><div class="vp-field"><div class="label"><strong>Site URL:</strong></div><div class="field">http://www.whenshitgoesmadmax.com/test</div></div><div class="vp-field"><div class="label"><strong>Theme Demo:</strong></div><div class="field">http://preview.hb-themes.com/?theme=Highend</div></div><div class="vp-field"><div class="label"><strong>WordPress Version:</strong></div><div class="field">3.9.1</div></div><div class="vp-field"><div class="label"><strong>WordPress Language:</strong></div><div class="field">en-US</div></div><div class="vp-field"><div class="label"><strong>Admin Email:</strong></div><div class="field">info@genco.tv</div></div><div class="vp-field"><div class="label"><strong>Server Information:</strong></div><div class="field">Apache</div></div><div class="vp-field"><div class="label"><strong>PHP Version:</strong></div><div class="field">5.4.30</div></div><div class="vp-field"><div class="label"><strong>WP Memory Limit:</strong></div><div class="field">40 MB <span style=\'color:red\'><br />Recommended memory limit should be at least 64MB. Please, take a look at: <a href=\'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP\' target=\'_blank\'>Increasing memory allocated to PHP</a> for more information.</span></div></div><div class="vp-field"><div class="label"><strong>WP Max Upload Size:</strong></div><div class="field">10 MB</div></div><div class="vp-field"><div class="label"><strong>Max Execution Time:</strong></div><div class="field">30 <span style=\'color:red\'><br />Recommended max_execution_time should be at least 120. Please, take a look at: <a href=\'http://hb-themes.com/forum/all/topic/how-to-increase-max_execution_time-variable/\' target=\'_blank\'>Increasing max_execution_time instructions</a> for more information.</span></div></div><div class="vp-field"><div class="label"><strong>WP Debug Mode:</strong></div><div class="field">Disabled</div></div></div></div><div class="hb-buttons"><a href="http://forum.hb-themes.com" class="vp-button button button-primary">Support Forum</a><a href="http://documentation.hb-themes.com/highend" class="vp-button button button-primary">Documentation</a><a href="http://www.youtube.com/user/hbthemes" class="vp-button button button-primary">Video Tutorials</a></div>";s:22:"hb_demo_importer_field";s:1719:"<p>Demo Import will replicate our demo on your website.<br />Please, use it carefully, it will replace some of your data. Also, make sure you don\'t have any issues (marked as red) in the <a href="http://www.whenshitgoesmadmax.com/test/wp-admin/themes.php?page=highend_options#hb_theme_diagnostic" target="_blank">System Diagnostics</a> section, before importing the demo.</p><p>The following data will be imported:</p><ol><li>Blog Posts from Highend Demo.</li><li>All Pages from Highend Demo.</li><li>All Custom Post Types items from Highend Demo.</li><li>Comments from Highend Demo.</li><li>Sliders from Highend Demo. (You need to install and activate sliders first).</li><li>Media library from Highend Demo.</li><li>Theme Options from Highend Demo.</li><li>Widgets and Sidebars from Highend Demo.</li><li>WordPress Menus from Highend Demo.</li></ol><p>FULL Demo Import process can take up to 25 minutes or even more to complete.</p><p><strong>DO NOT interrupt the process.</strong></p><p>The imported stuff cannot be deleted at once, so we suggest to import the demo on your test website, not live website.</p><div class="hb-buttons"><a href="#" class="vp-button button button-primary hb-import-button full-demo-import">Import FULL Demo Content</a><a href="#" class="vp-button button button-primary hb-import-button light-demo-import">Import LIGHT Demo Content</a></div><p>Due to large demo export files, on some hosts the full demo import will fail and generate Error 500 - Internal Server Error.<br />In that case, you can try increasing max_execution_time to 120 and WP_MEMORY_LIMIT to 128M.<br /><br />We strongly suggest to import the LIGHT demo content instead. (The demo content without images and sliders)</p>";s:0:"";s:0:"";}', 'yes') ;
INSERT INTO `wp_options` ( `option_id`, `option_name`, `option_value`, `autoload`) VALUES
(134, 'wpcf7', 'a:1:{s:7:"version";s:5:"3.9.3";}', 'yes'),
(135, 'ls-plugin-version', '5.1.1', 'yes'),
(136, 'ls-db-version', '5.0.0', 'yes'),
(137, 'ls-installed', '1', 'yes'),
(138, 'ls-google-fonts', 'a:4:{i:0;a:2:{s:5:"param";s:28:"Lato:100,300,regular,700,900";s:5:"admin";b:0;}i:1;a:2:{s:5:"param";s:13:"Open+Sans:300";s:5:"admin";b:0;}i:2;a:2:{s:5:"param";s:20:"Indie+Flower:regular";s:5:"admin";b:0;}i:3;a:2:{s:5:"param";s:22:"Oswald:300,regular,700";s:5:"admin";b:0;}}', 'yes'),
(139, 'revslider_checktables', '1', 'yes'),
(140, 'revslider-static-css', '.tp-caption a {\n/*color:#ff7302;*/\n/*color: #FFFFFF !important;*/\ntext-shadow:none;\n-webkit-transition:all 0.2s ease-out;\n-moz-transition:all 0.2s ease-out;\n-o-transition:all 0.2s ease-out;\n-ms-transition:all 0.2s ease-out;\n}\n\n.tp-caption a:hover {\n/*color:#ffa902;*/\n/*color: #FFFFFF !important;*/\n}', 'yes'),
(141, 'revslider-update-check-short', '1410979999', 'yes'),
(142, 'recently_activated', 'a:4:{s:19:"if-menu/if-menu.php";i:1411065552;s:35:"rename-wp-login/rename-wp-login.php";i:1410888550;s:57:"azurecurve-toggle-showhide/azurecurve-toggle-showhide.php";i:1410793687;s:44:"jquery-collapse-o-matic/collapse-o-matic.php";i:1410756683;}', 'yes'),
(144, 'theme_mods_HighendWP-child', 'a:32:{i:0;b:0;s:22:"hb_focus_color_setting";s:7:"#dd3333";s:21:"hb_top_bar_bg_setting";s:7:"#0a0a0a";s:25:"hb_top_bar_border_setting";s:7:"#0a0a0a";s:29:"hb_top_bar_text_color_setting";s:7:"#ffffff";s:29:"hb_top_bar_link_color_setting";s:7:"#ffffff";s:21:"hb_nav_bar_bg_setting";s:7:"#0a0a0a";s:27:"hb_nav_bar_stuck_bg_setting";s:7:"#0a0a0a";s:23:"hb_nav_bar_text_setting";s:7:"#ffffff";s:29:"hb_nav_bar_stuck_text_setting";s:7:"#ffffff";s:25:"hb_nav_bar_border_setting";s:7:"#0a0a0a";s:31:"hb_nav_bar_stuck_border_setting";s:7:"#ffffff";s:21:"hb_pfooter_bg_setting";s:7:"#ececec";s:23:"hb_pfooter_text_setting";s:7:"#323436";s:20:"hb_footer_bg_setting";s:7:"#3d3d3d";s:22:"hb_footer_text_setting";s:7:"#ffffff";s:22:"hb_footer_link_setting";s:4:"#fff";s:23:"hb_copyright_bg_setting";s:7:"#292929";s:25:"hb_copyright_text_setting";s:4:"#999";s:25:"hb_copyright_link_setting";s:4:"#fff";s:21:"hb_content_bg_setting";s:7:"#444444";s:23:"hb_content_c_bg_setting";s:7:"#ffffff";s:29:"hb_content_text_color_setting";s:7:"#0a0a0a";s:29:"hb_content_link_color_setting";s:7:"#da1e00";s:25:"hb_content_border_setting";s:7:"#e1e1e1";s:21:"hb_content_h1_setting";s:7:"#da1e00";s:21:"hb_content_h2_setting";s:7:"#da1e00";s:21:"hb_content_h3_setting";s:7:"#da1e00";s:21:"hb_content_h4_setting";s:7:"#da1e00";s:21:"hb_content_h5_setting";s:7:"#da1e00";s:21:"hb_content_h6_setting";s:7:"#da1e00";s:18:"nav_menu_locations";a:4:{s:9:"main-menu";i:8;s:11:"footer-menu";i:0;s:11:"mobile-menu";i:32;s:13:"one-page-menu";i:0;}}', 'yes'),
(155, 'faq_categories_children', 'a:0:{}', 'yes'),
(156, 'testimonial_categories_children', 'a:0:{}', 'yes'),
(157, 'client_categories_children', 'a:0:{}', 'yes'),
(158, 'team_categories_children', 'a:0:{}', 'yes'),
(159, 'portfolio_categories_children', 'a:2:{i:2;a:4:{i:0;i:3;i:1;i:4;i:2;i:5;i:3;i:7;}i:5;a:1:{i:0;i:6;}}', 'yes'),
(161, 'widget_pages', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(162, 'widget_calendar', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(163, 'widget_tag_cloud', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(164, 'widget_nav_menu', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(165, 'widget_layerslider_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(166, 'widget_rev-slider-widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(167, 'widget_hb_most_commented_posts_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(168, 'widget_hb_latest_posts_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(169, 'widget_hb_most_liked_posts_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(170, 'widget_hb_recent_comments_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(171, 'widget_hb_testimonials_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(172, 'widget_hb_video_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(173, 'widget_hb_instagram_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(174, 'widget_hb_pinterest_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(175, 'widget_hb_flickr_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(176, 'widget_hb_dribbble_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(177, 'widget_hb_google_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(178, 'widget_hb_facebook_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(179, 'widget_hb_contact_info_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(180, 'widget_hb_soc_net_widget', 'a:3:{i:1;a:0:{}i:2;a:3:{s:5:"title";s:20:"Visit us on Facebook";s:11:"large_icons";s:6:"normal";s:10:"icon_style";s:5:"light";}s:12:"_multiwidget";i:1;}', 'yes'),
(181, 'widget_gmap', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(182, 'widget_twitter', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(183, 'widget_hb_portfolio_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(184, 'widget_hb_portfolio_widget_rand', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(185, 'widget_hb_liked_portfolio_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(186, 'widget_hb_ad_twofifty_widget', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(187, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:"auto_add";a:0:{}}', 'yes'),
(201, 'woocommerce_default_country', 'US:NY', 'yes'),
(202, 'woocommerce_allowed_countries', 'all', 'yes'),
(203, 'woocommerce_specific_allowed_countries', 'a:0:{}', 'yes'),
(204, 'woocommerce_demo_store', 'no', 'yes'),
(205, 'woocommerce_demo_store_notice', 'This is a demo store for testing purposes — no orders shall be fulfilled.', 'no'),
(206, 'woocommerce_api_enabled', 'yes', 'yes'),
(207, 'woocommerce_currency', 'USD', 'yes'),
(208, 'woocommerce_currency_pos', 'left', 'yes'),
(209, 'woocommerce_price_thousand_sep', ',', 'yes'),
(210, 'woocommerce_price_decimal_sep', '.', 'yes'),
(211, 'woocommerce_price_num_decimals', '2', 'yes'),
(212, 'woocommerce_enable_lightbox', 'yes', 'yes'),
(213, 'woocommerce_enable_chosen', 'yes', 'no'),
(214, 'woocommerce_shop_page_id', '25', 'yes'),
(215, 'woocommerce_shop_page_display', '', 'yes'),
(216, 'woocommerce_category_archive_display', '', 'yes'),
(217, 'woocommerce_default_catalog_orderby', 'menu_order', 'yes'),
(218, 'woocommerce_cart_redirect_after_add', 'no', 'yes'),
(219, 'woocommerce_enable_ajax_add_to_cart', 'yes', 'yes'),
(220, 'woocommerce_weight_unit', 'lbs', 'yes'),
(221, 'woocommerce_dimension_unit', 'in', 'yes'),
(222, 'woocommerce_enable_review_rating', 'yes', 'no'),
(223, 'woocommerce_review_rating_required', 'yes', 'no'),
(224, 'woocommerce_review_rating_verification_label', 'yes', 'no'),
(225, 'woocommerce_review_rating_verification_required', 'no', 'no'),
(226, 'shop_catalog_image_size', 'a:3:{s:5:"width";s:3:"150";s:6:"height";s:3:"150";s:4:"crop";i:0;}', 'yes'),
(227, 'shop_single_image_size', 'a:3:{s:5:"width";s:3:"300";s:6:"height";s:3:"300";s:4:"crop";i:0;}', 'yes'),
(228, 'shop_thumbnail_image_size', 'a:3:{s:5:"width";s:3:"100";s:6:"height";s:3:"100";s:4:"crop";i:0;}', 'yes'),
(229, 'woocommerce_file_download_method', 'force', 'no'),
(230, 'woocommerce_downloads_require_login', 'no', 'no'),
(231, 'woocommerce_downloads_grant_access_after_payment', 'yes', 'no'),
(232, 'woocommerce_manage_stock', 'yes', 'yes'),
(233, 'woocommerce_hold_stock_minutes', '60', 'no'),
(234, 'woocommerce_notify_low_stock', 'yes', 'no'),
(235, 'woocommerce_notify_no_stock', 'yes', 'no'),
(236, 'woocommerce_stock_email_recipient', 'chris@genco.tv', 'no'),
(237, 'woocommerce_notify_low_stock_amount', '2', 'no'),
(238, 'woocommerce_notify_no_stock_amount', '0', 'no'),
(239, 'woocommerce_hide_out_of_stock_items', 'no', 'yes'),
(240, 'woocommerce_stock_format', '', 'yes'),
(241, 'woocommerce_calc_taxes', 'no', 'yes'),
(242, 'woocommerce_prices_include_tax', 'no', 'yes'),
(243, 'woocommerce_tax_based_on', 'shipping', 'yes'),
(244, 'woocommerce_default_customer_address', 'base', 'yes'),
(245, 'woocommerce_shipping_tax_class', 'title', 'yes'),
(246, 'woocommerce_tax_round_at_subtotal', 'no', 'yes'),
(247, 'woocommerce_tax_classes', 'Reduced Rate\nZero Rate', 'yes'),
(248, 'woocommerce_tax_display_shop', 'excl', 'yes'),
(249, 'woocommerce_price_display_suffix', '', 'yes'),
(250, 'woocommerce_tax_display_cart', 'excl', 'no'),
(251, 'woocommerce_tax_total_display', 'itemized', 'no'),
(252, 'woocommerce_enable_coupons', 'yes', 'no'),
(253, 'woocommerce_enable_guest_checkout', 'yes', 'no'),
(254, 'woocommerce_force_ssl_checkout', 'no', 'yes'),
(255, 'woocommerce_unforce_ssl_checkout', 'no', 'yes'),
(256, 'woocommerce_cart_page_id', '200', 'yes'),
(257, 'woocommerce_checkout_page_id', '201', 'yes'),
(258, 'woocommerce_terms_page_id', '', 'no') ;
INSERT INTO `wp_options` ( `option_id`, `option_name`, `option_value`, `autoload`) VALUES
(259, 'woocommerce_checkout_pay_endpoint', 'order-pay', 'yes'),
(260, 'woocommerce_checkout_order_received_endpoint', 'order-received', 'yes'),
(261, 'woocommerce_myaccount_add_payment_method_endpoint', 'add-payment-method', 'yes'),
(262, 'woocommerce_calc_shipping', 'yes', 'yes'),
(263, 'woocommerce_enable_shipping_calc', 'yes', 'no'),
(264, 'woocommerce_shipping_cost_requires_address', 'no', 'no'),
(265, 'woocommerce_shipping_method_format', '', 'no'),
(266, 'woocommerce_ship_to_billing', 'yes', 'no'),
(267, 'woocommerce_ship_to_billing_address_only', 'no', 'no'),
(268, 'woocommerce_ship_to_countries', '', 'yes'),
(269, 'woocommerce_specific_ship_to_countries', '', 'yes'),
(270, 'woocommerce_myaccount_page_id', '202', 'yes'),
(271, 'woocommerce_myaccount_view_order_endpoint', 'view-order', 'yes'),
(272, 'woocommerce_myaccount_edit_account_endpoint', 'edit-account', 'yes'),
(273, 'woocommerce_myaccount_edit_address_endpoint', 'edit-address', 'yes'),
(274, 'woocommerce_myaccount_lost_password_endpoint', 'lost-password', 'yes'),
(275, 'woocommerce_logout_endpoint', 'customer-logout', 'yes'),
(276, 'woocommerce_enable_signup_and_login_from_checkout', 'yes', 'no'),
(277, 'woocommerce_enable_myaccount_registration', 'yes', 'no'),
(278, 'woocommerce_enable_checkout_login_reminder', 'yes', 'no'),
(279, 'woocommerce_registration_generate_username', 'yes', 'no'),
(280, 'woocommerce_registration_generate_password', 'no', 'no'),
(281, 'woocommerce_email_from_name', 'Genco Olive Oil Co.', 'no'),
(282, 'woocommerce_email_from_address', 'chris@genco.tv', 'no'),
(283, 'woocommerce_email_header_image', '', 'no'),
(284, 'woocommerce_email_footer_text', 'Genco Olive Oil Co. - Powered by WooCommerce', 'no'),
(285, 'woocommerce_email_base_color', '#557da1', 'no'),
(286, 'woocommerce_email_background_color', '#f5f5f5', 'no'),
(287, 'woocommerce_email_body_background_color', '#fdfdfd', 'no'),
(288, 'woocommerce_email_text_color', '#505050', 'no'),
(290, 'woocommerce_db_version', '2.1.12', 'yes'),
(291, 'woocommerce_version', '2.1.12', 'yes'),
(299, 'woocommerce_meta_box_errors', 'a:0:{}', 'yes'),
(300, 'slurp_page_installed', '1', 'yes'),
(315, 'outlandish_sync_secret', 'X4Sv_b0,-KCW\'{vN', 'yes'),
(350, 'revslider-latest-version', '4.6.0', 'yes'),
(368, 'outlandish_sync_tokens', 'a:1:{s:39:"http://www.whenshitgoesmadmax.com/genco";s:16:"/!_UyK<-zyj3HRkg";}', 'yes'),
(423, 'product_shipping_class_children', 'a:0:{}', 'yes'),
(424, 'pa_color_children', 'a:0:{}', 'yes'),
(425, 'pa_size_children', 'a:0:{}', 'yes'),
(485, 'wpb_js_content_types', 'a:10:{i:0;s:4:"post";i:1;s:4:"page";i:2;s:4:"team";i:3;s:7:"clients";i:4;s:3:"faq";i:5;s:16:"hb_pricing_table";i:6;s:15:"hb_testimonials";i:7;s:9:"portfolio";i:8;s:7:"gallery";i:9;s:7:"product";}', 'yes'),
(486, 'wpb_js_groups_access_rules', 'a:5:{s:13:"administrator";a:1:{s:4:"show";s:3:"all";}s:6:"editor";a:1:{s:4:"show";s:3:"all";}s:6:"author";a:1:{s:4:"show";s:3:"all";}s:11:"contributor";a:1:{s:4:"show";s:3:"all";}s:12:"shop_manager";a:1:{s:4:"show";s:3:"all";}}', 'yes'),
(487, 'wpb_js_not_responsive_css', '', 'yes'),
(488, 'wpb_js_google_fonts_subsets', 'a:1:{i:0;s:5:"latin";}', 'yes'),
(515, 'woocommerce_permalinks', 'a:4:{s:13:"category_base";s:0:"";s:8:"tag_base";s:0:"";s:14:"attribute_base";s:0:"";s:12:"product_base";s:0:"";}', 'yes'),
(530, 'duplicate_post_copyexcerpt', '1', 'yes'),
(531, 'duplicate_post_copyattachments', '0', 'yes'),
(532, 'duplicate_post_copychildren', '0', 'yes'),
(533, 'duplicate_post_copystatus', '0', 'yes'),
(534, 'duplicate_post_taxonomies_blacklist', 'a:0:{}', 'yes'),
(535, 'duplicate_post_show_row', '1', 'yes'),
(536, 'duplicate_post_show_adminbar', '1', 'yes'),
(537, 'duplicate_post_show_submitbox', '1', 'yes'),
(538, 'duplicate_post_version', '2.6', 'yes'),
(541, 'widget_woocommerce_widget_cart', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(542, 'widget_woocommerce_products', 'a:3:{i:1;a:0:{}i:2;a:7:{s:5:"title";s:11:"Genco Stuff";s:6:"number";s:1:"5";s:4:"show";s:0:"";s:7:"orderby";s:4:"rand";s:5:"order";s:4:"desc";s:9:"hide_free";i:0;s:11:"show_hidden";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(543, 'widget_woocommerce_layered_nav', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(544, 'widget_woocommerce_layered_nav_filters', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(545, 'widget_woocommerce_price_filter', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(546, 'widget_woocommerce_product_categories', 'a:3:{i:1;a:0:{}i:2;a:6:{s:5:"title";s:18:"Product Categories";s:7:"orderby";s:4:"name";s:8:"dropdown";i:0;s:5:"count";i:0;s:12:"hierarchical";s:1:"1";s:18:"show_children_only";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(547, 'widget_woocommerce_product_search', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(548, 'widget_woocommerce_product_tag_cloud', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(549, 'widget_woocommerce_recent_reviews', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(550, 'widget_woocommerce_recently_viewed_products', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(551, 'widget_woocommerce_top_rated_products', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(585, 'sbg_sidebars', 'a:2:{s:11:"NewsSidebar";s:12:"News Sidebar";s:8:"Products";s:8:"Products";}', 'yes'),
(594, 'gallery_categories_children', 'a:1:{i:11;a:1:{i:0;i:28;}}', 'yes'),
(614, 'wpb_js_templates', 'a:2:{s:28:"news-post-template_353724243";a:2:{s:4:"name";s:18:"News Post Template";s:8:"template";s:6987:"[vc_row][vc_column][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper viverra magna porttitor faucibus. Duis bibendum metus eu massa ultricies dictum. Integer ac elit felis. Etiam semper, quam nec tempus bibendum, metus elit tristique nunc, tristique vehicula lorem massa nec quam. Phasellus vehicula, augue a facilisis fringilla, velit velit convallis nunc, id faucibus felis risus a purus. Nullam convallis congue nulla, nec consectetur ipsum aliquet non. Vestibulum tempus, risus quis tempus faucibus, risus enim consectetur enim, a suscipit lectus sem sit amet velit. Phasellus lorem mauris, convallis ultricies velit sed, rutrum elementum orci. Cras nec ornare justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\nSed pretium varius lacus, vitae mattis lorem venenatis ac. Ut at ipsum turpis. Etiam dignissim nisl sed dui tincidunt dignissim. Sed hendrerit sem at magna aliquet, id gravida diam imperdiet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam ligula nisi, vulputate sit amet felis non, gravida ultricies tellus. Proin quis tellus sed augue faucibus dignissim. Donec at mi sapien. Vivamus sed ante et nisl vulputate aliquam. Duis eu justo nec felis condimentum interdum vel in mauris.\nCum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse tincidunt dui quis diam placerat, quis tempor nibh tincidunt. Vestibulum nec luctus augue, et facilisis justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum dictum magna mauris, ac egestas quam iaculis iaculis. Morbi a pulvinar lectus. Vivamus at ligula turpis.\nDuis eu mauris sed diam pharetra porttitor. Maecenas fringilla mauris sed augue dapibus, nec porta magna pellentesque. Nunc iaculis turpis ut posuere mollis. Nullam lacinia porttitor ligula, eu egestas odio. Vivamus lobortis tellus vitae mauris imperdiet, adipiscing consectetur sapien bibendum. Sed rutrum gravida congue. Nullam hendrerit elementum neque volutpat laoreet. Donec in pretium urna, quis mattis erat. Vivamus tellus velit, sollicitudin sit amet sollicitudin ut, facilisis ut eros. Cras sagittis sagittis urna sed scelerisque.\nSed vestibulum porttitor mauris, sed cursus arcu laoreet in. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut lacinia libero sed ligula consectetur, iaculis hendrerit tortor consectetur. Sed justo tortor, vestibulum quis tincidunt quis, mollis vehicula arcu. Curabitur tincidunt nisi et nibh dignissim malesuada. Ut tempor, dolor eu vestibulum venenatis, ante purus rutrum libero, eu aliquam nisl arcu sed ligula. Pellentesque ante ipsum, tristique vitae consectetur vitae, tincidunt euismod erat. Vivamus congue blandit nisl id facilisis. Cras hendrerit risus velit, vel ornare neque semper in. Ut et nisi dictum, hendrerit lectus eget, facilisis augue. Vestibulum vulputate odio nulla, semper consectetur est porttitor in. In hac habitasse platea dictumst. Sed vel erat sagittis, fermentum purus eu, dignissim orci.[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column width="1/4"][image_frame url="398" border_style="boxed-frame" action="open-lightbox" animation="fade-in" rel="vegas"][/vc_column][vc_column width="1/4"][image_frame url="397" border_style="boxed-frame" action="open-lightbox" animation="fade-in" rel="vegas"][/vc_column][vc_column width="1/4"][image_frame url="396" border_style="boxed-frame" action="open-lightbox" animation="fade-in" rel="vegas"][/vc_column][vc_column width="1/4"][image_frame url="395" border_style="boxed-frame" action="open-lightbox" animation="fade-in" rel="vegas"][/vc_column][/vc_row][vc_row][vc_column][vc_empty_space height="32px"][vc_column_text]\n<h2>Header 2</h2>\n[/vc_column_text][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ullamcorper viverra magna porttitor faucibus. Duis bibendum metus eu massa ultricies dictum. Integer ac elit felis. Etiam semper, quam nec tempus bibendum, metus elit tristique nunc, tristique vehicula lorem massa nec quam. Phasellus vehicula, augue a facilisis fringilla, velit velit convallis nunc, id faucibus felis risus a purus. Nullam convallis congue nulla, nec consectetur ipsum aliquet non. Vestibulum tempus, risus quis tempus faucibus, risus enim consectetur enim, a suscipit lectus sem sit amet velit. Phasellus lorem mauris, convallis ultricies velit sed, rutrum elementum orci. Cras nec ornare justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\nSed pretium varius lacus, vitae mattis lorem venenatis ac. Ut at ipsum turpis. Etiam dignissim nisl sed dui tincidunt dignissim. Sed hendrerit sem at magna aliquet, id gravida diam imperdiet. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam ligula nisi, vulputate sit amet felis non, gravida ultricies tellus. Proin quis tellus sed augue faucibus dignissim. Donec at mi sapien. Vivamus sed ante et nisl vulputate aliquam. Duis eu justo nec felis condimentum interdum vel in mauris.\nCum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse tincidunt dui quis diam placerat, quis tempor nibh tincidunt. Vestibulum nec luctus augue, et facilisis justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum dictum magna mauris, ac egestas quam iaculis iaculis. Morbi a pulvinar lectus. Vivamus at ligula turpis.\nDuis eu mauris sed diam pharetra porttitor. Maecenas fringilla mauris sed augue dapibus, nec porta magna pellentesque. Nunc iaculis turpis ut posuere mollis. Nullam lacinia porttitor ligula, eu egestas odio. Vivamus lobortis tellus vitae mauris imperdiet, adipiscing consectetur sapien bibendum. Sed rutrum gravida congue. Nullam hendrerit elementum neque volutpat laoreet. Donec in pretium urna, quis mattis erat. Vivamus tellus velit, sollicitudin sit amet sollicitudin ut, facilisis ut eros. Cras sagittis sagittis urna sed scelerisque.\nSed vestibulum porttitor mauris, sed cursus arcu laoreet in. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut lacinia libero sed ligula consectetur, iaculis hendrerit tortor consectetur. Sed justo tortor, vestibulum quis tincidunt quis, mollis vehicula arcu. Curabitur tincidunt nisi et nibh dignissim malesuada. Ut tempor, dolor eu vestibulum venenatis, ante purus rutrum libero, eu aliquam nisl arcu sed ligula. Pellentesque ante ipsum, tristique vitae consectetur vitae, tincidunt euismod erat. Vivamus congue blandit nisl id facilisis. Cras hendrerit risus velit, vel ornare neque semper in. Ut et nisi dictum, hendrerit lectus eget, facilisis augue. Vestibulum vulputate odio nulla, semper consectetur est porttitor in. In hac habitasse platea dictumst. Sed vel erat sagittis, fermentum purus eu, dignissim orci.[/vc_column_text][/vc_column][/vc_row]";}s:15:"shows_709762557";a:2:{s:4:"name";s:5:"Shows";s:8:"template";s:2508:"[vc_row][vc_column width="1/1"][vc_column_text el_class="showTitle"]\n<h2>Manhattan, Kansas</h2>\n[/vc_column_text][vc_row_inner][vc_column_inner width="1/3"][vc_single_image image="1110" border_color="grey" img_link_target="_self" img_size="260x355" alignment="center"][/vc_column_inner][vc_column_inner width="2/3"][vc_column_text el_class="credits"]Written and Directed by Danny Provenzano\nExecutive Producer : Ron Tipa\nAssociate Producer: Kim Maria Cook\nProducer: Francisco Florencio\n\n[/vc_column_text][vc_column_text]In the on going struggle for the American dream, a not so regular “family” finds itself on the outskirts of oblivion. The five bourghs of New York, the home to some of the most ruthless Gangsters in the history of the american Mafia. On this quiet day in suburbia a botched hit by a notorious Blood set on a major organized crime captian, Sonny Verdi, causes him to consider the life . Victim to the hit, Sonny Verdi JR. is caught up in the middle of a gun battle that would rival the St. Valentines Day massacre. This event leads Sonny  Verdi Sr. to make a profound, life-altering decision that would impact not only his Crime Family but his own bloodline. It is at this point that Sonny Verdi Sr. makes that decision to hang up his holsters and respectfully request to be shelved.[showhide type="synopsis" more_text="Show More" less_text="Show Less" hidden="yes"]\n\nFast-forward 8 years later to present-day MANHATTAN, KANSAS, now home to the Verdi family. Follow Sonny Jr.’s exhilarating tale into a world of unforgettable characters and events. Backed with his Father’s love and support, Joey is an olive garden Italian with a vicious Sicilian bloodline whom, while waiting tables to make a living, manufactures and distributes his own line of Olive Oil under his trademark name  “Genco Olive Oil Company.”[/showhide][/vc_column_text][/vc_column_inner][/vc_row_inner][vc_accordion title="Episodes + Trailers" active_tab="1" collapsible="yes"][vc_accordion_tab title="Watch the trailer" icon="hb-moon-plus-circle"][vc_column_text]<video width="840" height="472" id="1" class="sublime" title="Manhattan, Kansas Trailer" data-uid="1" data-autoresize="fit" preload="none"><source src="http://player.vimeo.com/external/106190133.hd.mp4?s=7221b96577c63556fc731777ef9a78a7" data-quality="hd" /><source src="http://player.vimeo.com/external/106190133.sd.mp4?s=ddf5933e316868637a674442c013a766" /></video>[/vc_column_text][/vc_accordion_tab][/vc_accordion][/vc_column][/vc_row]";}}', 'no'),
(624, 'widget_sticky-posts', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
(626, 'mkrdip_cat_post_thumb_sizes', 'a:1:{s:16:"category-posts-2";a:2:{i:0;s:0:"";i:1;s:0:"";}}', 'yes'),
(627, 'widget_category-posts', 'a:2:{i:2;a:9:{s:5:"title";s:11:"Recent News";s:3:"cat";s:2:"11";s:3:"num";s:2:"10";s:7:"sort_by";s:4:"date";s:7:"excerpt";s:2:"on";s:14:"excerpt_length";s:2:"20";s:4:"date";s:2:"on";s:7:"thumb_w";s:0:"";s:7:"thumb_h";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(633, 'widget_rpwe_widget', 'a:2:{s:12:"_multiwidget";i:1;i:1;a:0:{}}', 'yes'),
(724, 'woocommerce_frontend_css_colors', 'a:5:{s:7:"primary";s:7:"#ad74a2";s:9:"secondary";s:7:"#f7f6f7";s:9:"highlight";s:7:"#dd3333";s:10:"content_bg";s:7:"#ffffff";s:7:"subtext";s:7:"#777777";}', 'yes'),
(870, 'jetpack_activated', '1', 'yes'),
(871, 'jetpack_options', 'a:10:{s:7:"version";s:16:"3.1.1:1407853924";s:11:"old_version";s:16:"3.1.1:1407853924";s:2:"id";i:74959920;s:6:"public";i:1;s:14:"last_heartbeat";i:1411136840;s:28:"fallback_no_verify_ssl_certs";i:0;s:9:"time_diff";i:0;s:10:"blog_token";s:65:"h0EKaJ73uoYsyGFPTIgBtNm*doeqKYxq.xreEfMv^VrZIZZoQKRWBh8&Br%hXTw2W";s:11:"user_tokens";a:1:{i:1;s:67:")0&5V&lD0Y)uSVo67OlDWzbA@)fPzPw).l8o0r1w!4NzdVT^hW5nGJOK$93igbimp.1";}s:11:"master_user";i:1;}', 'yes'),
(875, 'jetpack_log', 'a:4:{i:0;a:4:{s:4:"time";i:1407853938;s:7:"user_id";i:1;s:7:"blog_id";b:0;s:4:"code";s:8:"register";}i:1;a:4:{s:4:"time";i:1407854410;s:7:"user_id";i:1;s:7:"blog_id";i:72811523;s:4:"code";s:9:"authorize";}i:2;a:4:{s:4:"time";i:1410963780;s:7:"user_id";i:1;s:7:"blog_id";i:72811523;s:4:"code";s:8:"register";}i:3;a:4:{s:4:"time";i:1410963830;s:7:"user_id";i:1;s:7:"blog_id";i:74959920;s:4:"code";s:9:"authorize";}}', 'no'),
(882, 'stats_options', 'a:7:{s:9:"admin_bar";b:1;s:5:"roles";a:1:{i:0;s:13:"administrator";}s:11:"count_roles";a:6:{i:0;s:6:"editor";i:1;s:6:"author";i:2;s:11:"contributor";i:3;s:10:"subscriber";i:4;s:8:"customer";i:5;s:12:"shop_manager";}s:7:"blog_id";i:72811523;s:12:"do_not_track";b:1;s:10:"hide_smile";b:1;s:7:"version";s:1:"9";}', 'yes'),
(883, 'sharing-options', 'a:1:{s:6:"global";a:5:{s:12:"button_style";s:4:"icon";s:13:"sharing_label";b:0;s:10:"open_links";s:3:"new";s:4:"show";a:0:{}s:6:"custom";a:0:{}}}', 'yes'),
(884, 'safecss_rev', '395', 'yes'),
(885, 'safecss_revision_migrated', '1407854552', 'yes'),
(971, 'M_Installed', '20', 'yes'),
(973, 'M_Newsstream_Installed', '1', 'yes'),
(975, 'stats_cache', 'a:2:{s:32:"69b6b192bd4426586bc1217774d06eaf";a:1:{i:1411137455;a:8:{i:0;a:4:{s:7:"post_id";s:2:"35";s:10:"post_title";s:24:"Wiseguys &amp; Whackjobs";s:14:"post_permalink";s:46:"http://development.genco.tv/wiseguys-wackjobs/";s:5:"views";s:2:"37";}i:1;a:4:{s:7:"post_id";s:3:"758";s:10:"post_title";s:4:"Home";s:14:"post_permalink";s:20:"http://dev.genco.tv/";s:5:"views";s:2:"18";}i:2;a:4:{s:7:"post_id";s:1:"0";s:10:"post_title";s:9:"Home page";s:14:"post_permalink";s:20:"http://dev.genco.tv/";s:5:"views";s:1:"8";}i:3;a:4:{s:7:"post_id";s:2:"33";s:10:"post_title";s:17:"Manhattan, Kansas";s:14:"post_permalink";s:45:"http://development.genco.tv/manhattan-kansas/";s:5:"views";s:1:"6";}i:4;a:4:{s:7:"post_id";s:3:"455";s:10:"post_title";s:23:"Genco Olive Oil T-Shirt";s:14:"post_permalink";s:59:"http://development.genco.tv/product/street-justice-hoody-5/";s:5:"views";s:1:"6";}i:5;a:4:{s:7:"post_id";s:2:"39";s:10:"post_title";s:15:"Joe Perry\'s Raw";s:14:"post_permalink";s:43:"http://development.genco.tv/joe-perrys-raw/";s:5:"views";s:1:"4";}i:6;a:4:{s:7:"post_id";s:4:"1379";s:10:"post_title";s:31:"Wiseguys and Whackjobs T-Shirts";s:14:"post_permalink";s:56:"http://dev.genco.tv/product/wiseguys-whackjobs-t-shirts/";s:5:"views";s:1:"2";}i:7;a:4:{s:7:"post_id";s:3:"493";s:10:"post_title";s:28:"Genco Extra Virgin Olive Oil";s:14:"post_permalink";s:57:"http://dev.genco.tv/product/genco-extra-virgin-olive-oil/";s:5:"views";s:1:"2";}}}s:32:"45993d2137eaadfeb1702b30aca275aa";a:1:{i:1411137455;a:5:{i:0;a:2:{s:10:"searchterm";s:7:"gencotv";s:5:"views";s:1:"2";}i:1;a:2:{s:10:"searchterm";s:33:"genco tv manhattan kansas trailor";s:5:"views";s:1:"1";}i:2;a:2:{s:10:"searchterm";s:21:"wiseguys and wackjobs";s:5:"views";s:1:"1";}i:3;a:2:{s:10:"searchterm";s:8:"genco.tv";s:5:"views";s:1:"1";}i:4;a:2:{s:10:"searchterm";s:16:"www.genco.tv.com";s:5:"views";s:1:"1";}}}}', 'yes'),
(1039, 'membership_options', 'a:11:{s:13:"strangerlevel";i:2;s:14:"nocontent_page";s:2:"99";s:12:"account_page";s:3:"498";s:17:"registration_page";s:3:"497";s:26:"registrationcompleted_page";s:3:"497";s:18:"subscriptions_page";s:0:"";s:8:"formtype";s:3:"new";s:16:"registration_tos";s:0:"";s:25:"membershipadminshortcodes";a:1:{i:0;s:12:"contact-form";}s:24:"membershipdownloadgroups";a:1:{i:0;s:7:"default";}s:10:"masked_url";s:9:"downloads";}', 'yes'),
(1040, 'membership_activated_gateways', 'a:3:{i:0;s:0:"";i:1;s:13:"paypalexpress";i:2;s:17:"freesubscriptions";}', 'yes'),
(1041, 'membership_active', 'yes', 'yes'),
(1051, 'membership_wizard_visible', 'no', 'yes'),
(1126, 'ct_custom_post_types', 'a:1:{s:8:"epsiodes";a:14:{s:6:"labels";a:2:{s:4:"name";s:8:"Episodes";s:7:"add_new";s:7:"Episode";}s:8:"supports";a:8:{s:5:"title";s:5:"title";s:6:"editor";s:6:"editor";s:9:"thumbnail";s:9:"thumbnail";s:7:"excerpt";s:7:"excerpt";s:13:"custom_fields";s:13:"custom-fields";s:9:"revisions";s:9:"revisions";s:15:"page_attributes";s:15:"page-attributes";s:12:"post_formats";s:12:"post-formats";}s:16:"supports_reg_tax";a:2:{s:8:"category";s:1:"1";s:8:"post_tag";s:1:"1";}s:15:"capability_type";s:4:"post";s:12:"map_meta_cap";b:1;s:11:"description";s:0:"";s:13:"menu_position";i:50;s:6:"public";b:1;s:12:"hierarchical";b:0;s:11:"has_archive";b:0;s:7:"rewrite";a:3:{s:10:"with_front";b:1;s:5:"feeds";b:0;s:5:"pages";b:1;}s:9:"query_var";b:1;s:10:"can_export";b:1;s:10:"cf_columns";N;}}', 'yes'),
(1127, 'ct_frr_id', '53eb9b6271db7', 'yes'),
(1255, '_popupally_setting_general', 'a:2:{i:1;a:10:{s:5:"timed";s:5:"false";s:17:"timed-popup-delay";i:0;s:24:"enable-exit-intent-popup";s:5:"false";s:15:"enable-embedded";s:5:"false";s:17:"embedded-location";s:4:"none";s:8:"show-all";s:4:"true";s:7:"include";a:1:{i:333;s:4:"true";}s:7:"exclude";a:0:{}s:15:"cookie-duration";i:-1;s:9:"thank-you";a:0:{}}i:2;a:10:{s:5:"timed";s:5:"false";s:17:"timed-popup-delay";i:-1;s:24:"enable-exit-intent-popup";s:5:"false";s:15:"enable-embedded";s:5:"false";s:17:"embedded-location";s:4:"none";s:8:"show-all";s:5:"false";s:7:"include";a:0:{}s:7:"exclude";a:0:{}s:15:"cookie-duration";i:14;s:9:"thank-you";a:0:{}}}', 'yes'),
(1258, '_popupally_setting_style', 'a:2:{i:1;a:45:{s:4:"name";s:7:"Popup 1";s:11:"signup-form";s:0:"";s:19:"sign-up-form-action";s:0:"";s:23:"sign-up-form-name-field";s:0:"";s:24:"sign-up-form-email-field";s:0:"";s:17:"selected-template";s:6:"bxsjbi";s:14:"popup-selector";s:17:"#popup-box-sxzw-1";s:11:"popup-class";s:23:"popupally-opened-sxzw-1";s:11:"cookie-name";s:18:"popupally-cookie-1";s:13:"close-trigger";s:28:".popup-click-close-trigger-1";s:8:"headline";s:69:"Enter your name and email and get the weekly newsletter... it\'s FREE!";s:10:"sales-text";s:35:"Introduce yourself and your program";s:21:"subscribe-button-text";s:9:"Subscribe";s:16:"name-placeholder";s:26:"Enter your first name here";s:17:"email-placeholder";s:24:"Enter a valid email here";s:12:"privacy-text";s:63:"Your information will *never* be shared or sold to a 3rd party.";s:16:"background-color";s:7:"#fefefe";s:10:"text-color";s:7:"#444444";s:22:"subscribe-button-color";s:7:"#00c98d";s:27:"subscribe-button-text-color";s:7:"#ffffff";s:16:"display-headline";s:5:"block";s:16:"display-logo-row";s:5:"block";s:16:"display-logo-img";s:5:"block";s:15:"display-privacy";s:5:"block";s:9:"image-url";s:32:"/wp-admin/images/w-logo-blue.png";s:28:"plsbvs-background-img-action";s:0:"";s:23:"plsbvs-background-color";s:7:"#d3d3d3";s:16:"plsbvs-image-url";s:0:"";s:12:"plsbvs-width";s:3:"940";s:13:"plsbvs-height";s:2:"60";s:17:"plsbvs-text-color";s:7:"#111111";s:15:"plsbvs-headline";s:24:"Get free weekly updates:";s:19:"plsbvs-headline-top";s:2:"15";s:20:"plsbvs-headline-left";s:2:"60";s:23:"plsbvs-name-placeholder";s:4:"Name";s:21:"plsbvs-name-field-top";s:2:"15";s:22:"plsbvs-name-field-left";s:2:"90";s:24:"plsbvs-email-placeholder";s:5:"Email";s:22:"plsbvs-email-field-top";s:2:"15";s:23:"plsbvs-email-field-left";s:2:"90";s:28:"plsbvs-subscribe-button-text";s:8:"Sign up!";s:29:"plsbvs-subscribe-button-color";s:7:"#00c98d";s:34:"plsbvs-subscribe-button-text-color";s:7:"#ffffff";s:27:"plsbvs-subscribe-button-top";s:2:"15";s:28:"plsbvs-subscribe-button-left";s:2:"90";}i:2;a:45:{s:4:"name";s:7:"Popup 2";s:11:"signup-form";s:0:"";s:19:"sign-up-form-action";s:0:"";s:23:"sign-up-form-name-field";s:0:"";s:24:"sign-up-form-email-field";s:0:"";s:17:"selected-template";s:6:"bxsjbi";s:14:"popup-selector";s:17:"#popup-box-sxzw-2";s:11:"popup-class";s:23:"popupally-opened-sxzw-2";s:11:"cookie-name";s:18:"popupally-cookie-2";s:13:"close-trigger";s:28:".popup-click-close-trigger-2";s:8:"headline";s:69:"Enter your name and email and get the weekly newsletter... it\'s FREE!";s:10:"sales-text";s:35:"Introduce yourself and your program";s:21:"subscribe-button-text";s:9:"Subscribe";s:16:"name-placeholder";s:26:"Enter your first name here";s:17:"email-placeholder";s:24:"Enter a valid email here";s:12:"privacy-text";s:63:"Your information will *never* be shared or sold to a 3rd party.";s:16:"background-color";s:7:"#fefefe";s:10:"text-color";s:7:"#444444";s:22:"subscribe-button-color";s:7:"#00c98d";s:27:"subscribe-button-text-color";s:7:"#ffffff";s:16:"display-headline";s:5:"block";s:16:"display-logo-row";s:5:"block";s:16:"display-logo-img";s:5:"block";s:15:"display-privacy";s:5:"block";s:9:"image-url";s:32:"/wp-admin/images/w-logo-blue.png";s:28:"plsbvs-background-img-action";s:0:"";s:23:"plsbvs-background-color";s:7:"#d3d3d3";s:16:"plsbvs-image-url";s:0:"";s:12:"plsbvs-width";s:3:"940";s:13:"plsbvs-height";s:2:"60";s:17:"plsbvs-text-color";s:7:"#111111";s:15:"plsbvs-headline";s:24:"Get free weekly updates:";s:19:"plsbvs-headline-top";s:2:"15";s:20:"plsbvs-headline-left";s:2:"60";s:23:"plsbvs-name-placeholder";s:4:"Name";s:21:"plsbvs-name-field-top";s:2:"15";s:22:"plsbvs-name-field-left";s:2:"90";s:24:"plsbvs-email-placeholder";s:5:"Email";s:22:"plsbvs-email-field-top";s:2:"15";s:23:"plsbvs-email-field-left";s:2:"90";s:28:"plsbvs-subscribe-button-text";s:8:"Sign up!";s:29:"plsbvs-subscribe-button-color";s:7:"#00c98d";s:34:"plsbvs-subscribe-button-text-color";s:7:"#ffffff";s:27:"plsbvs-subscribe-button-top";s:2:"15";s:28:"plsbvs-subscribe-button-left";s:2:"90";}}', 'yes'),
(1261, '_popupally_setting_advanced', 'a:3:{s:9:"no-inline";s:5:"false";s:8:"max-page";s:3:"500";s:8:"max-post";s:3:"500";}', 'yes'),
(1264, '_popupally_setting_num_style_saved', '0', 'yes'),
(1416, 'otw_plugin_options', 'a:1:{s:19:"activate_appearence";b:1;}', 'yes'),
(1417, 'otw_widget_settings', 'a:0:{}', 'yes'),
(1424, 'showbiz-update-check-short', '1409662446', 'yes'),
(1425, 'showbiz-valid-notice', 'false', 'yes'),
(1427, 'showbiz-valid', 'true', 'yes'),
(1428, 'showbiz-api-key', 'epmqcv2cel9w3u254y68amv3kbpd0lx8', 'yes'),
(1429, 'showbiz-username', 'czucker0', 'yes') ;
