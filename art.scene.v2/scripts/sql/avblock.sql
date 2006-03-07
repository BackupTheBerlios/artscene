-- phpMyAdmin SQL Dump
-- version 2.6.0-alpha2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 07, 2006 at 04:57 PM
-- Server version: 4.0.24
-- PHP Version: 4.3.10-16
-- 
-- Database : `artscene`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `avblock`
-- 

CREATE TABLE `avblock` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `html` text NOT NULL,
  `template` varchar(140) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `avblock`
-- 

INSERT INTO `avblock` VALUES (4, 'work.submit.info', 'darb� talpinimo taisykl�s', '\r\nnet jei m�s� oficiali politika - vis� darb� i�saugojimas, art.scene pasilieka teis� trinti <u>�lam�t�</u> bei suspendinti vartotojus, kurie siun�ia niekalus, nes norime palaikyti nors ir minimal�, bet �iok� tok� darb� lyg� �ioje svetain�je. darbai ne savo kategorijoje irgi nebus toleruojami.\r\n\r\n<br><br>\r\ndarbai priimami tik �i� format�: JPG, GIF, PNG, SWF. jokie kiti formatai netinka. sistema negeneruoja ma�o paveiksliuko SWF failams, tad �iam formatui reikia kartu atsi�sti ir ma�� paveiksliuk� 120x90px, didesnius sistema pati suma�ins. jei kitiems formatams siun�iamas ma�as paveiksliukas, jis bus naudojamas vietoj sugeneruoto sistemos.<br>\r\n<br>\r\nnepriimami ma�esni nei 10kb darbai, vir�utin� riba - 300kb, i�skyrus ''flash'' kategorij�, kuri neturi vir�utin�s ribos.<br> brandus darbas tur�t� b�ti pakankamos kokyb�s ir detalumo, bet neperdidelio, kad dauguma vartotoj� ilgai nelaukdami gal�t� pasi�i�r�ti.\r\n\r\n<br><br>\r\n�tai gero elgesio taisykl�s sura�ytos <b>untitled</b>, o <b>pukomuko</b> primygtinai pataria laikytis:\r\n<ul>\r\n<li> pie�inius i art.scene gali d�ti tik pie�ini� autorius. daugiau niekas. nei mama, nei t�t�, nei sekretorius ar atstovas spaudai.\r\n�ia ne delfis kur gali inmesti internete rast� bajeriuk� ar paveiksliuk�. \r\n\r\n<li> pie�iniai turi b�ti dedami tik � jiems skirtas kategorijas. aroganti�kieji mianininkai, mai�taujantis prie� tvarka ir\r\n�iuolaikin� visuomen� ir balsuojantys u� chaos� bei �od�io laisv�, pasikelkite auks�iau savo beretes ir ramiai perskaitykite\r\nkategorij� pavadinimus. Taip j�s sukelsite ma�iau r�pes�i� art.scene tvarkytojams.\r\n\r\n<li> Jei pie�inius ne savo kategorijose suras art.scene tvarkytojas, labai tik�tina kad jie bus i�trinti.\r\n\r\n<li> ned�kite �lam�to, kelis kartus pervaryto per filtriukus.\r\n\r\n<li> ned�kite savo k�rinio pakartotinai, jei jis jau buvo i�trintas. garantuotai jis bus i�trintas v�l.\r\nnety�ia gali i�nykti ir j�s� u�registruotas nikas.\r\n\r\n<li> k�rinio vagyst�s atveju (kuomet dedamas svetimas pie�inys ar foto ar kitokio pob�d�io darbas) - nikas i�nykti gali ir ty�ia.\r\n</ul>\r\nlaikui b�gant punkt� gali padaug�ti :]\r\n', 'block.html', 1);
INSERT INTO `avblock` VALUES (2, 'work.deleted.admin', 'automatinis prane�imas', 'j�s� darb� "{work.subject}" i�tryn� administratoriai, nes jis neatitiko art.scene kokyb�s kriterij�. nauj� darb� gal�site �d�ti tik kit� dien�.<br>Persp�jame, kad keli i� eil�s �d�ti nepatenkinamos kokybes darbai gali atimti jums galimyb� publikuoti savo darbus. Prie� �d�dami darb�, dar kart� pagalvokite ar tai tikrai norite j� rodyti.\r\n<br>\r\npla�iau pasiskaitykite\r\n<ahref="http://art.scene.lt/process.php/page.news;menuname.newsitem;news.426">naujienose</a>.<br>\r\n<br>\r\nneatsakin�kite,\r\nprane�imus siun�ia robotas.', 'block.html', 1);
INSERT INTO `avblock` VALUES (3, 'work.deleted.system', 'automatinis prane�imas', 'j�s� darb� "{work.subject}" i�tryn� automatin� kokyb�s sistema. nauj� darb� gal�site �d�ti tik kit� dien�.\r\n<br><br>\r\npla�iau pasiskaitykite <a href="http://art.scene.lt/process.php/page.news;menuname.newsitem;news.270">naujienose</a>.<br>\r\n<br>\r\nneatsakin�kite,\r\nprane�imus siun�ia robotas.', 'block.html', 1);
