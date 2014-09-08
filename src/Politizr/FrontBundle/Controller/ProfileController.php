<?php

namespace Politizr\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\PropelAdapter;


use Politizr\Model\PUserQuery;
use Politizr\Model\PDDebateQuery;
use Politizr\Model\PTagQuery;
use Politizr\Model\PUTaggedTQuery;
use Politizr\Model\PUFollowTQuery;
use Politizr\Model\PDDCommentQuery;

use Politizr\Model\PUser;
use Politizr\Model\PUType;
use Politizr\Model\PTag;
use Politizr\Model\PTTagType;
use Politizr\Model\PUTaggedT;
use Politizr\Model\PUFollowT;


/**
 * Gestion des profils
 *
 * TODO:
 *	- gestion des erreurs / levés d'exceptions à revoir/blindés pour les appels Ajax
 *  - refactorisation pour réduire les doublons de code entre les tables PUTaggedT et PUFollowT
 *  - refactoring gestion des tags > gestion des doublons / admin + externalisation logique métier dans les *Query class
 *
 * @author Lionel Bouzonville
 */
class ProfileController extends Controller {

    /* ######################################################################################################## */
    /*                                                 ROUTING CLASSIQUE                                        */
    /* ######################################################################################################## */

    /* ######################################################################################################## */
    /*                                                      CITOYEN                                             */
    /* ######################################################################################################## */

    /**
     *  Accueil
     */
    public function homepageCAction($page)
    {
        $logger = $this->get('logger');
        $logger->info('*** homepageCAction');

        // Récupération user courant
        $pUser = $this->getUser();

        // *********************************** //
        //      Récupération objets vue
        // *********************************** //

        // Récupération liste des débats ordre publication décroissante
        // TODO + récupérer les débats rédigés par les puser suivis
        // TODO + gestion les débats correspondants aux tags suivis? notifs?
        // TODO req debats + réactions en 1 fois
        // TODO MAJ vers le KnpPaginatorBundle https://github.com/KnpLabs/KnpPaginatorBundle
        $maxPerPage = 10;
        $query = PDDebateQuery::create()->filterByOnline(true)->orderByPublishedAt(\Criteria::DESC);
        $pageDebates = $this->preparePagination($query, $maxPerPage);

        // *********************************** //
        //      Affichage de la vue
        // *********************************** //

        return $this->render('PolitizrFrontBundle:Profile:homepageC.html.twig', array(
                    'pageDebates' => $pageDebates
            ));
    }

    /**
     *  Suggestions
     */
    public function suggestionsCAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** suggestionsCAction');

        // Récupération user courant
        $pUser = $this->getUser();

        // *********************************** //
        //      Récupération objets vue
        // *********************************** //

        //      Suggestions de documents

        // Récupération listing débat "match" tags géo
        // TODO: algo "match" à définir
        // TODO pagintion
        $debatesGeo = $pUser->getTaggedDebates(PTTagType::TYPE_GEO);
        $debatesTheme = $pUser->getTaggedDebates(PTTagType::TYPE_THEME);

        //      Suggestions d'utilisateurs élus
        $usersGeo = $pUser->getTaggedPUsers(PTTagType::TYPE_GEO, PUType::TYPE_QUALIFIE);


        // *********************************** //
        //      Affichage de la vue
        // *********************************** //

        return $this->render('PolitizrFrontBundle:Profile:suggestionsC.html.twig', array(
                    'debatesGeo' => $debatesGeo,
                    'debatesTheme' => $debatesTheme,
                    'usersGeo' => $usersGeo
            ));
    }

    /**
     *  Populaires
     */
    public function popularsCAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** popularsCAction');

        // *********************************** //
        //      Récupération objets vue
        // *********************************** //

        // débats les plus populaires
        $debates = PDDebateQuery::create()->online()->popularity(5)->find();

        // profils les plus populaires
        $users = PUserQuery::create()->filterByPUTypeId(PUType::TYPE_QUALIFIE)->online()->popularity(5)->find();

        // commentaires les plus populaires
        $comments = PDDCommentQuery::create()->online()->last(10)->find();

        // *********************************** //
        //      Affichage de la vue
        // *********************************** //

        return $this->render('PolitizrFrontBundle:Profile:popularsC.html.twig', array(
                'debates' => $debates,
                'users' => $users,
                'comments' => $comments,
            ));
    }

    /* ######################################################################################################## */
    /*                                                      ÉLU                                                 */
    /* ######################################################################################################## */

    /**
     *  Accueil
     */
    public function homepageEAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** homepageEAction');

        // Récupération user courant
        $pUser = $this->getUser();

        // *********************************** //
        //      Récupération objets vue
        // *********************************** //


        // *********************************** //
        //      Affichage de la vue
        // *********************************** //

        return $this->render('PolitizrFrontBundle:Profile:homepageE.html.twig', array(
                    'pageDebates' => $pageDebates
            ));
    }



    /* ######################################################################################################## */
    /*                                                  FONCTIONS AJAX                                          */
    /* ######################################################################################################## */


    /* ######################################################################################################## */
    /*                                               INSCRIPTION STEP 3                                         */
    /* ######################################################################################################## */

    /**
     *      Renvoit un tableau contenant les tags
     */
    public function getPTagsAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** getPTagsAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
                // Récupération args
                $pTTagTypeId = $request->get('pTTagTypeId');
                $logger->info('$pTTagTypeId = ' . print_r($pTTagTypeId, true));

                // Récupération des tags
                // require_once dirname(__FILE__) . '/../../../../vendor/propel/propel1/runtime/lib/parser/PropelJSONParser.php';
                $pTags = PTagQuery::create()
                	->select(array('id', 'title'))
                	->filterByOnline(true)
                	->filterByPTTagTypeId($pTTagTypeId)
                	->orderByTitle()
                	->find()
                	->toArray();
                // $logger->info('$pTags = ' . print_r($pTags, true));

                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                    'pTags' => $pTags
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }


    /**
     *      Récupère les tags associé au user courant et renvoit le rendu associé
     */
    public function getPUTaggedTPTagsAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** getPUTaggedTPTagsAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
		        // *********************************** //
		        //      Récupération des tags existants
		        // *********************************** //
		        $pUserId = $this->getUser()->getId();

                // Récupération args
                $pTTagTypeId = $request->get('pTTagTypeId');
                $logger->info('$pTTagTypeId = ' . print_r($pTTagTypeId, true));

		        $pTags = PTagQuery::create()
		        			->usePuTaggedTPTagQuery()
		        				->filterByPUserId($pUserId)
		        			->endUse()
		        			->filterByOnline(true)
		        			->filterByPTTagTypeId($pTTagTypeId)
		        			->find();
                
                // Construction du rendu du tag
                $templating = $this->get('templating');

                $htmlTags = '';
                foreach($pTags as $pTag) {
	                $htmlTags .= $templating->render(
	                                    'PolitizrFrontBundle:Fragment:UserAddTag.html.twig', array(
	                                    	'pTagId' => $pTag->getId(), 
	                                    	'pTagTitle' => $pTag->getTitle(), 
	                                    	'pTTagTypeId' => $pTag->getPTTagTypeId(),
	                                    	'removeUrl' => $this->container->get('router')->generate('RemovePUTaggedTPTag')
	                                    	)
	                            );
	            }
                
                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                    'htmlTags' => $htmlTags
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }


    /**
     *     Ajoute un tag associé au puser courant et renvoit le rendu associé
     */
    public function addPUTaggedTPTagAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** addPUTaggedTPTagAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
                // Récupération user session
                $pUserId = $this->getUser()->getId();
                $logger->info('$pUserId = ' . print_r($pUserId, true));
                
                // Récupération args
                $pTagId = $request->get('pTagId');
                $logger->info('$pTagId = ' . print_r($pTagId, true));

                // Gestion de l'ajout du tag au profil
                $pUTaggedT = PUTaggedTQuery::create()->filterByPUserId($pUserId)->filterByPTagId($pTagId)->findOne();
                if (!$pUTaggedT) {
                	$logger->info('Ajout d\'un tag');

                	$pUTaggedT = new PUTaggedT();

                	$pUTaggedT->setPUserId($pUserId);
                	$pUTaggedT->setPTagId($pTagId);

                	$pUTaggedT->save();
                } else {
                	$logger->info('Tag déjà existant');

                	throw new \Exception('Tag déjà enregistré');
                }

                // Construction du rendu du tag
                $pTag = PTagQuery::create()->findPk($pTagId);
                $templating = $this->get('templating');
                $htmlTag = $templating->render(
                                    'PolitizrFrontBundle:Fragment:UserAddTag.html.twig', array(
                                    	'pTagId' => $pTag->getId(),
                                    	'pTagTitle' => $pTag->getTitle(),
                                    	'pTTagTypeId' => $pTag->getPTTagTypeId(),
                                    	'removeUrl' => $this->container->get('router')->generate('RemovePUTaggedTPTag')
                                    	)
                            );


                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                    'htmlTag' => $htmlTag
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }

    /**
     *     Supprime un tag associé au puser courant et renvoit le rendu associé
     */
    public function removePUTaggedTPTagAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** removePUTaggedTPTagAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
                // Récupération user session
                $pUserId = $this->getUser()->getId();
                $logger->info('$pUserId = ' . print_r($pUserId, true));
                
                // Récupération args
                $pTagId = $request->get('pTagId');
                $logger->info('$pTagId = ' . print_r($pTagId, true));

                // Gestion de l'ajout du tag au profil
                $pUTaggedT = PUTaggedTQuery::create()->filterByPUserId($pUserId)->filterByPTagId($pTagId)->findOne();
                if (!$pUTaggedT) {
                	$logger->info('Tag non trouvé');

                	throw new \Exception('Tag non trouvé');
                } else {
                	$logger->info('Tag trouvé');

                	$pUTaggedT->delete();
                }

                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }

    /**
     *      Récupère les tags suivis par le user courant et renvoit le rendu associé
     */
    public function getPUFollowTPTagsAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** getPUFollowTPTagsAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
		        // *********************************** //
		        //      Récupération des tags existants
		        // *********************************** //
		        $pUserId = $this->getUser()->getId();

                // Récupération args
                $pTTagTypeId = $request->get('pTTagTypeId');
                $logger->info('$pTTagTypeId = ' . print_r($pTTagTypeId, true));

		        $pTags = PTagQuery::create()
		        			->usePuFollowTPTagQuery()
		        				->filterByPUserId($pUserId)
		        			->endUse()
		        			->filterByOnline(true)
		        			->filterByPTTagTypeId($pTTagTypeId)
		        			->find();
                
                
                // Construction du rendu du tag
                $templating = $this->get('templating');

                $htmlTags = '';
                foreach($pTags as $pTag) {
	                $htmlTags .= $templating->render(
	                                    'PolitizrFrontBundle:Fragment:UserAddTag.html.twig', array(
	                                    	'pTagId' => $pTag->getId(),
	                                    	'pTagTitle' => $pTag->getTitle(),
	                                    	'pTTagTypeId' => $pTag->getPTTagTypeId(),
	                                    	'removeUrl' => $this->container->get('router')->generate('RemovePUFollowTPTag')
	                                    	)
	                            );
	            }
                
                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                    'htmlTags' => $htmlTags
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }


    /**
     *     Ajoute un tag suivi par le puser courant et renvoit le rendu associé
     */
    public function addPUFollowTPTagAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** addPUFollowTPTagAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
                // Récupération user session
                $pUserId = $this->getUser()->getId();
                $logger->info('$pUserId = ' . print_r($pUserId, true));
                
                // Récupération args
                $pTagId = $request->get('pTagId');
                $logger->info('$pTagId = ' . print_r($pTagId, true));

                // Gestion de l'ajout du tag au profil
                $pUTaggedT = PUFollowTQuery::create()->filterByPUserId($pUserId)->filterByPTagId($pTagId)->findOne();
                if (!$pUTaggedT) {
                	$logger->info('Ajout d\'un tag');

                	$pUTaggedT = new PUFollowT();

                	$pUTaggedT->setPUserId($pUserId);
                	$pUTaggedT->setPTagId($pTagId);

                	$pUTaggedT->save();
                } else {
                	$logger->info('Tag déjà existant');

                	throw new \Exception('Tag déjà enregistré');
                }

                // Construction du rendu du tag
                $pTag = PTagQuery::create()->findPk($pTagId);
                $templating = $this->get('templating');
                $htmlTag = $templating->render(
                                    'PolitizrFrontBundle:Fragment:UserAddTag.html.twig', array(
                                    	'pTagId' => $pTag->getId(),
                                    	'pTagTitle' => $pTag->getTitle(),
                                    	'pTTagTypeId' => $pTag->getPTTagTypeId(),
                                    	'removeUrl' => $this->container->get('router')->generate('RemovePUFollowTPTag')
                                    	)
                            );

                
                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                    'htmlTag' => $htmlTag
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }

    /**
     *     Supprime un tag suivi par le puser courant et renvoit le rendu associé
     */
    public function removePUFollowTPTagAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** removePUFollowTPTagAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
                // Récupération user session
                $pUserId = $this->getUser()->getId();
                $logger->info('$pUserId = ' . print_r($pUserId, true));
                
                // Récupération args
                $pTagId = $request->get('pTagId');
                $logger->info('$pTagId = ' . print_r($pTagId, true));

                // Gestion de l'ajout du tag au profil
                $pUTaggedT = PUFollowTQuery::create()->filterByPUserId($pUserId)->filterByPTagId($pTagId)->findOne();
                if (!$pUTaggedT) {
                	$logger->info('Tag non trouvé');

                	throw new \Exception('Tag non trouvé');
                } else {
                	$logger->info('Tag trouvé');

                	$pUTaggedT->delete();
                }

                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }

    /**
     *     Ajoute un nouveau tag saisi par l'utilisateur
     */
    public function addNewPTagAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('*** addNewPTagAction');
        
        try {
            if ($request->isXmlHttpRequest()) {
                // Récupération args
                $title = $request->get('title');
                $logger->info('$title = ' . print_r($title, true));
                $pTTagTypeId = $request->get('pTTagTypeId');
                $logger->info('$pTTagTypeId = ' . print_r($pTTagTypeId, true));

                // Test si le tag n'existe pas > on se base sur le slug
                $slug = \StudioEcho\Lib\StudioEchoUtils::generateSlug($title);
                $pTag = PTagQuery::create()->filterBySlug($slug)->findOne();

                if ($pTag) {
                	$logger->info('Slug déjà existant.');
                } else {
                	$logger->info('Création du tag.');

	                // Création du nouveau tag
	                $pTag = new PTag();

	                $pTag->setTitle($title);
	                $pTag->setPTTagTypeId($pTTagTypeId);
	                $pTag->setOnline(true);

	                $pTag->save();
	            }

                // Construction de la réponse
                $jsonResponse = array (
                    'success' => true,
                    'id' => $pTag->getId()
                );
            } else {
                throw $this->createNotFoundException('Not a XHR request');
            }
        } catch (NotFoundHttpException $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        } catch (\Exception $e) {
            $logger->info('Exception = ' . print_r($e->getMessage(), true));
            $jsonResponse = array('error' => $e->getMessage());
        }

        // JSON formatted success/error message
        $response = new Response(json_encode($jsonResponse));
        return $response;
    }


    /* ######################################################################################################## */
    /*                                                  FONCTIONS PRIVÉES                                             */
    /* ######################################################################################################## */


    /**
     * 
     * @param type $query
     * @return \Pagerfanta\Pagerfanta
     * @throws type
     */
    private function preparePagination($query, $maxPerPage = 5) {
        $adapter = new PropelAdapter($query);
        $pagerfanta = new Pagerfanta($adapter);

        try {
            $pagerfanta->setMaxPerPage($maxPerPage)->setCurrentPage($this->getRequest()->get('page'));
        } catch (Pagerfanta\Exception\NotIntegerCurrentPageException $e) {
            throw $this->createNotFoundException('PagerFanta NotIntegerCurrentPageException.');
        } catch (Pagerfanta\Exception\LessThan1CurrentPageException $e) {
            throw $this->createNotFoundException('PagerFanta LessThan1CurrentPageException.');
        } catch (Pagerfanta\Exception\OutOfRangeCurrentPageException $e) {
            throw $this->createNotFoundException('PagerFantaOutOfRangeCurrentPageException.');
        }
        
        return $pagerfanta;
    }
    
}