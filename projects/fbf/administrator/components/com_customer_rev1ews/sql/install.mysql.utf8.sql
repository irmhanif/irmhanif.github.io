CREATE TABLE IF NOT EXISTS `#__customer_rev1ews` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`uid` INT NOT NULL ,
`reviewvalue` VARCHAR(255)  NOT NULL ,
`reviewtext` TEXT NOT NULL ,
`image` TEXT NOT NULL ,
`tittle` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

