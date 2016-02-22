#  Débats publiés
( SELECT p_d_debate.id as id, p_d_debate.title as title, p_d_debate.note_pos as note_pos, p_d_debate.note_neg as note_neg, p_d_debate.published_at as published_at, 'Politizr\\Model\\PDDebate' as type
FROM p_d_debate
    LEFT JOIN p_d_d_tagged_t
        ON p_d_debate.id = p_d_d_tagged_t.p_d_debate_id
WHERE
    p_d_debate.published = 1
    AND p_d_debate.online = 1 
    AND p_d_d_tagged_t.p_tag_id IN (8, 31)
    AND p_d_debate.published_at BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() 
    )

UNION DISTINCT

#  Réactions publiés
( SELECT p_d_reaction.id as id, p_d_reaction.title as title, p_d_reaction.note_pos as note_pos, p_d_reaction.note_neg as note_neg, p_d_reaction.published_at as published_at, 'Politizr\\Model\\PDReaction' as type
FROM p_d_reaction
    LEFT JOIN p_d_r_tagged_t
        ON p_d_reaction.id = p_d_r_tagged_t.p_d_reaction_id
WHERE
    p_d_reaction.published = 1
    AND p_d_reaction.online = 1
    AND p_d_reaction.tree_level > 0
    AND p_d_r_tagged_t.p_tag_id IN (8, 31)
    AND p_d_reaction.published_at BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() 
    )

ORDER BY note_pos DESC, note_neg ASC