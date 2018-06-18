INSERT INTO `p_e_operation` (`id`, `title`, `description`, `geo_scoped`, `online`, `timeline`, `new_subject_link`, `created_at`, `updated_at`, `slug`) 
VALUES (25, 'CD09 - Plan Ariège THD', '
<h1>Le déploiement du Très Haut Débit en Ariège, c\'est parti!</h1>
<p>Exprimez-vous et/ou posez vos questions sur ce sujet!</p>
<p><span><a class="ctaOp" href="/-w/sujet/nouveau?topic=10c1d126-722e-4533-b807-c439b487116d">Je m\'exprime</a></span></p>
    ', 1, 1, 1, 0, '2018-06-08 16:56:39', '2018-06-08 16:56:39', 'cd09-plan-ariege-thd');

# app/console politizr:uuids:populate PEOperation


INSERT INTO `p_e_o_scope_p_l_c` (`p_e_operation_id`, `p_l_city_id`, `created_at`, `updated_at`)
SELECT 25, `id`, NOW(), NOW()
FROM `p_l_city`
WHERE `p_l_department_id` = 9
;