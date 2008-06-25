CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL auto_increment,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
