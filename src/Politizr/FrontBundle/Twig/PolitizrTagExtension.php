<?php
namespace Politizr\FrontBundle\Twig;

use Politizr\Constant\TagConstants;

use Politizr\FrontBundle\Lib\Tag;
use Politizr\Model\PTag;

use Politizr\Model\PTagQuery;
use Politizr\Model\PEOperationQuery;

use Politizr\Exception\InconsistentDataException;

/**
 * Tag's twig extension
 *
 * @author Lionel Bouzonville
 */
class PolitizrTagExtension extends \Twig_Extension
{
    private $securityTokenStorage;
    private $securityAuthorizationChecker;

    private $router;

    private $globalTools;

    private $logger;

    /**
     * @security.token_storage
     * @security.authorization_checker
     * @router
     * @politizr.tools.global
     * @logger
     */
    public function __construct(
        $securityTokenStorage,
        $securityAuthorizationChecker,
        $router,
        $globalTools,
        $logger
    ) {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->securityAuthorizationChecker =$securityAuthorizationChecker;

        $this->router = $router;

        $this->globalTools = $globalTools;

        $this->logger = $logger;
    }

    /* ######################################################################################################## */
    /*                                              FONCTIONS ET FILTRES                                        */
    /* ######################################################################################################## */

    /**
     *  Renvoie la liste des filtres
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'nbUsers',
                array($this, 'nbUsers'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'nbDocuments',
                array($this, 'nbDocuments'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'linkSubscribeTag',
                array($this, 'linkSubscribeTag'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'tagTypeClass',
                array($this, 'tagTypeClass'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'tagOperation',
                array($this, 'tagOperation'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
        );
    }

    /**
     *  Renvoie la liste des fonctions
     */
    public function getFunctions()
    {
        return array(
            'debateTagsEdit'  => new \Twig_SimpleFunction(
                'debateTagsEdit',
                array($this, 'debateTagsEdit'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            'reactionTagsEdit'  => new \Twig_SimpleFunction(
                'reactionTagsEdit',
                array($this, 'reactionTagsEdit'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            'userTagsEdit'  => new \Twig_SimpleFunction(
                'userTagsEdit',
                array($this, 'userTagsEdit'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
        );
    }


    /* ######################################################################################################## */
    /*                                             FILTRES                                                      */
    /* ######################################################################################################## */

    /**
     * Tag's number of associated users
     *
     * @param Tag $tag
     * @return html
     */
    public function nbUsers(Tag $tag)
    {
        // $this->logger->info('*** nbUsers');
        // $this->logger->info('$tag = '.print_r($tag, true));

        $nbUsers = $tag->countUsers();

        if (0 === $nbUsers) {
            $html = 'Suivi par personne';
        } elseif (1 === $nbUsers) {
            $html = sprintf('Suivi par 1 personne', $nbUsers);
        } else {
            $html = sprintf('Suivi par %s personnes', $this->globalTools->readeableNumber($nbUsers));
        }

        return $html;
    }

    /**
     * Tag's number of associated documents
     *
     * @param PTag $tag
     * @return html
     */
    public function nbDocuments(Tag $tag)
    {
        // $this->logger->info('*** nbUsers');
        // $this->logger->info('$tag = '.print_r($tag, true));

        $nbDocuments = $tag->countDocuments();

        if (0 === $nbDocuments) {
            $html = 'Aucune publication n\'aborde cette thématique';
        } elseif (1 === $nbDocuments) {
            $html = sprintf('1 publication aborde cette thématique', $nbDocuments);
        } else {
            $html = sprintf('%s publications abordent cette thématique', $this->globalTools->readeableNumber($nbDocuments));
        }

        return $html;
    }

    /**
     * Follow / unfollow tag
     *
     * @param PTag $tag
     * @return string
     */
    public function linkSubscribeTag(\Twig_Environment $env, PTag $tag)
    {
        // $this->logger->info('*** linkSubscribeTag');
        // $this->logger->info('$tag = '.print_r($tag, true));

        // get current user
        $user = $this->securityTokenStorage->getToken()->getUser();
        if (is_string($user)) {
            $user = null;
        }

        $follower = false;
        if ($user) {
            // Test if user has already associated this tag
            if ($user->isTagged($tag->getId())) {
                $follower = true;
            }
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Follow:_subscribeTagLink.html.twig',
            array(
                'object' => $tag,
                'follower' => $follower
            )
        );

        return $html;
    }

    /**
     * Return css tag class depending of tag type
     *
     * @param PTag $tag
     * @return string
     */
    public function tagTypeClass(PTag $tag)
    {
        // $this->logger->info('*** tagTypeClass');
        // $this->logger->info('$tag = '.print_r($tag, true));

        $tagTypeClass = "default";
        if ($tag->getTagType() == TagConstants::TAG_TYPE_THEME) {
            $tagTypeClass = "theme";
        } elseif ($tag->getTagType() == TagConstants::TAG_TYPE_TYPE) {
            $tagTypeClass = "type";
        } elseif ($tag->getTagType() == TagConstants::TAG_TYPE_FAMILY) {
            $tagTypeClass = "family";
        } elseif ($tag->getTagType() == TagConstants::TAG_TYPE_PRIVATE) {
            $tagTypeClass = "private";
        }
        
        return $tagTypeClass;

    }

    /**
     * Private operation linked to operation
     * 
     * @param PTag $tag
     * @return string
     */
    public function tagOperation(\Twig_Environment $env, PTag $tag)
    {
        // $this->logger->info('*** tagOperation');
        // $this->logger->info('$tag = '.print_r($tag, true));

        // get op for user
        $operation = PEOperationQuery::create()
            ->filterByOnline(true)
            ->usePEOPresetPTQuery()
                ->filterByPTagId($tag->getId())
            ->endUse()
            ->findOne();

        if (!$operation) {
            return null;
        }

        // Construction du rendu du tag            
        $html = $env->render(
            'PolitizrFrontBundle:User:_opBanner.html.twig',
            array(
                'operation' => $operation,
            )
        );

        return $html;
    }


    /* ######################################################################################################## */
    /*                                              FONCTIONS                                                   */
    /* ######################################################################################################## */

    /* ######################################################################################################## */
    /*                                      EDIT & DISPLAY TAGS                                                 */
    /* ######################################################################################################## */


    /**
     * Debate's tagged tags
     *
     * @param PDDebate $debate
     * @param integer $tagTypeId
     * @param integer $zoneId CSS zone id
     * @param boolean $newTag can create new tag
     * @return string
     */
    public function debateTagsEdit(\Twig_Environment $env, $debate, $tagTypeId, $zoneId = 1, $newTag = false)
    {
        // $this->logger->info('*** debateTagsEdit');
        // $this->logger->info('$debate = '.print_r($debate, true));
        // $this->logger->info('$tagTypeId = '.print_r($tagTypeId, true));
        // $this->logger->info('$zoneId = '.print_r($zoneId, true));

        // Construction des chemins XHR
        $xhrPathCreate = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_DEBATE_CREATE',
                'xhrService' => 'tag',
                'xhrMethod' => 'debateAddTag',
                'xhrType' => 'RETURN_HTML',
            )
        );

        $xhrPathDelete = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_DEBATE_DELETE',
                'xhrService' => 'tag',
                'xhrMethod' => 'debateDeleteTag',
                'xhrType' => 'RETURN_BOOLEAN',
            )
        );

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Tag:_edit.html.twig',
            array(
                'object' => $debate,
                'tagTypeId' => $tagTypeId,
                'zoneId' => $zoneId,
                'newTag' => $newTag,
                'withHidden' => false,
                'tags' => $debate->getTags($tagTypeId),
                'pathCreate' => $xhrPathCreate,
                'pathDelete' => $xhrPathDelete,
            )
        );

        return $html;
    }

    /**
     * Debate's tagged tags
     *
     * @param PDReaction $reaction
     * @param integer|array $tagTypeId
     * @param integer $zoneId CSS zone id
     * @param boolean $newTag can create new tag
     * @return string
     */
    public function reactionTagsEdit(\Twig_Environment $env, $reaction, $tagTypeId, $zoneId = 1, $newTag = false)
    {
        // $this->logger->info('*** reactionTagsEdit');
        // $this->logger->info('$reaction = '.print_r($reaction, true));
        // $this->logger->info('$tagTypeId = '.print_r($tagTypeId, true));
        // $this->logger->info('$zoneId = '.print_r($zoneId, true));

        // Construction des chemins XHR
        $xhrPathCreate = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_DEBATE_CREATE',
                'xhrService' => 'tag',
                'xhrMethod' => 'reactionAddTag',
                'xhrType' => 'RETURN_HTML',
            )
        );

        $xhrPathDelete = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_DEBATE_DELETE',
                'xhrService' => 'tag',
                'xhrMethod' => 'reactionDeleteTag',
                'xhrType' => 'RETURN_BOOLEAN',
            )
        );

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Tag:_edit.html.twig',
            array(
                'object' => $reaction,
                'tagTypeId' => $tagTypeId,
                'zoneId' => $zoneId,
                'newTag' => $newTag,
                'withHidden' => false,
                'tags' => $reaction->getTags($tagTypeId),
                'pathCreate' => $xhrPathCreate,
                'pathDelete' => $xhrPathDelete,
            )
        );

        return $html;
    }

    /**
     * User's tags management
     *
     * @param PUser $user
     * @param integer $tagTypeId
     * @param integer $zoneId CSS zone number
     * @param boolean $newTag create new tag
     * @param boolean $withHidden manage hidden tag's property
     * @return string
     */
    public function userTagsEdit(\Twig_Environment $env, $user, $tagTypeId, $zoneId = 1, $newTag = false, $withHidden = true)
    {
        // $this->logger->info('*** userTagsEdit');
        // $this->logger->info('$debate = '.print_r($user, true));
        // $this->logger->info('$tagTypeId = '.print_r($tagTypeId, true));
        // $this->logger->info('$zoneId = '.print_r($zoneId, true));
        // $this->logger->info('$withHidden = '.print_r($withHidden, true));

        // Construction des chemins XHR
        $xhrPathCreate = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_USER_CREATE',
                'xhrService' => 'tag',
                'xhrMethod' => 'userAddTag',
                'xhrType' => 'RETURN_HTML',
            )
        );

        $xhrPathHide = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_USER_HIDE',
                'xhrService' => 'tag',
                'xhrMethod' => 'userHideTag',
                'xhrType' => 'RETURN_BOOLEAN',
            )
        );

        $xhrPathDelete = $env->render(
            'PolitizrFrontBundle:Navigation\\Xhr:_xhrPath.html.twig',
            array(
                'xhrRoute' => 'ROUTE_TAG_USER_DELETE',
                'xhrService' => 'tag',
                'xhrMethod' => 'userDeleteTag',
                'xhrType' => 'RETURN_BOOLEAN',
            )
        );

        // Construction du rendu du tag
        $tags = $user->getTags($tagTypeId, $withHidden?null:false);

        $html = $env->render(
            'PolitizrFrontBundle:Tag:_edit.html.twig',
            array(
                'object' => $user,
                'tagTypeId' => $tagTypeId,
                'zoneId' => $zoneId,
                'newTag' => $newTag,
                'withHidden' => $withHidden,
                'tags' => $tags,
                'pathCreate' => $xhrPathCreate,
                'pathHide' => $xhrPathHide,
                'pathDelete' => $xhrPathDelete,
                )
        );

        return $html;
    }

    /* ######################################################################################################## */

    public function getName()
    {
        return 'p_e_tag';
    }
}
