# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- opengraph_data
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `opengraph_data`;

CREATE TABLE `opengraph_data`
(
    `id` INTEGER NOT NULL,
    `company_name` VARCHAR(255),
    `twitter_company_name` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
