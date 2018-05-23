<?php

namespace Politizr\AdminBundle\Controller\PUser;

use Admingenerated\PolitizrAdminBundle\BasePUserController\ActionsController as BaseActionsController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Politizr\Constant\PathConstants;
use Politizr\Constant\QualificationConstants;
use Politizr\Constant\ObjectTypeConstants;

use Politizr\Model\PMUserHistoric;

use Politizr\AdminBundle\Form\Type\AdminPUserLocalizationType;
use Politizr\AdminBundle\Form\Type\AdminPUserModerationType;

use Politizr\FrontBundle\Form\Type\PUserIdCheckType;
use Politizr\FrontBundle\Form\Type\PUMandateType;

use Politizr\Model\PUserQuery;
use Politizr\Model\PUser;
use Politizr\Model\PUMandate;

use Politizr\Exception\InconsistentDataException;

/**
 * ActionsController
 */
class ActionsController extends BaseActionsController
{
    /**
     *
     * @param PUser $user
     * @return Response
     */
    protected function successObjectIdcheck(PUser $user)
    {

        // id check form
        $form = $this->createForm(new PUserIdCheckType($user->getId()), $user);

        return $this->render('PolitizrAdminBundle:PUserActions:idcheck.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @param PUser $user
     * @return Response
     */
    protected function successObjectMandate(PUser $user)
    {

        // Mandates form views
        $formMandateViews = $this->get('politizr.tools.global')->getFormMandateViews($user->getId());

        // New mandate
        $mandate = new PUMandate();
        $formMandate = $this->createForm(new PUMandateType(QualificationConstants::TYPE_ELECTIV, $user->getId()), $mandate);

        return $this->render('PolitizrAdminBundle:PUserActions:mandate.html.twig', array(
            'user' => $user,
            'formMandate' => $formMandate?$formMandate->createView():null,
            'formMandateViews' => $formMandateViews?$formMandateViews:null,
        ));
    }

    /**
     *
     * @param PUser $user
     * @return Response
     */
    protected function successObjectLocalization(PUser $user)
    {

        $form = $this->createForm(new AdminPUserLocalizationType($user));

        return $this->render('PolitizrAdminBundle:PUserActions:localization.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @param PUser $user
     * @return Response
     */
    protected function successObjectModeration(PUser $user)
    {
        $form = $this->createForm(new AdminPUserModerationType($user));

        return $this->render('PolitizrAdminBundle:PUserActions:moderation.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @param $request
     * @param $pk
     * @return Response
     */
    public function moderationUpdateAction(Request $request, $pk)
    {
        $user = PUserQuery::create()->findPk($pk);
        if (!$user) {
            throw new InconsistentDataException('PUserQuery pk-'.$pk.' not found.');
        }

        $form = $this->createForm(new AdminPUserModerationType($user));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                dump($data);
                $moderationType = $data['p_m_moderation_type'];

                $this->get('politizr.functional.moderation')->archiveUser($user);

                $userModerated = $this->get('politizr.functional.moderation')->addUserModerated(
                    $user,
                    $moderationType->getId(),
                    ObjectTypeConstants::TYPE_USER,
                    $user->getId(),
                    $data['score_evolution']
                );
                dump($userModerated);

                $this->get('politizr.functional.moderation')->updateUserReputation($user, $data['score_evolution']);

                if ($data['ban']) {
                    $this->get('politizr.functional.moderation')->banUser($user);
                } else {
                    // Upd object
                    $user->setFirstname($data['firstname']);
                    $user->setName($data['name']);
                    $user->setBiography($data['biography']);
                    $user->setWebsite($data['website']);
                    $user->setFacebook($data['facebook']);
                    $user->setTwitter($data['twitter']);

                    $user->save();
                }

                if ($data['send_email']) {
                    $this->get('politizr.functional.moderation')->notifUser($user, $userModerated);
                }

                $abuseLevel = $user->getAbuseLevel();
                if (!$abuseLevel) {
                    $abuseLevel = 0;
                }
                $user->setAbuseLevel($abuseLevel + 1);
                $user->save();

                $this->get('session')->getFlashBag()->add('success', 'L\'utilisateur a été modéré avec succès.');

                return $this->redirect(
                    $this->generateUrl("Politizr_AdminBundle_PUser_list")
                );

            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $e->getMessage());
            }
        }

        return $this->render('PolitizrAdminBundle:PUserActions:moderation.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @param int $pk
     */
    public function archiveAction($pk)
    {
        $user = PUserQuery::create()->findPk($pk);
        if (!$user) {
            throw new InconsistentDataException('PUserQuery pk-'.$pk.' not found.');
        }

        try {
            $this->get('politizr.functional.moderation')->archiveUser($user);

            $this->get('session')->getFlashBag()->add('success', 'L\'archive a bien été créée.');
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('error', $e->getMessage());
        }

        return new RedirectResponse($this->generateUrl("Politizr_AdminBundle_PUser_edit", array('pk' => $pk)));
    }
}
