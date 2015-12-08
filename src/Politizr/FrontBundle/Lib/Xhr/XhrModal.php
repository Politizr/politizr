<?php
namespace Politizr\FrontBundle\Lib\Xhr;

use Symfony\Component\HttpFoundation\Request;

use Politizr\Exception\InconsistentDataException;
use Politizr\Exception\BoxErrorException;

use Politizr\Constant\ObjectTypeConstants;
use Politizr\Constant\ListingConstants;

use Politizr\Model\PDDebateQuery;
use Politizr\Model\PDReactionQuery;
use Politizr\Model\PUserQuery;
use Politizr\Model\PTagQuery;
use Politizr\Model\PQOrganizationQuery;

/**
 * XHR service for modal management.
 *
 * @author Lionel Bouzonville
 */
class XhrModal
{
    private $securityTokenStorage;
    private $templating;
    private $tagService;
    private $logger;

    /**
     *
     * @param @security.token_storage
     * @param @templating
     * @param @politizr.functional.tag
     * @param @logger
     */
    public function __construct(
        $securityTokenStorage,
        $templating,
        $tagService,
        $logger
    ) {
        $this->securityTokenStorage = $securityTokenStorage;

        $this->templating = $templating;
        
        $this->tagService = $tagService;

        $this->logger = $logger;
    }

    /* ######################################################################################################## */
    /*                                         PRIVATE FUNCTIONS                                                */
    /* ######################################################################################################## */

    /**
     * Return an array with request listing information:
     *    - order,
     *    - filters,
     *    - offset,
     *    - associated object uuid (option),
     *
     * @return array[order,filters,offset,associatedObjectId]
     */
    private function getFiltersFromRequest(Request $request)
    {
        $order = $request->get('order');
        $this->logger->info('$order = ' . print_r($order, true));
        $filtersDate = $request->get('filtersDate');
        $this->logger->info('$filtersDate = ' . print_r($filtersDate, true));
        $filtersUserType = $request->get('filtersUserType');
        $this->logger->info('$filtersUserType = ' . print_r($filtersUserType, true));
        $offset = $request->get('offset');
        $this->logger->info('$offset = ' . print_r($offset, true));
        $uuid = $request->get('uuid');
        $this->logger->info('$uuid = ' . print_r($uuid, true));

        // regroupement des filtres
        $filters = array_merge($filtersDate, $filtersUserType);

        return [ $order, $filters, $offset, $uuid ];
    }

    /* ######################################################################################################## */
    /*                                   GENERIC MODAL FUNCTIONS                                                */
    /* ######################################################################################################## */

    /**
     * Paginated modal listing loading
     */
    public function modalPaginatedList(Request $request)
    {
        $this->logger->info('*** modalPaginatedList');
        
        // Request arguments
        $twigTemplate = $request->get('twigTemplate');
        $this->logger->info('$twigTemplate = ' . print_r($twigTemplate, true));
        $model = $request->get('model');
        $this->logger->info('$model = ' . print_r($model, true));
        $uuid = $request->get('uuid');
        $this->logger->info('$uuid = ' . print_r($uuid, true));
        $defaultType = $request->get('defaultType');
        $this->logger->info('$defaultType = ' . print_r($defaultType, true));
        $defaultOrderFilters = $request->get('defaultOrderFilters');
        $this->logger->info('$defaultOrderFilters = ' . print_r($defaultOrderFilters, true));

        // Function process
        $subject = null;
        if ($model && $uuid) {
            $queryModel = 'Politizr\Model\\' . $model . 'Query';
            $subject = $queryModel::create()
                ->filterByUuid($uuid)
                ->findOne();
        }

        $html = $this->templating->render(
            'PolitizrFrontBundle:PaginatedList:'.$twigTemplate,
            array(
                'subject' => $subject,
                'defaultType' => $defaultType,
                'defaultOrderFilters' => $defaultOrderFilters,
            )
        );

        return array(
            'html' => $html,
            );
    }

    /**
     * Filters loading
     */
    public function filters(Request $request)
    {
        $this->logger->info('*** filters');
        
        // Request arguments
        $defaultType = $request->get('defaultType');
        $this->logger->info('$defaultType = ' . print_r($defaultType, true));
        $defaultOrderFilters = $request->get('defaultOrderFilters');
        $this->logger->info('$defaultOrderFilters = ' . print_r($defaultOrderFilters, true));

        if (ObjectTypeConstants::CONTEXT_DEBATE === $defaultType) {
            $listOrder = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_formOrderByDebate.html.twig',
                array(
                    'defaultOrder' => $defaultOrderFilters[0]['value'],
                )
            );
            $listFilter = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_formFiltersByDebate.html.twig',
                array(
                    'defaultFiltersByDate' => $defaultOrderFilters[1]['value'],
                    'defaultFiltersByUser' => $defaultOrderFilters[2]['value'],
                )
            );
        } elseif (ObjectTypeConstants::CONTEXT_REACTION === $defaultType) {
            $listOrder = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_formOrderByReaction.html.twig',
                array(
                    'defaultOrder' => $defaultOrderFilters[0]['value'],
                )
            );
            $listFilter = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_formFiltersByReaction.html.twig',
                array(
                    'defaultFiltersByDate' => $defaultOrderFilters[1]['value'],
                    'defaultFiltersByUser' => $defaultOrderFilters[2]['value'],
                )
            );
        } elseif (ObjectTypeConstants::CONTEXT_USER === $defaultType) {
            $listOrder = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_formOrderByUser.html.twig',
                array(
                    'defaultOrder' => $defaultOrderFilters[0]['value'],
                )
            );
            $listFilter = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_formFiltersByUser.html.twig',
                array(
                    'defaultFiltersByDate' => $defaultOrderFilters[1]['value'],
                    'defaultFiltersByUser' => $defaultOrderFilters[2]['value'],
                )
            );
        }

        // Renvoi de l'ensemble des blocs HTML maj
        return array(
            'listOrder' => $listOrder,
            'listFilter' => $listFilter,
            );
    }

    /* ######################################################################################################## */
    /*                                                 RANKING                                                  */
    /* ######################################################################################################## */

    /**
     * Debate ranking listing
     */
    public function rankingDebateList(Request $request)
    {
        $this->logger->info('*** rankingDebateList');

        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];

        // Function process
        $debates = PDDebateQuery::create()
                    ->distinct()
                    ->online()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($debates) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($debates) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_RANKING,
                    'context' => ListingConstants::MODAL_DEBATES,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_debates.html.twig',
                array(
                    'debates' => $debates,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /**
     * Reaction ranking listing
     */
    public function rankingReactionList(Request $request)
    {
        $this->logger->info('*** rankingReactionList');

        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];

        // Function process
        $reactions = PDReactionQuery::create()
                    ->distinct()
                    ->online()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($reactions) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($reactions) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_RANKING,
                    'context' => ListingConstants::MODAL_REACTIONS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_reactions.html.twig',
                array(
                    'reactions' => $reactions,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /**
     * Ranking user listing
     */
    public function rankingUserList(Request $request)
    {
        $this->logger->info('*** rankingUserList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];
        $this->logger->info('order = '.print_r($order, true));
        $this->logger->info('filters = '.print_r($filters, true));
        $this->logger->info('offset = '.print_r($offset, true));

        // Function process
        $users = PUserQuery::create()
                    ->distinct()
                    ->online()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($users) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($users) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_RANKING,
                    'context' => ListingConstants::MODAL_USERS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_users.html.twig',
                array(
                    'users' => $users,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                    )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /* ######################################################################################################## */
    /*                                                 SUGGESTION                                                  */
    /* ######################################################################################################## */

    /**
     * Suggestion debate listing
     */
    public function suggestionDebateList(Request $request)
    {
        $this->logger->info('*** suggestionDebateList');
        
        // Request arguments
        $offset = $request->get('offset');
        $this->logger->info('$offset = ' . print_r($offset, true));
        
        // Function process
        $user = $this->securityTokenStorage->getToken()->getUser();

        $debates = PDDebateQuery::create()->findBySuggestion($user->getId(), $offset, ListingConstants::MODAL_CLASSIC_PAGINATION);
        
        $moreResults = false;
        if (sizeof($debates) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($debates) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_SUGGESTION,
                    'context' => ListingConstants::MODAL_DEBATES,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_debates.html.twig',
                array(
                    'debates' => $debates,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /**
     * Suggestion reaction listing
     */
    public function suggestionReactionList(Request $request)
    {
        $this->logger->info('*** suggestionReactionList');
        
        // Request arguments
        $offset = $request->get('offset');
        $this->logger->info('$offset = ' . print_r($offset, true));
        
        // Function process
        $user = $this->securityTokenStorage->getToken()->getUser();

        $reactions = PDReactionQuery::create()->findBySuggestion($user->getId(), $offset, ListingConstants::MODAL_CLASSIC_PAGINATION);
        
        $moreResults = false;
        if (sizeof($reactions) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($reactions) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_SUGGESTION,
                    'context' => ListingConstants::MODAL_REACTIONS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_reactions.html.twig',
                array(
                    'reactions' => $reactions,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
        );
    }

    /**
     * Suggestion user listing
     */
    public function suggestionUserList(Request $request)
    {
        $this->logger->info('*** suggestionUserList');
        
        // Request arguments
        $offset = $request->get('offset');
        $this->logger->info('$offset = ' . print_r($offset, true));
        
        // Function process
        $user = $this->securityTokenStorage->getToken()->getUser();

        $users = PUserQuery::create()->findBySuggestion($user->getId(), $offset, ListingConstants::MODAL_CLASSIC_PAGINATION);
        
        $moreResults = false;
        if (sizeof($users) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0) {
            // hack for managing user null
            $nbUsers = 0;
            foreach ($users as $user) {
                if ($user && $user->getSlug()) {
                    $nbUsers++;
                    break;
                }
            }
        }

        if ($offset == 0 && $nbUsers == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_SUGGESTION,
                    'context' => ListingConstants::MODAL_USERS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_users.html.twig',
                array(
                    'users' => $users,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                    )
            );
        }

        return array(
            'html' => $html
            );
    }


    /* ######################################################################################################## */
    /*                                                   TAG                                                    */
    /* ######################################################################################################## */

    /**
     * Tag debate listing
     */
    public function tagDebateList(Request $request)
    {
        $this->logger->info('*** tagDebateList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];
        $uuid = $queryParams[3];

        // Retrieve subject
        $tag = PTagQuery::create()->filterByUuid($uuid)->findOne();

        // Compute relative geo tag ids
        $tagIds = $this->tagService->computePublicationGeotagRelativeIds($tag->getId());

        // Function process
        $debates = PDDebateQuery::create()
                    ->distinct()
                    ->online()
                    ->usePDDTaggedTQuery()
                        ->filterByPTagId($tagIds)
                    ->endUse()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($debates) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($debates) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_TAG,
                    'context' => ListingConstants::MODAL_DEBATES,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_debates.html.twig',
                array(
                    'debates' => $debates,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /**
     * Tag reaction listing
     */
    public function tagReactionList(Request $request)
    {
        $this->logger->info('*** tagReactionList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];
        $uuid = $queryParams[3];

        // Retrieve subject
        $tag = PTagQuery::create()->filterByUuid($uuid)->findOne();

        // Compute relative geo tag ids
        $tagIds = $this->tagService->computePublicationGeotagRelativeIds($tag->getId());

        // Function process
        $reactions = PDReactionQuery::create()
                    ->distinct()
                    ->online()
                    ->usePDRTaggedTQuery()
                        ->filterByPTagId($tagIds)
                    ->endUse()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($reactions) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($reactions) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_TAG,
                    'context' => ListingConstants::MODAL_REACTIONS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_reactions.html.twig',
                array(
                    'reactions' => $reactions,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /**
     * Tag user listing
     */
    public function tagUserList(Request $request)
    {
        $this->logger->info('*** tagUserList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];
        $uuid = $queryParams[3];

        // Retrieve subject
        $tag = PTagQuery::create()->filterByUuid($uuid)->findOne();

        // Compute relative geo tag ids
        $tagIds = $this->tagService->computeUserGeotagRelativeIds($tag->getId());

        // Function process
        $users = PUserQuery::create()
                    ->distinct()
                    ->online()
                    ->usePuTaggedTPUserQuery()
                        ->filterByPTagId($tagIds)
                    ->endUse()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($users) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($users) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_TAG,
                    'context' => ListingConstants::MODAL_USERS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_users.html.twig',
                array(
                    'users' => $users,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                    )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /* ######################################################################################################## */
    /*                                            ORGANIZATION                                                  */
    /* ######################################################################################################## */

    /**
     * Organization user listing
     */
    public function organizationUserList(Request $request)
    {
        $this->logger->info('*** organizationUserList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];
        $uuid = $queryParams[3];

        // Retrieve subject
        $organization = PQOrganizationQuery::create()->filterByUuid($uuid)->findOne();

        // Function process
        $users = PUserQuery::create()
                    ->distinct()
                    ->online()
                    ->usePUCurrentQOPUserQuery(null, \Criteria::LEFT_JOIN)
                        ->filterByPQOrganizationId($organization->getId())
                    ->endUse()
                    ->_or()
                    ->usePUAffinityQOPUserQuery(null, \Criteria::LEFT_JOIN)
                        ->filterByPQOrganizationId($organization->getId())
                    ->endUse()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find()
                    ;

        $moreResults = false;
        if (sizeof($users) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($users) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_ORGANIZATION,
                    'context' => ListingConstants::MODAL_USERS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_users.html.twig',
                array(
                    'users' => $users,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                    )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /* ######################################################################################################## */
    /*                                                FOLLOWED                                                  */
    /* ######################################################################################################## */

    /**
     * Followed debates listing
     */
    public function followedDebateList(Request $request)
    {
        $this->logger->info('*** followedDebateList');
  
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];

        // Function process
        $user = $this->securityTokenStorage->getToken()->getUser();

        $debates = PDDebateQuery::create()
                    ->distinct()
                    ->online()
                    ->usePuFollowDdPDDebateQuery()
                        ->filterByPUserId($user->getId())
                    ->endUse()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ->find();

        $moreResults = false;
        if (sizeof($debates) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($debates) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_FOLLOWED,
                    'context' => ListingConstants::MODAL_DEBATES,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_debates.html.twig',
                array(
                    'debates' => $debates,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /**
     * Followed users listing
     */
    public function followedUserList(Request $request)
    {
        $this->logger->info('*** followedUserList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];

        // Function process
        $user = $this->securityTokenStorage->getToken()->getUser();

        $query = PUserQuery::create()
                    ->distinct()
                    ->online()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ;

        $users = $user->getSubscribers($query);

        $moreResults = false;
        if (sizeof($users) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($users) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_FOLLOWED,
                    'context' => ListingConstants::MODAL_USERS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_users.html.twig',
                array(
                    'users' => $users,
                    'order' => $order,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                    )
            );
        }

        return array(
            'html' => $html,
            );
    }

    /* ######################################################################################################## */
    /*                                                FOLLOWER                                                  */
    /* ######################################################################################################## */

    /**
     * Follower listing
     */
    public function followerList(Request $request)
    {
        $this->logger->info('*** followerList');
        
        // Request arguments
        $queryParams = $this->getFiltersFromRequest($request);
        $order = $queryParams[0];
        $filters = $queryParams[1];
        $offset = $queryParams[2];
        $uuid = $queryParams[3];

        // Function process
        $user = PUserQuery::create()->filterByUuid($uuid)->findOne();

        $query = PUserQuery::create()
                    ->distinct()
                    ->online()
                    ->filterByKeywords($filters)
                    ->orderWithKeyword($order)
                    ->limit(ListingConstants::MODAL_CLASSIC_PAGINATION)
                    ->offset($offset)
                    ;

        $users = $user->getFollowers($query);

        $moreResults = false;
        if (sizeof($users) == ListingConstants::MODAL_CLASSIC_PAGINATION) {
            $moreResults = true;
        }

        if ($offset == 0 && count($users) == 0) {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_noResult.html.twig',
                array(
                    'type' => ListingConstants::MODAL_TYPE_FOLLOWER,
                    'context' => ListingConstants::MODAL_USERS,
                )
            );
        } else {
            $html = $this->templating->render(
                'PolitizrFrontBundle:PaginatedList:_users.html.twig',
                array(
                    'users' => $users,
                    'order' => $order,
                    'offset' => intval($offset) + ListingConstants::MODAL_CLASSIC_PAGINATION,
                    'moreResults' => $moreResults,
                    'paginateNextAction' => 'paginateNext'
                    )
            );
        }

        return array(
            'html' => $html,
            );
    }
}
