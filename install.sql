DROP TABLE IF EXISTS rex_rexpixel;

CREATE TABLE IF NOT EXISTS rex_rexpixel (
  `id` 			int(10) unsigned NOT NULL auto_increment,
  `images` 		text default NULL,
  `opacity` 	varchar(255) default NULL,
  `posleft` 	varchar(255) default NULL,
  `postop` 		varchar(255) default NULL,  
  `openclose` 	varchar(255) default NULL,  
  `zindex`		varchar(255) default NULL,    

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO rex_rexpixel
VALUES (1,'default.jpg','50','10','10','open','drunter');
