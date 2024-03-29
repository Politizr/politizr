<?php

namespace Politizr\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Politizr\Constant\QualificationConstants;
use Politizr\Constant\UserConstants;

use Politizr\Model\PUser;
use Politizr\Model\PUMandate;

use Politizr\Model\POrderQuery;
use Politizr\Model\POPaymentTypeQuery;
use Politizr\Model\PUserQuery;
use Politizr\Model\PLCityQuery;

use Politizr\FrontBundle\Form\Type\PUserRegisterType;
use Politizr\FrontBundle\Form\Type\PUserContactType;
use Politizr\FrontBundle\Form\Type\PUMandateType;
use Politizr\FrontBundle\Form\Type\PUserIdCheckType;

use Politizr\FrontBundle\Form\Type\PUserElectedRegisterType;
use Politizr\FrontBundle\Form\Type\PUserElectedContactType;

use Politizr\FrontBundle\Form\Type\LostPasswordType;

use Politizr\FrontBundle\Form\Type\POrderSubscriptionType;

use Politizr\Exception\InconsistentDataException;

/**
 * Security controller
 *
 * http://nyrodev.info/fr/posts/286/Connexions-OAuth-Multiple-avec-Symfony-2-3
 * http://sirprize.me/scribble/under-the-hood-of-symfony-security/
 * http://www.reecefowell.com/2011/10/26/redirecting-on-loginlogout-in-symfony2-using-loginhandlers/
 *
 * @author Lionel Bouzonville
 */
class SecurityController extends Controller
{

    /* ######################################################################################################## */
    /*                                                 CONNEXION                                                */
    /* ######################################################################################################## */

    /**
     * Login
     * http://symfony.com/doc/current/cookbook/security/form_login_setup.html
     */
    public function loginAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** loginAction');

        $this->get('session')->set('inscription/referer', $request->headers->get('referer'));

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // lost password form
        $formLostPassword = $this->createForm(new LostPasswordType());

        return $this->render(
            'PolitizrFrontBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                'formLostPassword' => $formLostPassword->createView(),
            )
        );
    }

    /**
     * Cancel inscription
     */
    public function cancelInscriptionAction()
    {
        // Récupération user
        // $user = $this->get('security.context')->getToken()->getUser();
        // $user->deleteWithoutArchive();
        return $this->redirect($this->generateUrl('Logout'));
    }


    /**
     * Page d'inscription: choix élu / citoyen
     */
    public function inscriptionChoiceAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionChoiceAction');

        $this->get('session')->set('inscription/referer', $request->headers->get('referer'));

        return $this->render('PolitizrFrontBundle:Public:inscriptionChoice.html.twig', array(
        ));
    }

    /* ######################################################################################################## */
    /*                                               INSCRIPTION CLASSIQUE                                      */
    /* ######################################################################################################## */

    /**
     * Page d'inscription / Etape 1
     */
    public function inscriptionAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionAction');

        $this->get('session')->set('inscription/type', 0);
        
        // Objet & formulaire
        $user = new PUser();
        $form = $this->createForm(new PUserRegisterType(), $user);
        
        return $this->render('PolitizrFrontBundle:Public:inscription.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *  Validation inscription / Etape 1
     */
    public function inscriptionCheckAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionCheckAction');

        $user = null;

        // test & redirect if user previously canceled his subscription during process
        $data =  $request->request->get('user_register');
        if ($data['email']) {
            $user = PUserQuery::create()
                        ->filterByUsername($data['email'])
                        ->filterByPUStatusId(UserConstants::STATUS_INSCRIPTION_PROCESS)
                        ->findOne();
        }
        if (!$user) {
            $user = new PUser();
        }

        $form = $this->createForm(new PUserRegisterType(), $user);

        $form->bind($request);
        if ($form->isValid()) {
            $user = $form->getData();

            // load user inscription start process
            $this->get('politizr.functional.security')->inscriptionCitizenStart($user);

            return $this->redirect($this->generateUrl('InscriptionContact'));
        }

        return $this->render('PolitizrFrontBundle:Public:inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Page d'inscription / Etape 2 / Contact
     */
    public function inscriptionContactAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionContactAction');

        $user = $this->getUser();

        // check if user has already filled his email
        $withEmail = true;
        if ($email = $user->getEmail()) {
            $withEmail = false;
        }

        // check if user comes from oauth
        $rolesTab = $user->getRoles();
        $oAuth = false;
        if (in_array('ROLE_OAUTH_USER', $rolesTab)) {
            $oAuth = true;
        }

        $form = $this->createForm(new PUserContactType($withEmail, $oAuth), $user);
        
        return $this->render('PolitizrFrontBundle:Security:inscriptionContact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     *  Validation inscription / Etape 2
     */
    public function inscriptionContactCheckAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionContactCheckAction');

        $user = $this->getUser();
        
        // check if user has already filled his email
        $withEmail = true;
        if ($email = $user->getEmail()) {
            $withEmail = false;
        }

        // check if user comes from oauth
        $rolesTab = $user->getRoles();
        $oAuth = false;
        if (in_array('ROLE_OAUTH_USER', $rolesTab)) {
            $oAuth = true;
        }

        $form = $this->createForm(new PUserContactType($withEmail, $oAuth), $user);
        
        $form->bind($request);
        if ($form->isValid()) {
            $user = $form->getData();
            $user->save();

            // upd localization infos
            $this->get('politizr.functional.localization')->updateUserGeoloc($user, $form);

            $this->get('politizr.functional.security')->inscriptionCitizenFinish($user);

            // Inscription done
            $request->getSession()->getFlashBag()->add('inscription/success', true);

            $this->get('session')->set('gettingStarted', true);

            // Redirect to page before inscription
            $refererUrl = $this->get('politizr.tools.global')->getRefererUrl();
            if ($refererUrl) {
                return $this->redirect($refererUrl);
            }

            return $this->redirect($this->generateUrl('HomepageC'));
        }

        return $this->render('PolitizrFrontBundle:Security:inscriptionContact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /* ######################################################################################################## */
    /*                                          INSCRIPTION ELU                                                 */
    /* ######################################################################################################## */

    /**
     * Page d'inscription élu  / Etape 1 / Inscription
     */
    public function inscriptionElectedAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedAction');

        $this->get('session')->set('inscription/type', 1);

        $user = new PUser();
        $form = $this->createForm(new PUserElectedRegisterType(), $user);
        
        return $this->render('PolitizrFrontBundle:Public:inscriptionElected.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Page d'inscription élu  / Etape 1 / Validation inscription
     */
    public function inscriptionElectedCheckAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedCheckAction');

        $user = null;

        // test & redirect if user previously canceled his subscription during process
        $data =  $request->request->get('user_elected_register');
        if ($data['email']) {
            $user = PUserQuery::create()
                        ->filterByUsername($data['email'])
                        ->filterByPUStatusId(UserConstants::STATUS_INSCRIPTION_PROCESS)
                        ->findOne();
        }
        if (!$user) {
            $user = new PUser();
        }

        $form = $this->createForm(new PUserElectedRegisterType(), $user);

        $form->bind($request);
        if ($form->isValid()) {
            $user = $form->getData();

            // Service associé au démarrage de l'inscription élu
            $this->get('politizr.functional.security')->inscriptionElectedStart($user);

            return $this->redirect($this->generateUrl('InscriptionElectedContact'));
        }
        
        return $this->render('PolitizrFrontBundle:Public:inscriptionElected.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Page d'inscription / Etape 2 / Contact
     */
    public function inscriptionElectedContactAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedContactAction');

        $user = $this->getUser();

        // check if user has already filled his email
        $withEmail = true;
        if ($email = $user->getEmail()) {
            $withEmail = false;
        }

        // check if user comes from oauth
        $rolesTab = $user->getRoles();
        // dump($rolesTab);
        $oAuth = false;
        if (in_array('ROLE_OAUTH_USER', $rolesTab)) {
            $oAuth = true;
        }

        $form = $this->createForm(new PUserElectedContactType($withEmail, $oAuth), $user);
        
        return $this->render('PolitizrFrontBundle:Security:inscriptionElectedContact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *  Validation inscription / Etape 2 / Contact
     */
    public function inscriptionElectedContactCheckAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedContactCheckAction');

        $user = $this->getUser();

        // check if user has already filled his email
        $withEmail = true;
        if ($email = $user->getEmail()) {
            $withEmail = false;
        }

        // check if user comes from oauth
        $rolesTab = $user->getRoles();
        $oAuth = false;
        if (in_array('ROLE_OAUTH_USER', $rolesTab)) {
            $oAuth = true;
        }

        $form = $this->createForm(new PUserElectedContactType($withEmail, $oAuth), $user);
        
        $form->bind($request);
        if ($form->isValid()) {
            $user = $form->getData();
            $user->save();

            // upd localization infos
            $this->get('politizr.functional.localization')->updateUserGeoloc($user, $form);

            return $this->redirect($this->generateUrl('InscriptionElectedMandate'));
        }

        return $this->render('PolitizrFrontBundle:Security:inscriptionElectedContact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Page d'inscription / Etape 3 / Mandat
     */
    public function inscriptionElectedMandateAction($error)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedMandateAction');

        $user = $this->getUser();

        // Existing mandates form views
        $formMandateViews = $this->get('politizr.tools.global')->getFormMandateViews($user->getId());

        // New mandate
        $mandate = new PUMandate();
        $mandate->setPQTypeId(QualificationConstants::TYPE_ELECTIV);
        $formMandate = $this->createForm(new PUMandateType(QualificationConstants::TYPE_ELECTIV), $mandate);

        // error
        $errorMsg = null;
        if ($error) {
            $errorMsg = 'Vous devez renseigner au moins 1 mandat';
        }

        return $this->render('PolitizrFrontBundle:Security:inscriptionElectedMandate.html.twig', array(
            'errorMsg' => $errorMsg,
            'formMandate' => $formMandate?$formMandate->createView():null,
            'formMandateViews' => $formMandateViews?$formMandateViews:null,
        ));
    }

    /**
     *  Validation inscription / Etape 3 / Mandat
     */
    public function inscriptionElectedMandateCheckAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedMandateCheckAction');

        $user = $this->getUser();

        // @todo > check if user has at least 1 mandate and redirect
        if ($count = $user->countPUMandates() > 0) {
            // return $this->redirect($this->generateUrl('InscriptionElectedOrder'));
            return $this->redirect($this->generateUrl('InscriptionElectedFinishSuccess'));
        } else {
            return $this->redirect($this->generateUrl('InscriptionElectedMandate', array('error' => true)));
        }
    }

    /**
     * Page d'inscription élu / Etape 4 / Choix de la formule
     */
    public function inscriptionElectedOrderAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedOrderAction');

        return $this->redirect($this->generateUrl('InscriptionElectedContact'));

        $user = $this->getUser();
        $form = $this->createForm(new POrderSubscriptionType());

        return $this->render('PolitizrFrontBundle:Security:inscriptionElectedOrder.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Page d'inscription élu / Etape 4 / Validation choix de la formule
     */
    public function inscriptionElectedOrderCheckAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedOrderCheckAction');

        return $this->redirect($this->generateUrl('InscriptionElectedContact'));

        $user = $this->getUser();
        $form = $this->createForm(new POrderSubscriptionType());

        $form->bind($request);
        if ($form->isValid()) {
            $datas = $form->getData();
            $subscription = $datas['p_o_subscription'];

            // Mise en session de la formule choisie
            $this->get('session')->set('p_o_subscription_id', $subscription->getId());

            return $this->redirect($this->generateUrl('InscriptionElectedPayment'));
        }

        return $this->render('PolitizrFrontBundle:Security:inscriptionElectedOrder.html.twig', array(
            'form' => $form->createView(),
            'layout' => $layout,
        ));
    }

    /**
     * Page d'inscription élu / Etape 3 / Paiement
     */
    public function inscriptionElectedPaymentAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedPaymentAction');

        return $this->redirect($this->generateUrl('InscriptionElectedContact'));

        $user = $this->getUser();

        // Listes des moyens de paiement / gestion hors form pour chargement dynamique des formulaires paypal/banque & pavés d'informations spécifiques
        $payments = POPaymentTypeQuery::create()->filterByOnline(true)->orderByRank()->find();
        
        return $this->render('PolitizrFrontBundle:Security:inscriptionElectedPayment.html.twig', array(
            'payments' => $payments,
        ));
    }

    /**
     * Page d'inscription élu / Etape 3 / Paiement terminé
     */
    public function inscriptionElectedPaymentFinishedAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedPaymentFinishedAction');

        return $this->redirect($this->generateUrl('InscriptionElectedContact'));

        // Mise à jour de la commande
        $this->get('politizr.functional.security')->updateOrderPaymentCompleted();

        return $this->redirect($this->generateUrl('InscriptionElectedIdCheck'));
    }

    /**
     * Page d'inscription élu / Etape 3 / Annulation paiement
     */
    public function inscriptionElectedPaymentCanceledAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedPaymentCanceledAction');

        return $this->redirect($this->generateUrl('InscriptionElectedContact'));

        // Mise à jour de la commande
        $this->get('politizr.functional.security')->updateOrderPaymentCanceled();

        // Suppression des valeurs en session
        $this->get('session')->remove('p_order_id');

        // Affichage de la vue ou redirection
        return $this->redirect($this->generateUrl('InscriptionElectedPayment'));
    }

    /**
     * Page d'inscription élu / success
     */
    public function inscriptionElectedFinishSuccessAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** inscriptionElectedFinishSuccessAction');

        $user = $this->getUser();

        // @todo more controls to avoid direct url call

//         // Récupération de la commande en cours
//         // @todo payment not ok > redirect before to another page
//         // @todo manage session expired
//         $orderId = $this->get('session')->get('p_order_id');
//         $order = POrderQuery::create()->findPk($orderId);
//         if (!$order) {
//             $this->get('session')->getFlashBag()->add('error', 'Session expirée.');
//         }
// 
//         // Suppression des valeurs en session
//         $this->get('session')->remove('p_o_subscription_id');
//         $this->get('session')->remove('p_order_id');

        // Finalisation du process d'inscription élu
        $this->get('politizr.functional.security')->inscriptionFinishElected($user);

        // Inscription done
        $request->getSession()->getFlashBag()->add('inscription/success', true);

        $this->get('session')->set('gettingStarted', true);

        // Redirect to page before inscription
        $refererUrl = $this->get('politizr.tools.global')->getRefererUrl();
        if ($refererUrl) {
            return $this->redirect($refererUrl);
        }

        return $this->redirect($this->generateUrl('HomepageE'));
    }

    /* ######################################################################################################## */
    /*                                                 CONNEXION OAUTH                                          */
    /* ######################################################################################################## */

    /**
     *  Action suivant la connexion oAuth
     */
    public function oauthTargetAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** oauthTargetAction');

        // Récupération de l'objet OAuthUser & mise en session des éléments associés
        $oAuthUser = $this->getUser();
        $oAuthData = $oAuthUser->getData();
        $this->get('session')->getFlashBag()->set('oAuthData', $oAuthData);

        return $this->redirect($this->generateUrl('OAuthRegister'));
    }
    
    /**
     *  Check l'état d'un utilisateur suite à une connexion oAuth
     */
    public function oauthRegisterAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** oauthRegisterAction');

        $isQualified = $this->get('session')->get('inscription/type');

        // Appel du service connexion oauth ou création user + connexion oauth suivant les cas
        $redirectUrl = $this->get('politizr.functional.security')->oauthRegister($isQualified);

        // Redirection
        return $this->redirect($redirectUrl);
    }

    /* ######################################################################################################## */
    /*                                              SUPPRESSION COMPTE                                          */
    /* ######################################################################################################## */

    /**
     *  Suppression du compte
     */
    public function deleteAccountAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** deleteAccount');

        $user = $this->getUser();
        $user->delete();

        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
            
        return $this->redirect($this->generateUrl('Homepage'));
    }

    /* ######################################################################################################## */
    /*                                             UNSUBSCRIBE NOTIF LINK                                       */
    /* ######################################################################################################## */

    /**
     * Désinscription des notifs email
     *
     * @param
     * @param
     */
    public function unsubscribeNotifLinkAction(Request $request, $email, $uuid)
    {
        $logger = $this->get('logger');
        $logger->info('*** unsubscribeNotifLinkAction');

        $user = PUserQuery::create()
            ->filterByEmail($email)
            ->filterByUuid($uuid)
            ->findOne();

        if (!$user) {
            throw new InconsistentDataException('Current user not found.');
        }

        $this->get('politizr.functional.notification')->unsubscribeNotifEmailByUserId($user->getId());

        return $this->render('PolitizrFrontBundle:Security:unsubscribeNotifLink.html.twig', array(
        ));
    }
}
