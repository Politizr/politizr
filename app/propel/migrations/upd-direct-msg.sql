# UPD USER TO ONLINE
UPDATE `p_user`
SET online = 1,
p_u_status_id = 1
WHERE online = 0 
AND roles LIKE '%ROLE_PROFILE_COMPLETED%'
AND (banned = 0 OR banned is null);

# UPD DEBATE TO SET OP
UPDATE `p_d_debate`
SET `online`=1,
# `p_e_operation_id`=28,
`published`=0,
`updated_at`= NOW(),
`p_l_country_id` = 1,
`description` = CONCAT('<p>', description, '</p>')
WHERE p_d_debate.title = 'MESSAGE DIRECT'
AND p_d_debate.created_at > '2019-03-03 16:30:00';

# PLUG TAG 1126 > @todo > only where published = false
# DELETE `p_d_d_tagged_t`
# FROM `p_d_d_tagged_t`
# INNER JOIN `p_d_debate` ON p_d_d_tagged_t.p_d_debate_id = p_d_debate.id
# WHERE p_d_debate.title = 'MESSAGE DIRECT'
# AND p_d_debate.created_at > '2019-03-03 16:30:00';
# 
# INSERT INTO `p_d_d_tagged_t` (p_tag_id, p_d_debate_id)
# SELECT 1126, id FROM `p_d_debate`
# WHERE p_d_debate.title = 'MESSAGE DIRECT'
# AND p_d_debate.created_at > '2019-03-03 16:30:00';
# 