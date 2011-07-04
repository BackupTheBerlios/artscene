UPDATE u_users
	SET 
		password = '8d3de004fbeedb4a7f810db8b25982b8',
		email = 'nera',
		lasthost = 'nera',
		forgotten_pass = '', 
		auto_login = ''
;


INSERT INTO avworks_stat (subject, work_id)
	SELECT subject, id
	FROM avworks;

UPDATE avworks_stat st, avworks w
	SET st.submiter = w.submiter
	WHERE st.work_id = w.id;
		
INSERT INTO u_user_info (uid) 
	SELECT u_users.id
	FROM u_users;
	
	
ALTER TABLE `u_user_info` ADD UNIQUE  `uid` (  `uid` );

