# WIP
SELECT DISTINCT COUNT(p_u_tagged_t.id) as `total`, `title`, p_tag.id as 'id'
FROM `p_u_tagged_t`
INNER JOIN `p_tag` on (p_tag.id = p_u_tagged_t.p_tag_id)
WHERE
`p_t_tag_type_id` = 2
GROUP BY p_tag.id
ORDER BY `total` desc

# à affiner pour sortir les top tags associé à une op, ie. systématiquement associé à un tag précis > req sur p_d_debate?