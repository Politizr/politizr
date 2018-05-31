SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM `p_u_subscribe_p_n_e`
WHERE `id` IN (SELECT * 
             FROM (SELECT `id` FROM `p_u_subscribe_p_n_e` 
                   GROUP BY p_user_id, p_n_email_id HAVING (COUNT(*) > 1)
                  ) AS A
            );

ALTER TABLE `p_u_subscribe_p_n_e` DROP `id`, ADD PRIMARY KEY(`p_user_id`,`p_n_email_id`);


DELETE FROM `p_u_current_q_o`
WHERE `id` IN (SELECT * 
             FROM (SELECT `id` FROM `p_u_current_q_o` 
                   GROUP BY p_user_id, p_q_organization_id HAVING (COUNT(*) > 1)
                  ) AS A
            );

ALTER TABLE `p_u_current_q_o` DROP `id`, ADD PRIMARY KEY(`p_user_id`,`p_q_organization_id`);

DROP INDEX `p_u_current_q_o_FI_1` ON `p_u_current_q_o`;

DROP INDEX `p_u_subscribe_p_n_e_FI_1` ON `p_u_subscribe_p_n_e`;

SET FOREIGN_KEY_CHECKS = 1;
