<?php
namespace Politizr\FrontBundle\Lib\Functional;

use Symfony\Component\EventDispatcher\GenericEvent;

use Politizr\Exception\InconsistentDataException;

use Politizr\Model\PUser;
use Politizr\Model\PCOwner;
use Politizr\Model\PCircle;
use Politizr\Model\PCTopic;

use Politizr\Model\PCOwnerQuery;
use Politizr\Model\PCircleQuery;
use Politizr\Model\PUserQuery;
use Politizr\Model\PCTopicQuery;
use Politizr\Model\PUInPCQuery;
use Politizr\Model\PDDebateQuery;
use Politizr\Model\PDReactionQuery;
use Politizr\Model\PDDCommentQuery;
use Politizr\Model\PDRCommentQuery;

use \PropelCollection;

/**
 * Functional service for circle management.
 *
 * @author Lionel Bouzonville
 */
class CircleService
{
    private $securityTokenStorage;
    private $securityAuthorizationChecker;
    
    private $circleManager;

    private $eventDispatcher;

    private $logger;

    /**
     *
     * @param @security.token_storage
     * @param @security.authorization_checker
     * @param @politizr.manager.circle
     * @param @event_dispatcher
     * @param @logger
     */
    public function __construct(
        $securityTokenStorage,
        $securityAuthorizationChecker,
        $circleManager,
        $eventDispatcher,
        $logger
    ) {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->securityAuthorizationChecker =$securityAuthorizationChecker;

        $this->circleManager = $circleManager;

        $this->eventDispatcher = $eventDispatcher;

        $this->logger = $logger;
    }

    /* ######################################################################################################## */
    /*                                              CIRCLE FUNCTIONS                                            */
    /* ######################################################################################################## */

    /**
     * Add a user in a circle
     *
     * @param PUser $user
     * @param PCircle $circle
     */    
    public function addUserInCircle(PUser $user = null, PCircle $circle = null)
    {
        if (!$user || !$circle) {
            throw new InconsistentDataException('User or circle null');
        }
        $this->circleManager->createUserInCircle($user->getId(), $circle->getId());

        // events
        $event = new GenericEvent($circle, array('p_user' => $user,));
        $dispatcher = $this->eventDispatcher->dispatch('c_subscribe', $event);
    }

    /**
     * Remove a user from a circle
     *
     * @param PUser $user
     * @param PCircle $circle
     */    
    public function removeUserFromCircle(PUser $user = null, PCircle $circle = null)
    {
        if (!$user || !$circle) {
            throw new InconsistentDataException('User or circle null');
        }
        $this->circleManager->deleteUserInCircle($user->getId(), $circle->getId());

        // events
        $event = new GenericEvent($circle, array('p_user' => $user,));
        $dispatcher = $this->eventDispatcher->dispatch('c_unsubscribe', $event);
    }

    /**
     * Remove a user authorization to publish reaction from a circle
     *
     * @param PUser $user
     * @param PCircle $circle
     * @param boolean $isAuthorizedReaction
     */    
    public function updateUserIsAuthorizedReactionInCircle(PUser $user = null, PCircle $circle = null, $isAuthorizedReaction)
    {
        if (!$user || !$circle) {
            throw new InconsistentDataException('User or circle null');
        }
        $this->circleManager->updateUserIsAuthorizedReactionInCircle($user->getId(), $circle->getId(), $isAuthorizedReaction);
    }

    /**
     * Get authorized circles by user
     *
     * @param PUser $user
     * @return PropelCollection[PCircle]
     */
    public function getAuthorizedCirclesByUser(PUser $user = null)
    {
        // $this->logger->info('*** getAuthorizedCirclesByUser');
        // $this->logger->info('$user = '.print_r($user, true));
        // $this->logger->info('$user->getPLCityId = '.print_r($user->getPLCityId(), true));

        if (!$user || !$user->getPLCityId()) {
            return null;
        }

        $circles = PCircleQuery::create()
                        ->filterByOnline(true)
                        ->usePCGroupLCQuery()
                            ->filterByPLCityId($user->getPLCityId())
                        ->endUse()
                        ->orderByRank()
                        ->find();

        return $circles;
    }

    /**
     * Get owners containing authorized circles by user
     *
     * @param PUser $user
     * @return PropelCollection[PCircle]
     */
    public function getAuthorizedOwnersByUser(PUser $user = null)
    {
        // $this->logger->info('*** getAuthorizedOwnersByUser');
        // $this->logger->info('$user = '.print_r($user, true));
        // $this->logger->info('$user->getPLCityId = '.print_r($user->getPLCityId(), true));

        if (!$user || !$user->getPLCityId()) {
            return null;
        }

        $owners = PCOwnerQuery::create()
                    ->usePCircleQuery()
                        ->filterByOnline(true)
                        ->usePCGroupLCQuery()
                            ->filterByPLCityId($user->getPLCityId())
                        ->endUse()
                    ->endUse()
                    ->distinct()
                    ->find();

        return $owners;
    }

    /**
     * Get membership circles' owners by user
     *
     * @param PUser $user
     * @return PropelCollection[PCOwner]
     */
    public function getOwnersByUser(PUser $user = null)
    {
        // $this->logger->info('*** getOwnersByUser');
        // $this->logger->info('$user = '.print_r($user, true));

        if (!$user) {
            throw new InconsistentDataException('User null');
        }

        $owners = PCOwnerQuery::create()
                    ->usePCircleQuery()
                        ->filterByOnline(true)
                        ->usePUinPCQuery()
                            ->filterByPUserId($user->getId())
                        ->endUse()
                    ->endUse()
                    ->distinct()
                    ->find();

        return $owners;
    }

    /**
     * Get owner's circles by user
     *
     * @param PCOwner $owner
     * @param PUser $user
     * @return PropelCollection[PCircle]
     */
    public function getOwnerCirclesByUser(PCOwner $owner, PUser $user)
    {
        // $this->logger->info('*** getPCOwnersByUser');
        // $this->logger->info('$user = '.print_r($user, true));

        if (!$owner) {
            throw new InconsistentDataException('Owner null');
        }
        if (!$user) {
            throw new InconsistentDataException('User null');
        }

        $circles = PCircleQuery::create()
                    ->filterByOnline(true)
                    ->filterByPCOwnerId($owner->getId())
                    ->usePUinPCQuery()
                        ->filterByPUserId($user->getId())
                    ->endUse()
                    ->orderByRank()
                    ->distinct()
                    ->find();

        return $circles;
    }

    /**
     * Get users in circle by circle id or all users if no circle id is specified
     *
     * @param int $circleId
     * @param boolean $isAuthorizedReaction
     * @param array $filters ['only_elected' => boolean, 'city_insee_code' => string, 'department_code' => string ]
     * @return PropelCollection[PUser]
     */
    public function getUsersInCircleByCircleId($circleId = null, $isAuthorizedReaction = null, $filters = null)
    {
        $users = PUserQuery::create()
            ->filterByCustomFilters($filters)
            ->_if($circleId)
                ->usePUinPCQuery()
                    ->filterByPCircleId($circleId)
                    ->_if($isAuthorizedReaction)
                        ->filterByIsAuthorizedReaction($isAuthorizedReaction)
                    ->_endif()
                ->endUse()
            ->_endif()
            ->orderByName()
            ->distinct()
            ->find();

        return $users;
    }

    /**
     * Check if user is member of circle
     *
     * @param PUser $user
     * @param PCircle $circle
     * @return boolean
     */
    public function isUserMemberOfCircle(PCircle $circle, PUser $user)
    {
        if (!$circle || !$user) {
            throw new InconsistentDataException('Circle or user null');
        }

        $nb = PUInPCQuery::create()
            ->filterByPUserId($user->getId())
            ->filterByPCircleId($circle->getId())
            ->count();

        if ($nb > 0) {
            return true;
        }

        return false;
    }

    /**
     * Return number of user's circles
     *
     * @param PUser $user
     * @return int
     */
    public function countUserCircles(PUser $user)
    {
        if (!$user) {
            throw new InconsistentDataException('User null');
        }

        $nb = PUInPCQuery::create()
            ->filterByPUserId($user->getId())
            ->count();

        return $nb;
    }

    /**
     * Get debates relative to a circle
     *
     * @param PCircle $circle
     * @return PropelCollection[PDDebate]
     */
    public function getDebatesByCircle(PCircle $circle = null)
    {
        if (!$circle) {
            throw new InconsistentDataException('Circle null');
        }

        $debates = PDDebateQuery::create()
            ->distinct()
            ->usePCTopicQuery()
                ->usePCircleQuery()
                    ->filterById($circle->getId())
                ->endUse()
            ->endUse()
            ->find();

        return $debates;
    }


    /**
     * Check if user has role to publish reaction in the circle
     *
     * @param PCircle $circle
     * @param PUser $user
     * @return boolean
     */
    public function isUserAuthorizedReaction(PCircle $circle, PUser $user)
    {
        if (!$circle || !$user) {
            throw new InconsistentDataException('Circle or user null');
        }

        $nb = PUInPCQuery::create()
            ->filterByPUserId($user->getId())
            ->filterByPCircleId($circle->getId())
            ->filterByIsAuthorizedReaction(true)
            ->count();

        if ($nb > 0) {
            return true;
        }

        return false;
    }

    /**
     * Get authorized reaction users by circle
     *
     * @param PUser $user
     * @param array|PUser $users
     * @return PropelCollection[PUser]
     */
    public function getAuthorizedReactionUsersByCircle(PCircle $circle, $users = null)
    {
        // $this->logger->info('*** getAuthorizedReactionUsersByCircle');
        // $this->logger->info('$circle = '.print_r($circle, true));

        if (!$circle) {
            return null;
        }

        $users = PUserQuery::create()
            ->usePUInPCQuery()
                ->filterByPCircleId($circle->getId())
                ->filterByIsAuthorizedReaction(true)
            ->endUse()
            ->_if($users !== null && $users instanceof PUser)
                ->filterById($users?$users->getId():null, ' NOT IN ')
            ->_endif()
            ->find();

        return $users;
    }

    /**
     * Get authorized reaction users ids by circle
     *
     * @param PUser $user
     * @param array|PUser $users
     * @return array
     */
    public function getAuthorizedReactionUsersIdsByCircle(PCircle $circle, $users = null)
    {
        $users = $this->getAuthorizedReactionUsersByCircle($circle, $users);

        $ids = array();
        foreach ($users as $user) {
            $ids[] = $user->getId();
        }

        return $ids;
    }

    /* ######################################################################################################## */
    /*                                              TOPIC FUNCTIONS                                             */
    /* ######################################################################################################## */
    
    /**
     * Update form options if topic has geoloc preset values
     *
     * @param PCTopic $topic
     * @param array $options
     */
    public function updateDocumentLocalizationTypeOptions(PCTopic $topic = null, & $options)
    {
        if ($topic && $topic->getForceGeolocType() && $topic->getForceGeolocId()) {
            $options['force_geoloc'] = true;
            $options['force_geoloc_type'] = $topic->getForceGeolocType();
            $options['force_geoloc_id'] = $topic->getForceGeolocId();
        }
    }

    /**
     * Get topic id list by user id
     *
     * @param int $userId
     * @return array
     */
    public function getTopicIdsByUserId($userId)
    {
        $topicIds = PCTopicQuery::create()
            ->select('Id')
            ->usePCircleQuery()
                ->usePUInPCQuery()
                    ->filterByPUserId($userId)
                ->endUse()
            ->endUse()
            ->find()
            ->toArray();

        return $topicIds;
    }

    /**
     * Get topic id list by user id
     *
     * @param int $userId
     * @return array
     */
    public function getPublicCircleTopicIds()
    {
        $topicIds = PCTopicQuery::create()
            ->select('Id')
            ->usePCircleQuery()
                ->filterByPublicCircle(true)
            ->endUse()
            ->find()
            ->toArray();

        return $topicIds;
    }

    /**
     * Return users by filtering those who are not in circle
     *
     * @param \PropelCollection $users
     * @param int $circleId
     * @return \PropelCollection
     */
    public function filterUsersNotInCircle(\PropelCollection $users, PCircle $circle)
    {
        foreach ($users as $key => $user) {
            if (!$this->isUserMemberOfCircle($circle, $user)) {
                $users->remove($key);
            }
        }
        return $users;
    }

    /**
     * Count number of PDDebate in a topic
     *
     * @param PCTopic $topic
     * @return int
     */
    public function countDebatesByTopic(PCTopic $topic)
    {
        if (!$topic) {
            return null;
        }

        $nb = PDDebateQuery::create()
            ->online()
            ->filterByPCTopicId($topic->getId())
            ->count();

        return $nb;
    }

    /**
     * Count number of PDReaction in a topic
     *
     * @param PCTopic $topic
     * @return int
     */
    public function countReactionsByTopic(PCTopic $topic)
    {
        if (!$topic) {
            return null;
        }

        $nb = PDReactionQuery::create()
            ->online()
            ->filterByPCTopicId($topic->getId())
            ->count();

        return $nb;
    }

    /**
     * Count number of PDDComment & PDRComment in a topic
     *
     * @param PCTopic $topic
     * @return int
     */
    public function countCommentsByTopic(PCTopic $topic)
    {
        if (!$topic) {
            return null;
        }

        $nbDebateComments = PDDCommentQuery::create()
            ->online()
            ->usePDDebateQuery()
                ->online()
                ->filterByPCTopicId($topic->getId())
            ->endUse()
            ->count();

        $nbReactionComments = PDRCommentQuery::create()
            ->online()
            ->usePDReactionQuery()
                ->online()
                ->filterByPCTopicId($topic->getId())
            ->endUse()
            ->count();

        $nb = $nbDebateComments + $nbReactionComments;

        return $nb;
    }
}
