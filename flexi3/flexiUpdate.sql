# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Mar 25, 2003 at 12:44 AM
# Server version: 3.23.55
# PHP Version: 4.2.3
# Database : `flexiUpdate`
# --------------------------------------------------------

#
# Table structure for table `fu_group_module_link`
#

DROP TABLE IF EXISTS fu_group_module_link;
CREATE TABLE fu_group_module_link (
  id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  module_id int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `fu_group_module_link`
#

INSERT INTO fu_group_module_link (id, group_id, module_id) VALUES (0, 1, 1);
# --------------------------------------------------------

#
# Table structure for table `fu_groups`
#

DROP TABLE IF EXISTS fu_groups;
CREATE TABLE fu_groups (
  id int(11) NOT NULL auto_increment,
  iname varchar(50) NOT NULL default '',
  name varchar(200) NOT NULL default '',
  description text NOT NULL,
  default_module varchar(100) NOT NULL default '',
  PRIMARY KEY  (id),
  UNIQUE KEY iname (iname)
) TYPE=MyISAM;

#
# Dumping data for table `fu_groups`
#

INSERT INTO fu_groups (id, iname, name, description, default_module) VALUES (1, 'admin', 'Administratoriai', '', 'control');
# --------------------------------------------------------

#
# Table structure for table `fu_modules`
#

DROP TABLE IF EXISTS fu_modules;
CREATE TABLE fu_modules (
  id int(11) NOT NULL auto_increment,
  iname varchar(50) NOT NULL default '',
  name varchar(200) NOT NULL default '',
  description text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY iname (iname)
) TYPE=MyISAM;

#
# Dumping data for table `fu_modules`
#

INSERT INTO fu_modules (id, iname, name, description) VALUES (1, 'control', 'Administravimas', '');
# --------------------------------------------------------

#
# Table structure for table `fu_pages`
#

DROP TABLE IF EXISTS fu_pages;
CREATE TABLE fu_pages (
  id int(11) unsigned NOT NULL auto_increment,
  iname varchar(40) NOT NULL default '',
  name varchar(150) NOT NULL default '',
  template int(10) NOT NULL default '0',
  type tinyint(4) NOT NULL default '0',
  link varchar(255) NOT NULL default '',
  content text NOT NULL,
  definition text NOT NULL,
  override tinyint(2) NOT NULL default '0',
  override_childs tinyint(2) NOT NULL default '0',
  override_definition text NOT NULL,
  visible tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY iname (iname)
) TYPE=MyISAM;

#
# Dumping data for table `fu_pages`
#

INSERT INTO fu_pages (id, iname, name, template, type, link, content, definition, override, override_childs, override_definition, visible) VALUES (1, 'first', 'Pirmas', 1, 0, '', '', '', 0, 0, '', 0);
# --------------------------------------------------------

#
# Table structure for table `fu_sessions`
#

DROP TABLE IF EXISTS fu_sessions;
CREATE TABLE fu_sessions (
  sid varchar(32) NOT NULL default '',
  expire int(11) unsigned NOT NULL default '0',
  ip varchar(255) NOT NULL default '',
  DATA text NOT NULL,
  user int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `fu_sessions`
#

INSERT INTO fu_sessions (sid, expire, ip, DATA, user) VALUES ('f435dcda9fa52a26aa48661f57901564', 1048510783, '', '', 0);
INSERT INTO fu_sessions (sid, expire, ip, DATA, user) VALUES ('f435dcda9fa52a26aa48661f57901564', 1048510783, '', '', 0);
INSERT INTO fu_sessions (sid, expire, ip, DATA, user) VALUES ('f435dcda9fa52a26aa48661f57901564', 1048510783, '', '', 0);
INSERT INTO fu_sessions (sid, expire, ip, DATA, user) VALUES ('f435dcda9fa52a26aa48661f57901564', 1048510783, '', '', 0);
# --------------------------------------------------------

#
# Table structure for table `fu_templates`
#

DROP TABLE IF EXISTS fu_templates;
CREATE TABLE fu_templates (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(20) NOT NULL default '',
  definition text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

#
# Dumping data for table `fu_templates`
#

INSERT INTO fu_templates (id, name, definition) VALUES (1, 'index', '');
# --------------------------------------------------------

#
# Table structure for table `fu_users`
#

DROP TABLE IF EXISTS fu_users;
CREATE TABLE fu_users (
  id int(11) NOT NULL auto_increment,
  username varchar(40) NOT NULL default '',
  password varchar(40) NOT NULL default '',
  name tinyint(200) NOT NULL default '0',
  email tinyint(200) NOT NULL default '0',
  phone varchar(200) NOT NULL default '',
  lastlogin datetime NOT NULL default '0000-00-00 00:00:00',
  lasthost varchar(200) NOT NULL default '',
  active tinyint(4) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  properties text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY username (username)
) TYPE=MyISAM;

#
# Dumping data for table `fu_users`
#

INSERT INTO fu_users (id, username, password, name, email, phone, lastlogin, lasthost, active, group_id, properties) VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, 0, '636262', '2003-03-23 23:36:46', 'legba', 1, 1, '');
# --------------------------------------------------------

#
# Table structure for table `fu_users_log`
#

DROP TABLE IF EXISTS fu_users_log;
CREATE TABLE fu_users_log (
  id int(11) NOT NULL auto_increment,
  timehit datetime NOT NULL default '0000-00-00 00:00:00',
  user int(11) NOT NULL default '0',
  module varchar(200) NOT NULL default '',
  ip varchar(20) NOT NULL default '',
  message text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `fu_users_log`
#

INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (1, '2002-11-12 18:15:29', 0, '', '172.16.2.118', 'user logged in from $host');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (2, '2002-11-12 18:15:38', 0, '', '172.16.2.118', 'user logged in from $host');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (3, '2002-11-12 18:15:56', 0, '', '172.16.2.118', 'user logged in from $host');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (4, '2002-11-12 18:15:58', 0, '', '172.16.2.118', 'user logged in from $host');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (6, '2002-11-12 18:23:35', 1, '', '172.16.2.118', 'user logged in from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (7, '2002-11-12 18:32:05', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (8, '2002-11-12 18:33:57', 1, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (9, '2002-11-12 18:35:07', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (10, '2002-11-12 18:35:07', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (11, '2002-11-12 18:36:07', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (12, '2002-11-12 18:36:11', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (13, '2002-11-12 18:36:49', 1, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (14, '2002-11-12 18:36:51', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (15, '2002-11-12 18:36:52', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (16, '2002-11-12 18:36:52', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (17, '2002-11-12 18:36:52', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (18, '2002-11-12 18:36:55', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (19, '2002-11-13 13:27:04', 0, 'control', '172.16.2.118', 'logout');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (20, '2002-11-13 13:27:10', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (21, '2002-11-13 21:31:31', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (22, '2002-11-14 11:25:42', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (23, '2002-11-14 13:00:55', 1, 'control', '172.16.2.118', 'login from salnaj');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (24, '2002-11-16 23:10:43', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (25, '2003-03-15 18:57:28', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (26, '2003-03-17 13:59:58', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (27, '2003-03-17 21:25:23', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (28, '2003-03-17 21:54:53', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (29, '2003-03-20 03:20:02', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (30, '2003-03-20 03:33:00', 1, 'control', '192.168.0.20', 'login from legba');
INSERT INTO fu_users_log (id, timehit, user, module, ip, message) VALUES (31, '2003-03-23 23:36:46', 1, 'control', '192.168.0.20', 'login from legba');

