# Insertion dans p_c_group_l_c de toutes les villes d'ariège
INSERT INTO `p_c_group_l_c` (`p_circle_id`, `p_l_city_id`, `created_at`, `updated_at`)
SELECT 2, `id`, NOW(), NOW() FROM `p_l_city`;