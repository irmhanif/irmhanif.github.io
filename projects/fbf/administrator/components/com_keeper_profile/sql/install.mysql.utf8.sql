CREATE TABLE IF NOT EXISTS `#__keeper_profile` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`keeper_name` VARCHAR(255)  NOT NULL ,
`keeper_image` TEXT NOT NULL ,
`keeper_short_des` TEXT NOT NULL ,
`keeper_detail_des` TEXT NOT NULL ,
`keeper_contact` VARCHAR(255)  NOT NULL ,
`keeper_location` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

