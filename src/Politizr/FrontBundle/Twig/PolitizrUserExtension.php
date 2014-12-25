<?php
namespace Politizr\Frontbundle\Twig;

use Politizr\Model\PDocument;
use Politizr\Model\PUStatus;

use Politizr\Model\PUFollowDDQuery;
use Politizr\Model\PUFollowUQuery;


/**
 * Extension Twig / Gestion des users
 *
 * @author Lionel Bouzonville
 */
class PolitizrUserExtension extends \Twig_Extension
{
    private $sc;

    private $logger;
    private $router;
    private $templating;

    private $user;

    /**
     *
     */
    public function __construct($serviceContainer) {
        $this->sc = $serviceContainer;
        
        $this->logger = $serviceContainer->get('logger');
        $this->router = $serviceContainer->get('router');
        $this->templating = $serviceContainer->get('templating');

        // Récupération du user en session
        $token = $serviceContainer->get('security.context')->getToken();
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
    // public function getFilters()
    // {
    //     return array(
    //         new \Twig_SimpleFilter('isGranted', array($this, 'isGranted')),
    //     );
    // }

    /**
     *  Renvoie la liste des fonctions
     */
    public function getFunctions()
    {
        return array(
            'isGrantedC'  => new \Twig_Function_Method($this, 'isGrantedC', array(
                    'is_safe' => array('html')
                    )
            ),
            'isGrantedE'  => new \Twig_Function_Method($this, 'isGrantedE', array(
                    'is_safe' => array('html')
                    )
            ),
            'linkSubscribe'  => new \Twig_Function_Method($this, 'linkSubscribe', array(
                    'is_safe' => array('html')
                    )
            ),
            'linkFollowers'  => new \Twig_Function_Method($this, 'linkFollowers', array(
                    'is_safe' => array('html')
                    )
            ),
        );
    }


    /* ######################################################################################################## */
    /*                                             FILTRES                                                      */
    /* ######################################################################################################## */


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

        if ($this->sc->get('security.context')->isGranted('ROLE_CITIZEN') &&
            $this->user &&
            $this->user->getOnline()) {
            return true;    
        }

        return false;
    }


    /**
     *  Test l'autorisation d'un user débatteur et de l'état de son inscription
     *
     * @param $user         PUser à tester
     *
     * @return string
     */
    public function isGrantedE()
    {
        $this->logger->info('*** isGrantedE');

        if ($this->sc->get('security.context')->isGranted('ROLE_ELECTED') &&
            $this->user &&
            $this->user->getPUStatusId() == PUStatus::ACTIVED &&
            $this->user->getOnline()) {
            return true;    
        }

        return false;
    }



    /**
     *  Affiche le lien "Suivre" / "Ne plus suivre" / "M'inscrire" suivant le cas
     *
     * @param $objectId     ID objet
     * @param $context      Type d'objet suivi: user - debate
     *
     * @return string
     */
    public function linkSubscribe($object, $context)
    {
        $this->logger->info('*** linkSubscribe');
        $this->logger->info('$object = '.print_r($object, true));
        $this->logger->info('$context = '.print_r($context, true));

        $follower = false;
        if ($this->user) {
            switch($context) {
                case PDocument::TYPE_DEBATE:
                    $follow = PUFollowDDQuery::create()
                        ->filterByPUserId($this->user->getId())
                        ->filterByPDDebateId($object->getId())
                        ->findOne();
                    
                    if ($follow) {
                        $follower = true;
                    }

                    break;
                case PDocument::TYPE_USER:
                    $follow = PUFollowUQuery::create()
                        ->filterByPUserFollowerId($this->user->getId())
                        ->filterByPUserId($object->getId())
                        ->findOne();
                    
                    if ($follow) {
                        $follower = true;
                    }

                    break;
            }
        }

        // Construction du rendu du tag
        $html = $this->templating->render(
                            'PolitizrFrontBundle:Fragment\\Follow:Subscribe.html.twig', array(
                                'object' => $object,
                                'context' => $context,
                                'follower' => $follower
                                )
                    );

        return $html;

    }

    /**
     *  Affiche le bloc des followers
     *
     * @param $objectId     ID objet
     * @param $context      Type d'objet suivi: user - debate
     *
     * @return string
     */
    public function linkFollowers($object, $context)
    {
        $this->logger->info('*** linkFollowers');
        $this->logger->info('$object = '.print_r($object, true));
        $this->logger->info('$context = '.print_r($context, true));

        $nbC = 0;
        $nbQ = 0;
        $followersC = array();
        $followersQ = array();
        switch($context) {
            case PDocument::TYPE_DEBATE:
                $nbC = $object->countFollowersC();
                $nbQ = $object->countFollowersQ();
                $followersC = $object->getFollowersC();
                $followersQ = $object->getFollowersC();

                break;
            case PDocument::TYPE_USER:
                $nbC = $object->countPUserFollowersC();
                $nbQ = $object->countPUserFollowersQ();
                $followersC = $object->getPUserFollowersC();
                $followersQ = $object->getPUserFollowersQ();

                break;
        }

        // Construction du rendu du tag
        $html = $this->templating->render(
                            'PolitizrFrontBundle:Fragment\\Follow:Followers.html.twig', array(
                                'nbC' => $nbC,
                                'nbQ' => $nbQ,
                                'followersC' => $followersC,
                                'followersQ' => $followersQ,
                                )
                    );

        return $html;

    }


    public function getName()
    {
        return 'p_e_user';
    }



}