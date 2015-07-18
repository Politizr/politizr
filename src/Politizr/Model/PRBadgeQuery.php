<?php

namespace Politizr\Model;

use Politizr\Model\om\BasePRBadgeQuery;

/**
 *
 * @author Lionel Bouzonville
 */
class PRBadgeQuery extends BasePRBadgeQuery
{
    /* ######################################################################################################## */
    /*                                              FILTERBY IF                                                 */
    /* ######################################################################################################## */

    /**
     *
     * @param boolean $online
     * @return PRBadgeQuery
     */
    public function filterIfOnline($online = null)
    {
        return $this
            ->_if(null !== $online)
                ->filterByOnline($online)
            ->_endif();
    }

    /**
     *
     * @param boolean $typeId
     * @return PRBadgeQuery
     */
    public function filterIfTypeId($typeId = null)
    {
        return $this
            ->_if(null !== $typeId)
                ->filterByPRBadgeTypeId($typeId)
            ->_else()
                ->orderByPRBadgeTypeId()
            ->_endif();
    }
}
