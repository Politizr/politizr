<?php
namespace Politizr\FrontBundle\Twig;

use Politizr\Constant\ReputationConstants;

use Politizr\Model\PDocumentInterface;
use Politizr\Model\PDDebate;
use Politizr\Model\PUStatus;
use Politizr\Model\PNotification;
use Politizr\Model\PUNotification;
use Politizr\Model\PUser;

use Politizr\Model\PUFollowUQuery;
use Politizr\Model\PRBadgeQuery;
use Politizr\Model\PDDebateQuery;
use Politizr\Model\PDReactionQuery;
use Politizr\Model\PDDCommentQuery;
use Politizr\Model\PDRCommentQuery;
use Politizr\Model\PUserQuery;

/**
 * User's twig extension
 *
 * @author Lionel Bouzonville
 */
class PolitizrUserExtension extends \Twig_Extension
{
    private $sc;

    private $logger;
    private $router;
    private $templating;
    private $securityContext;

    private $user;

    /**
     *
     */
    public function __construct($serviceContainer)
    {
        $this->sc = $serviceContainer;
        
        $this->logger = $serviceContainer->get('logger');
        $this->router = $serviceContainer->get('router');
        $this->templating = $serviceContainer->get('templating');
        $this->securityContext = $serviceContainer->get('security.context');

        // get connected user
        $token = $this->securityContext->getToken();
        if ($token && $user = $token->getUser()) {
            $className = 'Politizr\Model\PUser';
            if ($user && $user instanceof $className) {
                $this->user = $user;
            } else {
                $this->user = null;
            }
        } else {
            $this->user = null;
        }

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
                'photo',
                array($this, 'photo'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'photoBack',
                array($this, 'photoBack'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'followTags',
                array($this, 'followTags'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'tags',
                array($this, 'tags'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'linkSubscribeUser',
                array($this, 'linkSubscribeUser'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'followersUser',
                array($this, 'followersUser'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'linkedNotification',
                array($this, 'linkedNotification'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFilter(
                'isAuthorizedToReact',
                array($this, 'isAuthorizedToReact'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     *  Renvoie la liste des fonctions
     */
    public function getFunctions()
    {
        return array(
            'isGrantedC'  => new \Twig_Function_Method($this, 'isGrantedC', array('is_safe' => array('html'))),
            'isGrantedE'  => new \Twig_Function_Method($this, 'isGrantedE', array('is_safe' => array('html'))),
        );
    }


    /* ######################################################################################################## */
    /*                                             FILTRES                                                      */
    /* ######################################################################################################## */

    /**
     * Photo de profil d'un user
     *
     * @param PUser $user
     * @return html
     */
    public function photo(PUser $user, $filterName = 'user_bio')
    {
        // $this->logger->info('*** photo');
        // $this->logger->info('$user = '.print_r($user, true));

        $path = 'bundles/politizrfront/images/profil_default.png';
        if ($user && $fileName = $user->getFileName()) {
            $path = 'uploads/users/'.$fileName;
        }

        // Construction du rendu du tag
        $html = $this->templating->render(
            'PolitizrFrontBundle:User:_photo.html.twig',
            array(
                'user' => $user,
                'path' => $path,
                'filterName' => $filterName,
                )
        );

        return $html;
    }

    /**
     * Photo de profil d'un user
     *
     * @param PUser $user
     * @return html
     */
    public function photoBack(PUser $user, $filterName = 'user_bio_back')
    {
        // $this->logger->info('*** photoBack');
        // $this->logger->info('$user = '.print_r($user, true));

        $path = '/bundles/politizrfront/images/default_user_back.jpg';
        if ($user && $fileName = $user->getBackFileName()) {
            $path = '/uploads/users/'.$fileName;
        }

        return $path;
    }


   /**
     *  Affiche les tags suivis par un user suivant le type fourni
     *
     * @param PUser $user
     * @param $tagTypeId    integer     ID type de tag
     * @return string
     */
    public function followTags(PUser $user, $tagTypeId)
    {
        $this->logger->info('*** followTags');
        // $this->logger->info('$user = '.print_r($user, true));
        // $this->logger->info('$pTTagType = '.print_r($pTTagType, true));

        // Construction du rendu du tag
        $html = $this->templating->render(
            'PolitizrFrontBundle:Fragment\\Tag:glListRead.html.twig',
            array(
                'tags' => $user->getFollowTags($tagTypeId)
            )
        );

        return $html;

    }

   /**
     *  Affiche les tags associés à un user suivant le type fourni
     *
     * @param PUser $user
     * @param $tagTypeId    integer     ID type de tag
     * @return string
     */
    public function tags(PUser $user, $tagTypeId)
    {
        $this->logger->info('*** tags');
        // $this->logger->info('$uiser = '.print_r($uiser, true));
        // $this->logger->info('$pTTagType = '.print_r($pTTagType, true));

        // Construction du rendu du tag
        $html = $this->templating->render(
            'PolitizrFrontBundle:Fragment\\Tag:glListRead.html.twig',
            array(
                'tags' => $user->getTaggedTags($tagTypeId),
            )
        );

        return $html;

    }


    /**
     *  Affiche le lien "Suivre" / "Ne plus suivre" / "M'inscrire" suivant le cas
     *
     * @param PUser $user
     * @return string
     */
    public function linkSubscribeUser(PUser $user)
    {
        // $this->logger->info('*** linkSubscribeDebate');
        // $this->logger->info('$debate = '.print_r($user, true));

        $follower = false;
        if ($this->user) {
            $follow = PUFollowUQuery::create()
                ->filterByPUserFollowerId($this->user->getId())
                ->filterByPUserId($user->getId())
                ->findOne();
            
            if ($follow) {
                $follower = true;
            }
        }

        // Construction du rendu du tag
        $html = $this->templating->render(
            'PolitizrFrontBundle:Follow:_subscribeUser.html.twig',
            array(
                'object' => $user,
                'follower' => $follower
            )
        );

        return $html;

    }

    /**
     *  Affiche le bloc des followers
     *
     * @param PUser $user
     * @return string
     */
    public function followersUser(PUser $user)
    {
        // $this->logger->info('*** followersUser');
        // $this->logger->info('$debate = '.print_r($user, true));

        $nbC = 0;
        $nbQ = 0;
        $followersC = array();
        $followersQ = array();

        $nbC = $user->countFollowersC();
        $nbQ = $user->countFollowersQ();
        $followersC = $user->getFollowersC();
        $followersQ = $user->getFollowersQ();

        // Construction du rendu du tag
        $html = $this->templating->render(
            'PolitizrFrontBundle:Fragment\\Follow:Followers.html.twig',
            array(
                'nbC' => $nbC,
                'nbQ' => $nbQ,
                'followersC' => $followersC,
                'followersQ' => $followersQ,
            )
        );

        return $html;

    }


    /**
     * Notification HTML rendering
     *
     * @param PUNotification $notification
     * @param boolean $absolute render absolute URL link
     * @return html
     */
    public function linkedNotification(PUNotification $notification, $absolute = false)
    {
        // $this->logger->info('*** linkedNotification');
        // $this->logger->info('$notification = '.print_r($notification, true));

        // Récupération de l'objet d'interaction
        $commentDoc = '';
        $reactionParentTitle = null;
        $reactionParentUrl = null;
        switch ($notification->getPObjectName()) {
            case PDocumentInterface::TYPE_DEBATE:
                $subject = PDDebateQuery::create()->findPk($notification->getPObjectId());
                $title = $subject->getTitle();
                $url = $this->router->generate('DebateDetail', array('slug' => $subject->getSlug()), $absolute);
                break;
            case PDocumentInterface::TYPE_REACTION:
                $subject = PDReactionQuery::create()->findPk($notification->getPObjectId());
                $title = $subject->getTitle();
                $url = $this->router->generate('ReactionDetail', array('slug' => $subject->getSlug()), $absolute);
                
                // Document parent associée à la réaction
                if ($subject->getTreeLevel() > 1) {
                    // Réaction parente
                    $parent = $subject->getParent();
                    $reactionParentTitle = $parent->getTitle();
                    $reactionParentUrl = $this->router->generate('ReactionDetail', array('slug' => $parent->getSlug()), $absolute);
                } else {
                    // Débat
                    $debate = $subject->getDebate();
                    $reactionParentTitle = $debate->getTitle();
                    $reactionParentUrl = $this->router->generate('DebateDetail', array('slug' => $debate->getSlug()), $absolute);
                }

                break;
            case PDocumentInterface::TYPE_DEBATE_COMMENT:
                $subject = PDDCommentQuery::create()->findPk($notification->getPObjectId());
                
                $title = $subject->getDescription();
                $document = $subject->getPDocument();
                $commentDoc = $document->getTitle();
                $url = $this->router->generate('DebateDetail', array('slug' => $document->getSlug()), $absolute);

                break;
            case PDocumentInterface::TYPE_REACTION_COMMENT:
                $subject = PDRCommentQuery::create()->findPk($notification->getPObjectId());
                
                $title = $subject->getDescription();
                $document = $subject->getPDocument();
                $commentDoc = $document->getTitle();
                $url = $this->router->generate('ReactionDetail', array('slug' => $document->getSlug()), $absolute);

                break;
            case PDocumentInterface::TYPE_USER:
                $subject = PUserQuery::create()->findPk($notification->getPObjectId());
                $title = $subject->getFirstname().' '.$subject->getName();
                $url = $this->router->generate('UserDetail', array('slug' => $subject->getSlug()), $absolute);
                
                break;
            case PDocumentInterface::TYPE_BADGE:
                $subject = PRBadgeQuery::create()->findPk($notification->getPObjectId());
                $title = $subject->getTitle();

                $url = $this->router->generate('MyReputationC', array(), $absolute);
                if ($this->isGrantedE()) {
                    $url = $this->router->generate('MyReputationE', array(), $absolute);
                }
                
                break;
        }

        // Récupération de l'auteur de l'interaction
        $author = PUserQuery::create()->findPk($notification->getPAuthorUserId());
        $authorUrl = $this->router->generate('UserDetail', array('slug' => $author->getSlug()), $absolute);

        // Construction du rendu du tag
        $html = $this->templating->render(
            'PolitizrFrontBundle:Notification:_notification.html.twig',
            array(
                'id' => $notification->getPNotificationId(),
                'puId' => $notification->getId(),
                'author' => $author,
                'authorUrl' => $authorUrl,
                'title' => $title,
                'url' => $url,
                'commentDoc' => $commentDoc,
                'reactionParentTitle' => $reactionParentTitle,
                'reactionParentUrl' => $reactionParentUrl,
            )
        );

        return $html;
    }

    /**
     * Test if the user can publish a reaction to the debate
     *
     * @param PUser $user
     * @param PDDebate $debate
     * @return boolean
     */
    public function isAuthorizedToReact(PUser $user, PDDebate $debate)
    {
        // $this->logger->info('*** isAuthorizedToReact');
        // $this->logger->info('$user = '.print_r($user, true));

        // elected profile can react
        if ($this->securityContext->isGranted('ROLE_ELECTED')) {
            return true;
        }

        // author of the debate can react
        // + min reputation to reach
        $debateUser = $debate->getUser();
        $id = $user->getId();
        $score = $user->getReputationScore();
        if ($debateUser->getId() === $id && $score >= ReputationConstants::ACTION_REACTION_WRITE) {
            return true;
        }

        return false;
    }


    /* ######################################################################################################## */
    /*                                             FONCTIONS                                                    */
    /* ######################################################################################################## */

    /**
     *  Test l'autorisation d'un user citoyen et de l'état de son inscription
     *
     * @param $user         PUser à tester
     *
     * @return string
     */
    public function isGrantedC()
    {
        $this->logger->info('*** isGrantedC');

        if ($this->securityContext->isGranted('ROLE_CITIZEN') &&
            $this->user &&
            $this->user->getOnline()) {
            return true;
        }

        return false;
    }


    /**
     * Test l'autorisation d'un user débatteur et de l'état de son inscription
     *
     * @param $user         PUser à tester
     *
     * @return string
     */
    public function isGrantedE()
    {
        $this->logger->info('*** isGrantedE');

        if ($this->securityContext->isGranted('ROLE_ELECTED') &&
            $this->user &&
            $this->user->getPUStatusId() == PUStatus::ACTIVED &&
            $this->user->getOnline()) {
            return true;
        }

        return false;
    }

    /**
     * Nom de l'extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'p_e_user';
    }
}
