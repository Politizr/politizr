# Suppression des notifs mails pour tous les emails
DELETE FROM `p_u_subscribe_p_n_e`
WHERE `p_user_id` IN 
(
    SELECT `id` 
    FROM `p_user`
    WHERE email IN ('lulupeace@hotmail.fr')
)