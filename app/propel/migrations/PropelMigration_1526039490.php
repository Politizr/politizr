<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1526039490.
 * Generated on 2018-05-11 13:51:30 by lionel
 */
class PropelMigration_1526039490
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `p_user`
    ADD `organization` TINYINT(1) DEFAULT 0 AFTER `nb_views`;

ALTER TABLE `p_user_archive`
    ADD `organization` TINYINT(1) DEFAULT 0 AFTER `nb_views`;

CREATE TABLE `p_u_reaction_p_l_c`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `p_l_city_id` INTEGER NOT NULL,
    `p_user_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `p_u_reaction_p_l_c_FI_1` (`p_l_city_id`),
    INDEX `p_u_reaction_p_l_c_FI_2` (`p_user_id`),
    CONSTRAINT `p_u_reaction_p_l_c_FK_1`
        FOREIGN KEY (`p_l_city_id`)
        REFERENCES `p_l_city` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `p_u_reaction_p_l_c_FK_2`
        FOREIGN KEY (`p_user_id`)
        REFERENCES `p_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `p_u_reaction_p_l_c`;

DROP INDEX `acl_object_identity_ancestors_I_2` ON `acl_object_identity_ancestors`;

ALTER TABLE `p_user` DROP `organization`;

ALTER TABLE `p_user_archive` DROP `organization`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}