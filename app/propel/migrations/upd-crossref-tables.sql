DELETE FROM `p_u_subscribe_p_n_e`
WHERE `id` IN (SELECT * 
             FROM (SELECT `id` FROM `p_u_subscribe_p_n_e` 
                   GROUP BY p_user_id, p_n_email_id HAVING (COUNT(*) > 1)
                  ) AS A
            );

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `p_u_subscribe_p_n_e` DROP `id`, ADD PRIMARY KEY(`p_user_id`,`p_n_email_id`);
SET FOREIGN_KEY_CHECKS = 1;


DELETE FROM `p_u_current_q_o`
WHERE `id` IN (SELECT * 
             FROM (SELECT `id` FROM `p_u_current_q_o` 
                   GROUP BY p_user_id, p_q_organization_id HAVING (COUNT(*) > 1)
                  ) AS A
            );

SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `p_u_current_q_o` DROP `id`, ADD PRIMARY KEY(`p_user_id`,`p_q_organization_id`);
SET FOREIGN_KEY_CHECKS = 1;


