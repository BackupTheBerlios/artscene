--2006 04 04
ALTER TABLE `u_users` 
	ADD `del_works_admin` INT UNSIGNED NOT NULL DEFAULT '0',
	ADD `del_works_system` INT UNSIGNED NOT NULL DEFAULT '0';