INSERT INTO `p_user` (`p_u_status_id`, `organization`, `validated`, `online`, `p_l_city_id`, `biography`, `username`, `username_canonical`, `email`, `email_canonical`, `salt`, `password`, `firstname`, `name`, `qualified`, `created_at`, `updated_at`, `last_login`, `last_activity`, `roles`, `slug`) 
VALUES (1, 1, 1, 1, 3071, 'Direction de la Communication du Conseil Départemental de l\'Ariège', 'nhubert@cd09.fr', 'nhubert@cd09.fr', 'nhubert@cd09.fr', 'nhubert@cd09.fr', 'rdk0ar29ccgwos8k8kwwcccwg40ggw8', 'QI+YfdeJCF+r+d8VvxKnVBLyyojwjgx5TOfbLmdOBsWrtR90S9lx44vbDyedy4C5YY73J8jTBncPWKmikTI4/Q==', 'Conseil Départemental', 'Ariège', 0, '2018-05-11 14:03:18', '2018-05-11 14:03:18', '2018-05-11 14:20:48', '2018-05-11 14:20:48', '| ROLE_CITIZEN | ROLE_PROFILE_COMPLETED | ROLE_CIRCLE_1 | ROLE_CIRCLE_3 |', 'conseil-departemental-ariege');

# app/console politizr:uuids:populate PUser
# @todo admin > reput +150

# last id > cf https://dev.mysql.com/doc/refman/8.0/en/information-functions.html#function_last-insert-id 

SET @user_id = LAST_INSERT_ID();

# Insertion dans p_u_reaction_p_l_c de toutes les villes d'ariège pour ce compte
INSERT INTO `p_u_reaction_p_l_c` (`p_user_id`, `p_l_city_id`, `created_at`, `updated_at`)
SELECT @user_id, `id`, NOW(), NOW() FROM `p_l_city` WHERE `p_l_department_id` = 9;
