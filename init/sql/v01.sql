CREATE TABLE IF NOT EXISTS `User` (
	`user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(50) NOT NULL,
	`login` VARCHAR(16) NOT NULL,
	`password` VARCHAR(128) NOT NULL,
	`ts_seen` INT(11),
	`is_active` TINYINT(1) DEFAULT 0,
	`is_removed` TINYINT(1) DEFAULT 0,

	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `UserSession` (
	'usersession_id' INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`ts` INT(11),
	`hash` VARCHAR(140),
	`data` VARCHAR(512),

	PRIMARY KEY (`usersession_id`),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `UserACL` (
	`user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`role` VARCHAR(50),

	PRIMARY KEY (`user_id`),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `ACLRoles` (
	`role` VARCHAR(20) NOT NULL UNIQUE,
	`parent` VARCHAR(62) DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `ACLActions` (
	`role` VARCHAR(20) NOT NULL,
	`action` VARCHAR(30) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `List` (
	`list_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`user_dest` INT UNSIGNED,
	`ts` INT(11) NOT NULL,
	`type` INT,
	`name` VARCHAR(140),
	`note` VARCHAR(140),

	PRIMARY KEY (`list_id`),
	FOREIGN KEY (`user_dest`) REFERENCES `User`(`user_id`),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `Elem` (
	`elem_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`list_id` INT UNSIGNED NOT NULL,
	`content` TEXT NOT NULL,
	`ts` INT(11) NOT NULL,
	`is_read` TINYINT(1) DEFAULT 0,
	`note` VARCHAR(140),

	PRIMARY KEY (`elem_id`),
	FOREIGN KEY (`list_id`) REFERENCES `List`(`list_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `Ping` (
	`ping_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED,
	`user_dest` INT UNSIGNED,
	`list_id` INT UNSIGNED,
	`elem_id` INT UNSIGNED,
	`ts` INT(11) NOT NULL,
	`note` VARCHAR(140),

	PRIMARY KEY (`ping_id`)
) ENGINE=InnoDB;
