<?php

namespace Politizr\Model\om;

use \BasePeer;
use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Politizr\Model\PLCity;
use Politizr\Model\PUReactionPLC;
use Politizr\Model\PUReactionPLCPeer;
use Politizr\Model\PUReactionPLCQuery;
use Politizr\Model\PUser;

/**
 * @method PUReactionPLCQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PUReactionPLCQuery orderByPLCityId($order = Criteria::ASC) Order by the p_l_city_id column
 * @method PUReactionPLCQuery orderByPUserId($order = Criteria::ASC) Order by the p_user_id column
 * @method PUReactionPLCQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method PUReactionPLCQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method PUReactionPLCQuery groupById() Group by the id column
 * @method PUReactionPLCQuery groupByPLCityId() Group by the p_l_city_id column
 * @method PUReactionPLCQuery groupByPUserId() Group by the p_user_id column
 * @method PUReactionPLCQuery groupByCreatedAt() Group by the created_at column
 * @method PUReactionPLCQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method PUReactionPLCQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PUReactionPLCQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PUReactionPLCQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PUReactionPLCQuery leftJoinPUReactionPLCity($relationAlias = null) Adds a LEFT JOIN clause to the query using the PUReactionPLCity relation
 * @method PUReactionPLCQuery rightJoinPUReactionPLCity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PUReactionPLCity relation
 * @method PUReactionPLCQuery innerJoinPUReactionPLCity($relationAlias = null) Adds a INNER JOIN clause to the query using the PUReactionPLCity relation
 *
 * @method PUReactionPLCQuery leftJoinPUReactionPUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the PUReactionPUser relation
 * @method PUReactionPLCQuery rightJoinPUReactionPUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PUReactionPUser relation
 * @method PUReactionPLCQuery innerJoinPUReactionPUser($relationAlias = null) Adds a INNER JOIN clause to the query using the PUReactionPUser relation
 *
 * @method PUReactionPLC findOne(PropelPDO $con = null) Return the first PUReactionPLC matching the query
 * @method PUReactionPLC findOneOrCreate(PropelPDO $con = null) Return the first PUReactionPLC matching the query, or a new PUReactionPLC object populated from the query conditions when no match is found
 *
 * @method PUReactionPLC findOneByPLCityId(int $p_l_city_id) Return the first PUReactionPLC filtered by the p_l_city_id column
 * @method PUReactionPLC findOneByPUserId(int $p_user_id) Return the first PUReactionPLC filtered by the p_user_id column
 * @method PUReactionPLC findOneByCreatedAt(string $created_at) Return the first PUReactionPLC filtered by the created_at column
 * @method PUReactionPLC findOneByUpdatedAt(string $updated_at) Return the first PUReactionPLC filtered by the updated_at column
 *
 * @method array findById(int $id) Return PUReactionPLC objects filtered by the id column
 * @method array findByPLCityId(int $p_l_city_id) Return PUReactionPLC objects filtered by the p_l_city_id column
 * @method array findByPUserId(int $p_user_id) Return PUReactionPLC objects filtered by the p_user_id column
 * @method array findByCreatedAt(string $created_at) Return PUReactionPLC objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return PUReactionPLC objects filtered by the updated_at column
 */
abstract class BasePUReactionPLCQuery extends ModelCriteria
{
    // query_cache behavior
    protected $queryKey = '';

    /**
     * Initializes internal state of BasePUReactionPLCQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Politizr\\Model\\PUReactionPLC';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PUReactionPLCQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PUReactionPLCQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PUReactionPLCQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PUReactionPLCQuery) {
            return $criteria;
        }
        $query = new PUReactionPLCQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   PUReactionPLC|PUReactionPLC[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PUReactionPLCPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PUReactionPLCPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 PUReactionPLC A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 PUReactionPLC A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `p_l_city_id`, `p_user_id`, `created_at`, `updated_at` FROM `p_u_reaction_p_l_c` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new PUReactionPLC();
            $obj->hydrate($row);
            PUReactionPLCPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return PUReactionPLC|PUReactionPLC[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|PUReactionPLC[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PUReactionPLCPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PUReactionPLCPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PUReactionPLCPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PUReactionPLCPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PUReactionPLCPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the p_l_city_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPLCityId(1234); // WHERE p_l_city_id = 1234
     * $query->filterByPLCityId(array(12, 34)); // WHERE p_l_city_id IN (12, 34)
     * $query->filterByPLCityId(array('min' => 12)); // WHERE p_l_city_id >= 12
     * $query->filterByPLCityId(array('max' => 12)); // WHERE p_l_city_id <= 12
     * </code>
     *
     * @see       filterByPUReactionPLCity()
     *
     * @param     mixed $pLCityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterByPLCityId($pLCityId = null, $comparison = null)
    {
        if (is_array($pLCityId)) {
            $useMinMax = false;
            if (isset($pLCityId['min'])) {
                $this->addUsingAlias(PUReactionPLCPeer::P_L_CITY_ID, $pLCityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pLCityId['max'])) {
                $this->addUsingAlias(PUReactionPLCPeer::P_L_CITY_ID, $pLCityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PUReactionPLCPeer::P_L_CITY_ID, $pLCityId, $comparison);
    }

    /**
     * Filter the query on the p_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPUserId(1234); // WHERE p_user_id = 1234
     * $query->filterByPUserId(array(12, 34)); // WHERE p_user_id IN (12, 34)
     * $query->filterByPUserId(array('min' => 12)); // WHERE p_user_id >= 12
     * $query->filterByPUserId(array('max' => 12)); // WHERE p_user_id <= 12
     * </code>
     *
     * @see       filterByPUReactionPUser()
     *
     * @param     mixed $pUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterByPUserId($pUserId = null, $comparison = null)
    {
        if (is_array($pUserId)) {
            $useMinMax = false;
            if (isset($pUserId['min'])) {
                $this->addUsingAlias(PUReactionPLCPeer::P_USER_ID, $pUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pUserId['max'])) {
                $this->addUsingAlias(PUReactionPLCPeer::P_USER_ID, $pUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PUReactionPLCPeer::P_USER_ID, $pUserId, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PUReactionPLCPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PUReactionPLCPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PUReactionPLCPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PUReactionPLCPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PUReactionPLCPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PUReactionPLCPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related PLCity object
     *
     * @param   PLCity|PropelObjectCollection $pLCity The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PUReactionPLCQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPUReactionPLCity($pLCity, $comparison = null)
    {
        if ($pLCity instanceof PLCity) {
            return $this
                ->addUsingAlias(PUReactionPLCPeer::P_L_CITY_ID, $pLCity->getId(), $comparison);
        } elseif ($pLCity instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PUReactionPLCPeer::P_L_CITY_ID, $pLCity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPUReactionPLCity() only accepts arguments of type PLCity or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PUReactionPLCity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function joinPUReactionPLCity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PUReactionPLCity');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PUReactionPLCity');
        }

        return $this;
    }

    /**
     * Use the PUReactionPLCity relation PLCity object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PLCityQuery A secondary query class using the current class as primary query
     */
    public function usePUReactionPLCityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPUReactionPLCity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PUReactionPLCity', '\Politizr\Model\PLCityQuery');
    }

    /**
     * Filter the query by a related PUser object
     *
     * @param   PUser|PropelObjectCollection $pUser The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PUReactionPLCQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPUReactionPUser($pUser, $comparison = null)
    {
        if ($pUser instanceof PUser) {
            return $this
                ->addUsingAlias(PUReactionPLCPeer::P_USER_ID, $pUser->getId(), $comparison);
        } elseif ($pUser instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PUReactionPLCPeer::P_USER_ID, $pUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPUReactionPUser() only accepts arguments of type PUser or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PUReactionPUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function joinPUReactionPUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PUReactionPUser');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PUReactionPUser');
        }

        return $this;
    }

    /**
     * Use the PUReactionPUser relation PUser object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PUserQuery A secondary query class using the current class as primary query
     */
    public function usePUReactionPUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPUReactionPUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PUReactionPUser', '\Politizr\Model\PUserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   PUReactionPLC $pUReactionPLC Object to remove from the list of results
     *
     * @return PUReactionPLCQuery The current query, for fluid interface
     */
    public function prune($pUReactionPLC = null)
    {
        if ($pUReactionPLC) {
            $this->addUsingAlias(PUReactionPLCPeer::ID, $pUReactionPLC->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     PUReactionPLCQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PUReactionPLCPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     PUReactionPLCQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PUReactionPLCPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     PUReactionPLCQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PUReactionPLCPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     PUReactionPLCQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PUReactionPLCPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     PUReactionPLCQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PUReactionPLCPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     PUReactionPLCQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PUReactionPLCPeer::CREATED_AT);
    }
    // query_cache behavior

    public function setQueryKey($key)
    {
        $this->queryKey = $key;

        return $this;
    }

    public function getQueryKey()
    {
        return $this->queryKey;
    }

    public function cacheContains($key)
    {

        return apc_fetch($key);
    }

    public function cacheFetch($key)
    {

        return apc_fetch($key);
    }

    public function cacheStore($key, $value, $lifetime = 3600)
    {
        apc_store($key, $value, $lifetime);
    }

    protected function doSelect($con)
    {
        // check that the columns of the main class are already added (if this is the primary ModelCriteria)
        if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
            $this->addSelfSelectColumns();
        }
        $this->configureSelectColumns();

        $dbMap = Propel::getDatabaseMap(PUReactionPLCPeer::DATABASE_NAME);
        $db = Propel::getDB(PUReactionPLCPeer::DATABASE_NAME);

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            $params = array();
            $sql = BasePeer::createSelectSql($this, $params);
            if ($key) {
                $this->cacheStore($key, $sql);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
            } catch (Exception $e) {
                Propel::log($e->getMessage(), Propel::LOG_ERR);
                throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
            }

        return $stmt;
    }

    protected function doCount($con)
    {
        $dbMap = Propel::getDatabaseMap($this->getDbName());
        $db = Propel::getDB($this->getDbName());

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            // check that the columns of the main class are already added (if this is the primary ModelCriteria)
            if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
                $this->addSelfSelectColumns();
            }

            $this->configureSelectColumns();

            $needsComplexCount = $this->getGroupByColumns()
                || $this->getOffset()
                || $this->getLimit()
                || $this->getHaving()
                || in_array(Criteria::DISTINCT, $this->getSelectModifiers());

            $params = array();
            if ($needsComplexCount) {
                if (BasePeer::needsSelectAliases($this)) {
                    if ($this->getHaving()) {
                        throw new PropelException('Propel cannot create a COUNT query when using HAVING and  duplicate column names in the SELECT part');
                    }
                    $db->turnSelectColumnsToAliases($this);
                }
                $selectSql = BasePeer::createSelectSql($this, $params);
                $sql = 'SELECT COUNT(*) FROM (' . $selectSql . ') propelmatch4cnt';
            } else {
                // Replace SELECT columns with COUNT(*)
                $this->clearSelectColumns()->addSelectColumn('COUNT(*)');
                $sql = BasePeer::createSelectSql($this, $params);
            }

            if ($key) {
                $this->cacheStore($key, $sql);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute COUNT statement [%s]', $sql), $e);
        }

        return $stmt;
    }

}
