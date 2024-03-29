<?php

namespace Politizr\FrontBundle\Listener;

use Symfony\Component\EventDispatcher\GenericEvent;

use Politizr\Exception\InconsistentDataException;

use Politizr\Constant\ObjectTypeConstants;
use Politizr\Constant\ReputationConstants;

use Politizr\Model\PUReputation;

/**
 * Gestion des actions mettant à jour la réputation
 *
 * @author Lionel Bouzonville
 */
class ReputationListener
{

    protected $logger;
    protected $eventDispatcher;

    /**
     *
     */
    public function __construct($logger, $eventDispatcher)
    {
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * Publication d'un débat
     *
     * @param GenericEvent
     */
    public function onRDebatePublish(GenericEvent $event)
    {
        // $this->logger->info('*** onRDebatePublish');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_D_DEBATE_PUBLISH;
        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
    }

    /**
     * Publication d'une réaction
     *
     * @param GenericEvent
     */
    public function onRReactionPublish(GenericEvent $event)
    {
        // $this->logger->info('*** onRReactionPublish');

        // Réaction de la réaction
        $subject = $event->getSubject();

        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_D_REACTION_PUBLISH;
        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

        // Débat associé à la réaction
        $debate = $subject->getPDDebate();

        $debateUserId = $debate->getPUserId();
        $prActionId = ReputationConstants::ACTION_ID_D_TARGET_DEBATE_REACTION_PUBLISH;
        $objectName = get_class($debate);
        $objectId = $debate->getId();

        $this->insertPUReputation($debateUserId, $prActionId, $objectName, $objectId);


        // Réaction associée à la réaction
        if ($subject->getTreeLevel() > 1) {
            $parent = $subject->getParent();

            $parentUserId = $parent->getPUserId();
            $prActionId = ReputationConstants::ACTION_ID_D_TARGET_REACTION_REACTION_PUBLISH;
            $objectName = get_class($parent);
            $objectId = $parent->getId();

            $this->insertPUReputation($parentUserId, $prActionId, $objectName, $objectId);
        } else {
            $parentUserId = $debate->getPUserId();
        }
    }

    /**
     * Publication d'un commentaire
     *
     * @param GenericEvent
     */
    public function onRCommentPublish(GenericEvent $event)
    {
        // $this->logger->info('*** onRCommentPublish');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_D_COMMENT_PUBLISH;
        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

        // Document associé au commentaire
        $document = $subject->getPDocument();
        $targetUserId = $document->getPUserId();

        switch ($document->getType()) {
            case ObjectTypeConstants::TYPE_DEBATE:
                $prActionId = ReputationConstants::ACTION_ID_D_TARGET_DEBATE_COMMENT_PUBLISH;
                $this->insertPUReputation($targetUserId, $prActionId, $objectName, $objectId);
                break;
            case ObjectTypeConstants::TYPE_REACTION:
                $prActionId = ReputationConstants::ACTION_ID_D_TARGET_REACTION_COMMENT_PUBLISH;
                $this->insertPUReputation($targetUserId, $prActionId, $objectName, $objectId);
                break;
            default:
                throw new InconsistentDataException(sprintf('Object type %s not managed', $document->getType()));
        }
    }


    /**
     * Note positive sur un document
     *
     * @param GenericEvent
     */
    public function onRNotePos(GenericEvent $event)
    {
        // $this->logger->info('*** onRNotePos');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');

        $objectName = get_class($subject);
        $objectId = $subject->getId();

        switch ($objectName) {
            case 'Politizr\Model\PDDebate':
                $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_DEBATE_NOTE_POS;

                // Auteur associé
                $userIdAuthor = $subject->getPUserId();
                $prActionIdAuthor = ReputationConstants::ACTION_ID_D_TARGET_DEBATE_NOTE_POS;

                $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
                $this->insertPUReputation($userIdAuthor, $prActionIdAuthor, $objectName, $objectId);

                break;
            case 'Politizr\Model\PDReaction':
                $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_REACTION_NOTE_POS;

                // Auteur associé
                $userIdAuthor = $subject->getPUserId();
                $prActionIdAuthor = ReputationConstants::ACTION_ID_D_TARGET_REACTION_NOTE_POS;

                $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
                $this->insertPUReputation($userIdAuthor, $prActionIdAuthor, $objectName, $objectId);

                break;
            case 'Politizr\Model\PDDComment':
            case 'Politizr\Model\PDRComment':
                $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_COMMENT_NOTE_POS;

                // Auteur associé
                $userIdAuthor = $subject->getPUserId();
                $prActionIdAuthor = ReputationConstants::ACTION_ID_D_TARGET_COMMENT_NOTE_POS;

                $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
                $this->insertPUReputation($userIdAuthor, $prActionIdAuthor, $objectName, $objectId);

                break;
            default:
                throw new InconsistentDataException(sprintf('Object name %s not managed', $objectName));
        }
    }

    /**
     * Note négative sur un document
     *
     * @param GenericEvent
     */
    public function onRNoteNeg(GenericEvent $event)
    {
        // $this->logger->info('*** onRNoteNeg');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');

        $objectName = get_class($subject);
        $objectId = $subject->getId();

        switch (get_class($subject)) {
            case 'Politizr\Model\PDDebate':
                $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_DEBATE_NOTE_NEG;

                // Auteur associé
                $userIdAuthor = $subject->getPUserId();
                $prActionIdAuthor = ReputationConstants::ACTION_ID_D_TARGET_DEBATE_NOTE_NEG;

                $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
                $this->insertPUReputation($userIdAuthor, $prActionIdAuthor, $objectName, $objectId);

                break;
            case 'Politizr\Model\PDReaction':
                $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_REACTION_NOTE_NEG;

                // Auteur associé
                $userIdAuthor = $subject->getPUserId();
                $prActionIdAuthor = ReputationConstants::ACTION_ID_D_TARGET_REACTION_NOTE_NEG;

                $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
                $this->insertPUReputation($userIdAuthor, $prActionIdAuthor, $objectName, $objectId);

                break;
            case 'Politizr\Model\PDDComment':
            case 'Politizr\Model\PDRComment':
                $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_COMMENT_NOTE_NEG;

                // Auteur associé
                $userIdAuthor = $subject->getPUserId();
                $prActionIdAuthor = ReputationConstants::ACTION_ID_D_TARGET_COMMENT_NOTE_NEG;

                $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
                $this->insertPUReputation($userIdAuthor, $prActionIdAuthor, $objectName, $objectId);

                break;
            default:
                throw new InconsistentDataException(sprintf('Object type %s not managed', get_class($subject)));
        }
    }


    /**
     * Suivi d'un débat
     *
     * @param GenericEvent
     */
    public function onRDebateFollow(GenericEvent $event)
    {
        // $this->logger->info('*** onRDebateFollow');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_DEBATE_FOLLOW;

        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

        // Auteur du débat
        $userId = $subject->getPUserId();
        $prActionId = ReputationConstants::ACTION_ID_D_TARGET_DEBATE_FOLLOW;

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

    }

    /**
     * Suivi d'un user
     *
     * @param GenericEvent
     */
    public function onRUserFollow(GenericEvent $event)
    {
        // $this->logger->info('*** onRUserFollow');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_U_AUTHOR_USER_FOLLOW;

        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

        // User suivi
        $prActionId = ReputationConstants::ACTION_ID_U_TARGET_USER_FOLLOW;

        $this->insertPUReputation($objectId, $prActionId, $objectName, $userId);
    }

    /**
     * Ne plus suivre un débat
     *
     * @param GenericEvent
     */
    public function onRDebateUnfollow(GenericEvent $event)
    {
        // $this->logger->info('*** onRDebateUnfollow');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_D_AUTHOR_DEBATE_UNFOLLOW;

        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

        // Auteur du débat
        $userId = $subject->getPUserId();
        $prActionId = ReputationConstants::ACTION_ID_D_TARGET_DEBATE_UNFOLLOW;

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

    }

    /**
     * Ne plus suivre un user
     *
     * @param GenericEvent
     */
    public function onRUserUnfollow(GenericEvent $event)
    {
        // $this->logger->info('*** onRUserUnfollow');

        $subject = $event->getSubject();
        $userId = $event->getArgument('user_id');
        $prActionId = ReputationConstants::ACTION_ID_U_AUTHOR_USER_UNFOLLOW;
        
        $objectName = get_class($subject);
        $objectId = $subject->getId();

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);

        // User suivi
        $userId = $subject->getId();
        $prActionId = ReputationConstants::ACTION_ID_U_TARGET_USER_UNFOLLOW;

        $this->insertPUReputation($userId, $prActionId, $objectName, $objectId);
    }


    // ******************************************************** //
    //                      Méthodes privées                    //
    // ******************************************************** //


    /**
     * Insertion en BDD
     *
     * @param $userId
     * @param $prActionId
     * @param $objectName
     * @param $objectId
     * @return PUReputation
     */
    private function insertPUReputation($userId, $prActionId, $objectName, $objectId)
    {
        // $this->logger->info('*** insertPUReputation');
        // $this->logger->info('userId = '.print_r($userId, true));
        // $this->logger->info('prActionId = '.print_r($prActionId, true));
        // $this->logger->info('objectName = '.print_r($objectName, true));
        // $this->logger->info('objectId = '.print_r($objectId, true));

        $userRepAction = null;
        if ($userId) {
            $userRepAction = new PUReputation();

            $userRepAction->setPUserId($userId);
            $userRepAction->setPRActionId($prActionId);
            $userRepAction->setPObjectName($objectName);
            $userRepAction->setPObjectId($objectId);
            
            $userRepAction->save();
        }

        return $userRepAction;
    }
}
