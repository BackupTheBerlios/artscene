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

INSERT INTO `avblock` VALUES (4, 'work.submit.info', 'darbø talpinimo taisyklës', '\r\nnet jei mûsø oficiali politika - visø darbø iðsaugojimas, art.scene pasilieka teisæ trinti <u>ðlamðtà</u> bei suspendinti vartotojus, kurie siunèia niekalus, nes norime palaikyti nors ir minimalø, bet ðioká toká darbø lygá ðioje svetainëje. darbai ne savo kategorijoje irgi nebus toleruojami.\r\n\r\n<br><br>\r\ndarbai priimami tik ðiø formatø: JPG, GIF, PNG, SWF. jokie kiti formatai netinka. sistema negeneruoja maþo paveiksliuko SWF failams, tad ðiam formatui reikia kartu atsiøsti ir maþà paveiksliukà 120x90px, didesnius sistema pati sumaþins. jei kitiems formatams siunèiamas maþas paveiksliukas, jis bus naudojamas vietoj sugeneruoto sistemos.<br>\r\n<br>\r\nnepriimami maþesni nei 10kb darbai, virðutinë riba - 300kb, iðskyrus ''flash'' kategorijà, kuri neturi virðutinës ribos.<br> brandus darbas turëtø bûti pakankamos kokybës ir detalumo, bet neperdidelio, kad dauguma vartotojø ilgai nelaukdami galëtø pasiþiûrëti.\r\n\r\n<br><br>\r\nðtai gero elgesio taisyklës suraðytos <b>untitled</b>, o <b>pukomuko</b> primygtinai pataria laikytis:\r\n<ul>\r\n<li> pieðinius i art.scene gali dëti tik pieðiniø autorius. daugiau niekas. nei mama, nei tëtë, nei sekretorius ar atstovas spaudai.\r\nèia ne delfis kur gali inmesti internete rastà bajeriukà ar paveiksliukà. \r\n\r\n<li> pieðiniai turi bûti dedami tik á jiems skirtas kategorijas. arogantiðkieji mianininkai, maiðtaujantis prieð tvarka ir\r\nðiuolaikinæ visuomenæ ir balsuojantys uþ chaosà bei þodþio laisvæ, pasikelkite auksèiau savo beretes ir ramiai perskaitykite\r\nkategorijø pavadinimus. Taip jûs sukelsite maþiau rûpesèiø art.scene tvarkytojams.\r\n\r\n<li> Jei pieðinius ne savo kategorijose suras art.scene tvarkytojas, labai tikëtina kad jie bus iðtrinti.\r\n\r\n<li> nedëkite ðlamðto, kelis kartus pervaryto per filtriukus.\r\n\r\n<li> nedëkite savo kûrinio pakartotinai, jei jis jau buvo iðtrintas. garantuotai jis bus iðtrintas vël.\r\nnetyèia gali iðnykti ir jûsø uþregistruotas nikas.\r\n\r\n<li> kûrinio vagystës atveju (kuomet dedamas svetimas pieðinys ar foto ar kitokio pobûdþio darbas) - nikas iðnykti gali ir tyèia.\r\n</ul>\r\nlaikui bëgant punktø gali padaugëti :]\r\n', 'block.html', 1);
INSERT INTO `avblock` VALUES (2, 'work.deleted.admin', 'automatinis praneðimas', 'jûsø darbà "{work.subject}" iðtrynë administratoriai, nes jis neatitiko art.scene kokybës kriterijø. naujà darbà galësite ádëti tik kità dienà.<br>Perspëjame, kad keli ið eilës ádëti nepatenkinamos kokybes darbai gali atimti jums galimybæ publikuoti savo darbus. Prieð ádëdami darbà, dar kartà pagalvokite ar tai tikrai norite já rodyti.\r\n<br>\r\nplaèiau pasiskaitykite\r\n<ahref="http://art.scene.lt/process.php/page.news;menuname.newsitem;news.426">naujienose</a>.<br>\r\n<br>\r\nneatsakinëkite,\r\npraneðimus siunèia robotas.', 'block.html', 1);
INSERT INTO `avblock` VALUES (3, 'work.deleted.system', 'automatinis praneðimas', 'jûsø darbà "{work.subject}" iðtrynë automatinë kokybës sistema. naujà darbà galësite ádëti tik kità dienà.\r\n<br><br>\r\nplaèiau pasiskaitykite <a href="http://art.scene.lt/process.php/page.news;menuname.newsitem;news.270">naujienose</a>.<br>\r\n<br>\r\nneatsakinëkite,\r\npraneðimus siunèia robotas.', 'block.html', 1);
