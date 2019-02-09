# Purge des exceptions sans user id
DELETE FROM `p_m_app_exception`
WHERE p_user_id is NULL;

# Purge des emails dans p_m_emailing
DELETE FROM `p_m_emailing`;