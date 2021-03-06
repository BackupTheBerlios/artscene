-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2011 at 03:32 PM
-- Server version: 4.0.27
-- PHP Version: 5.2.6-3



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `artscene`
--

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
);

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
  KEY `user_id` (`user_id`),
  KEY `posted` (`posted`),
  KEY `avcomment_double` (`table_name`(3),`parent_id`)
);

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
);

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
  KEY `category_id` (`category_id`),
  KEY `visible` (`visible`),
  KEY `tripple` (`visible`,`posted`,`id`)
);

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
);

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
);

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
  `c_count` int(11) NOT NULL default '0',
  `c_last_post` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `submiter` (`submiter`),
  KEY `category_id` (`category_id`),
  KEY `posted` (`posted`),
  KEY `c_last_post` (`c_last_post`)
);

-- --------------------------------------------------------

--
-- Table structure for table `avworks_delete_log`
--

DROP TABLE IF EXISTS `avworks_delete_log`;
CREATE TABLE IF NOT EXISTS `avworks_delete_log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `admin_id` int(11) unsigned NOT NULL default '0',
  `posted` timestamp NOT NULL,
  `work_submiter` int(11) NOT NULL default '0',
  `work_subject` varchar(255) NOT NULL default '',
  `work_posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `work_votecount` int(11) NOT NULL default '0',
  `work_summark` float NOT NULL default '0',
  `work_avgmark` float NOT NULL default '0',
  `work_category` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `avworks_stat`
--

DROP TABLE IF EXISTS `avworks_stat`;
CREATE TABLE IF NOT EXISTS `avworks_stat` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default '',
  `info` text NOT NULL,
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `thumbnail` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `submiter` int(11) unsigned NOT NULL default '0',
  `category_id` int(11) unsigned NOT NULL default '0',
  `views` int(11) unsigned NOT NULL default '0',
  `color` varchar(20) NOT NULL default '',
  `file_size` int(11) NOT NULL default '0',
  `work_id` int(11) unsigned NOT NULL default '0',
  `submiter_name` varchar(255) NOT NULL default '',
  `category_name` varchar(255) NOT NULL default '',
  `vote_count` int(11) NOT NULL default '0',
  `vote_sum` int(11) NOT NULL default '0',
  `vote_avg` float NOT NULL default '0',
  `comment_count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `work_id` (`work_id`),
  KEY `submiter` (`submiter`),
  KEY `category_id` (`category_id`),
  KEY `vote_sum` (`vote_sum`),
  KEY `vote_avg` (`vote_avg`)
);

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
  KEY `work_id` (`work_id`),
  KEY `user_id` (`user_id`),
  KEY `posted` (`posted`)
);

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
);

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
);

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
  `vip` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `created_on` (`created_on`)
);

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
);

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
  KEY `hid` (`hid`),
  KEY `hid_id` (`hid`,`id`)
);

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
);

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
);

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
);

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
);

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
);

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
);

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
);

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
);

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
  `lastlogin` timestamp NOT NULL,
  `lasthost` varchar(200) NOT NULL default '',
  `active` tinyint(4) NOT NULL default '0',
  `forgotten_pass` varchar(40) NOT NULL default '',
  `auto_login` varchar(40) NOT NULL default '',
  `may_send_work_after` datetime NOT NULL default '0000-00-00 00:00:00',
  `may_comment_after` datetime NOT NULL default '0000-00-00 00:00:00',
  `del_works_admin` int(11) NOT NULL default '0',
  `del_works_system` int(11) NOT NULL default '0',
  `c_count` int(11) NOT NULL default '0',
  `c_last_post` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `c_last_post` (`c_last_post`)
);

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
);

-- --------------------------------------------------------

--
-- Table structure for table `u_user_log`
--

DROP TABLE IF EXISTS `u_user_log`;
CREATE TABLE IF NOT EXISTS `u_user_log` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `logindate` timestamp NOT NULL,
  `host` varchar(255) NOT NULL default '',
  `browser` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);
