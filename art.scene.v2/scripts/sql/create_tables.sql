-- phpMyAdmin SQL Dump
-- version 2.6.0-alpha2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 24, 2004 at 01:22 AM
-- Server version: 4.0.21
-- PHP Version: 4.3.8-12
-- 
-- Database : `artscene`
-- 
-- $Id: create_tables.sql,v 1.3 2004/09/28 20:53:36 pukomuko Exp $

-- --------------------------------------------------------

-- 
-- Table structure for table `avblock`
-- 

DROP TABLE IF EXISTS `avblock`;
CREATE TABLE IF NOT EXISTS `avblock` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `html` text NOT NULL,
  `template` varchar(140) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avcomments`
-- 

DROP TABLE IF EXISTS `avcomments`;
CREATE TABLE IF NOT EXISTS `avcomments` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subject` varchar(200) NOT NULL default '',
  `info` text NOT NULL,
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `parent_id` int(11) NOT NULL default '0',
  `table_name` varchar(40) NOT NULL default '',
  `user_id` int(11) NOT NULL default '0',
  `new` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `table_name` (`table_name`),
  KEY `avcomment_double` (`table_name`,`parent_id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avfaq`
-- 

DROP TABLE IF EXISTS `avfaq`;
CREATE TABLE IF NOT EXISTS `avfaq` (
  `id` int(11) NOT NULL auto_increment,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `lang_id` tinyint(4) NOT NULL default '0',
  `posted` date NOT NULL default '0000-00-00',
  `visible` tinyint(4) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `email` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avnews`
-- 

DROP TABLE IF EXISTS `avnews`;
CREATE TABLE IF NOT EXISTS `avnews` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default '',
  `info` text NOT NULL,
  `full_text` text NOT NULL,
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `keywords` varchar(255) NOT NULL default '',
  `visible` tinyint(4) unsigned NOT NULL default '0',
  `category_id` int(11) unsigned NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `submiter` int(11) unsigned NOT NULL default '0',
  `authorizer` int(11) unsigned NOT NULL default '0',
  `auth_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `submiter` (`submiter`),
  KEY `category_id` (`category_id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avnewscategory`
-- 

DROP TABLE IF EXISTS `avnewscategory`;
CREATE TABLE IF NOT EXISTS `avnewscategory` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `info` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `sort_number` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avworkcategory`
-- 

DROP TABLE IF EXISTS `avworkcategory`;
CREATE TABLE IF NOT EXISTS `avworkcategory` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `info` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `sort_number` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avworks`
-- 

DROP TABLE IF EXISTS `avworks`;
CREATE TABLE IF NOT EXISTS `avworks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default '',
  `info` text NOT NULL,
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `thumbnail` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `submiter` int(11) unsigned NOT NULL default '0',
  `category_id` int(11) unsigned NOT NULL default '0',
  `views` int(11) unsigned NOT NULL default '0',
  `score` int(11) NOT NULL default '0',
  `color` varchar(20) NOT NULL default '',
  `file_size` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `submiter` (`submiter`),
  KEY `category_id` (`category_id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `avworkvotes`
-- 

DROP TABLE IF EXISTS `avworkvotes`;
CREATE TABLE IF NOT EXISTS `avworkvotes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `mark` tinyint(4) NOT NULL default '0',
  `user_id` int(11) unsigned NOT NULL default '0',
  `work_id` int(11) unsigned NOT NULL default '0',
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `work_id` (`work_id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `forum_list`
-- 

DROP TABLE IF EXISTS `forum_list`;
CREATE TABLE IF NOT EXISTS `forum_list` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `sort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `forum_post_list`
-- 

DROP TABLE IF EXISTS `forum_post_list`;
CREATE TABLE IF NOT EXISTS `forum_post_list` (
  `id` int(11) NOT NULL auto_increment,
  `thread_id` int(11) NOT NULL default '0',
  `author_id` int(11) NOT NULL default '0',
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `good_bad` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `thread_id` (`thread_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `forum_thread_list`
-- 

DROP TABLE IF EXISTS `forum_thread_list`;
CREATE TABLE IF NOT EXISTS `forum_thread_list` (
  `id` int(11) NOT NULL auto_increment,
  `forum_id` int(11) NOT NULL default '0',
  `author_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hit_cnt` int(11) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `sticky` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `created_on` (`created_on`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `hirez`
-- 

DROP TABLE IF EXISTS `hirez`;
CREATE TABLE IF NOT EXISTS `hirez` (
  `filename` varchar(60) NOT NULL default '',
  `thumbnail` varchar(60) NOT NULL default '',
  `name` varchar(60) NOT NULL default '',
  `author` varchar(60) NOT NULL default '',
  `email` varchar(60) default NULL,
  `size` int(10) unsigned NOT NULL default '0',
  `descr` text,
  `laikas` date default NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`filename`),
  KEY `id` (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `hirez_talk`
-- 

DROP TABLE IF EXISTS `hirez_talk`;
CREATE TABLE IF NOT EXISTS `hirez_talk` (
  `author` varchar(60) NOT NULL default '',
  `email` varchar(60) default NULL,
  `hid` int(10) unsigned NOT NULL default '0',
  `message` text,
  `laikas` date default NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `hid` (`hid`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `languages`
-- 

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(4) NOT NULL default '',
  `lang_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=ISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `menuitem`
-- 

DROP TABLE IF EXISTS `menuitem`;
CREATE TABLE IF NOT EXISTS `menuitem` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `iname` varchar(200) NOT NULL default '',
  `page` varchar(200) NOT NULL default '',
  `file` varchar(200) NOT NULL default '',
  `type` tinyint(4) NOT NULL default '0',
  `link` varchar(255) NOT NULL default '',
  `html` text NOT NULL,
  `block_id` varchar(200) NOT NULL default '0',
  `include` varchar(255) NOT NULL default '',
  `column_id` varchar(255) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  `pid` int(11) unsigned NOT NULL default '0',
  `sort_number` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `polls`
-- 

DROP TABLE IF EXISTS `polls`;
CREATE TABLE IF NOT EXISTS `polls` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `posted` date NOT NULL default '0000-00-00',
  `lang_id` tinyint(4) NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  `lastip` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=ISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `polls_answers`
-- 

DROP TABLE IF EXISTS `polls_answers`;
CREATE TABLE IF NOT EXISTS `polls_answers` (
  `id` int(11) NOT NULL auto_increment,
  `quid` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=ISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `polls_questions`
-- 

DROP TABLE IF EXISTS `polls_questions`;
CREATE TABLE IF NOT EXISTS `polls_questions` (
  `id` int(11) NOT NULL auto_increment,
  `poll_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=ISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `polls_votes`
-- 

DROP TABLE IF EXISTS `polls_votes`;
CREATE TABLE IF NOT EXISTS `polls_votes` (
  `id` int(11) NOT NULL auto_increment,
  `uin` varchar(32) NOT NULL default '',
  `answer` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=ISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_group`
-- 

DROP TABLE IF EXISTS `u_group`;
CREATE TABLE IF NOT EXISTS `u_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `info` varchar(200) NOT NULL default '',
  `menu` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_module`
-- 

DROP TABLE IF EXISTS `u_module`;
CREATE TABLE IF NOT EXISTS `u_module` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `info` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_permission`
-- 

DROP TABLE IF EXISTS `u_permission`;
CREATE TABLE IF NOT EXISTS `u_permission` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `info` varchar(200) NOT NULL default '',
  `module_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_permission_link`
-- 

DROP TABLE IF EXISTS `u_permission_link`;
CREATE TABLE IF NOT EXISTS `u_permission_link` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL default '0',
  `permission_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_query_cache`
-- 

DROP TABLE IF EXISTS `u_query_cache`;
CREATE TABLE IF NOT EXISTS `u_query_cache` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `query` text NOT NULL,
  `result` longtext NOT NULL,
  `tablenames` varchar(255) NOT NULL default '',
  `expires` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_session`
-- 

DROP TABLE IF EXISTS `u_session`;
CREATE TABLE IF NOT EXISTS `u_session` (
  `id` varchar(20) NOT NULL default '',
  `LastAction` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `userID` mediumint(9) default NULL,
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_session_vars`
-- 

DROP TABLE IF EXISTS `u_session_vars`;
CREATE TABLE IF NOT EXISTS `u_session_vars` (
  `name` varchar(30) NOT NULL default '',
  `session` varchar(20) NOT NULL default '',
  `value` varchar(100) default NULL,
  `id` int(11) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `sessionID` (`session`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_usage`
-- 

DROP TABLE IF EXISTS `u_usage`;
CREATE TABLE IF NOT EXISTS `u_usage` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `timehit` timestamp(14) NOT NULL,
  `ip` char(30) NOT NULL default '',
  `user` char(40) NOT NULL default '',
  `agent` char(100) NOT NULL default '',
  `page` char(255) NOT NULL default '',
  `referrer` char(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=ISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_user_info`
-- 

DROP TABLE IF EXISTS `u_user_info`;
CREATE TABLE IF NOT EXISTS `u_user_info` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL default '0',
  `firstname` varchar(200) NOT NULL default '',
  `lastname` varchar(200) NOT NULL default '',
  `url` varchar(200) NOT NULL default '',
  `icq` varchar(200) NOT NULL default '',
  `mail_news` tinyint(4) NOT NULL default '0',
  `mail_comments` tinyint(4) NOT NULL default '0',
  `code` varchar(33) NOT NULL default '',
  `reg_date` datetime default NULL,
  `mail_works` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_user_log`
-- 

DROP TABLE IF EXISTS `u_user_log`;
CREATE TABLE IF NOT EXISTS `u_user_log` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `logindate` timestamp(14) NOT NULL,
  `host` varchar(255) NOT NULL default '',
  `browser` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM PACK_KEYS=1;

-- --------------------------------------------------------

-- 
-- Table structure for table `u_users`
-- 

DROP TABLE IF EXISTS `u_users`;
CREATE TABLE IF NOT EXISTS `u_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL default '',
  `password` varchar(33) NOT NULL default '',
  `group_id` int(5) NOT NULL default '0',
  `email` varchar(50) NOT NULL default '',
  `lastlogin` timestamp(14) NOT NULL,
  `lasthost` varchar(200) NOT NULL default '',
  `active` tinyint(4) NOT NULL default '0',
  `forgotten_pass` varchar(40) NOT NULL default '',
  `auto_login` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1;


CREATE TABLE avworks_stat(
id int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
subject varchar( 255 ) NOT NULL default '',
info text NOT NULL ,
posted datetime NOT NULL default '0000-00-00 00:00:00',
thumbnail varchar( 255 ) NOT NULL default '',
FILE varchar( 255 ) NOT NULL default '',
submiter int( 11 ) unsigned NOT NULL default '0',
category_id int( 11 ) unsigned NOT NULL default '0',
views int( 11 ) unsigned NOT NULL default '0',
color varchar( 20 ) NOT NULL default '',
file_size int( 11 ) NOT NULL default '0',
work_id int( 11 ) unsigned NOT NULL ,
submiter_name varchar( 255 ) NOT NULL default '',
category_name varchar( 255 ) NOT NULL default '',
vote_count int( 11 ) NOT NULL ,
vote_sum int( 11 ) NOT NULL ,
vote_avg float NOT NULL ,
comment_count int NOT NULL ,
PRIMARY KEY ( id ) ,
KEY submiter( submiter ) ,
KEY category_id( category_id )
) TYPE = MYISAM PACK_KEYS =1;