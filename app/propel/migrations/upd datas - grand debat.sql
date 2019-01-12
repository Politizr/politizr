# Insertion dans p_c_group_l_c de toutes les villes de France
INSERT INTO `p_c_group_l_c` (`p_circle_id`, `p_l_city_id`, `created_at`, `updated_at`)
SELECT 7, `id`, NOW(), NOW() FROM `p_l_city`;

# Inscription de tous les utilisateurs existants
INSERT INTO `p_u_in_p_c` (`p_circle_id`, `p_user_id`, `created_at`, `updated_at`)
SELECT 7, `id`, NOW(), NOW()
FROM `p_user`;

# MAJ des droits
UPDATE `p_user` SET `roles` = REPLACE(`roles`, ' ROLE_CIRCLE_7 |', '');

UPDATE `p_user` SET `roles` = CONCAT(`roles`, ' ROLE_CIRCLE_7 |'), `updated_at` = NOW();

# Mise en ligne du group et de ses thématiques
UPDATE `p_circle` SET `online` = 1 WHERE `id` = 7;

UPDATE `p_c_topic` SET `online` = 1 WHERE `p_circle_id` = 7;
