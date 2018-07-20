<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1532095596.
 * Generated on 2018-07-20 16:06:36 by lionel
 */
class PropelMigration_1532095596
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

ALTER TABLE `p_user` CHANGE `website` `website` VARCHAR(250);

ALTER TABLE `p_user` CHANGE `twitter` `twitter` VARCHAR(250);

ALTER TABLE `p_user` CHANGE `facebook` `facebook` VARCHAR(250);

ALTER TABLE `p_user_archive` CHANGE `website` `website` VARCHAR(250);

ALTER TABLE `p_user_archive` CHANGE `twitter` `twitter` VARCHAR(250);

ALTER TABLE `p_user_archive` CHANGE `facebook` `facebook` VARCHAR(250);

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

ALTER TABLE `p_user` CHANGE `website` `website` VARCHAR(150);

ALTER TABLE `p_user` CHANGE `twitter` `twitter` VARCHAR(150);

ALTER TABLE `p_user` CHANGE `facebook` `facebook` VARCHAR(150);

ALTER TABLE `p_user_archive` CHANGE `website` `website` VARCHAR(150);

ALTER TABLE `p_user_archive` CHANGE `twitter` `twitter` VARCHAR(150);

ALTER TABLE `p_user_archive` CHANGE `facebook` `facebook` VARCHAR(150);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}