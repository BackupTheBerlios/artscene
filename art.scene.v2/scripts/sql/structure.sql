-- phpMyAdmin SQL Dump
-- version 2.6.0-alpha2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 24, 2004 at 01:26 AM
-- Server version: 4.0.21
-- PHP Version: 4.3.8-12
-- 
-- Database : `artscene`
-- 

-- 
-- Dumping data for table `avblock`
-- 

INSERT INTO `avblock` (`id`, `name`, `title`, `html`, `template`, `visible`) VALUES (1, 'test', 'teest', '\r\n<P align=center><FONT face=Verdana \r\nsize=2>dfg<STRONG>dfgdfg</STRONG>dfg</FONT></P>\r\n\r\n\r\n', 'block.html', 0);

-- 
-- Dumping data for table `avnewscategory`
-- 

INSERT INTO `avnewscategory` (`id`, `name`, `info`, `file`, `sort_number`) VALUES (1, 'art.scene', 'svetain�s atnaujinimai, prane�imai apie vietinius �vykius', '', 1),
(2, 'programos', 'programin� �ranga ir kiti elektroniniai nieku�iai', '', 2),
(4, 'renginiai', 'parodos, koncertai, televizijos laidos, viskas, kas vyksta lietuv�l�je ir ne tik', '', 3),
(5, 'nuorodos', '�domesni puslapiai arba liuksusinio dizaino pavyzd�iai', '', 4),
(6, 'pam�stymai', 'kas daros? kur link einame? kod�l yra kaip yra? egocentri�kos blevyzgos', '', 5),
(7, 'patarimai', '', '', 6),
(8, 'iranga', 'naujienos ish hardware pasaulio', '', 1);

-- 
-- Dumping data for table `avworkcategory`
-- 

INSERT INTO `avworkcategory` (`id`, `name`, `info`, `file`, `sort_number`) VALUES (1, 'manipuliacyjos', 'da�niausia menyn� r��is ant �itos scenos, kai tepliojama naudojant fotkes ir ten nu lejeriukai filtriukai ir t.t.', '', 1),
(2, 'pai�alai', 'nu �ia kai be fotografyj� ir be objekt� ten gatav� nuo nulio u�lipdoma viskas', '', 2),
(3, 'tikra media', 'tai �ia teptukas pie�tukas gua�as molis pl�gas medis', '', 3),
(4, '3d', 'cia tai jau nu kai pure 3d arba gabalelis tik prifotoposhopotinta', '', 4),
(5, 'foto', 'fotografynei atlykimai', '', 5),
(6, 'flash', 'i�mislas multimedinis, �ia d�kit menus, o ne amato gudrybes.', '', 6);

-- 
-- Dumping data for table `languages`
-- 

INSERT INTO `languages` (`id`, `name`, `lang_name`) VALUES (1, 'lt', 'Lietuvi�'),
(2, 'en', 'Angl�'),
(3, 'ru', 'Rus�');

-- 
-- Dumping data for table `menuitem`
-- 

INSERT INTO `menuitem` (`id`, `name`, `iname`, `page`, `file`, `type`, `link`, `html`, `block_id`, `include`, `column_id`, `visible`, `pid`, `sort_number`) VALUES (1, 'Informacija', 'info', 'simple', '', 2, '', '<P>cia informaciniai puslapiai</P>\r\n', '0', 'content/about.html', '', 1, 0, 1),
(2, 'Vartotojai', 'usersinfo', 'index', '', 2, '', '\r\n<P>cia su vartotoju registracija susije daiktai:</P>\r\n<P>&nbsp;- register<BR>&nbsp;- online<BR>&nbsp;- list of registered<BR>&nbsp;- \r\nsettings<BR>&nbsp; - lostpassword</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', '', 1, 0, 2),
(3, 'registracija', 'signup', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_signup', 1, 2, 1),
(4, 'apie', 'about', 'simple', '', 4, '', '\r\n<P>&nbsp;</P>\r\n</BODY>\r\n</HTML>\r\n', '0', 'content/about.html', '', 1, 1, 1),
(5, 'dabar nar�o', 'online', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', 'users-login-show_online', 1, 2, 2),
(6, 'pamir�ai slapta�od�?', 'lostpassword', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password', 1, 2, 3),
(7, 'art.scene dalyviai', 'userslist', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'users-login-show_users_list', 1, 2, 4),
(8, 'asmeniniai nustatymai', 'usersettings', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_settings', 1, 2, 5),
(9, 'Naujienos', 'news', 'news', '', 2, '', '<P>visi naujienu puslapio variantai</P>', '0', '', '', 1, 0, 5),
(10, 'dalyvauk', 'submit', 'simple', '', 2, '', '<A href="page.simple;menuname.submitnews"><b>atsi�sk \r\nnaujien�</b></A><br>\r\n\r\n\r\n<a href="page.simple;menuname.submitwork"><b>�d�k darb�</b></a>\r\n\r\n\r\n', '0', '', '', 1, 2, 10),
(15, 'pasikeisk slapta�od�', 'lostpassword_recover', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password_recover', 1, 2, 1),
(11, 'atsi�sk naujien�', 'submitnews', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n\r\n\r\n', '0', '', 'news-news-show_submit', 1, 9, 1),
(12, 'faq - da�nai u�duodami klausimai', 'faq', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'faq-faq', 1, 0, 5),
(13, 'darbai', 'darbai', 'simple', '', 2, '', '', '0', '', '', 1, 0, 6),
(14, 'atsi�sk darb�', 'submitwork', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_submit-show_submit', 1, 13, 1),
(16, 'tokio darbo n�ra', 'nowork', 'simple', '', 2, '', 'surinkai blog� adres� arba �� darb� jau ka�kas i�tryn� (pats autorius arba ka�kuris i� pikt�j� admin�).<br>\r\nnesinervink ir eik �i�r�t kit� darb�. :]', '0', '', '', 0, 13, 2),
(17, 'prekiu �enklai', 'prekiuzenklai', 'simple', '', 2, '', '<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=363" target="_blank">diskaunt kard [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=357" target="_blank">aciu man [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=662" target="_blank">zirkles [zigmo zuvys]</a><br>\r\n\r\n<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=546" target="_blank">auka [taupa]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=619" target="_blank">ozka [taupa]</a><br>\r\n<br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=821" target="_blank">tauta [lietuva]</a><br>\r\n\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=863" target="_blank">pachmelovarai [audimas]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=860" target="_blank">pachmelovarai [audimas]</a><br>\r\n<br>\r\n\r\nshusnis darbu kur tiksliu prekiniu zenklu nezinau (kvepalai ir alkoholis):<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=857" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=858" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=856" target="_blank">spausk</a><br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=855" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=854" target="_blank">spausk</a><br>\r\n', '0', '', '', 1, 1, 5),
(18, 'exportas e-zine''ui', 'ezine', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_top_xml', 1, 13, 100),
(19, 'dalyvio darbai', 'works_user', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 20),
(20, 'labiausiai patik�', 'works_favourites', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 22),
(21, 'asmenin�s �inut�s', 'usermessages', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_messages', 1, 2, 20),
(22, 'atsakyti � �inut�', 'messagereply', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_reply_message', 1, 2, 25),
(23, 'blogi laikai', 'badtime', 'simple', '', 2, '', '�iuo metu <b>art.scene</b> kabo ant tako dsl ir greitis yra apgail�tinas. jei kas galit pad�ti perkelti server� prie geresnio interneto ry�io b�tinai para�ykit <a href="mailto:salna@ktl.mii.lt">juozui �alnai (pukomuko)</a>.\r\n<br><br>\r\no kolkas bandome �vairias srauto taupymo priemones, viena i� toki� - paveiksliuk� rodymas tik registruotiems vartotojams. <br><br>\r\ntad jei <b>nori pamatyti darb�</b> ant kurio spaudei - pirmiausia <b>prisijunk</b>.\r\n', '0', '', '', 1, 1, 1),
(24, 'forumai', 'forum', 'simple', '', 5, '', '', '0', '', 'forum-forum', 1, 0, 12),
(25, 'cleanup', 'cleanup', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-daily_cleanup', 1, 13, 1),
(26, 'art.scene.lt', 'address', 'simple', '', 2, '', 'nor��iau priminti, kad art.scenos adresas yra\r\n<h1>http://art.scene.lt</h1>', '0', '', '', 1, 1, 50),
(27, 'testfresh', 'fresh', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_fresh_works', 1, 13, 100),
(28, 'RSS - new', 'rssnew', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new', 1, 13, 50),
(29, 'RSS - user', 'rssuser', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new_user', 1, 13, 51),
(30, 'statistikos 2004', 'stat2004', 'simple', '', 2, '', 'prie� eidamas � art.scenos gimtadien�, pa�ad�jau �iupsnel� statistik�. bet �kritau � alkoholio li�n� ir neradau tam j�g�. dabar pav�luotai, bet stengiuosi atitaisyti savo klaid�.\r\n<br/><br/>\r\n\r\n<b>bendri skai�iukai</b>\r\n<br/><br/>\r\n�iemet (nuo nauj� met�) i� 2500 u�siregistravusi� dalyvi� prie sistemos prisijung� buvo tik 800. i� t� 800 - 300 prisijungusi� tik �iemet ir prisiregistravo. taigi tikr� senbuvi� turim 500 (aritmetika:)\r\n<br/><br/>\r\n�iemet jau atsiunt�te 300 darb� ir prabalsavot 12000 kart�.\r\n\r\n<br/><br/>\r\n<b>grafik�liai</b>\r\n<br/><br/>\r\n<img src="http://art.scene.lt/news_files/registrantai_bendras.gif"/><br/>\r\nbendro dalyvi� skai�iaus did�jimas. punktyrin� linija rodo tiesin� priklausomyb�. a� pats visus �iuos grafikus matau pirm� kart�. tai �is grafikas man keistokas. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/registrantai.gif"/><br/>\r\n�ia i�pai�yta, kiek b�davo besiregistruojan�i� nauj� dalyvi�, kiekvien� m�nes� atskirai. punktyras - �iaip polinominis �vertis.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekis_bendras.gif"/><br/>\r\n�ia pavaizduota, kaip did�jo bendras darb� kiekis. v�l tiesin� funkcija. dvigubai l�tesn� u� bendr� dalyvi� skai�i�.\r\n<br/><br/>\r\n\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekiai.gif"/><br/>\r\nkiek darb� buvo atsi�sta kiekvien� m�nes� atskirai. dar viso vasario neapdorojo trynimo sistema, tod�l i�lip�s � vir��, bet tendencija vis tiek did�janti.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbai_pagal_sritis.gif"/><br/>\r\n�ia pavaizduotas kiekvienos darb� srities aktyvumas kas m�nes�. m�lyna juosta - bendras darb� skai�ius, kuris matosi ir grafik�lyje auk��iau. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_bendras.gif"/><br/>\r\nbendras balsavim� kiekis b�gant laikui. pagaliau radau kreiv�, kurio priklausomyb� netiesin� :)\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_menuo.gif"/><br/>\r\nkaip vyko balsavimas pagal m�nesius.\r\n\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/palyginimas.gif"/><br/>\r\natkreipkit d�mes�, kad �io grafik�lio skal� - logaritmin�. �ia lyginamas bendras darb�, balsavim� ir dalyvi� skai�ius. man atrod�, kad darbai*dalyviai kis pana�iai kaip balsavim� skai�ius, bet visai apsirikau :)\r\n<br/></br>\r\n\r\nai�ku, tai neturi nieko bendro su menu, bet, galb�t, kam nors bus �domu. man dar labai �domu b�t� pabandyti i�pai�yti tarpusavio santyki� klasterius, bet tam excelis nepad�s. kadanors v�liau :)\r\n<br/></br>\r\n\r\npukomuko<br/>\r\n2004.03.06', '0', '', '', 1, 1, 4),
(31, 'trinti darb�', 'delete_work', 'index', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-delete_image', 1, 13, 1);

-- 
-- Dumping data for table `u_group`
-- 

INSERT INTO `u_group` (`id`, `name`, `info`, `menu`) VALUES (1, 'Administrators', 'Site administrators (all permissions)', 'admin_menu.html'),
(2, 'dalyviai', 'eiliniai dalyviai', 'admin_menu.html'),
(3, 'news admins', 'naujien� administratoriai', 'admin_menu.html'),
(4, 'deletomiotai', 'trina darbus :]', 'admin_menu.html'),
(5, 'sekliai morkos', 'cia sedi 17 :)', 'admin_menu.html'),
(6, 'Balsuotojai', 'bedarbiams balsuotojams', 'menu.html'),
(7, 'Nebalsuotojai', 'darbingiems nebalsuotojams', 'v');

-- 
-- Dumping data for table `u_module`
-- 

INSERT INTO `u_module` (`id`, `name`, `info`) VALUES (1, 'control', 'Administravimas'),
(2, 'content', 'Turinio valdymas'),
(3, 'faq', 'Da�niausiai u�duodami klausimai'),
(4, 'polls', 'Balsavimo sistema'),
(6, 'naujienos', 'Naujien� sistema'),
(7, 'darbai', 'darb� sistema');

-- 
-- Dumping data for table `u_permission`
-- 

INSERT INTO `u_permission` (`id`, `name`, `info`, `module_id`) VALUES (1, 'page_users_list', 'Vartotoj� s�ra�as', 1),
(2, 'page_users_edit', 'Vartotoj� redagavimas', 1),
(3, 'page_users_delete', 'Vartotoj� i�trynimas', 1),
(4, 'page_groups_list', 'Grupi� s�ra�as', 1),
(5, 'page_groups_edit', 'Grupi� redagavimas', 1),
(6, 'page_groups_delete', 'Grupi� i�trynimas', 1),
(7, 'page_modules_list', 'Moduli� s�ra�as', 1),
(8, 'page_modules_edit', 'Moduli� redagavimas', 1),
(9, 'page_modules_delete', 'Moduli� i�trynimas', 1),
(10, 'page_permissions_list', 'Teisi� s�ra�as', 1),
(11, 'page_permissions_edit', 'Teisi� redagavimas', 1),
(12, 'page_permissions_delete', 'Teisi� i�trynimas', 1),
(13, 'ini_edit_view', 'Nustatym� per�i�ra', 1),
(14, 'ini_edit_edit', 'Nustatym� redagavimas', 1),
(15, 'settings_edit', 'Asm. nustatym� redagavimas', 1),
(16, 'avblock_list', 'Blok� s�ra�as', 2),
(17, 'avblock_edit', 'Blok� redagavimas', 2),
(18, 'avblock_delete', 'Blok� i�trynimas', 2),
(19, 'avfaq_list', 'Klausim� s�ra�as', 3),
(20, 'avfaq_edit', 'Klausim� redagavimas', 3),
(21, 'avfaq_delete', 'Klausim� i�trynimas', 3),
(22, 'avpolls_list', 'Apklaus� s�ra�as', 4),
(23, 'avpolls_edit', 'Apklaus� redagavimas', 4),
(24, 'avpolls_delete', 'Apklaus� i�trynimas', 4),
(25, 'avpolls_answers_list', 'Atsakym� s�ra�as', 4),
(26, 'avpolls_answers_edit', 'Atsakym� redagavimas', 4),
(27, 'avpolls_answers_delete', 'Atsakym� i�trynimas', 4),
(28, 'avpolls_questions_list', 'Klausim� s�ra�as', 4),
(29, 'avpolls_questions_edit', 'Klausim� redagavimas', 4),
(30, 'avpolls_questions_delete', 'Klausim� i�trynimas', 4),
(49, 'page_user_log_list', 'Prisijungim� statistika', 1),
(37, 'page_language_list', 'Kalb� s�ra�as', 1),
(38, 'page_language_edit', 'Kalb� redagavimas', 1),
(39, 'page_language_delete', 'Kalb� i�trynimas', 1),
(40, 'avnews_list', 'Naujien� s�ra�as', 6),
(41, 'avnews_edit', 'Naujien� redagavimas', 6),
(42, 'avnews_delete', 'Naujien� i�trynimas', 6),
(43, 'avmenuitem_list', 'Strukt�ros per�i�ra', 2),
(44, 'avmenuitem_edit', 'Strukt�ros redagavimas', 2),
(45, 'avmenuitem_delete', 'Strukt�ros i�trynimas', 2),
(46, 'avfeedback_list', 'U�klaus� s�ra�as', 3),
(47, 'avfeedback_edit', 'U�klaus� redagavimas', 3),
(48, 'avfeedback_delete', 'U�klaus� i�trynimas', 3),
(51, 'avnewscategory_list', 'Naujien� kategorijos', 6),
(52, 'avnewscategory_edit', 'Kategorij� redagavimas', 6),
(53, 'avnewscategory_delete', 'Kategorij� i�trynimas', 6),
(54, 'avnews_auth', 'Naujien� autorizacija', 6),
(55, 'avnews_new', 'Nauja naujiena', 6),
(56, 'avcomments_list', 'Komentar� per�i�ra', 6),
(57, 'avcomments_edit', 'Komentar� redagavimas', 6),
(58, 'avcomments_delete', 'Komentar� trynimas', 6),
(59, 'avworkcategory_list', 'darb� kategorij� s�ra�as', 7),
(60, 'avworkcategory_edit', 'darb� kategorij� redagavimas', 7),
(61, 'avworkcategory_delete', 'darb� kategorij� �alinimas', 7),
(62, 'avworks_list', 'Darb� s�ra�as', 7),
(63, 'avworks_edit', 'Darb� redagavimas', 7),
(64, 'avworks_delete', 'Darb� �alinimas', 7);

-- 
-- Dumping data for table `u_permission_link`
-- 

INSERT INTO `u_permission_link` (`id`, `group_id`, `permission_id`) VALUES (969, 1, 61),
(968, 1, 60),
(967, 1, 59),
(966, 1, 58),
(965, 1, 57),
(964, 1, 56),
(963, 1, 55),
(962, 1, 54),
(961, 1, 53),
(960, 1, 52),
(959, 1, 51),
(958, 1, 42),
(957, 1, 41),
(956, 1, 40),
(955, 1, 30),
(954, 1, 29),
(953, 1, 28),
(952, 1, 27),
(951, 1, 26),
(950, 1, 25),
(949, 1, 24),
(948, 1, 23),
(947, 1, 22),
(946, 1, 48),
(945, 1, 47),
(944, 1, 46),
(943, 1, 21),
(942, 1, 20),
(941, 1, 19),
(940, 1, 45),
(939, 1, 44),
(938, 1, 43),
(937, 1, 18),
(936, 1, 17),
(935, 1, 16),
(934, 1, 39),
(933, 1, 38),
(932, 1, 37),
(931, 1, 49),
(930, 1, 15),
(929, 1, 14),
(928, 1, 13),
(898, 3, 16),
(897, 3, 49),
(896, 3, 15),
(895, 3, 7),
(894, 3, 4),
(893, 2, 56),
(892, 2, 55),
(891, 2, 51),
(890, 2, 40),
(889, 2, 28),
(888, 2, 25),
(887, 2, 22),
(886, 2, 46),
(885, 2, 19),
(927, 1, 12),
(926, 1, 11),
(925, 1, 10),
(884, 2, 43),
(924, 1, 9),
(923, 1, 8),
(883, 2, 16),
(882, 2, 15),
(922, 1, 7),
(921, 1, 6),
(920, 1, 5),
(919, 1, 4),
(899, 3, 43),
(900, 3, 19),
(901, 3, 46),
(902, 3, 22),
(903, 3, 25),
(904, 3, 28),
(905, 3, 40),
(906, 3, 41),
(907, 3, 42),
(908, 3, 51),
(909, 3, 52),
(910, 3, 53),
(911, 3, 54),
(912, 3, 55),
(913, 3, 56),
(914, 3, 57),
(915, 3, 58),
(918, 1, 3),
(917, 1, 2),
(916, 1, 1),
(970, 1, 62),
(971, 1, 63),
(972, 1, 64),
(1032, 4, 63),
(1031, 4, 62),
(1030, 4, 60),
(1029, 4, 59),
(1028, 4, 58),
(1027, 4, 57),
(1026, 4, 56),
(1025, 4, 55),
(1024, 4, 54),
(1023, 4, 53),
(1022, 4, 52),
(1021, 4, 51),
(1020, 4, 42),
(1019, 4, 41),
(1018, 4, 40),
(1017, 4, 48),
(1016, 4, 47),
(1015, 4, 46),
(1014, 4, 21),
(1013, 4, 20),
(1012, 4, 19),
(1011, 4, 49),
(1033, 4, 64),
(1034, 5, 1),
(1035, 5, 4),
(1036, 5, 7),
(1037, 5, 10),
(1038, 5, 13),
(1039, 5, 15),
(1040, 5, 49),
(1041, 5, 37),
(1042, 5, 16),
(1043, 5, 43),
(1044, 5, 19),
(1045, 5, 46),
(1046, 5, 22),
(1047, 5, 25),
(1048, 5, 28),
(1049, 5, 40),
(1050, 5, 41),
(1051, 5, 42),
(1052, 5, 51),
(1053, 5, 54),
(1054, 5, 55),
(1055, 5, 56),
(1056, 6, 19),
(1057, 6, 46),
(1058, 6, 40),
(1059, 6, 51),
(1060, 6, 59),
(1061, 6, 62);
