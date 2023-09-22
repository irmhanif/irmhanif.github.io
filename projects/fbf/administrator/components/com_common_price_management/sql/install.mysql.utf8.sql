CREATE TABLE IF NOT EXISTS `#__common_price_management` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`gst` VARCHAR(255)  NOT NULL ,
`f_firt_installment` INT NOT NULL ,
`f_first_inst_date` INT NOT NULL ,
`f_final_installment` INT NOT NULL ,
`f_final_inst_date` INT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;

