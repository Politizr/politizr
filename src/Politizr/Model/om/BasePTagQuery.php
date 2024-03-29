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
use Politizr\Model\PDDTaggedT;
use Politizr\Model\PDDebate;
use Politizr\Model\PDRTaggedT;
use Politizr\Model\PDReaction;
use Politizr\Model\PEOPresetPT;
use Politizr\Model\PEOperation;
use Politizr\Model\PTTagType;
use Politizr\Model\PTag;
use Politizr\Model\PTagPeer;
use Politizr\Model\PTagQuery;
use Politizr\Model\PUTaggedT;
use Politizr\Model\PUser;

/**
 * @method PTagQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PTagQuery orderByUuid($order = Criteria::ASC) Order by the uuid column
 * @method PTagQuery orderByPTTagTypeId($order = Criteria::ASC) Order by the p_t_tag_type_id column
 * @method PTagQuery orderByPTParentId($order = Criteria::ASC) Order by the p_t_parent_id column
 * @method PTagQuery orderByPUserId($order = Criteria::ASC) Order by the p_user_id column
 * @method PTagQuery orderByPOwnerId($order = Criteria::ASC) Order by the p_owner_id column
 * @method PTagQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method PTagQuery orderByModerated($order = Criteria::ASC) Order by the moderated column
 * @method PTagQuery orderByModeratedAt($order = Criteria::ASC) Order by the moderated_at column
 * @method PTagQuery orderByOnline($order = Criteria::ASC) Order by the online column
 * @method PTagQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method PTagQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method PTagQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 *
 * @method PTagQuery groupById() Group by the id column
 * @method PTagQuery groupByUuid() Group by the uuid column
 * @method PTagQuery groupByPTTagTypeId() Group by the p_t_tag_type_id column
 * @method PTagQuery groupByPTParentId() Group by the p_t_parent_id column
 * @method PTagQuery groupByPUserId() Group by the p_user_id column
 * @method PTagQuery groupByPOwnerId() Group by the p_owner_id column
 * @method PTagQuery groupByTitle() Group by the title column
 * @method PTagQuery groupByModerated() Group by the moderated column
 * @method PTagQuery groupByModeratedAt() Group by the moderated_at column
 * @method PTagQuery groupByOnline() Group by the online column
 * @method PTagQuery groupByCreatedAt() Group by the created_at column
 * @method PTagQuery groupByUpdatedAt() Group by the updated_at column
 * @method PTagQuery groupBySlug() Group by the slug column
 *
 * @method PTagQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PTagQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PTagQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PTagQuery leftJoinPTTagType($relationAlias = null) Adds a LEFT JOIN clause to the query using the PTTagType relation
 * @method PTagQuery rightJoinPTTagType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PTTagType relation
 * @method PTagQuery innerJoinPTTagType($relationAlias = null) Adds a INNER JOIN clause to the query using the PTTagType relation
 *
 * @method PTagQuery leftJoinPTagRelatedByPTParentId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PTagRelatedByPTParentId relation
 * @method PTagQuery rightJoinPTagRelatedByPTParentId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PTagRelatedByPTParentId relation
 * @method PTagQuery innerJoinPTagRelatedByPTParentId($relationAlias = null) Adds a INNER JOIN clause to the query using the PTagRelatedByPTParentId relation
 *
 * @method PTagQuery leftJoinPUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the PUser relation
 * @method PTagQuery rightJoinPUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PUser relation
 * @method PTagQuery innerJoinPUser($relationAlias = null) Adds a INNER JOIN clause to the query using the PUser relation
 *
 * @method PTagQuery leftJoinPOwner($relationAlias = null) Adds a LEFT JOIN clause to the query using the POwner relation
 * @method PTagQuery rightJoinPOwner($relationAlias = null) Adds a RIGHT JOIN clause to the query using the POwner relation
 * @method PTagQuery innerJoinPOwner($relationAlias = null) Adds a INNER JOIN clause to the query using the POwner relation
 *
 * @method PTagQuery leftJoinPTagRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the PTagRelatedById relation
 * @method PTagQuery rightJoinPTagRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PTagRelatedById relation
 * @method PTagQuery innerJoinPTagRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the PTagRelatedById relation
 *
 * @method PTagQuery leftJoinPEOPresetPT($relationAlias = null) Adds a LEFT JOIN clause to the query using the PEOPresetPT relation
 * @method PTagQuery rightJoinPEOPresetPT($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PEOPresetPT relation
 * @method PTagQuery innerJoinPEOPresetPT($relationAlias = null) Adds a INNER JOIN clause to the query using the PEOPresetPT relation
 *
 * @method PTagQuery leftJoinPuTaggedTPTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the PuTaggedTPTag relation
 * @method PTagQuery rightJoinPuTaggedTPTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PuTaggedTPTag relation
 * @method PTagQuery innerJoinPuTaggedTPTag($relationAlias = null) Adds a INNER JOIN clause to the query using the PuTaggedTPTag relation
 *
 * @method PTagQuery leftJoinPDDTaggedT($relationAlias = null) Adds a LEFT JOIN clause to the query using the PDDTaggedT relation
 * @method PTagQuery rightJoinPDDTaggedT($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PDDTaggedT relation
 * @method PTagQuery innerJoinPDDTaggedT($relationAlias = null) Adds a INNER JOIN clause to the query using the PDDTaggedT relation
 *
 * @method PTagQuery leftJoinPDRTaggedT($relationAlias = null) Adds a LEFT JOIN clause to the query using the PDRTaggedT relation
 * @method PTagQuery rightJoinPDRTaggedT($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PDRTaggedT relation
 * @method PTagQuery innerJoinPDRTaggedT($relationAlias = null) Adds a INNER JOIN clause to the query using the PDRTaggedT relation
 *
 * @method PTag findOne(PropelPDO $con = null) Return the first PTag matching the query
 * @method PTag findOneOrCreate(PropelPDO $con = null) Return the first PTag matching the query, or a new PTag object populated from the query conditions when no match is found
 *
 * @method PTag findOneByUuid(string $uuid) Return the first PTag filtered by the uuid column
 * @method PTag findOneByPTTagTypeId(int $p_t_tag_type_id) Return the first PTag filtered by the p_t_tag_type_id column
 * @method PTag findOneByPTParentId(int $p_t_parent_id) Return the first PTag filtered by the p_t_parent_id column
 * @method PTag findOneByPUserId(int $p_user_id) Return the first PTag filtered by the p_user_id column
 * @method PTag findOneByPOwnerId(int $p_owner_id) Return the first PTag filtered by the p_owner_id column
 * @method PTag findOneByTitle(string $title) Return the first PTag filtered by the title column
 * @method PTag findOneByModerated(boolean $moderated) Return the first PTag filtered by the moderated column
 * @method PTag findOneByModeratedAt(string $moderated_at) Return the first PTag filtered by the moderated_at column
 * @method PTag findOneByOnline(boolean $online) Return the first PTag filtered by the online column
 * @method PTag findOneByCreatedAt(string $created_at) Return the first PTag filtered by the created_at column
 * @method PTag findOneByUpdatedAt(string $updated_at) Return the first PTag filtered by the updated_at column
 * @method PTag findOneBySlug(string $slug) Return the first PTag filtered by the slug column
 *
 * @method array findById(int $id) Return PTag objects filtered by the id column
 * @method array findByUuid(string $uuid) Return PTag objects filtered by the uuid column
 * @method array findByPTTagTypeId(int $p_t_tag_type_id) Return PTag objects filtered by the p_t_tag_type_id column
 * @method array findByPTParentId(int $p_t_parent_id) Return PTag objects filtered by the p_t_parent_id column
 * @method array findByPUserId(int $p_user_id) Return PTag objects filtered by the p_user_id column
 * @method array findByPOwnerId(int $p_owner_id) Return PTag objects filtered by the p_owner_id column
 * @method array findByTitle(string $title) Return PTag objects filtered by the title column
 * @method array findByModerated(boolean $moderated) Return PTag objects filtered by the moderated column
 * @method array findByModeratedAt(string $moderated_at) Return PTag objects filtered by the moderated_at column
 * @method array findByOnline(boolean $online) Return PTag objects filtered by the online column
 * @method array findByCreatedAt(string $created_at) Return PTag objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return PTag objects filtered by the updated_at column
 * @method array findBySlug(string $slug) Return PTag objects filtered by the slug column
 */
abstract class BasePTagQuery extends ModelCriteria
{
    // query_cache behavior
    protected $queryKey = '';

    // archivable behavior
    protected $archiveOnDelete = true;

    /**
     * Initializes internal state of BasePTagQuery object.
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
            $modelName = 'Politizr\\Model\\PTag';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PTagQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PTagQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PTagQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PTagQuery) {
            return $criteria;
        }
        $query = new PTagQuery(null, null, $modelAlias);

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
     * @return   PTag|PTag[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PTagPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 PTag A model object, or null if the key is not found
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
     * @return                 PTag A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `uuid`, `p_t_tag_type_id`, `p_t_parent_id`, `p_user_id`, `p_owner_id`, `title`, `moderated`, `moderated_at`, `online`, `created_at`, `updated_at`, `slug` FROM `p_tag` WHERE `id` = :p0';
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
            $obj = new PTag();
            $obj->hydrate($row);
            PTagPeer::addInstanceToPool($obj, (string) $key);
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
     * @return PTag|PTag[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|PTag[]|mixed the list of results, formatted by the current formatter
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
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PTagPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PTagPeer::ID, $keys, Criteria::IN);
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
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PTagPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PTagPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the uuid column
     *
     * Example usage:
     * <code>
     * $query->filterByUuid('fooValue');   // WHERE uuid = 'fooValue'
     * $query->filterByUuid('%fooValue%'); // WHERE uuid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uuid The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByUuid($uuid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uuid)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uuid)) {
                $uuid = str_replace('*', '%', $uuid);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PTagPeer::UUID, $uuid, $comparison);
    }

    /**
     * Filter the query on the p_t_tag_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPTTagTypeId(1234); // WHERE p_t_tag_type_id = 1234
     * $query->filterByPTTagTypeId(array(12, 34)); // WHERE p_t_tag_type_id IN (12, 34)
     * $query->filterByPTTagTypeId(array('min' => 12)); // WHERE p_t_tag_type_id >= 12
     * $query->filterByPTTagTypeId(array('max' => 12)); // WHERE p_t_tag_type_id <= 12
     * </code>
     *
     * @see       filterByPTTagType()
     *
     * @param     mixed $pTTagTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByPTTagTypeId($pTTagTypeId = null, $comparison = null)
    {
        if (is_array($pTTagTypeId)) {
            $useMinMax = false;
            if (isset($pTTagTypeId['min'])) {
                $this->addUsingAlias(PTagPeer::P_T_TAG_TYPE_ID, $pTTagTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pTTagTypeId['max'])) {
                $this->addUsingAlias(PTagPeer::P_T_TAG_TYPE_ID, $pTTagTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::P_T_TAG_TYPE_ID, $pTTagTypeId, $comparison);
    }

    /**
     * Filter the query on the p_t_parent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPTParentId(1234); // WHERE p_t_parent_id = 1234
     * $query->filterByPTParentId(array(12, 34)); // WHERE p_t_parent_id IN (12, 34)
     * $query->filterByPTParentId(array('min' => 12)); // WHERE p_t_parent_id >= 12
     * $query->filterByPTParentId(array('max' => 12)); // WHERE p_t_parent_id <= 12
     * </code>
     *
     * @see       filterByPTagRelatedByPTParentId()
     *
     * @param     mixed $pTParentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByPTParentId($pTParentId = null, $comparison = null)
    {
        if (is_array($pTParentId)) {
            $useMinMax = false;
            if (isset($pTParentId['min'])) {
                $this->addUsingAlias(PTagPeer::P_T_PARENT_ID, $pTParentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pTParentId['max'])) {
                $this->addUsingAlias(PTagPeer::P_T_PARENT_ID, $pTParentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::P_T_PARENT_ID, $pTParentId, $comparison);
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
     * @see       filterByPUser()
     *
     * @param     mixed $pUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByPUserId($pUserId = null, $comparison = null)
    {
        if (is_array($pUserId)) {
            $useMinMax = false;
            if (isset($pUserId['min'])) {
                $this->addUsingAlias(PTagPeer::P_USER_ID, $pUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pUserId['max'])) {
                $this->addUsingAlias(PTagPeer::P_USER_ID, $pUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::P_USER_ID, $pUserId, $comparison);
    }

    /**
     * Filter the query on the p_owner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPOwnerId(1234); // WHERE p_owner_id = 1234
     * $query->filterByPOwnerId(array(12, 34)); // WHERE p_owner_id IN (12, 34)
     * $query->filterByPOwnerId(array('min' => 12)); // WHERE p_owner_id >= 12
     * $query->filterByPOwnerId(array('max' => 12)); // WHERE p_owner_id <= 12
     * </code>
     *
     * @see       filterByPOwner()
     *
     * @param     mixed $pOwnerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByPOwnerId($pOwnerId = null, $comparison = null)
    {
        if (is_array($pOwnerId)) {
            $useMinMax = false;
            if (isset($pOwnerId['min'])) {
                $this->addUsingAlias(PTagPeer::P_OWNER_ID, $pOwnerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pOwnerId['max'])) {
                $this->addUsingAlias(PTagPeer::P_OWNER_ID, $pOwnerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::P_OWNER_ID, $pOwnerId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PTagPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the moderated column
     *
     * Example usage:
     * <code>
     * $query->filterByModerated(true); // WHERE moderated = true
     * $query->filterByModerated('yes'); // WHERE moderated = true
     * </code>
     *
     * @param     boolean|string $moderated The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByModerated($moderated = null, $comparison = null)
    {
        if (is_string($moderated)) {
            $moderated = in_array(strtolower($moderated), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PTagPeer::MODERATED, $moderated, $comparison);
    }

    /**
     * Filter the query on the moderated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByModeratedAt('2011-03-14'); // WHERE moderated_at = '2011-03-14'
     * $query->filterByModeratedAt('now'); // WHERE moderated_at = '2011-03-14'
     * $query->filterByModeratedAt(array('max' => 'yesterday')); // WHERE moderated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $moderatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByModeratedAt($moderatedAt = null, $comparison = null)
    {
        if (is_array($moderatedAt)) {
            $useMinMax = false;
            if (isset($moderatedAt['min'])) {
                $this->addUsingAlias(PTagPeer::MODERATED_AT, $moderatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moderatedAt['max'])) {
                $this->addUsingAlias(PTagPeer::MODERATED_AT, $moderatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::MODERATED_AT, $moderatedAt, $comparison);
    }

    /**
     * Filter the query on the online column
     *
     * Example usage:
     * <code>
     * $query->filterByOnline(true); // WHERE online = true
     * $query->filterByOnline('yes'); // WHERE online = true
     * </code>
     *
     * @param     boolean|string $online The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByOnline($online = null, $comparison = null)
    {
        if (is_string($online)) {
            $online = in_array(strtolower($online), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PTagPeer::ONLINE, $online, $comparison);
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
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PTagPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PTagPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PTagPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PTagPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PTagPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the slug column
     *
     * Example usage:
     * <code>
     * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
     * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slug The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function filterBySlug($slug = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slug)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slug)) {
                $slug = str_replace('*', '%', $slug);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PTagPeer::SLUG, $slug, $comparison);
    }

    /**
     * Filter the query by a related PTTagType object
     *
     * @param   PTTagType|PropelObjectCollection $pTTagType The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPTTagType($pTTagType, $comparison = null)
    {
        if ($pTTagType instanceof PTTagType) {
            return $this
                ->addUsingAlias(PTagPeer::P_T_TAG_TYPE_ID, $pTTagType->getId(), $comparison);
        } elseif ($pTTagType instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PTagPeer::P_T_TAG_TYPE_ID, $pTTagType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPTTagType() only accepts arguments of type PTTagType or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PTTagType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPTTagType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PTTagType');

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
            $this->addJoinObject($join, 'PTTagType');
        }

        return $this;
    }

    /**
     * Use the PTTagType relation PTTagType object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PTTagTypeQuery A secondary query class using the current class as primary query
     */
    public function usePTTagTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPTTagType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PTTagType', '\Politizr\Model\PTTagTypeQuery');
    }

    /**
     * Filter the query by a related PTag object
     *
     * @param   PTag|PropelObjectCollection $pTag The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPTagRelatedByPTParentId($pTag, $comparison = null)
    {
        if ($pTag instanceof PTag) {
            return $this
                ->addUsingAlias(PTagPeer::P_T_PARENT_ID, $pTag->getId(), $comparison);
        } elseif ($pTag instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PTagPeer::P_T_PARENT_ID, $pTag->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPTagRelatedByPTParentId() only accepts arguments of type PTag or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PTagRelatedByPTParentId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPTagRelatedByPTParentId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PTagRelatedByPTParentId');

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
            $this->addJoinObject($join, 'PTagRelatedByPTParentId');
        }

        return $this;
    }

    /**
     * Use the PTagRelatedByPTParentId relation PTag object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PTagQuery A secondary query class using the current class as primary query
     */
    public function usePTagRelatedByPTParentIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPTagRelatedByPTParentId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PTagRelatedByPTParentId', '\Politizr\Model\PTagQuery');
    }

    /**
     * Filter the query by a related PUser object
     *
     * @param   PUser|PropelObjectCollection $pUser The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPUser($pUser, $comparison = null)
    {
        if ($pUser instanceof PUser) {
            return $this
                ->addUsingAlias(PTagPeer::P_USER_ID, $pUser->getId(), $comparison);
        } elseif ($pUser instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PTagPeer::P_USER_ID, $pUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPUser() only accepts arguments of type PUser or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PUser');

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
            $this->addJoinObject($join, 'PUser');
        }

        return $this;
    }

    /**
     * Use the PUser relation PUser object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PUserQuery A secondary query class using the current class as primary query
     */
    public function usePUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PUser', '\Politizr\Model\PUserQuery');
    }

    /**
     * Filter the query by a related PUser object
     *
     * @param   PUser|PropelObjectCollection $pUser The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPOwner($pUser, $comparison = null)
    {
        if ($pUser instanceof PUser) {
            return $this
                ->addUsingAlias(PTagPeer::P_OWNER_ID, $pUser->getId(), $comparison);
        } elseif ($pUser instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PTagPeer::P_OWNER_ID, $pUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPOwner() only accepts arguments of type PUser or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the POwner relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPOwner($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('POwner');

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
            $this->addJoinObject($join, 'POwner');
        }

        return $this;
    }

    /**
     * Use the POwner relation PUser object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PUserQuery A secondary query class using the current class as primary query
     */
    public function usePOwnerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPOwner($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'POwner', '\Politizr\Model\PUserQuery');
    }

    /**
     * Filter the query by a related PTag object
     *
     * @param   PTag|PropelObjectCollection $pTag  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPTagRelatedById($pTag, $comparison = null)
    {
        if ($pTag instanceof PTag) {
            return $this
                ->addUsingAlias(PTagPeer::ID, $pTag->getPTParentId(), $comparison);
        } elseif ($pTag instanceof PropelObjectCollection) {
            return $this
                ->usePTagRelatedByIdQuery()
                ->filterByPrimaryKeys($pTag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPTagRelatedById() only accepts arguments of type PTag or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PTagRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPTagRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PTagRelatedById');

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
            $this->addJoinObject($join, 'PTagRelatedById');
        }

        return $this;
    }

    /**
     * Use the PTagRelatedById relation PTag object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PTagQuery A secondary query class using the current class as primary query
     */
    public function usePTagRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPTagRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PTagRelatedById', '\Politizr\Model\PTagQuery');
    }

    /**
     * Filter the query by a related PEOPresetPT object
     *
     * @param   PEOPresetPT|PropelObjectCollection $pEOPresetPT  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPEOPresetPT($pEOPresetPT, $comparison = null)
    {
        if ($pEOPresetPT instanceof PEOPresetPT) {
            return $this
                ->addUsingAlias(PTagPeer::ID, $pEOPresetPT->getPTagId(), $comparison);
        } elseif ($pEOPresetPT instanceof PropelObjectCollection) {
            return $this
                ->usePEOPresetPTQuery()
                ->filterByPrimaryKeys($pEOPresetPT->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPEOPresetPT() only accepts arguments of type PEOPresetPT or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PEOPresetPT relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPEOPresetPT($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PEOPresetPT');

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
            $this->addJoinObject($join, 'PEOPresetPT');
        }

        return $this;
    }

    /**
     * Use the PEOPresetPT relation PEOPresetPT object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PEOPresetPTQuery A secondary query class using the current class as primary query
     */
    public function usePEOPresetPTQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPEOPresetPT($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PEOPresetPT', '\Politizr\Model\PEOPresetPTQuery');
    }

    /**
     * Filter the query by a related PUTaggedT object
     *
     * @param   PUTaggedT|PropelObjectCollection $pUTaggedT  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPuTaggedTPTag($pUTaggedT, $comparison = null)
    {
        if ($pUTaggedT instanceof PUTaggedT) {
            return $this
                ->addUsingAlias(PTagPeer::ID, $pUTaggedT->getPTagId(), $comparison);
        } elseif ($pUTaggedT instanceof PropelObjectCollection) {
            return $this
                ->usePuTaggedTPTagQuery()
                ->filterByPrimaryKeys($pUTaggedT->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPuTaggedTPTag() only accepts arguments of type PUTaggedT or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PuTaggedTPTag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPuTaggedTPTag($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PuTaggedTPTag');

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
            $this->addJoinObject($join, 'PuTaggedTPTag');
        }

        return $this;
    }

    /**
     * Use the PuTaggedTPTag relation PUTaggedT object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PUTaggedTQuery A secondary query class using the current class as primary query
     */
    public function usePuTaggedTPTagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPuTaggedTPTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PuTaggedTPTag', '\Politizr\Model\PUTaggedTQuery');
    }

    /**
     * Filter the query by a related PDDTaggedT object
     *
     * @param   PDDTaggedT|PropelObjectCollection $pDDTaggedT  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPDDTaggedT($pDDTaggedT, $comparison = null)
    {
        if ($pDDTaggedT instanceof PDDTaggedT) {
            return $this
                ->addUsingAlias(PTagPeer::ID, $pDDTaggedT->getPTagId(), $comparison);
        } elseif ($pDDTaggedT instanceof PropelObjectCollection) {
            return $this
                ->usePDDTaggedTQuery()
                ->filterByPrimaryKeys($pDDTaggedT->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPDDTaggedT() only accepts arguments of type PDDTaggedT or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PDDTaggedT relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPDDTaggedT($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PDDTaggedT');

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
            $this->addJoinObject($join, 'PDDTaggedT');
        }

        return $this;
    }

    /**
     * Use the PDDTaggedT relation PDDTaggedT object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PDDTaggedTQuery A secondary query class using the current class as primary query
     */
    public function usePDDTaggedTQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPDDTaggedT($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PDDTaggedT', '\Politizr\Model\PDDTaggedTQuery');
    }

    /**
     * Filter the query by a related PDRTaggedT object
     *
     * @param   PDRTaggedT|PropelObjectCollection $pDRTaggedT  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPDRTaggedT($pDRTaggedT, $comparison = null)
    {
        if ($pDRTaggedT instanceof PDRTaggedT) {
            return $this
                ->addUsingAlias(PTagPeer::ID, $pDRTaggedT->getPTagId(), $comparison);
        } elseif ($pDRTaggedT instanceof PropelObjectCollection) {
            return $this
                ->usePDRTaggedTQuery()
                ->filterByPrimaryKeys($pDRTaggedT->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPDRTaggedT() only accepts arguments of type PDRTaggedT or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PDRTaggedT relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function joinPDRTaggedT($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PDRTaggedT');

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
            $this->addJoinObject($join, 'PDRTaggedT');
        }

        return $this;
    }

    /**
     * Use the PDRTaggedT relation PDRTaggedT object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Politizr\Model\PDRTaggedTQuery A secondary query class using the current class as primary query
     */
    public function usePDRTaggedTQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPDRTaggedT($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PDRTaggedT', '\Politizr\Model\PDRTaggedTQuery');
    }

    /**
     * Filter the query by a related PEOperation object
     * using the p_e_o_preset_p_t table as cross reference
     *
     * @param   PEOperation $pEOperation the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   PTagQuery The current query, for fluid interface
     */
    public function filterByPEOperation($pEOperation, $comparison = Criteria::EQUAL)
    {
        return $this
            ->usePEOPresetPTQuery()
            ->filterByPEOperation($pEOperation, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related PUser object
     * using the p_u_tagged_t table as cross reference
     *
     * @param   PUser $pUser the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   PTagQuery The current query, for fluid interface
     */
    public function filterByPuTaggedTPUser($pUser, $comparison = Criteria::EQUAL)
    {
        return $this
            ->usePuTaggedTPTagQuery()
            ->filterByPuTaggedTPUser($pUser, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related PDDebate object
     * using the p_d_d_tagged_t table as cross reference
     *
     * @param   PDDebate $pDDebate the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   PTagQuery The current query, for fluid interface
     */
    public function filterByPDDebate($pDDebate, $comparison = Criteria::EQUAL)
    {
        return $this
            ->usePDDTaggedTQuery()
            ->filterByPDDebate($pDDebate, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related PDReaction object
     * using the p_d_r_tagged_t table as cross reference
     *
     * @param   PDReaction $pDReaction the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   PTagQuery The current query, for fluid interface
     */
    public function filterByPDReaction($pDReaction, $comparison = Criteria::EQUAL)
    {
        return $this
            ->usePDRTaggedTQuery()
            ->filterByPDReaction($pDReaction, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   PTag $pTag Object to remove from the list of results
     *
     * @return PTagQuery The current query, for fluid interface
     */
    public function prune($pTag = null)
    {
        if ($pTag) {
            $this->addUsingAlias(PTagPeer::ID, $pTag->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Code to execute before every DELETE statement
     *
     * @param     PropelPDO $con The connection object used by the query
     */
    protected function basePreDelete(PropelPDO $con)
    {
        // archivable behavior

        if ($this->archiveOnDelete) {
            $this->archive($con);
        } else {
            $this->archiveOnDelete = true;
        }


        return $this->preDelete($con);
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     PTagQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PTagPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     PTagQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PTagPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     PTagQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PTagPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     PTagQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PTagPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     PTagQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PTagPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     PTagQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PTagPeer::CREATED_AT);
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

        $dbMap = Propel::getDatabaseMap(PTagPeer::DATABASE_NAME);
        $db = Propel::getDB(PTagPeer::DATABASE_NAME);

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

    // archivable behavior

    /**
     * Copy the data of the objects satisfying the query into PTagArchive archive objects.
     * The archived objects are then saved.
     * If any of the objects has already been archived, the archived object
     * is updated and not duplicated.
     * Warning: This termination methods issues 2n+1 queries.
     *
     * @param      PropelPDO $con	Connection to use.
     * @param      Boolean $useLittleMemory	Whether or not to use PropelOnDemandFormatter to retrieve objects.
     *               Set to false if the identity map matters.
     *               Set to true (default) to use less memory.
     *
     * @return     int the number of archived objects
     * @throws     PropelException
     */
    public function archive($con = null, $useLittleMemory = true)
    {
        $totalArchivedObjects = 0;
        $criteria = clone $this;
        // prepare the query
        $criteria->setWith(array());
        if ($useLittleMemory) {
            $criteria->setFormatter(ModelCriteria::FORMAT_ON_DEMAND);
        }
        if ($con === null) {
            $con = Propel::getConnection(PTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $con->beginTransaction();
        try {
            // archive all results one by one
            foreach ($criteria->find($con) as $object) {
                $object->archive($con);
                $totalArchivedObjects++;
            }
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $totalArchivedObjects;
    }

    /**
     * Enable/disable auto-archiving on delete for the next query.
     *
     * @param boolean $archiveOnDelete True if the query must archive deleted objects, false otherwise.
     */
    public function setArchiveOnDelete($archiveOnDelete)
    {
        $this->archiveOnDelete = $archiveOnDelete;
    }

    /**
     * Delete records matching the current query without archiving them.
     *
     * @param      PropelPDO $con	Connection to use.
     *
     * @return integer the number of deleted rows
     */
    public function deleteWithoutArchive($con = null)
    {
        $this->archiveOnDelete = false;

        return $this->delete($con);
    }

    /**
     * Delete all records without archiving them.
     *
     * @param      PropelPDO $con	Connection to use.
     *
     * @return integer the number of deleted rows
     */
    public function deleteAllWithoutArchive($con = null)
    {
        $this->archiveOnDelete = false;

        return $this->deleteAll($con);
    }

}
