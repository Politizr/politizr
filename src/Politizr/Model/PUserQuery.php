<?php

namespace Politizr\Model;

use Politizr\Model\om\BasePUserQuery;

use Politizr\Model\PUser;
use Politizr\Model\PUType;
use Politizr\Model\PUStatus;

class PUserQuery extends BasePUserQuery
{


    // *****************************    AGGREGATIONS / UTILES    ************************* //
    
    /**
     * Cumule les contraintes associés à un objet en ligne
     */
    public function online() {
    	return $this->filterByOnline(true)->filterByPUStatusId(PUStatus::STATUS_ACTIV);
    }

	/**
	 *	Filtre à appliquer aux objets retournés en page d'accueil
	 *  TODO qu'est ce qu'un auteur "populaire"? + requête
	 *		> + gros score reputation?   /!\ pas de note pour les élus?
	 *		> + de followers?
	 *
	 */
	public function popularity($limit = 10) {
		// followers
		return $this->joinPUFollowURelatedByPUserId('PUFollowU', \Criteria::LEFT_JOIN)
				->withColumn('COUNT(PUFollowU.PUserId)', 'NbFollowers')
				->groupBy('Id')
				->setLimit($limit)
				->orderBy('NbFollowers', \Criteria::DESC)
				;
	}
}
