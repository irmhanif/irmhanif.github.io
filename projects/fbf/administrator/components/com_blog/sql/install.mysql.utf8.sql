CREATE TABLE IF NOT EXISTS `#__blog_france` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`tittle` VARCHAR(255)  NOT NULL ,
`category` VARCHAR(255)  NOT NULL ,
`short_description` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`blog_image` TEXT NOT NULL ,
`adding_date` DATE NOT NULL ,
`banner` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

