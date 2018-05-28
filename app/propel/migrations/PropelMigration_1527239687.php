<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1527239687.
 * Generated on 2018-05-25 11:14:47 by lionel
 */
class PropelMigration_1527239687
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

DROP TABLE IF EXISTS `p_u_affinity_q_o`;

DROP INDEX `p_u_current_q_o_FI_1` ON `p_u_current_q_o`;

DROP INDEX `p_u_subscribe_p_n_e_FI_1` ON `p_u_subscribe_p_n_e`;

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

DROP INDEX `acl_object_identity_ancestors_I_2` ON `acl_object_identity_ancestors`;

CREATE INDEX `p_u_current_q_o_FI_1` ON `p_u_current_q_o` (`p_user_id`);

CREATE INDEX `p_u_subscribe_p_n_e_FI_1` ON `p_u_subscribe_p_n_e` (`p_user_id`);

CREATE TABLE `p_u_affinity_q_o`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `p_user_id` INTEGER NOT NULL,
    `p_q_organization_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `p_u_affinity_q_o_FI_1` (`p_user_id`),
    INDEX `p_u_affinity_q_o_FI_2` (`p_q_organization_id`),
    CONSTRAINT `p_u_affinity_q_o_FK_1`
        FOREIGN KEY (`p_user_id`)
        REFERENCES `p_user` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `p_u_affinity_q_o_FK_2`
        FOREIGN KEY (`p_q_organization_id`)
        REFERENCES `p_q_organization` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}