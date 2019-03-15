# UPD DEBATE TO FRANCE
UPDATE `p_d_debate`
SET p_l_country_id = 1,
 p_l_city_id = NULL,
 p_l_department_id = NULL,
 p_l_region_id = NULL
WHERE p_c_topic_id IN (16, 17, 18, 19, 20, 21, 22, 23, 24, 25);

# UPD REACTION TO FRANCE
UPDATE `p_d_reaction`
SET p_l_country_id = 1,
 p_l_city_id = NULL,
 p_l_department_id = NULL,
 p_l_region_id = NULL
WHERE p_c_topic_id IN (16, 17, 18, 19, 20, 21, 22, 23, 24, 25);
