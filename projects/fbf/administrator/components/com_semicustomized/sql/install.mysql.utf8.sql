CREATE TABLE IF NOT EXISTS `#__semicustomized_plan` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`reference` VARCHAR(255)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`hoteltitle1` VARCHAR(255)  NOT NULL ,
`hotelprice1` VARCHAR(255)  NOT NULL ,
`extraroom1` VARCHAR(255)  NOT NULL ,
`maxroomcapacity` VARCHAR(255)  NOT NULL ,
`hoteltitle2` VARCHAR(255)  NOT NULL ,
`priceperroom2` VARCHAR(255)  NOT NULL ,
`extraroom2` VARCHAR(255)  NOT NULL ,
`maxroomcapacity2` VARCHAR(255)  NOT NULL ,
`hoteltitle3` VARCHAR(255)  NOT NULL ,
`priceperroom3` VARCHAR(255)  NOT NULL ,
`extraroom3` VARCHAR(255)  NOT NULL ,
`maxroomcapacity3` VARCHAR(255)  NOT NULL ,
`transportpricel1` VARCHAR(255)  NOT NULL ,
`transportcapacity1` VARCHAR(255)  NOT NULL ,
`transportprice2` VARCHAR(255)  NOT NULL ,
`transportcapacity2` VARCHAR(255)  NOT NULL ,
`transportprice3` VARCHAR(255)  NOT NULL ,
`transportcapacity3` VARCHAR(255)  NOT NULL ,
`transportprice4` VARCHAR(255)  NOT NULL ,
`transportcapacity4` VARCHAR(255)  NOT NULL ,
`keeperprice1` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

