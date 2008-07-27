-- phpMyAdmin SQL Dump
-- version 2.6.0-alpha2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 27, 2008 at 03:16 AM
-- Server version: 4.0.27
-- PHP Version: 4.4.4-8+etch6
-- 
-- Database : `artscene`
-- 

-- 
-- Dumping data for table `avblock`
-- 

INSERT INTO avblock VALUES (4, 'work.submit.info', 'darbø talpinimo taisyklës', 'Net jei mes ir skatiname meno populiarumà bei norëtume sulaukti kuo\r\ndaugiau tikrø meniniø vertybiø savo tinklalapyje, taèiau visada\r\npasiliekame teisæ iðtrinti bet koká darbà, neatitinkantá kokybës\r\nkriterijø, ir suspenduoti vartotojus be atskirø paaiðkinimø.\r\n<br>\r\nJûsø paèiø labui siekiame svetainëje iðlaikyti aukðtà meniðkumo lygá\r\nir pateikti tik kokybiðkus darbus. Darbai ne savo kategorijose taip\r\npat bus iðtrinti.\r\n\r\n\r\n<br><br>\r\nPriimami tik ðiø formatø darbai: JPG, GIF, PNG, SWF. Jokie kiti\r\nformatai netinka.\r\nÁspëjame, kad sistema negeneruoja maþo paveiksliuko SWF failams, todël\r\nðiam formatui reikia kartu atsiøsti ir maþà paveiksliukà 120x90px, o\r\ndidesnius sistema sumaþins pati.\r\n\r\nJei kitiems formatams bus siunèiamas maþas paveiksliukas, jis bus\r\nnaudojamas vietoj sugeneruoto sistemos.<br>\r\n<br>\r\nNepriimami maþesni nei 10kb dydþio darbai, virðutinë riba - 300kb,\r\niðskyrus "flash" kategorijà, kuri neturi virðutinës ribos.<br> Brandus\r\ndarbas turëtø bûti pakankamos kokybës ir detalumo derinys, bet ne per\r\ndidelis savo „svoriu", kad dauguma vartotojø ilgai nelaukdami galëtø\r\npasiþiûrëti.\r\n\r\n<br><br>\r\nGero elgesio taisyklës:\r\n<ul>\r\n<li> Pieðinius á „art.scene" gali dëti tik pieðiniø autorius.\r\nNesuteikiama teisë darbus patalpinti ágaliotiems asmenims, norint\r\napsaugoti autoriø teises. Tinklalapis yra skirtas rimtiems darbams,\r\nèia nëra pageidaujami juokingi paveikslëliai ar populiarûs\r\ninternetiniai pokðtai.\r\n\r\n\r\n<li> Pieðiniai turi bûti dedami tik á jiems skirtas kategorijas.\r\nMenininkams, maiðtaujantiems prieð tvarka ir ðiuolaikinæ visuomenæ bei\r\nskleidþiantiems chaosà ar þodþio laisvæ, patariame tiesiog kelis\r\nkartus patikrinti priskiriamà kategorijà . Taip sukelsite maþiau\r\nrûpesèiø „art.scene" tvarkytojams.\r\n<li> Jei pieðinius ne savo kategorijose suras „art.scene" tvarkytojas,\r\ntikriausiai jie bus iðtrinti.\r\n\r\n<li> Nedëkite „ðlamðto", kelis kartus pervaryto per filtriukus.\r\n\r\n<li> Nedëkite savo kûrinio pakartotinai, jei jis jau buvo iðtrintas.\r\nJis bûtinai bus iðtrintas ir dar kartà.\r\nNetyèia gali iðnykti ir Jûsø uþregistruotas „nikas".\r\n\r\n<li> Kûrinio vagystës atveju (kai dedamas svetimas pieðinys, foto ar\r\nkitokio pobûdþio darbas, paþeidþiantis autorines teises) – „nikas"\r\niðnykti gali ir tyèia.\r\n</ul>\r\nAdministratoriai be iðankstinio áspëjimo pasilieka teisæ keisti ir\r\návesti naujas taisykles.\r\n', 'block.html', 1);
INSERT INTO avblock VALUES (2, 'work.deleted.admin', 'automatinis praneðimas', 'Informuojame, kad Jûsø darbà "{work.subject}" iðtrynë\r\nadministratoriai, nes jis neatitiko „art.scene" kokybës reikalavimø.\r\nNaujà darbà galësite ádëti tik kità dienà. <br>Perspëjame, kad keli ið\r\neilës ádëti nepatenkinamos kokybës darbai gali atimti Jums galimybæ\r\npublikuoti savo darbus. Prieð ádëdami darbà, dar kartà ávertinkite, ar\r\ntikrai norite já rodyti.\r\n<br>\r\nPlaèiau skaitykite\r\n<ahref="http://art.scene.lt/process.php/page.news;menuname.newsitem;news.426\r\n">naujienose</a>.<br>\r\n<br>\r\nPraðome neatsakinëti,\r\npraneðimus siunèia sistema.\r\n', 'block.html', 1);
INSERT INTO avblock VALUES (3, 'work.deleted.system', 'automatinis praneðimas', 'Informuojame, kad Jûsø darbà "{work.subject}" iðtrynë automatinë\r\nkokybës sistema. Naujà darbà galësite ádëti tik kità dienà.\r\n<br><br>\r\nPlaèiau skaitykite <a\r\nhref=" http://art.scene.lt/process.php/page.news;menuname.newsitem;news.270">naujienose</a>.<br>\r\n<br>\r\nPraðome neatsakinëti,\r\npraneðimus siunèia sistema.\r\n', 'block.html', 1);

-- 
-- Dumping data for table `avnewscategory`
-- 

INSERT INTO avnewscategory VALUES (1, 'art.scene', 'svetainës atnaujinimai, praneðimai apie vietinius ávykius', '', 1);
INSERT INTO avnewscategory VALUES (2, 'programos', 'programinë áranga ir kiti elektroniniai niekuèiai', '', 2);
INSERT INTO avnewscategory VALUES (4, 'renginiai', 'parodos, koncertai, televizijos laidos, viskas, kas vyksta lietuvëlëje ir ne tik', '', 3);
INSERT INTO avnewscategory VALUES (5, 'nuorodos', 'ádomesni puslapiai arba liuksusinio dizaino pavyzdþiai', '', 4);
INSERT INTO avnewscategory VALUES (6, 'pamàstymai', 'kas daros? kur link einame? kodël yra kaip yra? egocentriðkos blevyzgos', '', 5);
INSERT INTO avnewscategory VALUES (7, 'patarimai', '', '', 6);
INSERT INTO avnewscategory VALUES (8, 'iranga', 'naujienos ish hardware pasaulio', '', 1);
INSERT INTO avnewscategory VALUES (9, 'darbas', 'duokit duonos', '', 5);

-- 
-- Dumping data for table `avworkcategory`
-- 

INSERT INTO avworkcategory VALUES (1, 'manipuliacijos', 'darbai, kuriø pagrindas fotografijos', '', 1);
INSERT INTO avworkcategory VALUES (2, 'komp. pieðiniai', 'kompiuterinëmis priemonëmis sukurti darbai', '', 2);
INSERT INTO avworkcategory VALUES (3, 'tikra media', 'tai èia teptukas pieðtukas guaðas molis plûgas medis', '', 3);
INSERT INTO avworkcategory VALUES (4, '3d', 'cia tai jau nu kai pure 3d arba gabalelis tik prifotoposhopotinta', '', 4);
INSERT INTO avworkcategory VALUES (5, 'foto', 'fotografijos', '', 5);
INSERT INTO avworkcategory VALUES (6, 'flash', 'iðmislas multimedinis, èia dëkit menus, o ne amato gudrybes.', '', 6);

-- 
-- Dumping data for table `forum_list`
-- 

INSERT INTO forum_list VALUES (1, 'art.scene.v3', 'pamàstymai apie ateitá', 20);
INSERT INTO forum_list VALUES (2, 'nuorodos', 'pasidalinkit interneto dþiaugsmais', 15);
INSERT INTO forum_list VALUES (3, 'skundai/pageidavimai', 'kaþkas neveikia kaip turëtø?', 18);
INSERT INTO forum_list VALUES (4, 'fotografija', 'dalybos patirtimi ir áspudþiais', 13);
INSERT INTO forum_list VALUES (5, 'programos', 'pagalba ávaldant programas monstrus', 14);
INSERT INTO forum_list VALUES (6, '3d', 'padëk draugui', 12);
INSERT INTO forum_list VALUES (7, 'plepalai', 'kas ðiandien uþëjo ant seilës?', 5);
INSERT INTO forum_list VALUES (8, 'darbai', 'paiðymas / manipuliacijos', 10);

-- 
-- Dumping data for table `menuitem`
-- 

INSERT INTO menuitem VALUES (1, 'Informacija', 'info', 'simple', '', 2, '', '<P>cia informaciniai puslapiai</P>\r\n', '0', 'content/about.html', '', 1, 0, 1);
INSERT INTO menuitem VALUES (2, 'Vartotojai', 'usersinfo', 'index', '', 2, '', '\r\n<P>cia su vartotoju registracija susije daiktai:</P>\r\n<P>&nbsp;- register<BR>&nbsp;- online<BR>&nbsp;- list of registered<BR>&nbsp;- \r\nsettings<BR>&nbsp; - lostpassword</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', '', 1, 0, 2);
INSERT INTO menuitem VALUES (3, 'registracija', 'signup', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_signup', 1, 2, 1);
INSERT INTO menuitem VALUES (4, 'apie', 'about', 'simple', '', 2, '', 'problemos, neaiðkumai, klausimai? aplankyk <a href="page.simple;menuname.faq">faq</a>.<br><br>\r\n\r\n<b>apie projektà</b>\r\n<br><br>\r\njeigu d117 vadinasi laisvøjø menø vieta, tai mums belieka kertelë su uþvadinimu - menai nelaisvëje. =]<br>\r\nnorëèiau, kad laisvës bûtø daug, bet ne anarchijos. turëtø bûti vieta, kur smagu uþeiti, kur smagu atsiøsti darbus. daugiau ðilumos!<br>\r\ndaugiau naujienø, interaktyvumo. tikiuosi, kad viskas nenumirs po kategorizacijos ir passwordø represijom.\r\n<br><br>\r\n\r\n\r\n<b>þmonës</b>\r\n<br><br>\r\npukomuko / juozas ðalna - ka yra?<br>\r\ngabris - dabartinis dizainas.\r\n\r\n\r\n<br><br>\r\n<b>truputëlis istorijos</b>\r\n<br><br>\r\nsenai senai gûdþià þiemà idealistas mokinukas pagamino puslapëlá juodà ir þalsvà. po pusmeèio þalsvà pakeitë rusva, bet juodos liko pakankamai daug. rusva spalva priviliojo daugybæ þmogeliø, kurie tempë á puslapëlá ávairiaspalvius ðudukus. laikui bëgant krûva vis augo ir augo. mokinukas paûgëjo ir tapo studentu, bet jo viltys, kad studijuojant atsiras laiko naujam aptvarui aplink krûvà, nyko su kiekviena link sesijos lydinèia diena. po sesijos studentas tapo studentu-darbininku ir krûva pradëjo menkti. visus metus studentas-darbininkas tik pagaliuku pamaiðydavo krûvà, nes dirbo jis ávairiaus didumo aptvarëliø konstruotoju, ir pagaliau atëjo dienà, kai prireikë sukonstruoti panaðaus didumo aptvarëlá, kaip ir juodai rusvosios krûvos. mûsø protagonistas ilgai stenëjo, bet rezultatas buvo vertas tik darbininko, ir nors iðkeltai uþduoèiai jis ganëtinai tiko, deja, negalëjo pakeisti mûsø juodai rusvosios krûvelës aptvaro. ðis procesas stebëtinai iðvargino mûsø pagrindiná veikëjà, todël jis pakeitë darbo sàlygas, bet ten ið jo pareikalavo dar sudëtingesnio aptvaro. taèiau dabar jis jau buvo patyræs ir atliko savo darbà kaip studentas-darbininkas, todël rezultatas turëjo pakankamai smarvës pakeisti juodai rusvàjá. ðtai toks epas.\r\n<br><br>\r\no dabar keletas tikslesniø sakiniø ir datø:<br>\r\n1998 - idëja.<br>\r\n1999 þiema - pirma versija online, galbût ðiek tiek juokinga ir nefunkcionali.<br>\r\n1999 vasara - visiðkai nauja svetainë, kuri praktiðkai nepakitus funkcionuoja iki 2002 metø.<br>\r\n2001 þiema - dar vienas totalus perraðymas.<br>\r\n<br>\r\n\r\n<b>padëkos</b>\r\n<br><br>\r\nypatingos padëkos tadui þelioniui ir <a href="http://fluxus.lt">fluxus.lt</a> uþ teisingà kelià, hostingà ir suportà, kosmos''ui uþ pirmuosius perl skriptus ir moralinæ paramà, uab "<a href="http://www.avc.lt">alternatyvus valdymas</a>" uþ galimybæ sukonstruoti galingà backend''à, gabriui uþ ðá dizainà ir kantrybæ, visiems kitiems, kurie atsiliepë á mano isteriðkus ðûkius sukurpti dizainà, visiems, kurie pastoviai klausinëjo, kada bus v2, ir didþiausios padëkos tiems, kurie palaiko art.scene gyvà - siunèia puikius darbus. aèiû.\r\n\r\n<br><br>\r\n<b>nori atsiøsti savo darbà?</b>\r\n<br><br>\r\njei tu já kà tik sukûrei - dar pasilaikyk já kokià savaitëlæ, vëliau pasiþiûrëk ir ásitikink, kad tai ne ðlamðtas. toks procesas truputá sumaþins moralinæ traumà, kai gausi meilà ''tavo pieðinys nebepublikuojamas art.scene svetainëje''. taigi, vis dar nori uþpublikuoti savo darbà? jei dar nesi uþsiregistravæs - <a href="page.simple;menuname.signup">registruokis</a>! tada jau ieðkok nuorodos ''atsiøsk darbà'' ir sek nurodymus ekrane.<br>\r\n<br>\r\nprie ðios svetainës praleidau daug ilgø vakarø, buvo daug nervø ir vargo, todël mielieji praðyèiau gerbti mano darbà ir netalptinti èia ðlamðto.\r\n\r\n<br><br>\r\n<b>kaip naudotis?</b>\r\n<br><br>\r\nsmulkiau tokie klausimai aptariami <a href="page.simple;menuname.faq">faq''e</a>.<br><br>\r\n<b>apdovanojimai</b>\r\n<br><br>\r\nreiktø kadanors atsiskanuoti tuos du diplomus, kuriuos gavau uþ art.scene per lietuvos www èempionatus. dabar nepamenu, kelintas tai buvo www èempionatas, bet 1999 metais art.scene pateko tarp lauretø, taèiau, man regis, tokiø svetainiø skaièius artëjo link 50 :] be diplomo, dar gavau tokius lipdukus su svetainës pirmuoju puslapiu, bet në vieno nebeturiu, tik yra vienas uþsilikæs mano tuometinës asmeninës svetainës, kuri irgi papuolë á lauretus.<br>\r\n2000 metais vykusiame èempionate art.scene iðkovojo I-àjà vietà, tai buvo vienintelis kartas, kai art.scene atneðë man materialinës naudos. gavau þydrus ''solo'' marðkinius, su kuriais gëda kur nors pasirodyti, antivirusà panda, kurá tà patá vakarà padovanojau draugui su gimtadieniu, pelæ, tokià paèià prieð mënesá buvau nusipirkæs uþ 30lt, deja, jos abi jau sulûþo, bei dar kelis kanceliarinius niekuèius. 2001 metø www èempionate svetainës neuþregistravau, nieks jos ir nepasigedo :]<br>\r\ndar buvo keletas online apdovanojimø, kaip pvz <a href="http://www.laikas.lt">www.laikas.lt</a> ''rekomenduojama svetainë''(?) dar kaþkelios kitos svetainës buvo ásidëjusios pagirianèias nuorodas.\r\n\r\n<br><br>&nbsp;', '0', '', '', 1, 1, 1);
INSERT INTO menuitem VALUES (5, 'dabar narðo', 'online', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', 'users-login-show_online', 1, 2, 2);
INSERT INTO menuitem VALUES (6, 'pamirðai slaptaþodá?', 'lostpassword', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password', 1, 2, 3);
INSERT INTO menuitem VALUES (7, 'art.scene dalyviai', 'userslist', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'users-login-show_users_list', 1, 2, 4);
INSERT INTO menuitem VALUES (8, 'asmeniniai nustatymai', 'usersettings', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_settings', 1, 2, 5);
INSERT INTO menuitem VALUES (9, 'Naujienos', 'news', 'news', '', 2, '', '<P>visi naujienu puslapio variantai</P>', '0', '', '', 1, 0, 5);
INSERT INTO menuitem VALUES (10, 'dalyvauk', 'submit', 'simple', '', 2, '', '<ul>\r\n<li><A href="page.simple;menuname.submitnews"><b>atsiøsk \r\nnaujienà</b></A><br>\r\nnaujienas perþiûri ir tvirtina administratoriai. galbût jûsø þinutei uþteks forumo? bûtina raðyti lietuviðkomis raidëmis.\r\n<br><br>\r\n</li>\r\n\r\n\r\n<li><a href="page.simple;menuname.submitwork"><b>ádëk darbà</b></a><br>\r\nprieð dedant darbà bûtina susipaþinti su taisyklëmis.</li>\r\n</ul>\r\n\r\n', '0', '', '', 1, 2, 10);
INSERT INTO menuitem VALUES (15, 'pasikeisk slaptaþodá', 'lostpassword_recover', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password_recover', 1, 2, 1);
INSERT INTO menuitem VALUES (11, 'atsiøsk naujienà', 'submitnews', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n\r\n\r\n', '0', '', 'news-news-show_submit', 1, 9, 1);
INSERT INTO menuitem VALUES (12, 'faq - daþnai uþduodami klausimai', 'faq', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'faq-faq', 1, 0, 5);
INSERT INTO menuitem VALUES (13, 'darbai', 'darbai', 'simple', '', 2, '', '', '0', '', '', 1, 0, 6);
INSERT INTO menuitem VALUES (14, 'atsiøsk darbà', 'submitwork', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_submit-show_submit', 1, 13, 1);
INSERT INTO menuitem VALUES (16, 'tokio darbo nëra', 'nowork', 'simple', '', 2, '', 'surinkai blogà adresà arba ðá darbà jau kaþkas iðtrynë (pats autorius arba kaþkuris ið piktøjø adminø).<br>\r\nnesinervink ir eik þiûrët kitø darbø. :]', '0', '', '', 0, 13, 2);
INSERT INTO menuitem VALUES (17, 'prekiu þenklai', 'prekiuzenklai', 'simple', '', 2, '', '<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=363" target="_blank">diskaunt kard [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=357" target="_blank">aciu man [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=662" target="_blank">zirkles [zigmo zuvys]</a><br>\r\n\r\n<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=546" target="_blank">auka [taupa]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=619" target="_blank">ozka [taupa]</a><br>\r\n<br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=821" target="_blank">tauta [lietuva]</a><br>\r\n\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=863" target="_blank">pachmelovarai [audimas]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=860" target="_blank">pachmelovarai [audimas]</a><br>\r\n<br>\r\n\r\nshusnis darbu kur tiksliu prekiniu zenklu nezinau (kvepalai ir alkoholis):<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=857" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=858" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=856" target="_blank">spausk</a><br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=855" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=854" target="_blank">spausk</a><br>\r\n', '0', '', '', 1, 1, 5);
INSERT INTO menuitem VALUES (18, 'exportas e-zine''ui', 'ezine', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_top_xml', 1, 13, 100);
INSERT INTO menuitem VALUES (19, 'dalyvio darbai', 'works_user', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 20);
INSERT INTO menuitem VALUES (20, 'labiausiai patikæ', 'works_favourites', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 22);
INSERT INTO menuitem VALUES (21, 'asmeninës þinutës', 'usermessages', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_messages', 1, 2, 20);
INSERT INTO menuitem VALUES (22, 'atsakyti á þinutæ', 'messagereply', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_reply_message', 1, 2, 25);
INSERT INTO menuitem VALUES (23, 'blogi laikai', 'badtime', 'simple', '', 2, '', 'ðiuo metu <b>art.scene</b> kabo ant tako dsl ir greitis yra apgailëtinas. jei kas galit padëti perkelti serverá prie geresnio interneto ryðio bûtinai paraðykit <a href="mailto:salna@ktl.mii.lt">juozui ðalnai (pukomuko)</a>.\r\n<br><br>\r\no kolkas bandome ávairias srauto taupymo priemones, viena ið tokiø - paveiksliukø rodymas tik registruotiems vartotojams. <br><br>\r\ntad jei <b>nori pamatyti darbà</b> ant kurio spaudei - pirmiausia <b>prisijunk</b>.\r\n', '0', '', '', 1, 1, 1);
INSERT INTO menuitem VALUES (24, 'forumai', 'forum', 'simple', '', 5, '', '', '0', '', 'forum-forum', 1, 0, 12);
INSERT INTO menuitem VALUES (25, 'cleanup', 'cleanup', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-daily_cleanup', 1, 13, 1);
INSERT INTO menuitem VALUES (26, 'art.scene.lt', 'address', 'simple', '', 2, '', 'norëèiau priminti, kad art.scenos adresas yra\r\n<h1>http://art.scene.lt</h1>', '0', '', '', 1, 1, 50);
INSERT INTO menuitem VALUES (27, 'testfresh', 'fresh', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_fresh_works', 1, 13, 100);
INSERT INTO menuitem VALUES (28, 'RSS - new', 'rssnew', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new', 1, 13, 50);
INSERT INTO menuitem VALUES (29, 'RSS - user', 'rssuser', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new_user', 1, 13, 51);
INSERT INTO menuitem VALUES (30, 'statistikos 2004', 'stat2004', 'simple', '', 2, '', 'prieð eidamas á art.scenos gimtadiená, paþadëjau þiupsnelá statistikø. bet ákritau á alkoholio liûnà ir neradau tam jëgø. dabar pavëluotai, bet stengiuosi atitaisyti savo klaidà.\r\n<br/><br/>\r\n\r\n<b>bendri skaièiukai</b>\r\n<br/><br/>\r\nðiemet (nuo naujø metø) ið 2500 uþsiregistravusiø dalyviø prie sistemos prisijungæ buvo tik 800. ið tø 800 - 300 prisijungusiø tik ðiemet ir prisiregistravo. taigi tikrø senbuviø turim 500 (aritmetika:)\r\n<br/><br/>\r\nðiemet jau atsiuntëte 300 darbø ir prabalsavot 12000 kartø.\r\n\r\n<br/><br/>\r\n<b>grafikëliai</b>\r\n<br/><br/>\r\n<img src="http://art.scene.lt/news_files/registrantai_bendras.gif"/><br/>\r\nbendro dalyviø skaièiaus didëjimas. punktyrinë linija rodo tiesinæ priklausomybæ. að pats visus ðiuos grafikus matau pirmà kartà. tai ðis grafikas man keistokas. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/registrantai.gif"/><br/>\r\nèia iðpaiðyta, kiek bûdavo besiregistruojanèiø naujø dalyviø, kiekvienà mënesá atskirai. punktyras - ðiaip polinominis ávertis.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekis_bendras.gif"/><br/>\r\nèia pavaizduota, kaip didëjo bendras darbø kiekis. vël tiesinë funkcija. dvigubai lëtesnë uþ bendrà dalyviø skaièiø.\r\n<br/><br/>\r\n\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekiai.gif"/><br/>\r\nkiek darbø buvo atsiøsta kiekvienà mënesá atskirai. dar viso vasario neapdorojo trynimo sistema, todël iðlipæs á virðø, bet tendencija vis tiek didëjanti.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbai_pagal_sritis.gif"/><br/>\r\nèia pavaizduotas kiekvienos darbø srities aktyvumas kas mënesá. mëlyna juosta - bendras darbø skaièius, kuris matosi ir grafikëlyje aukðèiau. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_bendras.gif"/><br/>\r\nbendras balsavimø kiekis bëgant laikui. pagaliau radau kreivæ, kurio priklausomybë netiesinë :)\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_menuo.gif"/><br/>\r\nkaip vyko balsavimas pagal mënesius.\r\n\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/palyginimas.gif"/><br/>\r\natkreipkit dëmesá, kad ðio grafikëlio skalë - logaritminë. èia lyginamas bendras darbø, balsavimø ir dalyviø skaièius. man atrodë, kad darbai*dalyviai kis panaðiai kaip balsavimø skaièius, bet visai apsirikau :)\r\n<br/></br>\r\n\r\naiðku, tai neturi nieko bendro su menu, bet, galbût, kam nors bus ádomu. man dar labai ádomu bûtø pabandyti iðpaiðyti tarpusavio santykiø klasterius, bet tam excelis nepadës. kadanors vëliau :)\r\n<br/></br>\r\n\r\npukomuko<br/>\r\n2004.03.06', '0', '', '', 1, 1, 4);
INSERT INTO menuitem VALUES (31, 'trinti darbà', 'delete_work', 'index', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-delete_image', 1, 13, 1);
INSERT INTO menuitem VALUES (32, 'tokio vartotojo nëra', 'nouser', 'simple', '', 2, '', 'pasiklydai arba nespëjai.', '0', '', '', 1, 13, 3);
INSERT INTO menuitem VALUES (34, 'ðvieþiai komentuoti darbai', 'freshworks', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_fresh_works', 1, 13, 15);

-- 
-- Dumping data for table `u_group`
-- 

INSERT INTO u_group VALUES (1, 'Administrators', 'Site administrators (all permissions)', 'admin_menu.html');
INSERT INTO u_group VALUES (2, 'dalyviai', 'eiliniai dalyviai', 'admin_menu.html');
INSERT INTO u_group VALUES (3, 'news admins', 'naujienø administratoriai', 'admin_menu.html');
INSERT INTO u_group VALUES (4, 'deletomiotai', 'trina darbus :]', 'admin_menu.html');
INSERT INTO u_group VALUES (5, 'sekliai morkos', 'cia sedi 17 :)', 'admin_menu.html');
INSERT INTO u_group VALUES (6, 'Balsuotojai', 'bedarbiams balsuotojams', 'menu.html');
INSERT INTO u_group VALUES (7, 'Nebalsuotojai', 'darbingiems nebalsuotojams', 'v');

-- 
-- Dumping data for table `u_module`
-- 

INSERT INTO u_module VALUES (1, 'control', 'Administravimas');
INSERT INTO u_module VALUES (2, 'content', 'Turinio valdymas');
INSERT INTO u_module VALUES (3, 'faq', 'Daþniausiai uþduodami klausimai');
INSERT INTO u_module VALUES (4, 'polls', 'Balsavimo sistema');
INSERT INTO u_module VALUES (6, 'naujienos', 'Naujienø sistema');
INSERT INTO u_module VALUES (7, 'darbai', 'darbø sistema');

-- 
-- Dumping data for table `u_permission`
-- 

INSERT INTO u_permission VALUES (1, 'page_users_list', 'Vartotojø sàraðas', 1);
INSERT INTO u_permission VALUES (2, 'page_users_edit', 'Vartotojø redagavimas', 1);
INSERT INTO u_permission VALUES (3, 'page_users_delete', 'Vartotojø iðtrynimas', 1);
INSERT INTO u_permission VALUES (4, 'page_groups_list', 'Grupiø sàraðas', 1);
INSERT INTO u_permission VALUES (5, 'page_groups_edit', 'Grupiø redagavimas', 1);
INSERT INTO u_permission VALUES (6, 'page_groups_delete', 'Grupiø iðtrynimas', 1);
INSERT INTO u_permission VALUES (7, 'page_modules_list', 'Moduliø sàraðas', 1);
INSERT INTO u_permission VALUES (8, 'page_modules_edit', 'Moduliø redagavimas', 1);
INSERT INTO u_permission VALUES (9, 'page_modules_delete', 'Moduliø iðtrynimas', 1);
INSERT INTO u_permission VALUES (10, 'page_permissions_list', 'Teisiø sàraðas', 1);
INSERT INTO u_permission VALUES (11, 'page_permissions_edit', 'Teisiø redagavimas', 1);
INSERT INTO u_permission VALUES (12, 'page_permissions_delete', 'Teisiø iðtrynimas', 1);
INSERT INTO u_permission VALUES (13, 'ini_edit_view', 'Nustatymø perþiûra', 1);
INSERT INTO u_permission VALUES (14, 'ini_edit_edit', 'Nustatymø redagavimas', 1);
INSERT INTO u_permission VALUES (15, 'settings_edit', 'Asm. nustatymø redagavimas', 1);
INSERT INTO u_permission VALUES (16, 'avblock_list', 'Blokø sàraðas', 2);
INSERT INTO u_permission VALUES (17, 'avblock_edit', 'Blokø redagavimas', 2);
INSERT INTO u_permission VALUES (18, 'avblock_delete', 'Blokø iðtrynimas', 2);
INSERT INTO u_permission VALUES (19, 'avfaq_list', 'Klausimø sàraðas', 3);
INSERT INTO u_permission VALUES (20, 'avfaq_edit', 'Klausimø redagavimas', 3);
INSERT INTO u_permission VALUES (21, 'avfaq_delete', 'Klausimø iðtrynimas', 3);
INSERT INTO u_permission VALUES (22, 'avpolls_list', 'Apklausø sàraðas', 4);
INSERT INTO u_permission VALUES (23, 'avpolls_edit', 'Apklausø redagavimas', 4);
INSERT INTO u_permission VALUES (24, 'avpolls_delete', 'Apklausø iðtrynimas', 4);
INSERT INTO u_permission VALUES (25, 'avpolls_answers_list', 'Atsakymø sàraðas', 4);
INSERT INTO u_permission VALUES (26, 'avpolls_answers_edit', 'Atsakymø redagavimas', 4);
INSERT INTO u_permission VALUES (27, 'avpolls_answers_delete', 'Atsakymø iðtrynimas', 4);
INSERT INTO u_permission VALUES (28, 'avpolls_questions_list', 'Klausimø sàraðas', 4);
INSERT INTO u_permission VALUES (29, 'avpolls_questions_edit', 'Klausimø redagavimas', 4);
INSERT INTO u_permission VALUES (30, 'avpolls_questions_delete', 'Klausimø iðtrynimas', 4);
INSERT INTO u_permission VALUES (49, 'page_user_log_list', 'Prisijungimø statistika', 1);
INSERT INTO u_permission VALUES (37, 'page_language_list', 'Kalbø sàraðas', 1);
INSERT INTO u_permission VALUES (38, 'page_language_edit', 'Kalbø redagavimas', 1);
INSERT INTO u_permission VALUES (39, 'page_language_delete', 'Kalbø iðtrynimas', 1);
INSERT INTO u_permission VALUES (40, 'avnews_list', 'Naujienø sàraðas', 6);
INSERT INTO u_permission VALUES (41, 'avnews_edit', 'Naujienø redagavimas', 6);
INSERT INTO u_permission VALUES (42, 'avnews_delete', 'Naujienø iðtrynimas', 6);
INSERT INTO u_permission VALUES (43, 'avmenuitem_list', 'Struktûros perþiûra', 2);
INSERT INTO u_permission VALUES (44, 'avmenuitem_edit', 'Struktûros redagavimas', 2);
INSERT INTO u_permission VALUES (45, 'avmenuitem_delete', 'Struktûros iðtrynimas', 2);
INSERT INTO u_permission VALUES (46, 'avfeedback_list', 'Uþklausø sàraðas', 3);
INSERT INTO u_permission VALUES (47, 'avfeedback_edit', 'Uþklausø redagavimas', 3);
INSERT INTO u_permission VALUES (48, 'avfeedback_delete', 'Uþklausø iðtrynimas', 3);
INSERT INTO u_permission VALUES (51, 'avnewscategory_list', 'Naujienø kategorijos', 6);
INSERT INTO u_permission VALUES (52, 'avnewscategory_edit', 'Kategorijø redagavimas', 6);
INSERT INTO u_permission VALUES (53, 'avnewscategory_delete', 'Kategorijø iðtrynimas', 6);
INSERT INTO u_permission VALUES (54, 'avnews_auth', 'Naujienø autorizacija', 6);
INSERT INTO u_permission VALUES (55, 'avnews_new', 'Nauja naujiena', 6);
INSERT INTO u_permission VALUES (56, 'avcomments_list', 'Komentarø perþiûra', 6);
INSERT INTO u_permission VALUES (57, 'avcomments_edit', 'Komentarø redagavimas', 6);
INSERT INTO u_permission VALUES (58, 'avcomments_delete', 'Komentarø trynimas', 6);
INSERT INTO u_permission VALUES (59, 'avworkcategory_list', 'darbø kategorijø sàraðas', 7);
INSERT INTO u_permission VALUES (60, 'avworkcategory_edit', 'darbø kategorijø redagavimas', 7);
INSERT INTO u_permission VALUES (61, 'avworkcategory_delete', 'darbø kategorijø ðalinimas', 7);
INSERT INTO u_permission VALUES (62, 'avworks_list', 'Darbø sàraðas', 7);
INSERT INTO u_permission VALUES (63, 'avworks_edit', 'Darbø redagavimas', 7);
INSERT INTO u_permission VALUES (64, 'avworks_delete', 'Darbø ðalinimas', 7);
INSERT INTO u_permission VALUES (65, 'avworks_delete_log_list', 'Darbø trynimo logo perþiûra', 7);

-- 
-- Dumping data for table `u_permission_link`
-- 

INSERT INTO u_permission_link VALUES (1118, 1, 64);
INSERT INTO u_permission_link VALUES (1117, 1, 63);
INSERT INTO u_permission_link VALUES (1116, 1, 62);
INSERT INTO u_permission_link VALUES (1115, 1, 61);
INSERT INTO u_permission_link VALUES (1114, 1, 60);
INSERT INTO u_permission_link VALUES (1113, 1, 59);
INSERT INTO u_permission_link VALUES (1112, 1, 58);
INSERT INTO u_permission_link VALUES (1111, 1, 57);
INSERT INTO u_permission_link VALUES (1110, 1, 56);
INSERT INTO u_permission_link VALUES (1109, 1, 55);
INSERT INTO u_permission_link VALUES (1108, 1, 54);
INSERT INTO u_permission_link VALUES (1107, 1, 53);
INSERT INTO u_permission_link VALUES (1106, 1, 52);
INSERT INTO u_permission_link VALUES (1105, 1, 51);
INSERT INTO u_permission_link VALUES (1104, 1, 42);
INSERT INTO u_permission_link VALUES (1103, 1, 41);
INSERT INTO u_permission_link VALUES (1102, 1, 40);
INSERT INTO u_permission_link VALUES (1101, 1, 30);
INSERT INTO u_permission_link VALUES (1100, 1, 29);
INSERT INTO u_permission_link VALUES (1099, 1, 28);
INSERT INTO u_permission_link VALUES (1098, 1, 27);
INSERT INTO u_permission_link VALUES (1097, 1, 26);
INSERT INTO u_permission_link VALUES (1096, 1, 25);
INSERT INTO u_permission_link VALUES (1095, 1, 24);
INSERT INTO u_permission_link VALUES (1094, 1, 23);
INSERT INTO u_permission_link VALUES (1093, 1, 22);
INSERT INTO u_permission_link VALUES (1092, 1, 48);
INSERT INTO u_permission_link VALUES (1091, 1, 47);
INSERT INTO u_permission_link VALUES (1090, 1, 46);
INSERT INTO u_permission_link VALUES (1089, 1, 21);
INSERT INTO u_permission_link VALUES (1088, 1, 20);
INSERT INTO u_permission_link VALUES (1087, 1, 19);
INSERT INTO u_permission_link VALUES (1086, 1, 45);
INSERT INTO u_permission_link VALUES (1085, 1, 44);
INSERT INTO u_permission_link VALUES (1084, 1, 43);
INSERT INTO u_permission_link VALUES (1083, 1, 18);
INSERT INTO u_permission_link VALUES (1082, 1, 17);
INSERT INTO u_permission_link VALUES (1081, 1, 16);
INSERT INTO u_permission_link VALUES (1080, 1, 39);
INSERT INTO u_permission_link VALUES (1079, 1, 38);
INSERT INTO u_permission_link VALUES (1078, 1, 37);
INSERT INTO u_permission_link VALUES (1077, 1, 49);
INSERT INTO u_permission_link VALUES (898, 3, 16);
INSERT INTO u_permission_link VALUES (897, 3, 49);
INSERT INTO u_permission_link VALUES (896, 3, 15);
INSERT INTO u_permission_link VALUES (895, 3, 7);
INSERT INTO u_permission_link VALUES (894, 3, 4);
INSERT INTO u_permission_link VALUES (893, 2, 56);
INSERT INTO u_permission_link VALUES (892, 2, 55);
INSERT INTO u_permission_link VALUES (891, 2, 51);
INSERT INTO u_permission_link VALUES (890, 2, 40);
INSERT INTO u_permission_link VALUES (889, 2, 28);
INSERT INTO u_permission_link VALUES (888, 2, 25);
INSERT INTO u_permission_link VALUES (887, 2, 22);
INSERT INTO u_permission_link VALUES (886, 2, 46);
INSERT INTO u_permission_link VALUES (885, 2, 19);
INSERT INTO u_permission_link VALUES (1076, 1, 15);
INSERT INTO u_permission_link VALUES (1075, 1, 14);
INSERT INTO u_permission_link VALUES (1074, 1, 13);
INSERT INTO u_permission_link VALUES (884, 2, 43);
INSERT INTO u_permission_link VALUES (1073, 1, 12);
INSERT INTO u_permission_link VALUES (1072, 1, 11);
INSERT INTO u_permission_link VALUES (883, 2, 16);
INSERT INTO u_permission_link VALUES (882, 2, 15);
INSERT INTO u_permission_link VALUES (1071, 1, 10);
INSERT INTO u_permission_link VALUES (1070, 1, 9);
INSERT INTO u_permission_link VALUES (1069, 1, 8);
INSERT INTO u_permission_link VALUES (1068, 1, 7);
INSERT INTO u_permission_link VALUES (899, 3, 43);
INSERT INTO u_permission_link VALUES (900, 3, 19);
INSERT INTO u_permission_link VALUES (901, 3, 46);
INSERT INTO u_permission_link VALUES (902, 3, 22);
INSERT INTO u_permission_link VALUES (903, 3, 25);
INSERT INTO u_permission_link VALUES (904, 3, 28);
INSERT INTO u_permission_link VALUES (905, 3, 40);
INSERT INTO u_permission_link VALUES (906, 3, 41);
INSERT INTO u_permission_link VALUES (907, 3, 42);
INSERT INTO u_permission_link VALUES (908, 3, 51);
INSERT INTO u_permission_link VALUES (909, 3, 52);
INSERT INTO u_permission_link VALUES (910, 3, 53);
INSERT INTO u_permission_link VALUES (911, 3, 54);
INSERT INTO u_permission_link VALUES (912, 3, 55);
INSERT INTO u_permission_link VALUES (913, 3, 56);
INSERT INTO u_permission_link VALUES (914, 3, 57);
INSERT INTO u_permission_link VALUES (915, 3, 58);
INSERT INTO u_permission_link VALUES (1067, 1, 6);
INSERT INTO u_permission_link VALUES (1066, 1, 5);
INSERT INTO u_permission_link VALUES (1065, 1, 4);
INSERT INTO u_permission_link VALUES (1064, 1, 3);
INSERT INTO u_permission_link VALUES (1063, 1, 2);
INSERT INTO u_permission_link VALUES (1062, 1, 1);
INSERT INTO u_permission_link VALUES (1142, 4, 64);
INSERT INTO u_permission_link VALUES (1141, 4, 63);
INSERT INTO u_permission_link VALUES (1140, 4, 62);
INSERT INTO u_permission_link VALUES (1139, 4, 60);
INSERT INTO u_permission_link VALUES (1138, 4, 59);
INSERT INTO u_permission_link VALUES (1137, 4, 58);
INSERT INTO u_permission_link VALUES (1136, 4, 57);
INSERT INTO u_permission_link VALUES (1135, 4, 56);
INSERT INTO u_permission_link VALUES (1134, 4, 55);
INSERT INTO u_permission_link VALUES (1133, 4, 54);
INSERT INTO u_permission_link VALUES (1132, 4, 53);
INSERT INTO u_permission_link VALUES (1131, 4, 52);
INSERT INTO u_permission_link VALUES (1130, 4, 51);
INSERT INTO u_permission_link VALUES (1129, 4, 42);
INSERT INTO u_permission_link VALUES (1128, 4, 41);
INSERT INTO u_permission_link VALUES (1127, 4, 40);
INSERT INTO u_permission_link VALUES (1126, 4, 48);
INSERT INTO u_permission_link VALUES (1125, 4, 47);
INSERT INTO u_permission_link VALUES (1124, 4, 46);
INSERT INTO u_permission_link VALUES (1123, 4, 21);
INSERT INTO u_permission_link VALUES (1122, 4, 20);
INSERT INTO u_permission_link VALUES (1121, 4, 19);
INSERT INTO u_permission_link VALUES (1120, 4, 49);
INSERT INTO u_permission_link VALUES (1034, 5, 1);
INSERT INTO u_permission_link VALUES (1035, 5, 4);
INSERT INTO u_permission_link VALUES (1036, 5, 7);
INSERT INTO u_permission_link VALUES (1037, 5, 10);
INSERT INTO u_permission_link VALUES (1038, 5, 13);
INSERT INTO u_permission_link VALUES (1039, 5, 15);
INSERT INTO u_permission_link VALUES (1040, 5, 49);
INSERT INTO u_permission_link VALUES (1041, 5, 37);
INSERT INTO u_permission_link VALUES (1042, 5, 16);
INSERT INTO u_permission_link VALUES (1043, 5, 43);
INSERT INTO u_permission_link VALUES (1044, 5, 19);
INSERT INTO u_permission_link VALUES (1045, 5, 46);
INSERT INTO u_permission_link VALUES (1046, 5, 22);
INSERT INTO u_permission_link VALUES (1047, 5, 25);
INSERT INTO u_permission_link VALUES (1048, 5, 28);
INSERT INTO u_permission_link VALUES (1049, 5, 40);
INSERT INTO u_permission_link VALUES (1050, 5, 41);
INSERT INTO u_permission_link VALUES (1051, 5, 42);
INSERT INTO u_permission_link VALUES (1052, 5, 51);
INSERT INTO u_permission_link VALUES (1053, 5, 54);
INSERT INTO u_permission_link VALUES (1054, 5, 55);
INSERT INTO u_permission_link VALUES (1055, 5, 56);
INSERT INTO u_permission_link VALUES (1056, 6, 19);
INSERT INTO u_permission_link VALUES (1057, 6, 46);
INSERT INTO u_permission_link VALUES (1058, 6, 40);
INSERT INTO u_permission_link VALUES (1059, 6, 51);
INSERT INTO u_permission_link VALUES (1060, 6, 59);
INSERT INTO u_permission_link VALUES (1061, 6, 62);
INSERT INTO u_permission_link VALUES (1119, 1, 65);
INSERT INTO u_permission_link VALUES (1143, 4, 65);
