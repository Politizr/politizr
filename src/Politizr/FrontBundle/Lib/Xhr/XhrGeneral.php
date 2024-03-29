<?php
namespace Politizr\FrontBundle\Lib\Xhr;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;

use StudioEcho\Lib\StudioEchoUtils;

use Politizr\Exception\InconsistentDataException;
use Politizr\Exception\BoxErrorException;

use Politizr\Constant\ObjectTypeConstants;
use Politizr\Constant\ListingConstants;

use Politizr\Model\PUser;
use Politizr\Model\PDDebate;

use Politizr\Model\PMCguQuery;
use Politizr\Model\PMCgvQuery;
use Politizr\Model\PMCharteQuery;

use Politizr\FrontBundle\Form\Type\PDDirectType;

/**
 * XHR service for general management.
 * beta
 *
 * @author Lionel Bouzonville
 */
class XhrGeneral
{
    private $securityTokenStorage;
    private $eventDispatcher;
    private $securityService;
    private $documentService;
    private $templating;
    private $formFactory;
    private $logger;

    /**
     *
     * @param @security.token_storage
     * @param @event_dispatcher
     * @param @politizr.functional.security
     * @param @politizr.functional.document
     * @param @templating
     * @param @form.factory
     * @param @logger
     */
    public function __construct(
        $securityTokenStorage,
        $eventDispatcher,
        $securityService,
        $documentService,
        $templating,
        $formFactory,
        $logger
    ) {
        $this->securityTokenStorage = $securityTokenStorage;

        $this->eventDispatcher = $eventDispatcher;

        $this->securityService = $securityService;
        $this->documentService = $documentService;

        $this->templating = $templating;
        $this->formFactory = $formFactory;

        $this->logger = $logger;
    }

    /**
     * Show/Hide suggestion timeline by default
     * beta
     */
    public function showSuggestion(Request $request)
    {
        // $this->logger->info('*** showSuggestion');

        // Request arguments
        $show = $request->get('show');
        // $this->logger->info('$show = ' . print_r($show, true));
        
        if ($show == "true") {
            $show = true;
        } else {
            $show = false;
        }
        $request->getSession()->set('showSuggestion', $show);

        return true;
    }

    /**
     * Hide OP slide
     * beta
     */
    public function hideOp(Request $request)
    {
        // $this->logger->info('*** hideOp');

        // Request arguments
        $request->getSession()->set('showOp', false);

        return true;
    }

    /**
     * Direct message send
     * beta
     */
    public function directMessageSend(Request $request)
    {
        // $this->logger->info('*** directMessageSend');

        // Request arguments
        // $this->logger->info('$formTypeId = '.print_r($formTypeId, true));

        $form = $this->formFactory->create(new PDDirectType());

        $form->bind($request);
        if ($form->isValid()) {
            $directMessage = $form->getData();
            $automaticCreation = $form->get('automatic_creation')->getData();
            $directMessage->save();

            // Envoi email
            $dispatcher =  $this->eventDispatcher->dispatch('direct_message_email', new GenericEvent($directMessage));

            // Automatic user & subject creation
            try {
                if ($automaticCreation) {
                    $user = $this->securityService->createUserFromDirectMessage($directMessage);

                    if ($user) {
                        $debate = $this->documentService->createDebateFromDirectMessage($user, $directMessage);
                    }
                }
            } catch (\Exception $e) {
                $this->logger->info('Exception creation auto - Msg = '.$e->getMessage());
            }
        } else {
            $errors = StudioEchoUtils::getAjaxFormErrors($form);
            throw new BoxErrorException($errors);
        }

        return true;
    }

}
