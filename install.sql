DROP TABLE IF EXISTS rex_rexpixel;

CREATE TABLE IF NOT EXISTS rex_rexpixel (
  `id` 				int(10) unsigned NOT NULL auto_increment,
  `images` 			text default NULL,
  `aktivesbild` 	varchar(255) default NULL,  
  `opacity` 		int(10) default NULL,
  `posleft` 		int(20) default NULL,
  `postop` 			int(20) default NULL,  
  `openclose` 		varchar(255) default NULL,  
  `zindex`			varchar(255) default NULL,   
  `layoutpos`		varchar(255) default NULL,     

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO rex_rexpixel
VALUES (1,'rex_pixel_default.jpg','','50','10','10','open','drunter','center');
