CREATE TABLE IF NOT EXISTS `#__customized_trip` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`trip_tittle` VARCHAR(255)  NOT NULL ,
`picture` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`tittle_link1` VARCHAR(255)  NOT NULL ,
`link_to_blog1` VARCHAR(255)  NOT NULL ,
`tittle_link2` VARCHAR(255)  NOT NULL ,
`link_to_blog2` VARCHAR(255)  NOT NULL ,
`tittle_link3` VARCHAR(255)  NOT NULL ,
`link_to_blog3` VARCHAR(255)  NOT NULL ,
`tittle_link4` VARCHAR(255)  NOT NULL ,
`link_to_blog4` VARCHAR(255)  NOT NULL ,
`flight` VARCHAR(255)  NOT NULL ,
`keeper` VARCHAR(255)  NOT NULL ,
`trnasport` VARCHAR(255)  NOT NULL ,
`placeofdeparture` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

