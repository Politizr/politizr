# move publication to online topic
UPDATE `p_d_debate`
SET p_c_topic_id = 17
WHERE p_c_topic_id = 21;

UPDATE `p_d_reaction`
SET p_c_topic_id = 17
WHERE p_c_topic_id = 21;