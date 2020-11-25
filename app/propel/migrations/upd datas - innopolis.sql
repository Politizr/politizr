# MAJ du propriétaire
INSERT INTO `p_c_owner` (`id`, `uuid`, `title`, `summary`, `description`, `created_at`, `updated_at`, `slug`) VALUES
(5, '848e728e-17ca-47fd-9ea5-ef962b326061', 'Innopolis Expo',   NULL,   NULL,   '2020-11-18 14:22:45',  '2020-11-18 14:22:45',  'innopolis-expo-5fb520256a6e9');


# MAJ de la consultation
INSERT INTO `p_circle` (`id`, `uuid`, `p_c_owner_id`, `p_circle_type_id`, `title`, `summary`, `description`, `logo_file_name`, `url`, `online`, `read_only`, `only_elected`, `public_circle`, `open_reaction`, `created_at`, `updated_at`, `slug`, `sortable_rank`) VALUES
(10,    'b11040ae-61a4-473e-913d-63871f7a4186', 5,  4,  'Quelle \"Smart City\" voulons-nous ?', NULL,   '<div class=\"grpGlobalIntroBigArticle width60\">\r\n    <h1>La SmartCity, kesako ?!</h1>\r\n    <p>\r\n        Lorem Ipsum...\r\n   </p>\r\n    <i>— L\'équipe INNOPOLIS</i>\r\n    </p>\r\n</div>\r\n<div class=\"grpGlobalIntroSmallArticles width40\">\r\n    <div class=\"darkBG\">\r\n        <p>\r\n        POLITIZR, c’est une équipe de 3 personnes qui travaillent de façon bénévole sur la démocratie participative et numérique depuis 2015. Nous souhaitons conserver un service gratuit et sans publicités mais le développement et la maintenance de nos services ont un coût... Contribuez à notre développement pour maintenir un service gratuit et de qualité! Je finance POLITIZR pour le prix d\'un...\r\n        </p>\r\n        <form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">\r\n        <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">\r\n        <input type=\"hidden\" name=\"hosted_button_id\" value=\"NSTX8A9KDW8GJ\">\r\n        <table>\r\n        <tbody><tr><td><select name=\"os0\">\r\n            <option value=\"Cafe\">Café Long €2,40 EUR</option>\r\n            <option value=\"Sandwich\">Sandwich €6,00 EUR</option>\r\n            <option value=\"Livre de poche\">Livre de poche €12,00 EUR</option>\r\n        </select> </td></tr>\r\n        </tbody></table>\r\n        <input type=\"hidden\" name=\"currency_code\" value=\"EUR\">\r\n        <input type=\"image\" src=\"https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_buynowCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal, le réflexe sécurité pour payer en ligne\">\r\n        </form>\r\n    </div>\r\n    <h2>Votre participation valorisée</h2>\r\n    <p>INNOPOLIS reprendra les meilleurs contributions / questions pour les discuter lors de la plénière qui sera organisé etc..</p>\r\n    <p>\r\n        &nbsp;\r\n    </p>\r\n</div>',  'c6e1a7fec4d68a1a812b5a7e2a046004.png', NULL,   1,  0,  0,  1,  0,  '2020-11-18 14:26:10',  '2020-11-18 15:49:31',  'quelle-smart-city-voulons-nous-5fb520f274755', 1);


# MAJ des thématiques
INSERT INTO `p_c_topic` (`id`, `uuid`, `p_circle_id`, `title`, `summary`, `description`, `file_name`, `online`, `force_geoloc_type`, `force_geoloc_id`, `created_at`, `updated_at`, `slug`, `sortable_rank`) VALUES
(30,    '80e9ce92-3b09-461e-863e-0cbbf5f78a0a', 10, 'Que faire pour être éco-citoyen ?',    '<h1>Que faire pour être éco-citoyen ?</h1>',   '<div class=\"grpBriefCenter\">\r\n    <div class=\"grpBriefParagraph\">\r\n\r\n    <h1>Proposez vos idées</h1>\r\n    <ul>\r\n        <li>...</li>\r\n    </ul>\r\n\r\n    <p>\r\n        <br><br>\r\n                <i><b>Et tous les sujets qu\'ils vous semblent importants d\'aborder ici...</b></i>\r\n    </p>\r\n    </div>\r\n</div>',    '07fb65b78da4dc9eccecdeb99cef8cd7.jpeg',    1,  NULL,   NULL,   '2020-11-18 15:07:18',  '2020-11-18 16:10:39',  'que-faire-pour-etre-eco-citoyen-5fb52a9691b9e',    1),
(31,    '035724ed-b565-4684-8f86-5b8c305b8285', 10, 'Qu\'est-ce qu\'une Smart City réussie ?',  '<h1>Qu\'est-ce qu\'une Smart City réussie ?</h1>', '<div class=\"grpBriefCenter\">\r\n    <div class=\"grpBriefParagraph\">\r\n\r\n    <h1>Proposez vos idées</h1>\r\n    <ul>\r\n        <li>...</li>\r\n    </ul>\r\n\r\n    <p>\r\n        <br><br>\r\n                <i><b>Et tous les sujets qu\'ils vous semblent importants d\'aborder ici...</b></i>\r\n    </p>\r\n    </div>\r\n</div>',    'dff9e0dd82884d8de849d8287d6881fb.jpeg',    1,  NULL,   NULL,   '2020-11-18 15:52:02',  '2020-11-18 16:11:26',  'qu-est-ce-qu-une-smart-city-reussie-5fb5351205ce2',    2),
(32,    '75c0cfa1-1971-482e-a639-2d862a4673f0', 10, 'Le numérique, pourquoi faire ?',   '<h1>Le numérique, pourquoi faire ?</h1>',  '<div class=\"grpBriefCenter\">\r\n    <div class=\"grpBriefParagraph\">\r\n\r\n    <h1>Proposez vos idées</h1>\r\n    <ul>\r\n        <li>...</li>\r\n    </ul>\r\n\r\n    <p>\r\n        <br><br>\r\n                <i><b>Et tous les sujets qu\'ils vous semblent importants d\'aborder ici...</b></i>\r\n    </p>\r\n    </div>\r\n</div>',    '115ade3d2a1194cf94f12441ee235797.jpeg',    1,  NULL,   NULL,   '2020-11-18 15:59:19',  '2020-11-18 16:12:00',  'le-numerique-pourquoi-faire-5fb536c749c0c',    3);



# Insertion dans p_c_group_l_c de toutes les villes de France
INSERT INTO `p_c_group_l_c` (`p_circle_id`, `p_l_city_id`, `created_at`, `updated_at`)
SELECT 10, `id`, NOW(), NOW() FROM `p_l_city`;

# Inscription de tous les utilisateurs existants
INSERT INTO `p_u_in_p_c` (`p_circle_id`, `p_user_id`, `created_at`, `updated_at`)
SELECT 10, `id`, NOW(), NOW()
FROM `p_user`;

# MAJ des droits
UPDATE `p_user` SET `roles` = REPLACE(`roles`, ' ROLE_CIRCLE_10 |', '');

UPDATE `p_user` SET `roles` = CONCAT(`roles`, ' ROLE_CIRCLE_10 |'), `updated_at` = NOW();

# Mise en ligne du group et de ses thématiques
# UPDATE `p_circle` SET `online` = 1 WHERE `id` = 10;
# 
# UPDATE `p_c_topic` SET `online` = 1 WHERE `p_circle_id` = 10;
