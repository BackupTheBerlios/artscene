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

INSERT INTO avblock VALUES (4, 'work.submit.info', 'darb� talpinimo taisykl�s', 'Net jei mes ir skatiname meno populiarum� bei nor�tume sulaukti kuo\r\ndaugiau tikr� menini� vertybi� savo tinklalapyje, ta�iau visada\r\npasiliekame teis� i�trinti bet kok� darb�, neatitinkant� kokyb�s\r\nkriterij�, ir suspenduoti vartotojus be atskir� paai�kinim�.\r\n<br>\r\nJ�s� pa�i� labui siekiame svetain�je i�laikyti auk�t� meni�kumo lyg�\r\nir pateikti tik kokybi�kus darbus. Darbai ne savo kategorijose taip\r\npat bus i�trinti.\r\n\r\n\r\n<br><br>\r\nPriimami tik �i� format� darbai: JPG, GIF, PNG, SWF. Jokie kiti\r\nformatai netinka.\r\n�sp�jame, kad sistema negeneruoja ma�o paveiksliuko SWF failams, tod�l\r\n�iam formatui reikia kartu atsi�sti ir ma�� paveiksliuk� 120x90px, o\r\ndidesnius sistema suma�ins pati.\r\n\r\nJei kitiems formatams bus siun�iamas ma�as paveiksliukas, jis bus\r\nnaudojamas vietoj sugeneruoto sistemos.<br>\r\n<br>\r\nNepriimami ma�esni nei 10kb dyd�io darbai, vir�utin� riba - 300kb,\r\ni�skyrus "flash" kategorij�, kuri neturi vir�utin�s ribos.<br> Brandus\r\ndarbas tur�t� b�ti pakankamos kokyb�s ir detalumo derinys, bet ne per\r\ndidelis savo �svoriu", kad dauguma vartotoj� ilgai nelaukdami gal�t�\r\npasi�i�r�ti.\r\n\r\n<br><br>\r\nGero elgesio taisykl�s:\r\n<ul>\r\n<li> Pie�inius � �art.scene" gali d�ti tik pie�ini� autorius.\r\nNesuteikiama teis� darbus patalpinti �galiotiems asmenims, norint\r\napsaugoti autori� teises. Tinklalapis yra skirtas rimtiems darbams,\r\n�ia n�ra pageidaujami juokingi paveiksl�liai ar populiar�s\r\ninternetiniai pok�tai.\r\n\r\n\r\n<li> Pie�iniai turi b�ti dedami tik � jiems skirtas kategorijas.\r\nMenininkams, mai�taujantiems prie� tvarka ir �iuolaikin� visuomen� bei\r\nskleid�iantiems chaos� ar �od�io laisv�, patariame tiesiog kelis\r\nkartus patikrinti priskiriam� kategorij� . Taip sukelsite ma�iau\r\nr�pes�i� �art.scene" tvarkytojams.\r\n<li> Jei pie�inius ne savo kategorijose suras �art.scene" tvarkytojas,\r\ntikriausiai jie bus i�trinti.\r\n\r\n<li> Ned�kite ��lam�to", kelis kartus pervaryto per filtriukus.\r\n\r\n<li> Ned�kite savo k�rinio pakartotinai, jei jis jau buvo i�trintas.\r\nJis b�tinai bus i�trintas ir dar kart�.\r\nNety�ia gali i�nykti ir J�s� u�registruotas �nikas".\r\n\r\n<li> K�rinio vagyst�s atveju (kai dedamas svetimas pie�inys, foto ar\r\nkitokio pob�d�io darbas, pa�eid�iantis autorines teises) � �nikas"\r\ni�nykti gali ir ty�ia.\r\n</ul>\r\nAdministratoriai be i�ankstinio �sp�jimo pasilieka teis� keisti ir\r\n�vesti naujas taisykles.\r\n', 'block.html', 1);
INSERT INTO avblock VALUES (2, 'work.deleted.admin', 'automatinis prane�imas', 'Informuojame, kad J�s� darb� "{work.subject}" i�tryn�\r\nadministratoriai, nes jis neatitiko �art.scene" kokyb�s reikalavim�.\r\nNauj� darb� gal�site �d�ti tik kit� dien�. <br>Persp�jame, kad keli i�\r\neil�s �d�ti nepatenkinamos kokyb�s darbai gali atimti Jums galimyb�\r\npublikuoti savo darbus. Prie� �d�dami darb�, dar kart� �vertinkite, ar\r\ntikrai norite j� rodyti.\r\n<br>\r\nPla�iau skaitykite\r\n<ahref="http://art.scene.lt/process.php/page.news;menuname.newsitem;news.426\r\n">naujienose</a>.<br>\r\n<br>\r\nPra�ome neatsakin�ti,\r\nprane�imus siun�ia sistema.\r\n', 'block.html', 1);
INSERT INTO avblock VALUES (3, 'work.deleted.system', 'automatinis prane�imas', 'Informuojame, kad J�s� darb� "{work.subject}" i�tryn� automatin�\r\nkokyb�s sistema. Nauj� darb� gal�site �d�ti tik kit� dien�.\r\n<br><br>\r\nPla�iau skaitykite <a\r\nhref=" http://art.scene.lt/process.php/page.news;menuname.newsitem;news.270">naujienose</a>.<br>\r\n<br>\r\nPra�ome neatsakin�ti,\r\nprane�imus siun�ia sistema.\r\n', 'block.html', 1);

-- 
-- Dumping data for table `avnewscategory`
-- 

INSERT INTO avnewscategory VALUES (1, 'art.scene', 'svetain�s atnaujinimai, prane�imai apie vietinius �vykius', '', 1);
INSERT INTO avnewscategory VALUES (2, 'programos', 'programin� �ranga ir kiti elektroniniai nieku�iai', '', 2);
INSERT INTO avnewscategory VALUES (4, 'renginiai', 'parodos, koncertai, televizijos laidos, viskas, kas vyksta lietuv�l�je ir ne tik', '', 3);
INSERT INTO avnewscategory VALUES (5, 'nuorodos', '�domesni puslapiai arba liuksusinio dizaino pavyzd�iai', '', 4);
INSERT INTO avnewscategory VALUES (6, 'pam�stymai', 'kas daros? kur link einame? kod�l yra kaip yra? egocentri�kos blevyzgos', '', 5);
INSERT INTO avnewscategory VALUES (7, 'patarimai', '', '', 6);
INSERT INTO avnewscategory VALUES (8, 'iranga', 'naujienos ish hardware pasaulio', '', 1);
INSERT INTO avnewscategory VALUES (9, 'darbas', 'duokit duonos', '', 5);

-- 
-- Dumping data for table `avworkcategory`
-- 

INSERT INTO avworkcategory VALUES (1, 'manipuliacijos', 'darbai, kuri� pagrindas fotografijos', '', 1);
INSERT INTO avworkcategory VALUES (2, 'komp. pie�iniai', 'kompiuterin�mis priemon�mis sukurti darbai', '', 2);
INSERT INTO avworkcategory VALUES (3, 'tikra media', 'tai �ia teptukas pie�tukas gua�as molis pl�gas medis', '', 3);
INSERT INTO avworkcategory VALUES (4, '3d', 'cia tai jau nu kai pure 3d arba gabalelis tik prifotoposhopotinta', '', 4);
INSERT INTO avworkcategory VALUES (5, 'foto', 'fotografijos', '', 5);
INSERT INTO avworkcategory VALUES (6, 'flash', 'i�mislas multimedinis, �ia d�kit menus, o ne amato gudrybes.', '', 6);

-- 
-- Dumping data for table `forum_list`
-- 

INSERT INTO forum_list VALUES (1, 'art.scene.v3', 'pam�stymai apie ateit�', 20);
INSERT INTO forum_list VALUES (2, 'nuorodos', 'pasidalinkit interneto d�iaugsmais', 15);
INSERT INTO forum_list VALUES (3, 'skundai/pageidavimai', 'ka�kas neveikia kaip tur�t�?', 18);
INSERT INTO forum_list VALUES (4, 'fotografija', 'dalybos patirtimi ir �spud�iais', 13);
INSERT INTO forum_list VALUES (5, 'programos', 'pagalba �valdant programas monstrus', 14);
INSERT INTO forum_list VALUES (6, '3d', 'pad�k draugui', 12);
INSERT INTO forum_list VALUES (7, 'plepalai', 'kas �iandien u��jo ant seil�s?', 5);
INSERT INTO forum_list VALUES (8, 'darbai', 'pai�ymas / manipuliacijos', 10);

-- 
-- Dumping data for table `menuitem`
-- 

INSERT INTO menuitem VALUES (1, 'Informacija', 'info', 'simple', '', 2, '', '<P>cia informaciniai puslapiai</P>\r\n', '0', 'content/about.html', '', 1, 0, 1);
INSERT INTO menuitem VALUES (2, 'Vartotojai', 'usersinfo', 'index', '', 2, '', '\r\n<P>cia su vartotoju registracija susije daiktai:</P>\r\n<P>&nbsp;- register<BR>&nbsp;- online<BR>&nbsp;- list of registered<BR>&nbsp;- \r\nsettings<BR>&nbsp; - lostpassword</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', '', 1, 0, 2);
INSERT INTO menuitem VALUES (3, 'registracija', 'signup', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_signup', 1, 2, 1);
INSERT INTO menuitem VALUES (4, 'apie', 'about', 'simple', '', 2, '', 'problemos, neai�kumai, klausimai? aplankyk <a href="page.simple;menuname.faq">faq</a>.<br><br>\r\n\r\n<b>apie projekt�</b>\r\n<br><br>\r\njeigu d117 vadinasi laisv�j� men� vieta, tai mums belieka kertel� su u�vadinimu - menai nelaisv�je. =]<br>\r\nnor��iau, kad laisv�s b�t� daug, bet ne anarchijos. tur�t� b�ti vieta, kur smagu u�eiti, kur smagu atsi�sti darbus. daugiau �ilumos!<br>\r\ndaugiau naujien�, interaktyvumo. tikiuosi, kad viskas nenumirs po kategorizacijos ir password� represijom.\r\n<br><br>\r\n\r\n\r\n<b>�mon�s</b>\r\n<br><br>\r\npukomuko / juozas �alna - ka yra?<br>\r\ngabris - dabartinis dizainas.\r\n\r\n\r\n<br><br>\r\n<b>truput�lis istorijos</b>\r\n<br><br>\r\nsenai senai g�d�i� �iem� idealistas mokinukas pagamino puslap�l� juod� ir �alsv�. po pusme�io �alsv� pakeit� rusva, bet juodos liko pakankamai daug. rusva spalva priviliojo daugyb� �mogeli�, kurie temp� � puslap�l� �vairiaspalvius �udukus. laikui b�gant kr�va vis augo ir augo. mokinukas pa�g�jo ir tapo studentu, bet jo viltys, kad studijuojant atsiras laiko naujam aptvarui aplink kr�v�, nyko su kiekviena link sesijos lydin�ia diena. po sesijos studentas tapo studentu-darbininku ir kr�va prad�jo menkti. visus metus studentas-darbininkas tik pagaliuku pamai�ydavo kr�v�, nes dirbo jis �vairiaus didumo aptvar�li� konstruotoju, ir pagaliau at�jo dien�, kai prireik� sukonstruoti pana�aus didumo aptvar�l�, kaip ir juodai rusvosios kr�vos. m�s� protagonistas ilgai sten�jo, bet rezultatas buvo vertas tik darbininko, ir nors i�keltai u�duo�iai jis gan�tinai tiko, deja, negal�jo pakeisti m�s� juodai rusvosios kr�vel�s aptvaro. �is procesas steb�tinai i�vargino m�s� pagrindin� veik�j�, tod�l jis pakeit� darbo s�lygas, bet ten i� jo pareikalavo dar sud�tingesnio aptvaro. ta�iau dabar jis jau buvo patyr�s ir atliko savo darb� kaip studentas-darbininkas, tod�l rezultatas tur�jo pakankamai smarv�s pakeisti juodai rusv�j�. �tai toks epas.\r\n<br><br>\r\no dabar keletas tikslesni� sakini� ir dat�:<br>\r\n1998 - id�ja.<br>\r\n1999 �iema - pirma versija online, galb�t �iek tiek juokinga ir nefunkcionali.<br>\r\n1999 vasara - visi�kai nauja svetain�, kuri prakti�kai nepakitus funkcionuoja iki 2002 met�.<br>\r\n2001 �iema - dar vienas totalus perra�ymas.<br>\r\n<br>\r\n\r\n<b>pad�kos</b>\r\n<br><br>\r\nypatingos pad�kos tadui �elioniui ir <a href="http://fluxus.lt">fluxus.lt</a> u� teising� keli�, hosting� ir suport�, kosmos''ui u� pirmuosius perl skriptus ir moralin� param�, uab "<a href="http://www.avc.lt">alternatyvus valdymas</a>" u� galimyb� sukonstruoti galing� backend''�, gabriui u� �� dizain� ir kantryb�, visiems kitiems, kurie atsiliep� � mano isteri�kus ��kius sukurpti dizain�, visiems, kurie pastoviai klausin�jo, kada bus v2, ir did�iausios pad�kos tiems, kurie palaiko art.scene gyv� - siun�ia puikius darbus. a�i�.\r\n\r\n<br><br>\r\n<b>nori atsi�sti savo darb�?</b>\r\n<br><br>\r\njei tu j� k� tik suk�rei - dar pasilaikyk j� koki� savait�l�, v�liau pasi�i�r�k ir �sitikink, kad tai ne �lam�tas. toks procesas truput� suma�ins moralin� traum�, kai gausi meil� ''tavo pie�inys nebepublikuojamas art.scene svetain�je''. taigi, vis dar nori u�publikuoti savo darb�? jei dar nesi u�siregistrav�s - <a href="page.simple;menuname.signup">registruokis</a>! tada jau ie�kok nuorodos ''atsi�sk darb�'' ir sek nurodymus ekrane.<br>\r\n<br>\r\nprie �ios svetain�s praleidau daug ilg� vakar�, buvo daug nerv� ir vargo, tod�l mielieji pra�y�iau gerbti mano darb� ir netalptinti �ia �lam�to.\r\n\r\n<br><br>\r\n<b>kaip naudotis?</b>\r\n<br><br>\r\nsmulkiau tokie klausimai aptariami <a href="page.simple;menuname.faq">faq''e</a>.<br><br>\r\n<b>apdovanojimai</b>\r\n<br><br>\r\nreikt� kadanors atsiskanuoti tuos du diplomus, kuriuos gavau u� art.scene per lietuvos www �empionatus. dabar nepamenu, kelintas tai buvo www �empionatas, bet 1999 metais art.scene pateko tarp lauret�, ta�iau, man regis, toki� svetaini� skai�ius art�jo link 50 :] be diplomo, dar gavau tokius lipdukus su svetain�s pirmuoju puslapiu, bet n� vieno nebeturiu, tik yra vienas u�silik�s mano tuometin�s asmenin�s svetain�s, kuri irgi papuol� � lauretus.<br>\r\n2000 metais vykusiame �empionate art.scene i�kovojo I-�j� viet�, tai buvo vienintelis kartas, kai art.scene atne�� man materialin�s naudos. gavau �ydrus ''solo'' mar�kinius, su kuriais g�da kur nors pasirodyti, antivirus� panda, kur� t� pat� vakar� padovanojau draugui su gimtadieniu, pel�, toki� pa�i� prie� m�nes� buvau nusipirk�s u� 30lt, deja, jos abi jau sul��o, bei dar kelis kanceliarinius nieku�ius. 2001 met� www �empionate svetain�s neu�registravau, nieks jos ir nepasigedo :]<br>\r\ndar buvo keletas online apdovanojim�, kaip pvz <a href="http://www.laikas.lt">www.laikas.lt</a> ''rekomenduojama svetain�''(?) dar ka�kelios kitos svetain�s buvo �sid�jusios pagirian�ias nuorodas.\r\n\r\n<br><br>&nbsp;', '0', '', '', 1, 1, 1);
INSERT INTO menuitem VALUES (5, 'dabar nar�o', 'online', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n</BODY>\r\n</HTML>\r\n', '0', '', 'users-login-show_online', 1, 2, 2);
INSERT INTO menuitem VALUES (6, 'pamir�ai slapta�od�?', 'lostpassword', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password', 1, 2, 3);
INSERT INTO menuitem VALUES (7, 'art.scene dalyviai', 'userslist', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'users-login-show_users_list', 1, 2, 4);
INSERT INTO menuitem VALUES (8, 'asmeniniai nustatymai', 'usersettings', 'simple', '', 5, '', '<P>&nbsp;</P>', '0', '', 'users-login-show_settings', 1, 2, 5);
INSERT INTO menuitem VALUES (9, 'Naujienos', 'news', 'news', '', 2, '', '<P>visi naujienu puslapio variantai</P>', '0', '', '', 1, 0, 5);
INSERT INTO menuitem VALUES (10, 'dalyvauk', 'submit', 'simple', '', 2, '', '<ul>\r\n<li><A href="page.simple;menuname.submitnews"><b>atsi�sk \r\nnaujien�</b></A><br>\r\nnaujienas per�i�ri ir tvirtina administratoriai. galb�t j�s� �inutei u�teks forumo? b�tina ra�yti lietuvi�komis raid�mis.\r\n<br><br>\r\n</li>\r\n\r\n\r\n<li><a href="page.simple;menuname.submitwork"><b>�d�k darb�</b></a><br>\r\nprie� dedant darb� b�tina susipa�inti su taisykl�mis.</li>\r\n</ul>\r\n\r\n', '0', '', '', 1, 2, 10);
INSERT INTO menuitem VALUES (15, 'pasikeisk slapta�od�', 'lostpassword_recover', 'simple', '', 5, '', '', '0', '', 'users-login-show_lost_password_recover', 1, 2, 1);
INSERT INTO menuitem VALUES (11, 'atsi�sk naujien�', 'submitnews', 'simple', '', 5, '', '\r\n<P>&nbsp;</P>\r\n\r\n\r\n', '0', '', 'news-news-show_submit', 1, 9, 1);
INSERT INTO menuitem VALUES (12, 'faq - da�nai u�duodami klausimai', 'faq', 'simple', '', 5, '', '<P>&nbsp;</P>\r\n', '0', '', 'faq-faq', 1, 0, 5);
INSERT INTO menuitem VALUES (13, 'darbai', 'darbai', 'simple', '', 2, '', '', '0', '', '', 1, 0, 6);
INSERT INTO menuitem VALUES (14, 'atsi�sk darb�', 'submitwork', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_submit-show_submit', 1, 13, 1);
INSERT INTO menuitem VALUES (16, 'tokio darbo n�ra', 'nowork', 'simple', '', 2, '', 'surinkai blog� adres� arba �� darb� jau ka�kas i�tryn� (pats autorius arba ka�kuris i� pikt�j� admin�).<br>\r\nnesinervink ir eik �i�r�t kit� darb�. :]', '0', '', '', 0, 13, 2);
INSERT INTO menuitem VALUES (17, 'prekiu �enklai', 'prekiuzenklai', 'simple', '', 2, '', '<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=363" target="_blank">diskaunt kard [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=357" target="_blank">aciu man [zigmo zuvys]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=662" target="_blank">zirkles [zigmo zuvys]</a><br>\r\n\r\n<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=546" target="_blank">auka [taupa]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=619" target="_blank">ozka [taupa]</a><br>\r\n<br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=821" target="_blank">tauta [lietuva]</a><br>\r\n\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=863" target="_blank">pachmelovarai [audimas]</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=860" target="_blank">pachmelovarai [audimas]</a><br>\r\n<br>\r\n\r\nshusnis darbu kur tiksliu prekiniu zenklu nezinau (kvepalai ir alkoholis):<br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=857" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=858" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=856" target="_blank">spausk</a><br>\r\n\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=855" target="_blank">spausk</a><br>\r\n<a href="http://art.scene.lt/scripts/hirez_browse.php3?iid=854" target="_blank">spausk</a><br>\r\n', '0', '', '', 1, 1, 5);
INSERT INTO menuitem VALUES (18, 'exportas e-zine''ui', 'ezine', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_top_xml', 1, 13, 100);
INSERT INTO menuitem VALUES (19, 'dalyvio darbai', 'works_user', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 20);
INSERT INTO menuitem VALUES (20, 'labiausiai patik�', 'works_favourites', 'userinfo', '', 5, '', '', '0', '', 'darbai-darbai-show_list', 1, 13, 22);
INSERT INTO menuitem VALUES (21, 'asmenin�s �inut�s', 'usermessages', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_messages', 1, 2, 20);
INSERT INTO menuitem VALUES (22, 'atsakyti � �inut�', 'messagereply', 'userinfo', '', 5, '', '', '0', '', 'users-messages-show_reply_message', 1, 2, 25);
INSERT INTO menuitem VALUES (23, 'blogi laikai', 'badtime', 'simple', '', 2, '', '�iuo metu <b>art.scene</b> kabo ant tako dsl ir greitis yra apgail�tinas. jei kas galit pad�ti perkelti server� prie geresnio interneto ry�io b�tinai para�ykit <a href="mailto:salna@ktl.mii.lt">juozui �alnai (pukomuko)</a>.\r\n<br><br>\r\no kolkas bandome �vairias srauto taupymo priemones, viena i� toki� - paveiksliuk� rodymas tik registruotiems vartotojams. <br><br>\r\ntad jei <b>nori pamatyti darb�</b> ant kurio spaudei - pirmiausia <b>prisijunk</b>.\r\n', '0', '', '', 1, 1, 1);
INSERT INTO menuitem VALUES (24, 'forumai', 'forum', 'simple', '', 5, '', '', '0', '', 'forum-forum', 1, 0, 12);
INSERT INTO menuitem VALUES (25, 'cleanup', 'cleanup', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-daily_cleanup', 1, 13, 1);
INSERT INTO menuitem VALUES (26, 'art.scene.lt', 'address', 'simple', '', 2, '', 'nor��iau priminti, kad art.scenos adresas yra\r\n<h1>http://art.scene.lt</h1>', '0', '', '', 1, 1, 50);
INSERT INTO menuitem VALUES (27, 'testfresh', 'fresh', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_fresh_works', 1, 13, 100);
INSERT INTO menuitem VALUES (28, 'RSS - new', 'rssnew', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new', 1, 13, 50);
INSERT INTO menuitem VALUES (29, 'RSS - user', 'rssuser', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_rss_new_user', 1, 13, 51);
INSERT INTO menuitem VALUES (30, 'statistikos 2004', 'stat2004', 'simple', '', 2, '', 'prie� eidamas � art.scenos gimtadien�, pa�ad�jau �iupsnel� statistik�. bet �kritau � alkoholio li�n� ir neradau tam j�g�. dabar pav�luotai, bet stengiuosi atitaisyti savo klaid�.\r\n<br/><br/>\r\n\r\n<b>bendri skai�iukai</b>\r\n<br/><br/>\r\n�iemet (nuo nauj� met�) i� 2500 u�siregistravusi� dalyvi� prie sistemos prisijung� buvo tik 800. i� t� 800 - 300 prisijungusi� tik �iemet ir prisiregistravo. taigi tikr� senbuvi� turim 500 (aritmetika:)\r\n<br/><br/>\r\n�iemet jau atsiunt�te 300 darb� ir prabalsavot 12000 kart�.\r\n\r\n<br/><br/>\r\n<b>grafik�liai</b>\r\n<br/><br/>\r\n<img src="http://art.scene.lt/news_files/registrantai_bendras.gif"/><br/>\r\nbendro dalyvi� skai�iaus did�jimas. punktyrin� linija rodo tiesin� priklausomyb�. a� pats visus �iuos grafikus matau pirm� kart�. tai �is grafikas man keistokas. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/registrantai.gif"/><br/>\r\n�ia i�pai�yta, kiek b�davo besiregistruojan�i� nauj� dalyvi�, kiekvien� m�nes� atskirai. punktyras - �iaip polinominis �vertis.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekis_bendras.gif"/><br/>\r\n�ia pavaizduota, kaip did�jo bendras darb� kiekis. v�l tiesin� funkcija. dvigubai l�tesn� u� bendr� dalyvi� skai�i�.\r\n<br/><br/>\r\n\r\n\r\n<img src="http://art.scene.lt/news_files/darbu_kiekiai.gif"/><br/>\r\nkiek darb� buvo atsi�sta kiekvien� m�nes� atskirai. dar viso vasario neapdorojo trynimo sistema, tod�l i�lip�s � vir��, bet tendencija vis tiek did�janti.\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/darbai_pagal_sritis.gif"/><br/>\r\n�ia pavaizduotas kiekvienos darb� srities aktyvumas kas m�nes�. m�lyna juosta - bendras darb� skai�ius, kuris matosi ir grafik�lyje auk��iau. \r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_bendras.gif"/><br/>\r\nbendras balsavim� kiekis b�gant laikui. pagaliau radau kreiv�, kurio priklausomyb� netiesin� :)\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/balsai_menuo.gif"/><br/>\r\nkaip vyko balsavimas pagal m�nesius.\r\n\r\n<br/><br/>\r\n\r\n<img src="http://art.scene.lt/news_files/palyginimas.gif"/><br/>\r\natkreipkit d�mes�, kad �io grafik�lio skal� - logaritmin�. �ia lyginamas bendras darb�, balsavim� ir dalyvi� skai�ius. man atrod�, kad darbai*dalyviai kis pana�iai kaip balsavim� skai�ius, bet visai apsirikau :)\r\n<br/></br>\r\n\r\nai�ku, tai neturi nieko bendro su menu, bet, galb�t, kam nors bus �domu. man dar labai �domu b�t� pabandyti i�pai�yti tarpusavio santyki� klasterius, bet tam excelis nepad�s. kadanors v�liau :)\r\n<br/></br>\r\n\r\npukomuko<br/>\r\n2004.03.06', '0', '', '', 1, 1, 4);
INSERT INTO menuitem VALUES (31, 'trinti darb�', 'delete_work', 'index', '', 5, '', '', '0', '', 'darbai-darbai_cleanup-delete_image', 1, 13, 1);
INSERT INTO menuitem VALUES (32, 'tokio vartotojo n�ra', 'nouser', 'simple', '', 2, '', 'pasiklydai arba nesp�jai.', '0', '', '', 1, 13, 3);
INSERT INTO menuitem VALUES (34, '�vie�iai komentuoti darbai', 'freshworks', 'simple', '', 5, '', '', '0', '', 'darbai-darbai_list-show_fresh_works', 1, 13, 15);

-- 
-- Dumping data for table `u_group`
-- 

INSERT INTO u_group VALUES (1, 'Administrators', 'Site administrators (all permissions)', 'admin_menu.html');
INSERT INTO u_group VALUES (2, 'dalyviai', 'eiliniai dalyviai', 'admin_menu.html');
INSERT INTO u_group VALUES (3, 'news admins', 'naujien� administratoriai', 'admin_menu.html');
INSERT INTO u_group VALUES (4, 'deletomiotai', 'trina darbus :]', 'admin_menu.html');
INSERT INTO u_group VALUES (5, 'sekliai morkos', 'cia sedi 17 :)', 'admin_menu.html');
INSERT INTO u_group VALUES (6, 'Balsuotojai', 'bedarbiams balsuotojams', 'menu.html');
INSERT INTO u_group VALUES (7, 'Nebalsuotojai', 'darbingiems nebalsuotojams', 'v');

-- 
-- Dumping data for table `u_module`
-- 

INSERT INTO u_module VALUES (1, 'control', 'Administravimas');
INSERT INTO u_module VALUES (2, 'content', 'Turinio valdymas');
INSERT INTO u_module VALUES (3, 'faq', 'Da�niausiai u�duodami klausimai');
INSERT INTO u_module VALUES (4, 'polls', 'Balsavimo sistema');
INSERT INTO u_module VALUES (6, 'naujienos', 'Naujien� sistema');
INSERT INTO u_module VALUES (7, 'darbai', 'darb� sistema');

-- 
-- Dumping data for table `u_permission`
-- 

INSERT INTO u_permission VALUES (1, 'page_users_list', 'Vartotoj� s�ra�as', 1);
INSERT INTO u_permission VALUES (2, 'page_users_edit', 'Vartotoj� redagavimas', 1);
INSERT INTO u_permission VALUES (3, 'page_users_delete', 'Vartotoj� i�trynimas', 1);
INSERT INTO u_permission VALUES (4, 'page_groups_list', 'Grupi� s�ra�as', 1);
INSERT INTO u_permission VALUES (5, 'page_groups_edit', 'Grupi� redagavimas', 1);
INSERT INTO u_permission VALUES (6, 'page_groups_delete', 'Grupi� i�trynimas', 1);
INSERT INTO u_permission VALUES (7, 'page_modules_list', 'Moduli� s�ra�as', 1);
INSERT INTO u_permission VALUES (8, 'page_modules_edit', 'Moduli� redagavimas', 1);
INSERT INTO u_permission VALUES (9, 'page_modules_delete', 'Moduli� i�trynimas', 1);
INSERT INTO u_permission VALUES (10, 'page_permissions_list', 'Teisi� s�ra�as', 1);
INSERT INTO u_permission VALUES (11, 'page_permissions_edit', 'Teisi� redagavimas', 1);
INSERT INTO u_permission VALUES (12, 'page_permissions_delete', 'Teisi� i�trynimas', 1);
INSERT INTO u_permission VALUES (13, 'ini_edit_view', 'Nustatym� per�i�ra', 1);
INSERT INTO u_permission VALUES (14, 'ini_edit_edit', 'Nustatym� redagavimas', 1);
INSERT INTO u_permission VALUES (15, 'settings_edit', 'Asm. nustatym� redagavimas', 1);
INSERT INTO u_permission VALUES (16, 'avblock_list', 'Blok� s�ra�as', 2);
INSERT INTO u_permission VALUES (17, 'avblock_edit', 'Blok� redagavimas', 2);
INSERT INTO u_permission VALUES (18, 'avblock_delete', 'Blok� i�trynimas', 2);
INSERT INTO u_permission VALUES (19, 'avfaq_list', 'Klausim� s�ra�as', 3);
INSERT INTO u_permission VALUES (20, 'avfaq_edit', 'Klausim� redagavimas', 3);
INSERT INTO u_permission VALUES (21, 'avfaq_delete', 'Klausim� i�trynimas', 3);
INSERT INTO u_permission VALUES (22, 'avpolls_list', 'Apklaus� s�ra�as', 4);
INSERT INTO u_permission VALUES (23, 'avpolls_edit', 'Apklaus� redagavimas', 4);
INSERT INTO u_permission VALUES (24, 'avpolls_delete', 'Apklaus� i�trynimas', 4);
INSERT INTO u_permission VALUES (25, 'avpolls_answers_list', 'Atsakym� s�ra�as', 4);
INSERT INTO u_permission VALUES (26, 'avpolls_answers_edit', 'Atsakym� redagavimas', 4);
INSERT INTO u_permission VALUES (27, 'avpolls_answers_delete', 'Atsakym� i�trynimas', 4);
INSERT INTO u_permission VALUES (28, 'avpolls_questions_list', 'Klausim� s�ra�as', 4);
INSERT INTO u_permission VALUES (29, 'avpolls_questions_edit', 'Klausim� redagavimas', 4);
INSERT INTO u_permission VALUES (30, 'avpolls_questions_delete', 'Klausim� i�trynimas', 4);
INSERT INTO u_permission VALUES (49, 'page_user_log_list', 'Prisijungim� statistika', 1);
INSERT INTO u_permission VALUES (37, 'page_language_list', 'Kalb� s�ra�as', 1);
INSERT INTO u_permission VALUES (38, 'page_language_edit', 'Kalb� redagavimas', 1);
INSERT INTO u_permission VALUES (39, 'page_language_delete', 'Kalb� i�trynimas', 1);
INSERT INTO u_permission VALUES (40, 'avnews_list', 'Naujien� s�ra�as', 6);
INSERT INTO u_permission VALUES (41, 'avnews_edit', 'Naujien� redagavimas', 6);
INSERT INTO u_permission VALUES (42, 'avnews_delete', 'Naujien� i�trynimas', 6);
INSERT INTO u_permission VALUES (43, 'avmenuitem_list', 'Strukt�ros per�i�ra', 2);
INSERT INTO u_permission VALUES (44, 'avmenuitem_edit', 'Strukt�ros redagavimas', 2);
INSERT INTO u_permission VALUES (45, 'avmenuitem_delete', 'Strukt�ros i�trynimas', 2);
INSERT INTO u_permission VALUES (46, 'avfeedback_list', 'U�klaus� s�ra�as', 3);
INSERT INTO u_permission VALUES (47, 'avfeedback_edit', 'U�klaus� redagavimas', 3);
INSERT INTO u_permission VALUES (48, 'avfeedback_delete', 'U�klaus� i�trynimas', 3);
INSERT INTO u_permission VALUES (51, 'avnewscategory_list', 'Naujien� kategorijos', 6);
INSERT INTO u_permission VALUES (52, 'avnewscategory_edit', 'Kategorij� redagavimas', 6);
INSERT INTO u_permission VALUES (53, 'avnewscategory_delete', 'Kategorij� i�trynimas', 6);
INSERT INTO u_permission VALUES (54, 'avnews_auth', 'Naujien� autorizacija', 6);
INSERT INTO u_permission VALUES (55, 'avnews_new', 'Nauja naujiena', 6);
INSERT INTO u_permission VALUES (56, 'avcomments_list', 'Komentar� per�i�ra', 6);
INSERT INTO u_permission VALUES (57, 'avcomments_edit', 'Komentar� redagavimas', 6);
INSERT INTO u_permission VALUES (58, 'avcomments_delete', 'Komentar� trynimas', 6);
INSERT INTO u_permission VALUES (59, 'avworkcategory_list', 'darb� kategorij� s�ra�as', 7);
INSERT INTO u_permission VALUES (60, 'avworkcategory_edit', 'darb� kategorij� redagavimas', 7);
INSERT INTO u_permission VALUES (61, 'avworkcategory_delete', 'darb� kategorij� �alinimas', 7);
INSERT INTO u_permission VALUES (62, 'avworks_list', 'Darb� s�ra�as', 7);
INSERT INTO u_permission VALUES (63, 'avworks_edit', 'Darb� redagavimas', 7);
INSERT INTO u_permission VALUES (64, 'avworks_delete', 'Darb� �alinimas', 7);
INSERT INTO u_permission VALUES (65, 'avworks_delete_log_list', 'Darb� trynimo logo per�i�ra', 7);

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
