DROP TABLE IF EXISTS rex_rexpixel;

CREATE TABLE IF NOT EXISTS rex_rexpixel (
  `id` 				         int(10) unsigned NOT NULL auto_increment,
  `anaus`              varchar(255) default NULL, 
  `sichtbarkeit`       varchar(255) default NULL, 
  `layeraktiv`         varchar(255) default NULL, 
  `images` 			       text default NULL, 
  `aktivesbild`        varchar(255) default NULL,  
  `aktivesbildhoehe`   varchar(255) default NULL,  
  `opacity` 		       int(10) default NULL,
  `posleft` 		       int(20) default NULL,
  `postop` 			       int(20) default NULL,
  `openclose` 	       varchar(255) default NULL,  
  `zindex`			       varchar(255) default NULL,
  `layoutpos`		       varchar(255) default NULL,
  `posleft_img`        int(20) default NULL,
  `postop_img`         int(20) default NULL,

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO rex_rexpixel
VALUES (1,'an','eingeloggte','aktiv','rex_pixel_default.jpg','rex_pixel_default.jpg','768','50','10','10','open','drueber','center',NULL,NULL);
