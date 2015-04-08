DROP TABLE IF EXISTS `ED`.`Canadian`;
CREATE TABLE  `ED`.`Canadian` (
  `key_ID` bigint(10) unsigned NOT NULL auto_increment,
  `Diagnosis` tinytext NOT NULL,
  `Code` tinytext NOT NULL,
  PRIMARY KEY  (`key_ID`)
) TYPE=MyISAM;