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

INSERT INTO `avnewscategory` (`id`, `name`, `info`, `file`, `sort_number`) VALUES (1, 'art.scene', 'svetainës atnaujinimai, praneðimai apie vietinius ávykius', '', 1),
(2, 'programos', 'programinë áranga ir kiti elektroniniai niekuèiai', '', 2),
(4, 'renginiai', 'parodos, koncertai, televizijos laidos, viskas, kas vyksta lietuvëlëje ir ne tik', '', 3),
(5, 'nuorodos', 'ádomesni puslapiai arba liuksusinio dizaino pavyzdþiai', '', 4),
(6, 'pamàstymai', 'kas daros? kur link einame? kodël yra kaip yra? egocentriðkos blevyzgos', '', 5),
(7, 'patarimai', '', '', 6),
(8, 'iranga', 'naujienos ish hardware pasaulio', '', 1);

-- 
-- Dumping data for table `avworkcategory`
-- 

INSERT INTO `avworkcategory` (`id`, `name`, `info`, `file`, `sort_number`) VALUES (1, 'manipuliacyjos', 'daþniausia menynë rûðis ant ðitos scenos, kai tepliojama naudojant fotkes ir ten nu lejeriukai filtriukai ir t.t.', '', 1),
(2, 'paiðalai', 'nu èia kai be fotografyjø ir be objektø ten gatavø nuo nulio uþlipdoma viskas', '', 2),
(3, 'tikra media', 'tai èia teptukas pieðtukas guaðas molis plûgas medis', '', 3),
(4, '3d', 'cia tai jau nu kai pure 3d arba gabalelis tik prifotoposhopotinta', '', 4),
(5, 'foto', 'fotografynei atlykimai', '', 5),
(6, 'flash', 'iðmislas multimedinis, èia dëkit menus, o ne amato gudrybes.', '', 6);

-- 
-- Dumping data for table `languages`
-- 

INSERT INTO `languages` (`id`, `name`, `lang_name`) VALUES (1, 'lt', 'Lietuviø'),
(2, 'en', 'Anglø'),
(3, 'ru', 'Rusø');

-- 
-- Dumping data for table `menuitem`
-- 

INSERT INTO `menuitem` (`id`, `name`, `iname`, `page`, `file`, `type`, `link`, `html`, `block_id`, `include`, `column_id`, `visible`, `pid`, `sort_number`) VALUES (1, 'Informacija', 'info', 'simple', '', 2, '', '<P>cia informaciniai puslapiai</P>\r\n', '0', 'content/about.html', '', 1, 0, 1),
(2, 'Vartotojai', 'usersinfo', 'index', '', 2, '', '\r\n<P>cia su vartotoju registracija susije daiktai:</P>\r\n<P>&nbsp;- register<BR>&nbsp;- online<BR>&nbsp;- list of registered<BR>&nbsp;- \r\nsettings<BR>&nbsp; - lostpassword</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', '', 1, 0, 2),
(3, 'registracija', 'signup', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_signup', 1, 2, 1),
(4, 'apie', 'about', 'simple', '', 4, '', '\r\n<P>&nbsp;</P>\r\n</BODY>\r\n</HTML>\r\n', '0', 'content/about.html', '', 1, 1, 1),
(5, 'dabar narðo', 'online', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', 'users-login-show_online', 1, 2, 2),
(6, 'pamirðai slaptaþodá?', 'lostpassword', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password', 1, 2, 3),
(7, 'art.scene dalyviai', 'userslist', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'users-login-show_users_list', 1, 2, 4),
(8, 'asmeniniai nustatymai', 'usersettings', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_settings', 1, 2, 5),
(9, 'Naujienos', 'news', 'news', '', 2, '', '<P>visi naujienu puslapio variantai</P>', '0', '', '', 1, 0, 5),
(10, 'dalyvauk', 'submit', 'simple', '', 2, '', '<A href="page.simple;menuname.submitnews"><b>atsiøsk \r\nnaujienà</b></A><br>\r\n\r\n\r\n<a href="page.simple;menuname.submitwork"><b>ádëk darbà</b></a>\r\n\r\n\r\n', '0', '', '', 1, 2, 10),
(15, 'pasikeisk slaptaþodá', 'lostpassword_recover', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password_recover', 1, 2, 1),
(11, 'atsiøsk naujienà', 'submitnews', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n\r\n\r\n', '0', '', 'news-news-show_submit', 1, 9, 1),
(12, 'faq - daþnai uþduodami klausimai', 'faq', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'faq-faq', 1, 0, 5),
(13, 'darbai', 'darbai', 'simple', '', 2, '', '', '0', '', '', 1, 0, 6),
(14, 'atsiøsk darbà', 'submitwork', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_submit-show_submit', 1, 13, 1),
(16, 'tokio darbo nëra', 'nowork', 'simple', '', 2, '', 'surinkai blogà adresà arba ðá darbà jau kaþkas iðtrynë (pats autorius arba kaþkuris ið piktøjø adminø).<br>\r\nnesinervink ir eik þiûrët kitø darbø. :]', '0', '', '', 0, 13, 2),
(17, 'prekiu þenklai', 'prekiuzenklai', 'simple', '', 2, '', '<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=363" target="_blank">diskaunt kard [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=357" target="_blank">aciu man [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=662" target="_blank">zirkles [zigmo zuvys]</a><br>\r\n\r\n<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=546" target="_blank">auka [taupa]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=619" target="_blank">ozka [taupa]</a><br>\r\n<br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=821" target="_blank">tauta [lietuva]</a><br>\r\n\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=863" target="_blank">pachmelovarai [audimas]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=860" target="_blank">pachmelovarai [audimas]</a><br>\r\n<br>\r\n\r\nshusnis darbu kur tiksliu prekiniu zenklu nezinau (kvepalai ir alkoholis):<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=857" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=858" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=856" target="_blank">spausk</a><br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=855" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=854" target="_blank">spausk</a><br>\r\n', '0', '', '', 1, 1, 5),
(18, 'exportas e-zine''ui', 'ezine', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_top_xml', 1, 13, 100),
(19, 'dalyvio darbai', 'works_user', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 20),
(20, 'labiausiai patikæ', 'works_favourites', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 22),
(21, 'asmeninës þinutës', 'usermessages', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_messages', 1, 2, 20),
(22, 'atsakyti á þinutæ', 'messagereply', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_reply_message', 1, 2, 25),
(23, 'blogi laikai', 'badtime', 'simple', '', 2, '', 'ðiuo metu <b>art.scene</b> kabo ant tako dsl ir greitis yra apgailëtinas. jei kas galit padëti perkelti serverá prie geresnio interneto ryðio bûtinai paraðykit <a href="mailto:salna@ktl.mii.lt">juozui ðalnai (pukomuko)</a>.\r\n<br><br>\r\no kolkas bandome ávairias srauto taupymo priemones, viena ið tokiø - paveiksliukø rodymas tik registruotiems vartotojams. <br><br>\r\ntad jei <b>nori pamatyti darbà</b> ant kurio spaudei - pirmiausia <b>prisijunk</b>.\r\n', '0', '', '', 1, 1, 1),
(24, 'forumai', 'forum', 'simple', '', 5, '', '', '0', '', 'forum-forum', 1, 0, 12),
(25, 'cleanup', 'cleanup', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-daily_cleanup', 1, 13, 1),
(26, 'art.scene.lt', 'address', 'simple', '', 2, '', 'norëèiau priminti, kad art.scenos adresas yra\r\n<h1>http://art.scene.lt</h1>', '0', '', '', 1, 1, 50),
(27, 'testfresh', 'fresh', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_fresh_works', 1, 13, 100),
(28, 'RSS - new', 'rssnew', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new', 1, 13, 50),
(29, 'RSS - user', 'rssuser', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new_user', 1, 13, 51),
(30, 'statistikos 2004', 'stat2004', 'simple', '', 2, '', 'prieð eidamas á art.scenos gimtadiená, paþadëjau þiupsnelá statistikø. bet ákritau á alkoholio liûnà ir neradau tam jëgø. dabar pavëluotai, bet stengiuosi atitaisyti savo klaidà.\r\n<br/><br/>\r\n\r\n<b>bendri skaièiukai</b>\r\n<br/><br/>\r\nðiemet (nuo naujø metø) ið 2500 uþsiregistravusiø dalyviø prie sistemos prisijungæ buvo tik 800. ið tø 800 - 300 prisijungusiø tik ðiemet ir prisiregistravo. taigi tikrø senbuviø turim 500 (aritmetika:)\r\n<br/><br/>\r\nðiemet jau atsiuntëte 300 darbø ir prabalsavot 12000 kartø.\r\n\r\n<br/><br/>\r\n<b>grafikëliai</b>\r\n<br/><br/>\r\n<img src="http://art.scene.lt/news_files/registrantai_bendras.gif"/><br/>\r\nbendro dalyviø skaièiaus didëjimas. punktyrinë linija rodo tiesinæ priklausomybæ. að pats visus ðiuos grafikus matau pirmà kartà. tai ðis grafikas man keistokas. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/registrantai.gif"/><br/>\r\nèia iðpaiðyta, kiek bûdavo besiregistruojanèiø naujø dalyviø, kiekvienà mënesá atskirai. punktyras - ðiaip polinominis ávertis.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekis_bendras.gif"/><br/>\r\nèia pavaizduota, kaip didëjo bendras darbø kiekis. vël tiesinë funkcija. dvigubai lëtesnë uþ bendrà dalyviø skaièiø.\r\n<br/><br/>\r\n\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekiai.gif"/><br/>\r\nkiek darbø buvo atsiøsta kiekvienà mënesá atskirai. dar viso vasario neapdorojo trynimo sistema, todël iðlipæs á virðø, bet tendencija vis tiek didëjanti.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbai_pagal_sritis.gif"/><br/>\r\nèia pavaizduotas kiekvienos darbø srities aktyvumas kas mënesá. mëlyna juosta - bendras darbø skaièius, kuris matosi ir grafikëlyje aukðèiau. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_bendras.gif"/><br/>\r\nbendras balsavimø kiekis bëgant laikui. pagaliau radau kreivæ, kurio priklausomybë netiesinë :)\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_menuo.gif"/><br/>\r\nkaip vyko balsavimas pagal mënesius.\r\n\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/palyginimas.gif"/><br/>\r\natkreipkit dëmesá, kad ðio grafikëlio skalë - logaritminë. èia lyginamas bendras darbø, balsavimø ir dalyviø skaièius. man atrodë, kad darbai*dalyviai kis panaðiai kaip balsavimø skaièius, bet visai apsirikau :)\r\n<br/></br>\r\n\r\naiðku, tai neturi nieko bendro su menu, bet, galbût, kam nors bus ádomu. man dar labai ádomu bûtø pabandyti iðpaiðyti tarpusavio santykiø klasterius, bet tam excelis nepadës. kadanors vëliau :)\r\n<br/></br>\r\n\r\npukomuko<br/>\r\n2004.03.06', '0', '', '', 1, 1, 4),
(31, 'trinti darbà', 'delete_work', 'index', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-delete_image', 1, 13, 1);

-- 
-- Dumping data for table `u_group`
-- 

INSERT INTO `u_group` (`id`, `name`, `info`, `menu`) VALUES (1, 'Administrators', 'Site administrators (all permissions)', 'admin_menu.html'),
(2, 'dalyviai', 'eiliniai dalyviai', 'admin_menu.html'),
(3, 'news admins', 'naujienø administratoriai', 'admin_menu.html'),
(4, 'deletomiotai', 'trina darbus :]', 'admin_menu.html'),
(5, 'sekliai morkos', 'cia sedi 17 :)', 'admin_menu.html'),
(6, 'Balsuotojai', 'bedarbiams balsuotojams', 'menu.html'),
(7, 'Nebalsuotojai', 'darbingiems nebalsuotojams', 'v');

-- 
-- Dumping data for table `u_module`
-- 

INSERT INTO `u_module` (`id`, `name`, `info`) VALUES (1, 'control', 'Administravimas'),
(2, 'content', 'Turinio valdymas'),
(3, 'faq', 'Daþniausiai uþduodami klausimai'),
(4, 'polls', 'Balsavimo sistema'),
(6, 'naujienos', 'Naujienø sistema'),
(7, 'darbai', 'darbø sistema');

-- 
-- Dumping data for table `u_permission`
-- 

INSERT INTO `u_permission` (`id`, `name`, `info`, `module_id`) VALUES (1, 'page_users_list', 'Vartotojø sàraðas', 1),
(2, 'page_users_edit', 'Vartotojø redagavimas', 1),
(3, 'page_users_delete', 'Vartotojø iðtrynimas', 1),
(4, 'page_groups_list', 'Grupiø sàraðas', 1),
(5, 'page_groups_edit', 'Grupiø redagavimas', 1),
(6, 'page_groups_delete', 'Grupiø iðtrynimas', 1),
(7, 'page_modules_list', 'Moduliø sàraðas', 1),
(8, 'page_modules_edit', 'Moduliø redagavimas', 1),
(9, 'page_modules_delete', 'Moduliø iðtrynimas', 1),
(10, 'page_permissions_list', 'Teisiø sàraðas', 1),
(11, 'page_permissions_edit', 'Teisiø redagavimas', 1),
(12, 'page_permissions_delete', 'Teisiø iðtrynimas', 1),
(13, 'ini_edit_view', 'Nustatymø perþiûra', 1),
(14, 'ini_edit_edit', 'Nustatymø redagavimas', 1),
(15, 'settings_edit', 'Asm. nustatymø redagavimas', 1),
(16, 'avblock_list', 'Blokø sàraðas', 2),
(17, 'avblock_edit', 'Blokø redagavimas', 2),
(18, 'avblock_delete', 'Blokø iðtrynimas', 2),
(19, 'avfaq_list', 'Klausimø sàraðas', 3),
(20, 'avfaq_edit', 'Klausimø redagavimas', 3),
(21, 'avfaq_delete', 'Klausimø iðtrynimas', 3),
(22, 'avpolls_list', 'Apklausø sàraðas', 4),
(23, 'avpolls_edit', 'Apklausø redagavimas', 4),
(24, 'avpolls_delete', 'Apklausø iðtrynimas', 4),
(25, 'avpolls_answers_list', 'Atsakymø sàraðas', 4),
(26, 'avpolls_answers_edit', 'Atsakymø redagavimas', 4),
(27, 'avpolls_answers_delete', 'Atsakymø iðtrynimas', 4),
(28, 'avpolls_questions_list', 'Klausimø sàraðas', 4),
(29, 'avpolls_questions_edit', 'Klausimø redagavimas', 4),
(30, 'avpolls_questions_delete', 'Klausimø iðtrynimas', 4),
(49, 'page_user_log_list', 'Prisijungimø statistika', 1),
(37, 'page_language_list', 'Kalbø sàraðas', 1),
(38, 'page_language_edit', 'Kalbø redagavimas', 1),
(39, 'page_language_delete', 'Kalbø iðtrynimas', 1),
(40, 'avnews_list', 'Naujienø sàraðas', 6),
(41, 'avnews_edit', 'Naujienø redagavimas', 6),
(42, 'avnews_delete', 'Naujienø iðtrynimas', 6),
(43, 'avmenuitem_list', 'Struktûros perþiûra', 2),
(44, 'avmenuitem_edit', 'Struktûros redagavimas', 2),
(45, 'avmenuitem_delete', 'Struktûros iðtrynimas', 2),
(46, 'avfeedback_list', 'Uþklausø sàraðas', 3),
(47, 'avfeedback_edit', 'Uþklausø redagavimas', 3),
(48, 'avfeedback_delete', 'Uþklausø iðtrynimas', 3),
(51, 'avnewscategory_list', 'Naujienø kategorijos', 6),
(52, 'avnewscategory_edit', 'Kategorijø redagavimas', 6),
(53, 'avnewscategory_delete', 'Kategorijø iðtrynimas', 6),
(54, 'avnews_auth', 'Naujienø autorizacija', 6),
(55, 'avnews_new', 'Nauja naujiena', 6),
(56, 'avcomments_list', 'Komentarø perþiûra', 6),
(57, 'avcomments_edit', 'Komentarø redagavimas', 6),
(58, 'avcomments_delete', 'Komentarø trynimas', 6),
(59, 'avworkcategory_list', 'darbø kategorijø sàraðas', 7),
(60, 'avworkcategory_edit', 'darbø kategorijø redagavimas', 7),
(61, 'avworkcategory_delete', 'darbø kategorijø ðalinimas', 7),
(62, 'avworks_list', 'Darbø sàraðas', 7),
(63, 'avworks_edit', 'Darbø redagavimas', 7),
(64, 'avworks_delete', 'Darbø ðalinimas', 7);

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
