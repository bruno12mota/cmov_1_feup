DROP TABLE IF EXISTS tickets;
CREATE TABLE IF NOT EXISTS tickets(
	'ticket_id' bigint(20) unsigned NOT NULL AUTO_INCREMENT,	
	'type' varchar(2) NOT NULL DEFAULT 'T1',  
	'validated' boolean DEFAULT 0,	
	'validation_date' datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

	PRIMARY KEY ('ticket_id')
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
	'user_id' bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	'name' varchar(255) NOT NULL DEFAULT '',
	'username' varchar(255) NOT NULL DEFAULT '',
	'password' varchar(64) NOT NULL DEFAULT '',
	
	'card_type' varchar(255) NOT NULL DEFAULT '',
	'card_number' varchar(255) NOT NULL DEFAULT '',
	'card_validity' varchar(3) NOT NULL DEFAULT '',

	PRIMARY KEY ('ticket_id')
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS bus;
CREATE TABLE IF NOT EXISTS bus(

) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


