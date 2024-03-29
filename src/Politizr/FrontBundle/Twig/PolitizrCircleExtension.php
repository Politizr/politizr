<?php
namespace Politizr\FrontBundle\Twig;

use Politizr\Exception\InconsistentDataException;

use Politizr\Model\PCircle;
use Politizr\Model\PCTopic;
use Politizr\Model\PDocumentInterface;
use Politizr\Model\PDCommentInterface;

use Politizr\Model\PCircleQuery;
use Politizr\Model\PCTopicQuery;
use Politizr\Model\PUserQuery;
use Politizr\Model\PUInPCQuery;

use Politizr\Constant\CircleConstants;
    
/**
 * User's circle twig extension
 *
 * @author Lionel Bouzonville
 */
class PolitizrCircleExtension extends \Twig_Extension
{
    private $securityTokenStorage;
    private $securityAuthorizationChecker;

    private $router;

    private $circleService;
    
    private $globalTools;

    private $logger;

    /**
     * @security.token_storage
     * @security.authorization_checker
     * @router
     * @politizr.functional.circle
     * @politizr.tools.global
     * @logger
     */
    public function __construct(
        $securityTokenStorage,
        $securityAuthorizationChecker,
        $router,
        $circleService,
        $globalTools,
        $logger
    ) {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->securityAuthorizationChecker =$securityAuthorizationChecker;

        $this->router = $router;

        $this->circleService = $circleService;

        $this->globalTools = $globalTools;
        
        $this->logger = $logger;
    }

    /* ######################################################################################################## */
    /*                                              FONCTIONS ET FILTRES                                        */
    /* ######################################################################################################## */

    /**
     * Filters list
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'circleDetail',
                array($this, 'circleDetail'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'circleActions',
                array($this, 'circleActions'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'circleMenuTop',
                array($this, 'circleMenuTop'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'circleFooter',
                array($this, 'circleFooter'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'topicStats',
                array($this, 'topicStats'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'topicBriefing',
                array($this, 'topicBriefing'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'topicQuestion',
                array($this, 'topicQuestion'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'topicHowToBox',
                array($this, 'topicHowToBox'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'authorizedReactionUsers',
                array($this, 'authorizedReactionUsers'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            new \Twig_SimpleFilter(
                'readOnlyMessage',
                array($this, 'readOnlyMessage'),
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
            'authorizedReactionUsersForCd09'  => new \Twig_SimpleFunction(
                'authorizedReactionUsersForCd09',
                array($this, 'authorizedReactionUsersForCd09'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            'circleBreadcrumb'  => new \Twig_SimpleFunction(
                'circleBreadcrumb',
                array($this, 'circleBreadcrumb'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
            'circleCardHeader'  => new \Twig_SimpleFunction(
                'circleCardHeader',
                array($this, 'circleCardHeader'),
                array('is_safe' => array('html'), 'needs_environment' => true)
            ),
        );
    }


    /* ######################################################################################################## */
    /*                                             FILTRES                                                      */
    /* ######################################################################################################## */

    /**
     * Compute right interact links between user and circle: join or consult/quit
     *
     * @param PCircle $circle
     * @return html
     */
    public function circleDetail(\Twig_Environment $env, PCircle $circle, $topics)
    {
        // $this->logger->info('*** circleDetail');
        // $this->logger->info('$circle = '.print_r($circle, true));

        // get template path > generic or dedicated
        $templatePath = 'Circle';
        if ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_FREE) {
            $templatePath = 'Circle\\free';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_MEDIUM) {
            $templatePath = 'Circle\\medium';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_FULL) {
            $templatePath = 'Circle\\full';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09THD_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09thd';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09DOB_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09dob';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::LHOSPI_ID_CIRCLE) {
            $templatePath = 'Circle\\lhospi';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBAT_ID_CIRCLE) {
            $templatePath = 'Circle\\granddebat';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBATSUITE_ID_CIRCLE) {
            $templatePath = 'Circle\\granddebatsuite';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::MONDEDAPRES_ID_CIRCLE) {
            $templatePath = 'Circle\\mondedapres';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::INNOPOLIS_ID_CIRCLE) {
            $templatePath = 'Circle\\innopolis';
        } else {
            $templatePath = 'Circle';
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:'.$templatePath.':_detail.html.twig',
            array(
                'circle' => $circle,
                'topics' => $topics,
            )
        );

        return $html;
    }

    /**
     * Compute right interact links between user and circle: join or consult/quit
     *
     * @param PCircle $circle
     * @return html
     */
    public function circleActions(\Twig_Environment $env, PCircle $circle)
    {
        // $this->logger->info('*** circleActions');
        // $this->logger->info('$circle = '.print_r($circle, true));

        // get current user
        $user = $this->securityTokenStorage->getToken()->getUser();
        if (is_string($user)) {
            $user = null;
            return null;
        }

        $isMember = $this->circleService->isUserMemberOfCircle($circle, $user);

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Circle:_menuActions.html.twig',
            array(
                'isMember' => $isMember,
                'circle' => $circle
            )
        );

        return $html;
    }

    /**
     * Manage circle menu
     *
     * @param PCircle $circle
     * @return html
     */
    public function circleMenuTop(\Twig_Environment $env, PCircle $circle)
    {
        // $this->logger->info('*** circleMenuTop');
        // $this->logger->info('$circle = '.print_r($circle, true));

        // get circle's topics
        $topics = PCTopicQuery::create()
                    ->filterByPCircleId($circle->getId())
                    ->filterByOnline(true)
                    ->orderByRank()
                    ->find();

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Circle:_menuTop.html.twig',
            array(
                'circle' => $circle,
                'topics' => $topics,
            )
        );

        return $html;
    }

    /**
     * Manage circle footer
     *
     * @param PCircle $circle
     * @return html
     */
    public function circleFooter(\Twig_Environment $env, PCircle $circle)
    {
        // $this->logger->info('*** circleFooter');
        // $this->logger->info('$circle = '.print_r($circle, true));

        // get template path > generic or dedicated
        $templatePath = 'Circle';
        if ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_FREE) {
            $templatePath = 'Circle\\free';
        } elseif ($circle->getId() == CircleConstants::CD09_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09';
        } elseif ($circle->getId() == CircleConstants::CD09THD_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09thd';
        } elseif ($circle->getId() == CircleConstants::CD09DOB_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09dob';
        } elseif ($circle->getId() == CircleConstants::GRANDDEBAT_ID_CIRCLE) {
            $templatePath = 'Circle\\granddebat';
        } elseif ($circle->getId() == CircleConstants::GRANDDEBATSUITE_ID_CIRCLE) {
            $templatePath = 'Circle\\granddebat';
        } elseif ($circle->getId() == CircleConstants::MONDEDAPRES_ID_CIRCLE) {
            $templatePath = 'Circle\\granddebat';
        } elseif ($circle->getId() == CircleConstants::INNOPOLIS_ID_CIRCLE) {
            $templatePath = 'Circle\\innopolis';
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:'.$templatePath.':_footer.html.twig',
            array(
                'circle' => $circle
            )
        );

        return $html;
    }

    /**
     * Compute topic stats
     *
     * @param PCTopic $topic
     * @return html
     */
    public function topicStats(\Twig_Environment $env, PCTopic $topic)
    {
        // $this->logger->info('*** topicStats');
        // $this->logger->info('$topic = '.print_r($topic, true));

        $nbDebates = $this->circleService->countDebatesByTopic($topic);
        $nbReactions = $this->circleService->countReactionsByTopic($topic);
        $nbComments = $this->circleService->countCommentsByTopic($topic);

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Topic:_topicStats.html.twig',
            array(
                'circle' => $topic->getPCircle(),
                'topic' => $topic,
                'nbDebates' => $nbDebates,
                'nbReactions' => $nbReactions,
                'nbComments' => $nbComments,
            )
        );

        return $html;
    }

    /**
     * Display topic briefing
     *
     * @param PCTopic $topic
     * @return html
     */
    public function topicBriefing(\Twig_Environment $env, PCTopic $topic)
    {
        // $this->logger->info('*** topicBriefing');
        // $this->logger->info('$topic = '.print_r($topic, true));

        $circle = $topic->getPCircle();

        // get template path > generic or dedicated
        $templatePath = 'Topic';
        if ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09THD_ID_CIRCLE) {
            $templatePath = 'Topic\\cd09thd';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09DOB_ID_CIRCLE) {
            $templatePath = 'Topic\\cd09dob';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBATSUITE_ID_CIRCLE) {
            $templatePath = 'Topic\\granddebatsuite';
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:'.$templatePath.':_briefing.html.twig',
            array(
                'circle' => $circle,
                'topic' => $topic,
            )
        );

        return $html;
    }

    /**
     * Display topic "I've a new question"
     *
     * @param PCTopic $topic
     * @return html
     */
    public function topicQuestion(\Twig_Environment $env, PCTopic $topic)
    {
        // $this->logger->info('*** topicQuestion');
        // $this->logger->info('$topic = '.print_r($topic, true));

        $circle = $topic->getPCircle();

        // get template path > generic or dedicated
        $templatePath = 'Topic';
        if ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09THD_ID_CIRCLE) {
            $templatePath = 'Topic\\cd09thd';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::CD09DOB_ID_CIRCLE) {
            $templatePath = 'Topic\\cd09dob';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBAT_ID_CIRCLE) {
            $templatePath = 'Topic\\granddebat';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBATSUITE_ID_CIRCLE) {
            $templatePath = 'Topic\\granddebatsuite';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::MONDEDAPRES_ID_CIRCLE) {
            $templatePath = 'Topic\\mondedapres';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::INNOPOLIS_ID_CIRCLE) {
            $templatePath = 'Topic\\innopolis';
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:'.$templatePath.':_question.html.twig',
            array(
                'circle' => $topic->getPCircle(),
                'topic' => $topic,
            )
        );

        return $html;
    }

    /**
     * Display contextual "how to" box
     *
     * @param PCTopic $topic
     * @return string
     */
    public function topicHowToBox(\Twig_Environment $env, PCTopic $topic)
    {
        $html = null;

        $circle = $topic->getPCircle();

        // get template path > generic or dedicated
        $templatePath = 'Topic';
        if ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBAT_ID_CIRCLE) {
            $templatePath = 'Topic\\granddebat';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::GRANDDEBATSUITE_ID_CIRCLE) {
            $templatePath = 'Topic\\granddebatsuite';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::MONDEDAPRES_ID_CIRCLE) {
            $templatePath = 'Topic\\mondedapres';
        } elseif ($circle->getPCircleTypeId() == CircleConstants::CIRCLE_TYPE_SPECIFIC && $circle->getId() == CircleConstants::INNOPOLIS_ID_CIRCLE) {
            $templatePath = 'Topic\\innopolis';
        }

        $html = $env->render(
            'PolitizrFrontBundle:'.$templatePath.':_circleHowTo.html.twig',
            array(
            )
        );

        return $html;
    }


    /**
     * Display listing of users authorized to react in this circle
     *
     * @param PCTopic $topic
     * @return html
     */
    public function authorizedReactionUsers(\Twig_Environment $env, PCircle $circle)
    {
        // $this->logger->info('*** authorizedReactionUsers');
        // $this->logger->info('$topic = '.print_r($topic, true));

        $mainUser = null;
        if ($circle->getId() == CircleConstants::CD09_ID_CIRCLE) {
            $mainUser = PUserQuery::create()->findPk(CircleConstants::CD09_ID_USER_PRESIDENT);
        }

        $users = $this->circleService->getAuthorizedReactionUsersByCircle($circle, $mainUser);

        // get template path > generic or dedicated
        $templatePath = 'Circle';
        if ($circle->getId() == CircleConstants::CD09_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09';
        } elseif ($circle->getId() == CircleConstants::CD09_ID_CIRCLE) {
            $templatePath = 'Circle\\cd09';
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:'.$templatePath.':_authorizedReactionUsers.html.twig',
            array(
                'mainUser' => $mainUser,
                'users' => $users,
            )
        );

        return $html;
    }

    /**
     * Display banner if circle is in "read only" mode
     *
     * @param PCircle $circle
     * @return string
     */
    public function readOnlyMessage(\Twig_Environment $env, PCircle $circle)
    {
        $html = null;

        if (! $circle->getReadOnly()) {
            return null;
        }

        $html = $env->render(
            'PolitizrFrontBundle:Circle:_readOnlyBanner.html.twig',
            array(
                'circle' => $circle,
            )
        );

        return $html;
    }

    /* ######################################################################################################## */
    /*                                             FONCTIONS                                                    */
    /* ######################################################################################################## */

    /**
     * Display a customized authorized reaction users for CD09 
     *
     * @param PUser $user
     * @return string
     */
    public function authorizedReactionUsersForCd09(\Twig_Environment $env)
    {
        // $this->logger->info('*** authorizedReactionUsersForCd09');

        $users = PUserQuery::create()->filterById(CircleConstants::CD09_IDS_USER_RESPONSES)->find();
        
        $html = $env->render(
            'PolitizrFrontBundle:Circle\\cd09:_authorizedReactionUsers.html.twig',
            array(
                'mainUser' => $mainUser,
                'users' => $users,
            )
        );

        return $html;
    }

    /**
     * Breadcrumb
     *
     * @param PCircle $circle
     * @param PCTopic $topic
     * @param PDocument $document
     * @return html
     */
    public function circleBreadcrumb(
        \Twig_Environment $env,
        PCircle $circle = null,
        PCTopic $topic = null,
        PDocumentInterface $document = null
    ) {
        // $this->logger->info('*** circleBreadcrumb');
        // $this->logger->info('$circle = '.print_r($circle, true));

        $circleLevel = false;
        $topicLevel = false;
        $documentLevel = false;

        if ($circle) {
            $circleLevel = true;
            
            $owner = $circle->getPCOwner();
        } elseif ($topic) {
            $topicLevel = true;

            $circle = $topic->getPCircle();
            $owner = $circle->getPCOwner();
        } elseif ($document) {
            $documentLevel = true;

            $topic = $document->getPCTopic();

            if ($topic) {
                $circle = $topic->getPCircle();
                $owner = $circle->getPCOwner();
            } else {
                return null;
            }
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Circle:_breadcrumb.html.twig',
            array(
                'circleLevel' => $circleLevel,
                'topicLevel' => $topicLevel,
                'documentLevel' => $documentLevel,
                'owner' => $owner,
                'circle' => $circle,
                'topic' => $topic,
                'document' => $document,
            )
        );

        return $html;
    }

    /**
     * Header for document's card (debate, reaction, comment) in circle context
     *
     * @param PDocumentInterface $document
     * @param PDCommentInterface $comment
     * @return html
     */
    public function circleCardHeader(
        \Twig_Environment $env,
        PDocumentInterface $document = null,
        PDCommentInterface $comment = null
    ) {
        // $this->logger->info('*** circleCardHeader');
        // $this->logger->info('$document = '.print_r($document, true));
        // $this->logger->info('$comment = '.print_r($comment, true));
        if ($document && $topic = $document->getPCTopic()) {
            $circle = $topic->getPCircle();
            $owner = $circle->getPCOwner();
        } elseif ($comment && $comment->getPDocument() && $topic = $comment->getPDocument()->getPCTopic()) {
            $circle = $topic->getPCircle();
            $owner = $circle->getPCOwner();
        } else {
            return null;
        }

        // Construction du rendu du tag
        $html = $env->render(
            'PolitizrFrontBundle:Document:_circleHeader.html.twig',
            array(
                'owner' => $owner,
                'circle' => $circle,
            )
        );

        return $html;
    }

    public function getName()
    {
        return 'p_e_circle';
    }
}
