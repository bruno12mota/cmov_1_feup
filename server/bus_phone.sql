DROP TABLE IF EXISTS tickets;
CREATE TABLE IF NOT EXISTS tickets(
	`ticket_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,	
	`type` varchar(2) NOT NULL DEFAULT 'T1',  
	`validated` boolean DEFAULT 0,	
	`validation_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`bus_id` bigint(20) unsigned DEFAULT 0,

	PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO tickets (`type`) VALUES
('T1'),
('T1'),
('T1'),
('T2'),
('T2'),
('T3'),
('T3'),
('T3'),
('T3');


DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
	`user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL DEFAULT '',
	`email` varchar(255) NOT NULL DEFAULT '',
	`password` varchar(64) NOT NULL DEFAULT '',
	
	`card_type` varchar(255) NOT NULL DEFAULT '',
	`card_number` varchar(255) NOT NULL DEFAULT '',
	`card_validity` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

	PRIMARY KEY (`user_id`),
	UNIQUE (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO users (`name`, `email`, `password`, `card_type`, `card_number`, `card_validity`) VALUES
('Bruno', 'bruno@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '123', '123', '123'),
('Edgar', 'edgar@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '123', '123', '123');


DROP TABLE IF EXISTS users_tickets;
CREATE TABLE IF NOT EXISTS users_tickets(
	`user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
	`ticket_id` bigint(20) unsigned NOT NULL DEFAULT '0',

  	PRIMARY KEY (`user_id`,`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

INSERT INTO users_tickets (`user_id`, `ticket_id`) VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('2', '5');



DROP TABLE IF EXISTS bus;
CREATE TABLE IF NOT EXISTS bus(
	`bus_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`bus_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO bus (`bus_id`) VALUES
('1'),
('2');