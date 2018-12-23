# Insertion du groupe
INSERT INTO `p_circle` (`id`, `p_circle_type_id`, `p_c_owner_id`, `uuid`, `title`, `summary`, `description`, `url`, `online`, `only_elected`, `created_at`, `updated_at`, `slug`, `sortable_rank`)
VALUES ('4', 4, 1, NULL, 'Rencontres de l\'Ariège 2018', '<p>Rencontres de l\'Ariège 2018</p>', '
<div class="grpGlobalIntroBigArticle">
<img src="/bundles/politizrfront/images/grp-DOB2018/CD09-illuDOB.jpg">
    <div class="grpGlobalIntroOneCol center">
        <p>
            <b>Ce débat d’orientations budgétaires vous intéresse?</b> Posez vos questions directement ici sur POLITIZR et venez à la rencontre du Président du Conseil Départemental lors de six rencontres organisées du 27 novembre au 5 décembre sur l’ensemble du territoire de l’Ariège.
<br/>
            <b>Aides sociales, routes, collèges, THD, aménagement du territoire, vie associative… Oui, les orientations budgétaires du Conseil Départemental de l’Ariège vous concerne !</b>
        </p>
</div>
</div>
<div class="grpGlobalIntroSmallArticles">
    <div class="grpGlobalIntroOneCol">
        <b>DOB : le Conseil Départemental de l’Ariège trace les orientations stratégiques de son budget 2019</b><br/><br/>
        <p>Les Conseillers Départementaux de l’Ariège se réunissent le lundi 26 novembre, à 15 heures, à l’Hôtel du Département, à Foix. Principaux points à l’ordre du jour de cette séance plénière et publique, les orientations stratégiques et budgétaires pour l’exercice 2019.</p>
        <h1>Qu\'est-ce que le DOB?</h1>
       <p>Le Débat d’Orientations Budgétaires figure le premier acte de l’exercice budgétaire à venir. En ce sens, il permet aux Conseillers Départementaux d’échanger sur les priorités et les évolutions de la situation financière de la collectivité. Il trace les perspectives de fonctionnement et d’investissement qui seront ensuite validées lors du vote du Budget primitif 2019, programmé les lundi 7 et mardi 8 janvier.<br/><br/>
      Précisons que le DOB ne donne pas lieu à un vote, au sens propre, sur les rapports présentés lors de la séance, mais qu’il vise à susciter le débat entre les élus en vue de la définition du budget à venir. D’où son importance et les enjeux de cette séance du 26 novembre.</p><br/><br/>
        <h1>Quelle est le contexte de ce DOB 2019?</h1>
        <p>Depuis la publication de la Programmation de la Loi de Finances publiques 2018-2022, il y a près d’un an, les Conseils Départementaux se heurtent à une réelle complexité budgétaire, entre dépenses en hausse et recettes en baisse.</p>
<p>Le DOB 2019 du Département de l’Ariège est donc préparé dans un contexte extrêmement tendu, du fait de fortes contraintes telles que:<br/>
- Une augmentation de dépenses de fonctionnement limitée à 1,05 %<br/>
- Une augmentation continue des dépenses de solidarité à 2,5 % (RSA, APA, etc.)<br/>
- Des recettes de fonctionnement atones.
</p>
    </div>
    <div class="grpGlobalIntroOneCol">
<p>L’objectif du Département est de bâtir un budget 2019 réaliste et susceptible de répondre aux besoins des Ariégeoises et des Ariégeois sans risque de devoir payer des pénalités à l’Etat en cas de non-respect de la « règle » du 1,05 %.
</p>
    <img src="/bundles/politizrfront/images/grp-DOB2018/cd09.jpg">

        <h1>Un DOB contraint mais ambitieux</h1>
        <p>Dans cette logique, le DOB soumis aux Conseillers Départementaux pour 2019 tente de résoudre une équation complexe entre adaptation aux contraintes et maintien d’ambitions pour le territoire. Ainsi, la politique d’investissement devrait s’élever à 51 millions d’euros, soit 4 millions supplémentaires par rapport à 2018.<br/>
Les effets de la gestion rigoureuse au cours des exercices précédents permet au Département d’appréhender ce niveau d’investissement avec un recours à l’emprunt maîtrisé, à 9,3 millions d’euros. Cet emprunt concernera principalement la part départementale du financement du déploiement du réseau à Très Haut Débit (9,2 M€).
        </p>
        <h1>Le DOB 2019 en chiffres</h1>
        <p>Le budget primitif esquissé dans ce Débat d’orientations budgétaires s’équilibre à hauteur de 221 626 870 €, avec une section de fonctionnement à 170 203 000 € (+ 1,48 %), dont 92,7 M€ pour la Solidarité (AIS, enfance, établissements spécialisés, accompagnement, logement).</p>
<p>Au chapitre des investissements, les grandes affectations seront notamment :<br/>
- 12,6 M€ aux Routes départementales,<br/>
- 10,4 M€ aux bâtiments départementaux (collèges notamment),<br/>
- 9,2 M€ pour le Très Haut Débit,<br/>
- 8,9 M€ au tourisme et aux aides aux territoires,<br/>
- 5,8 M€ à l’aménagement du département.
</p>
    </div>
    <div class="grpGlobalIntroTwoCol">

    </div>
</div>
', NULL, '1', '0', now(), now(), 'rencontres-de-l-ariege-2018', 4);

# app/console politizr:uuids:populate PCircle

# Insertion de la charte du groupe
INSERT INTO `p_m_charte` (`id`, `p_circle_id`, `title`, `summary`, `description`, `online`, `created_at`, `updated_at`) 
VALUES (5, 4, 'Charte de la consultation Rencontres de l\'Ariège 2018 sur Politizr', 'v1.0','
<h1>1 Pr&eacute;ambule</h1>
<p>En compl&eacute;ment de sa plate-forme g&eacute;n&eacute;rale, POLITIZR a con&ccedil;u et d&eacute;velopp&eacute; des espaces de discussion permettant aux collectivit&eacute;s de discuter avec leurs administr&eacute;s.</p>
<p>Cette charte s\'applique pour la collectivit&eacute; "Ari&egrave;ge le d&eacute;partement" au sujet du groupe "Rencontres de l\Ariège 2018": elle a &eacute;t&eacute; r&eacute;dig&eacute;e conjointement par POLITIZR et le Conseil D&eacute;partemental de l\'Ari&egrave;ge.</p>
<p>Afin de garantir la qualit&eacute; des discussions, toute contribution &agrave; la plate-forme est subordonn&eacute;e au respect de la pr&eacute;sente Charte.</p>
<h1>2 Respect et convivialit&eacute;</h1>
<p>Les termes de toute contribution doivent &ecirc;tre courtois et mesur&eacute;s.</p>
<p>Tout contributeur s&rsquo;engage au respect des autres. Ainsi, toute invective, insulte, injure, d&eacute;nigrement, malveillance, harc&egrave;lement est prohib&eacute; tant envers tout autre utilisateur, tous tiers, le Conseil D&eacute;partemental de l\'Ari&egrave;ge et POLITIZR.</p>
<p>Les contributeurs s&rsquo;interdisent de divulguer des informations relevant de la vie priv&eacute;e d&rsquo;autres contributeurs ou de toute autre personne.</p>
<p>Les utilisateurs s&rsquo;interdisent d\'induire en erreur d\'autres utilisateurs en usurpant l\'identit&eacute; ou une d&eacute;nomination sociale ou en portant atteinte &agrave; l\'image ou &agrave; la r&eacute;putation d\'autres personnes et/ou en se faisant passer pour un tiers ou pour un employ&eacute;, un service habilit&eacute; ou un affili&eacute; du&nbsp;Conseil D&eacute;partemental de l\'Ari&egrave;ge ou de POLITIZR.</p>
<h1>3 Argumentation de qualit&eacute;</h1>
<p>Les contributions doivent avoir un lien pertinent avec les th&eacute;matiques propos&eacute;es par&nbsp;le Conseil D&eacute;partemental de l\'Ari&egrave;ge.</p>
<p>Dans la mesure du possibile, il n&rsquo;y aura pas lieu &agrave; la publication de plusieurs contributions identiques ou similaires.</p>
<p>L&rsquo;utilisation des majuscules ou des caract&egrave;res r&eacute;p&eacute;t&eacute;s pour renforcer les arguments n&rsquo;est pas admise.</p>
<h1>4 Mod&eacute;ration</h1>
<p>POLITIZR pratique une mod&eacute;ration a posteriori et non syst&eacute;matique de l&rsquo;ensemble des contributions et informations associ&eacute;es&nbsp;aux profils.</p>
<p>Toute personne ayant connaissance d&rsquo;un contenu illicite ou contraire &agrave; la pr&eacute;sente charte est invit&eacute;e &agrave; en informer POLITZR en remplissant le formulaire de signalement pr&eacute;sent sur l&rsquo;ensemble des publications (icone &lt;!&gt;).</p>
<p>POLITIZR est autoris&eacute; &agrave; supprimer du site de son propre chef ou suite &agrave; un signalement toute contribution totalement ou partiellement notamment aux fins de respect des tiers, de la Charte &eacute;thique et du bon fonctionnement du site.</p>
<p>Sont notamment soumis a mod&eacute;ration :</p>
<ul>
<li>Toute publicit&eacute; ou lien promotionnel vers un ou des sites ext&eacute;rieurs ne sont pas autoris&eacute;s. Toute publicit&eacute; ou promotion contenues dans une contribution sont interdites.</li>
<li>les petites annonces et autres publications sans rapport avec la politique.</li>
<li>les contributions &agrave; caract&egrave;re raciste, x&eacute;nophobe, r&eacute;visionniste, n&eacute;gationniste;&nbsp;</li>
<li>les propos injurieux, diffamatoires, discriminants, envers une personne ou un groupe de personnes,</li>
</ul>
<ol>
<li>en raison de leur origine, de leur appartenance ou de leur non-appartenance, vraie ou suppos&eacute;e, &agrave; une ethnie, une nation, ou une religion;</li>
<li>en raison de leur sexe, de leur orientation sexuelle ou de leur handicap;</li>
</ol>
<ul>
<li>les propos injurieux, diffamatoires, discriminants, portant atteinte &agrave; la vie priv&eacute;e, au droit &agrave; l\'image, ou &agrave; la r&eacute;putation et aux droits d&rsquo;autrui . Et plus g&eacute;n&eacute;ralement, toute violation des droits de propri&eacute;t&eacute; intellectuelle (notamment en mati&egrave;re de musique, vid&eacute;o, animations, jeux, logiciels, bases de donn&eacute;es, images, sons et textes), tout autre droit de propri&eacute;t&eacute; appartenant &agrave; un tiers ou tout secret commercial appartenant &agrave; un de ces tiers;</li>
<li>les propos portant atteinte &agrave; la dignit&eacute; humaine ;</li>
<li>la provocation &agrave; la violence, au suicide, au terrorisme et &agrave; l\'utilisation, la fabrication ou la distribution de substances ill&eacute;gales ou illicites ;</li>
<li>les publications (commentaires, r&eacute;ponses) sans rapport avec les sujets&nbsp;sur lesquelles ils&nbsp;sont publi&eacute;s ("hors sujet") ;</li>
<li>dans le cadre d\'une publication dans un "groupe", les publications (commentaires, sujets, r&eacute;ponses) sans rapport avec la th&eacute;matique propos&eacute;e et sur lesquelles ils sont publi&eacute;s ("hors sujet") ;</li>
<li>la provocation, apologie ou incitation &agrave; commettre des crimes ou des d&eacute;lits et plus particuli&egrave;rement des crimes contre l\'humanit&eacute; ;</li>
<li>les fausses nouvelles.</li>
</ul>
<p>Cette liste n&rsquo;est pas exhaustive.</p>
<p>POLITIZR se r&eacute;serve le droit de ne pas publier certaines contributions, de les publier avec un certain retard ou de les supprimer. POLITIZR n&rsquo;a pas &agrave; motiver cette d&eacute;cision.</p>
<p>De plus, POLITIZR se r&eacute;serve le droit de transmettre les donn&eacute;es personnelles concernant un utilisateur et/ou un abonn&eacute; en vue du respect d&rsquo;une obligation l&eacute;gale, sur demande des autorit&eacute;s de police, administrative ou judiciaires et pour l&rsquo;application d&rsquo;une d&eacute;cision de justice ou &eacute;manant d&rsquo;une autorit&eacute; administrative.</p>
<h1>5 Responsabilit&eacute;</h1>
<p>Les contenus post&eacute;s sur le site rel&egrave;vent de la seule responsabilit&eacute; des contributeurs, POLITIZR ne peut en aucun cas &ecirc;tre tenu pour responsable de ces contenus, notamment de leur caract&egrave;re ill&eacute;gal, d&rsquo;erreurs ou d&rsquo;omissions qu&rsquo;ils pourraient contenir ou de tout dommage cons&eacute;cutif &agrave; leur utilisation.</p>
<p>Conform&eacute;ment &agrave; la loi, d&egrave;s lors qu&rsquo;il sera inform&eacute; de la publication d&rsquo;un contenu susceptible d&rsquo;engager sa responsabilit&eacute; p&eacute;nale, et apr&egrave;s avoir inform&eacute; le contributeur responsable de cette publication, POLITIZR pourra proc&eacute;der &agrave; sa suppression.</p>
', 1, '2018-05-08 10:35:55', '2018-05-08 10:35:55');

# Insertion des topics principaux
INSERT INTO `p_c_topic` (`id`, `p_circle_id`, `title`, `summary`, `description`, `online`, `created_at`, `updated_at`, `slug`, `sortable_rank`) 
VALUES (15, 4, 'Vos Questions', '
<h1>Posez ici vos questions</h1>
<p>Le Conseil D&eacute;partemental de l\'Ari&egrave;ge vous r&eacute;pond!</p>
', null, 1, '2017-09-08 14:38:56', '2017-09-08 14:38:56', 'vos-questions-orientations-budgetaires', 1);

# app/console politizr:uuids:populate PCTopic


# Insertion dans p_c_group_l_c de toutes les villes d'ariège
INSERT INTO `p_c_group_l_c` (`p_circle_id`, `p_l_city_id`, `created_at`, `updated_at`)
SELECT 4, `id`, NOW(), NOW() FROM `p_l_city` WHERE `p_l_department_id` = 9;

# Force geoloc topic
UPDATE `p_c_topic` SET `force_geoloc_type`= "department", `force_geoloc_id`=9;

# new > could be done via admin
# Inscription de tous les ariégeois
# INSERT INTO `p_u_in_p_c` (`p_circle_id`, `p_user_id`, `created_at`, `updated_at`)
# SELECT 3, `id`, NOW(), NOW()
# FROM `p_user`
# WHERE `p_l_city_id` IN (
#     SELECT `id` FROM `p_l_city` WHERE `p_l_department_id` = 9
# );
# 
# # MAJ des droits
# UPDATE `p_user` SET `roles` = REPLACE(`roles`, ' ROLE_CIRCLE_4 |', '');
# 
# UPDATE `p_user` SET `roles` = CONCAT(`roles`, ' ROLE_CIRCLE_4 |'), `updated_at` = NOW() 
# WHERE `p_l_city_id` IN (
#     SELECT `id` FROM `p_l_city` WHERE `p_l_department_id` = 9
# );
# 