<?php

namespace Politizr\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Politizr\Model\PDReactionArchive;
use Politizr\Model\PDReactionArchivePeer;
use Politizr\Model\PDReactionArchiveQuery;

/**
 * @method PDReactionArchiveQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PDReactionArchiveQuery orderByUuid($order = Criteria::ASC) Order by the uuid column
 * @method PDReactionArchiveQuery orderByPUserId($order = Criteria::ASC) Order by the p_user_id column
 * @method PDReactionArchiveQuery orderByPDDebateId($order = Criteria::ASC) Order by the p_d_debate_id column
 * @method PDReactionArchiveQuery orderByParentReactionId($order = Criteria::ASC) Order by the parent_reaction_id column
 * @method PDReactionArchiveQuery orderByPLCityId($order = Criteria::ASC) Order by the p_l_city_id column
 * @method PDReactionArchiveQuery orderByPLDepartmentId($order = Criteria::ASC) Order by the p_l_department_id column
 * @method PDReactionArchiveQuery orderByPLRegionId($order = Criteria::ASC) Order by the p_l_region_id column
 * @method PDReactionArchiveQuery orderByPLCountryId($order = Criteria::ASC) Order by the p_l_country_id column
 * @method PDReactionArchiveQuery orderByPCTopicId($order = Criteria::ASC) Order by the p_c_topic_id column
 * @method PDReactionArchiveQuery orderByFbAdId($order = Criteria::ASC) Order by the fb_ad_id column
 * @method PDReactionArchiveQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method PDReactionArchiveQuery orderByFileName($order = Criteria::ASC) Order by the file_name column
 * @method PDReactionArchiveQuery orderByCopyright($order = Criteria::ASC) Order by the copyright column
 * @method PDReactionArchiveQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method PDReactionArchiveQuery orderByNotePos($order = Criteria::ASC) Order by the note_pos column
 * @method PDReactionArchiveQuery orderByNoteNeg($order = Criteria::ASC) Order by the note_neg column
 * @method PDReactionArchiveQuery orderByNbViews($order = Criteria::ASC) Order by the nb_views column
 * @method PDReactionArchiveQuery orderByWantBoost($order = Criteria::ASC) Order by the want_boost column
 * @method PDReactionArchiveQuery orderByPublished($order = Criteria::ASC) Order by the published column
 * @method PDReactionArchiveQuery orderByPublishedAt($order = Criteria::ASC) Order by the published_at column
 * @method PDReactionArchiveQuery orderByPublishedBy($order = Criteria::ASC) Order by the published_by column
 * @method PDReactionArchiveQuery orderByFavorite($order = Criteria::ASC) Order by the favorite column
 * @method PDReactionArchiveQuery orderByOnline($order = Criteria::ASC) Order by the online column
 * @method PDReactionArchiveQuery orderByHomepage($order = Criteria::ASC) Order by the homepage column
 * @method PDReactionArchiveQuery orderByModerated($order = Criteria::ASC) Order by the moderated column
 * @method PDReactionArchiveQuery orderByModeratedPartial($order = Criteria::ASC) Order by the moderated_partial column
 * @method PDReactionArchiveQuery orderByModeratedAt($order = Criteria::ASC) Order by the moderated_at column
 * @method PDReactionArchiveQuery orderByIndexedAt($order = Criteria::ASC) Order by the indexed_at column
 * @method PDReactionArchiveQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method PDReactionArchiveQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method PDReactionArchiveQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method PDReactionArchiveQuery orderByTreeLeft($order = Criteria::ASC) Order by the tree_left column
 * @method PDReactionArchiveQuery orderByTreeRight($order = Criteria::ASC) Order by the tree_right column
 * @method PDReactionArchiveQuery orderByTreeLevel($order = Criteria::ASC) Order by the tree_level column
 * @method PDReactionArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method PDReactionArchiveQuery groupById() Group by the id column
 * @method PDReactionArchiveQuery groupByUuid() Group by the uuid column
 * @method PDReactionArchiveQuery groupByPUserId() Group by the p_user_id column
 * @method PDReactionArchiveQuery groupByPDDebateId() Group by the p_d_debate_id column
 * @method PDReactionArchiveQuery groupByParentReactionId() Group by the parent_reaction_id column
 * @method PDReactionArchiveQuery groupByPLCityId() Group by the p_l_city_id column
 * @method PDReactionArchiveQuery groupByPLDepartmentId() Group by the p_l_department_id column
 * @method PDReactionArchiveQuery groupByPLRegionId() Group by the p_l_region_id column
 * @method PDReactionArchiveQuery groupByPLCountryId() Group by the p_l_country_id column
 * @method PDReactionArchiveQuery groupByPCTopicId() Group by the p_c_topic_id column
 * @method PDReactionArchiveQuery groupByFbAdId() Group by the fb_ad_id column
 * @method PDReactionArchiveQuery groupByTitle() Group by the title column
 * @method PDReactionArchiveQuery groupByFileName() Group by the file_name column
 * @method PDReactionArchiveQuery groupByCopyright() Group by the copyright column
 * @method PDReactionArchiveQuery groupByDescription() Group by the description column
 * @method PDReactionArchiveQuery groupByNotePos() Group by the note_pos column
 * @method PDReactionArchiveQuery groupByNoteNeg() Group by the note_neg column
 * @method PDReactionArchiveQuery groupByNbViews() Group by the nb_views column
 * @method PDReactionArchiveQuery groupByWantBoost() Group by the want_boost column
 * @method PDReactionArchiveQuery groupByPublished() Group by the published column
 * @method PDReactionArchiveQuery groupByPublishedAt() Group by the published_at column
 * @method PDReactionArchiveQuery groupByPublishedBy() Group by the published_by column
 * @method PDReactionArchiveQuery groupByFavorite() Group by the favorite column
 * @method PDReactionArchiveQuery groupByOnline() Group by the online column
 * @method PDReactionArchiveQuery groupByHomepage() Group by the homepage column
 * @method PDReactionArchiveQuery groupByModerated() Group by the moderated column
 * @method PDReactionArchiveQuery groupByModeratedPartial() Group by the moderated_partial column
 * @method PDReactionArchiveQuery groupByModeratedAt() Group by the moderated_at column
 * @method PDReactionArchiveQuery groupByIndexedAt() Group by the indexed_at column
 * @method PDReactionArchiveQuery groupByCreatedAt() Group by the created_at column
 * @method PDReactionArchiveQuery groupByUpdatedAt() Group by the updated_at column
 * @method PDReactionArchiveQuery groupBySlug() Group by the slug column
 * @method PDReactionArchiveQuery groupByTreeLeft() Group by the tree_left column
 * @method PDReactionArchiveQuery groupByTreeRight() Group by the tree_right column
 * @method PDReactionArchiveQuery groupByTreeLevel() Group by the tree_level column
 * @method PDReactionArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method PDReactionArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PDReactionArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PDReactionArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PDReactionArchive findOne(PropelPDO $con = null) Return the first PDReactionArchive matching the query
 * @method PDReactionArchive findOneOrCreate(PropelPDO $con = null) Return the first PDReactionArchive matching the query, or a new PDReactionArchive object populated from the query conditions when no match is found
 *
 * @method PDReactionArchive findOneByUuid(string $uuid) Return the first PDReactionArchive filtered by the uuid column
 * @method PDReactionArchive findOneByPUserId(int $p_user_id) Return the first PDReactionArchive filtered by the p_user_id column
 * @method PDReactionArchive findOneByPDDebateId(int $p_d_debate_id) Return the first PDReactionArchive filtered by the p_d_debate_id column
 * @method PDReactionArchive findOneByParentReactionId(int $parent_reaction_id) Return the first PDReactionArchive filtered by the parent_reaction_id column
 * @method PDReactionArchive findOneByPLCityId(int $p_l_city_id) Return the first PDReactionArchive filtered by the p_l_city_id column
 * @method PDReactionArchive findOneByPLDepartmentId(int $p_l_department_id) Return the first PDReactionArchive filtered by the p_l_department_id column
 * @method PDReactionArchive findOneByPLRegionId(int $p_l_region_id) Return the first PDReactionArchive filtered by the p_l_region_id column
 * @method PDReactionArchive findOneByPLCountryId(int $p_l_country_id) Return the first PDReactionArchive filtered by the p_l_country_id column
 * @method PDReactionArchive findOneByPCTopicId(int $p_c_topic_id) Return the first PDReactionArchive filtered by the p_c_topic_id column
 * @method PDReactionArchive findOneByFbAdId(string $fb_ad_id) Return the first PDReactionArchive filtered by the fb_ad_id column
 * @method PDReactionArchive findOneByTitle(string $title) Return the first PDReactionArchive filtered by the title column
 * @method PDReactionArchive findOneByFileName(string $file_name) Return the first PDReactionArchive filtered by the file_name column
 * @method PDReactionArchive findOneByCopyright(string $copyright) Return the first PDReactionArchive filtered by the copyright column
 * @method PDReactionArchive findOneByDescription(string $description) Return the first PDReactionArchive filtered by the description column
 * @method PDReactionArchive findOneByNotePos(int $note_pos) Return the first PDReactionArchive filtered by the note_pos column
 * @method PDReactionArchive findOneByNoteNeg(int $note_neg) Return the first PDReactionArchive filtered by the note_neg column
 * @method PDReactionArchive findOneByNbViews(int $nb_views) Return the first PDReactionArchive filtered by the nb_views column
 * @method PDReactionArchive findOneByWantBoost(int $want_boost) Return the first PDReactionArchive filtered by the want_boost column
 * @method PDReactionArchive findOneByPublished(boolean $published) Return the first PDReactionArchive filtered by the published column
 * @method PDReactionArchive findOneByPublishedAt(string $published_at) Return the first PDReactionArchive filtered by the published_at column
 * @method PDReactionArchive findOneByPublishedBy(string $published_by) Return the first PDReactionArchive filtered by the published_by column
 * @method PDReactionArchive findOneByFavorite(boolean $favorite) Return the first PDReactionArchive filtered by the favorite column
 * @method PDReactionArchive findOneByOnline(boolean $online) Return the first PDReactionArchive filtered by the online column
 * @method PDReactionArchive findOneByHomepage(boolean $homepage) Return the first PDReactionArchive filtered by the homepage column
 * @method PDReactionArchive findOneByModerated(boolean $moderated) Return the first PDReactionArchive filtered by the moderated column
 * @method PDReactionArchive findOneByModeratedPartial(boolean $moderated_partial) Return the first PDReactionArchive filtered by the moderated_partial column
 * @method PDReactionArchive findOneByModeratedAt(string $moderated_at) Return the first PDReactionArchive filtered by the moderated_at column
 * @method PDReactionArchive findOneByIndexedAt(string $indexed_at) Return the first PDReactionArchive filtered by the indexed_at column
 * @method PDReactionArchive findOneByCreatedAt(string $created_at) Return the first PDReactionArchive filtered by the created_at column
 * @method PDReactionArchive findOneByUpdatedAt(string $updated_at) Return the first PDReactionArchive filtered by the updated_at column
 * @method PDReactionArchive findOneBySlug(string $slug) Return the first PDReactionArchive filtered by the slug column
 * @method PDReactionArchive findOneByTreeLeft(int $tree_left) Return the first PDReactionArchive filtered by the tree_left column
 * @method PDReactionArchive findOneByTreeRight(int $tree_right) Return the first PDReactionArchive filtered by the tree_right column
 * @method PDReactionArchive findOneByTreeLevel(int $tree_level) Return the first PDReactionArchive filtered by the tree_level column
 * @method PDReactionArchive findOneByArchivedAt(string $archived_at) Return the first PDReactionArchive filtered by the archived_at column
 *
 * @method array findById(int $id) Return PDReactionArchive objects filtered by the id column
 * @method array findByUuid(string $uuid) Return PDReactionArchive objects filtered by the uuid column
 * @method array findByPUserId(int $p_user_id) Return PDReactionArchive objects filtered by the p_user_id column
 * @method array findByPDDebateId(int $p_d_debate_id) Return PDReactionArchive objects filtered by the p_d_debate_id column
 * @method array findByParentReactionId(int $parent_reaction_id) Return PDReactionArchive objects filtered by the parent_reaction_id column
 * @method array findByPLCityId(int $p_l_city_id) Return PDReactionArchive objects filtered by the p_l_city_id column
 * @method array findByPLDepartmentId(int $p_l_department_id) Return PDReactionArchive objects filtered by the p_l_department_id column
 * @method array findByPLRegionId(int $p_l_region_id) Return PDReactionArchive objects filtered by the p_l_region_id column
 * @method array findByPLCountryId(int $p_l_country_id) Return PDReactionArchive objects filtered by the p_l_country_id column
 * @method array findByPCTopicId(int $p_c_topic_id) Return PDReactionArchive objects filtered by the p_c_topic_id column
 * @method array findByFbAdId(string $fb_ad_id) Return PDReactionArchive objects filtered by the fb_ad_id column
 * @method array findByTitle(string $title) Return PDReactionArchive objects filtered by the title column
 * @method array findByFileName(string $file_name) Return PDReactionArchive objects filtered by the file_name column
 * @method array findByCopyright(string $copyright) Return PDReactionArchive objects filtered by the copyright column
 * @method array findByDescription(string $description) Return PDReactionArchive objects filtered by the description column
 * @method array findByNotePos(int $note_pos) Return PDReactionArchive objects filtered by the note_pos column
 * @method array findByNoteNeg(int $note_neg) Return PDReactionArchive objects filtered by the note_neg column
 * @method array findByNbViews(int $nb_views) Return PDReactionArchive objects filtered by the nb_views column
 * @method array findByWantBoost(int $want_boost) Return PDReactionArchive objects filtered by the want_boost column
 * @method array findByPublished(boolean $published) Return PDReactionArchive objects filtered by the published column
 * @method array findByPublishedAt(string $published_at) Return PDReactionArchive objects filtered by the published_at column
 * @method array findByPublishedBy(string $published_by) Return PDReactionArchive objects filtered by the published_by column
 * @method array findByFavorite(boolean $favorite) Return PDReactionArchive objects filtered by the favorite column
 * @method array findByOnline(boolean $online) Return PDReactionArchive objects filtered by the online column
 * @method array findByHomepage(boolean $homepage) Return PDReactionArchive objects filtered by the homepage column
 * @method array findByModerated(boolean $moderated) Return PDReactionArchive objects filtered by the moderated column
 * @method array findByModeratedPartial(boolean $moderated_partial) Return PDReactionArchive objects filtered by the moderated_partial column
 * @method array findByModeratedAt(string $moderated_at) Return PDReactionArchive objects filtered by the moderated_at column
 * @method array findByIndexedAt(string $indexed_at) Return PDReactionArchive objects filtered by the indexed_at column
 * @method array findByCreatedAt(string $created_at) Return PDReactionArchive objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return PDReactionArchive objects filtered by the updated_at column
 * @method array findBySlug(string $slug) Return PDReactionArchive objects filtered by the slug column
 * @method array findByTreeLeft(int $tree_left) Return PDReactionArchive objects filtered by the tree_left column
 * @method array findByTreeRight(int $tree_right) Return PDReactionArchive objects filtered by the tree_right column
 * @method array findByTreeLevel(int $tree_level) Return PDReactionArchive objects filtered by the tree_level column
 * @method array findByArchivedAt(string $archived_at) Return PDReactionArchive objects filtered by the archived_at column
 */
abstract class BasePDReactionArchiveQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePDReactionArchiveQuery object.
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
            $modelName = 'Politizr\\Model\\PDReactionArchive';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PDReactionArchiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PDReactionArchiveQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PDReactionArchiveQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PDReactionArchiveQuery) {
            return $criteria;
        }
        $query = new PDReactionArchiveQuery(null, null, $modelAlias);

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
     * @return   PDReactionArchive|PDReactionArchive[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PDReactionArchivePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PDReactionArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 PDReactionArchive A model object, or null if the key is not found
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
     * @return                 PDReactionArchive A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `uuid`, `p_user_id`, `p_d_debate_id`, `parent_reaction_id`, `p_l_city_id`, `p_l_department_id`, `p_l_region_id`, `p_l_country_id`, `p_c_topic_id`, `fb_ad_id`, `title`, `file_name`, `copyright`, `description`, `note_pos`, `note_neg`, `nb_views`, `want_boost`, `published`, `published_at`, `published_by`, `favorite`, `online`, `homepage`, `moderated`, `moderated_partial`, `moderated_at`, `indexed_at`, `created_at`, `updated_at`, `slug`, `tree_left`, `tree_right`, `tree_level`, `archived_at` FROM `p_d_reaction_archive` WHERE `id` = :p0';
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
            $obj = new PDReactionArchive();
            $obj->hydrate($row);
            PDReactionArchivePeer::addInstanceToPool($obj, (string) $key);
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
     * @return PDReactionArchive|PDReactionArchive[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|PDReactionArchive[]|mixed the list of results, formatted by the current formatter
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PDReactionArchivePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PDReactionArchivePeer::ID, $keys, Criteria::IN);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::ID, $id, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PDReactionArchivePeer::UUID, $uuid, $comparison);
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
     * @param     mixed $pUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPUserId($pUserId = null, $comparison = null)
    {
        if (is_array($pUserId)) {
            $useMinMax = false;
            if (isset($pUserId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_USER_ID, $pUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pUserId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_USER_ID, $pUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_USER_ID, $pUserId, $comparison);
    }

    /**
     * Filter the query on the p_d_debate_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPDDebateId(1234); // WHERE p_d_debate_id = 1234
     * $query->filterByPDDebateId(array(12, 34)); // WHERE p_d_debate_id IN (12, 34)
     * $query->filterByPDDebateId(array('min' => 12)); // WHERE p_d_debate_id >= 12
     * $query->filterByPDDebateId(array('max' => 12)); // WHERE p_d_debate_id <= 12
     * </code>
     *
     * @param     mixed $pDDebateId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPDDebateId($pDDebateId = null, $comparison = null)
    {
        if (is_array($pDDebateId)) {
            $useMinMax = false;
            if (isset($pDDebateId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_D_DEBATE_ID, $pDDebateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pDDebateId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_D_DEBATE_ID, $pDDebateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_D_DEBATE_ID, $pDDebateId, $comparison);
    }

    /**
     * Filter the query on the parent_reaction_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentReactionId(1234); // WHERE parent_reaction_id = 1234
     * $query->filterByParentReactionId(array(12, 34)); // WHERE parent_reaction_id IN (12, 34)
     * $query->filterByParentReactionId(array('min' => 12)); // WHERE parent_reaction_id >= 12
     * $query->filterByParentReactionId(array('max' => 12)); // WHERE parent_reaction_id <= 12
     * </code>
     *
     * @param     mixed $parentReactionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByParentReactionId($parentReactionId = null, $comparison = null)
    {
        if (is_array($parentReactionId)) {
            $useMinMax = false;
            if (isset($parentReactionId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::PARENT_REACTION_ID, $parentReactionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentReactionId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::PARENT_REACTION_ID, $parentReactionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::PARENT_REACTION_ID, $parentReactionId, $comparison);
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
     * @param     mixed $pLCityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPLCityId($pLCityId = null, $comparison = null)
    {
        if (is_array($pLCityId)) {
            $useMinMax = false;
            if (isset($pLCityId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_CITY_ID, $pLCityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pLCityId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_CITY_ID, $pLCityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_L_CITY_ID, $pLCityId, $comparison);
    }

    /**
     * Filter the query on the p_l_department_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPLDepartmentId(1234); // WHERE p_l_department_id = 1234
     * $query->filterByPLDepartmentId(array(12, 34)); // WHERE p_l_department_id IN (12, 34)
     * $query->filterByPLDepartmentId(array('min' => 12)); // WHERE p_l_department_id >= 12
     * $query->filterByPLDepartmentId(array('max' => 12)); // WHERE p_l_department_id <= 12
     * </code>
     *
     * @param     mixed $pLDepartmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPLDepartmentId($pLDepartmentId = null, $comparison = null)
    {
        if (is_array($pLDepartmentId)) {
            $useMinMax = false;
            if (isset($pLDepartmentId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_DEPARTMENT_ID, $pLDepartmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pLDepartmentId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_DEPARTMENT_ID, $pLDepartmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_L_DEPARTMENT_ID, $pLDepartmentId, $comparison);
    }

    /**
     * Filter the query on the p_l_region_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPLRegionId(1234); // WHERE p_l_region_id = 1234
     * $query->filterByPLRegionId(array(12, 34)); // WHERE p_l_region_id IN (12, 34)
     * $query->filterByPLRegionId(array('min' => 12)); // WHERE p_l_region_id >= 12
     * $query->filterByPLRegionId(array('max' => 12)); // WHERE p_l_region_id <= 12
     * </code>
     *
     * @param     mixed $pLRegionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPLRegionId($pLRegionId = null, $comparison = null)
    {
        if (is_array($pLRegionId)) {
            $useMinMax = false;
            if (isset($pLRegionId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_REGION_ID, $pLRegionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pLRegionId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_REGION_ID, $pLRegionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_L_REGION_ID, $pLRegionId, $comparison);
    }

    /**
     * Filter the query on the p_l_country_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPLCountryId(1234); // WHERE p_l_country_id = 1234
     * $query->filterByPLCountryId(array(12, 34)); // WHERE p_l_country_id IN (12, 34)
     * $query->filterByPLCountryId(array('min' => 12)); // WHERE p_l_country_id >= 12
     * $query->filterByPLCountryId(array('max' => 12)); // WHERE p_l_country_id <= 12
     * </code>
     *
     * @param     mixed $pLCountryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPLCountryId($pLCountryId = null, $comparison = null)
    {
        if (is_array($pLCountryId)) {
            $useMinMax = false;
            if (isset($pLCountryId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_COUNTRY_ID, $pLCountryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pLCountryId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_L_COUNTRY_ID, $pLCountryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_L_COUNTRY_ID, $pLCountryId, $comparison);
    }

    /**
     * Filter the query on the p_c_topic_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPCTopicId(1234); // WHERE p_c_topic_id = 1234
     * $query->filterByPCTopicId(array(12, 34)); // WHERE p_c_topic_id IN (12, 34)
     * $query->filterByPCTopicId(array('min' => 12)); // WHERE p_c_topic_id >= 12
     * $query->filterByPCTopicId(array('max' => 12)); // WHERE p_c_topic_id <= 12
     * </code>
     *
     * @param     mixed $pCTopicId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPCTopicId($pCTopicId = null, $comparison = null)
    {
        if (is_array($pCTopicId)) {
            $useMinMax = false;
            if (isset($pCTopicId['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_C_TOPIC_ID, $pCTopicId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pCTopicId['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::P_C_TOPIC_ID, $pCTopicId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::P_C_TOPIC_ID, $pCTopicId, $comparison);
    }

    /**
     * Filter the query on the fb_ad_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFbAdId('fooValue');   // WHERE fb_ad_id = 'fooValue'
     * $query->filterByFbAdId('%fooValue%'); // WHERE fb_ad_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fbAdId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByFbAdId($fbAdId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fbAdId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fbAdId)) {
                $fbAdId = str_replace('*', '%', $fbAdId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::FB_AD_ID, $fbAdId, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PDReactionArchivePeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the file_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFileName('fooValue');   // WHERE file_name = 'fooValue'
     * $query->filterByFileName('%fooValue%'); // WHERE file_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fileName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByFileName($fileName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fileName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fileName)) {
                $fileName = str_replace('*', '%', $fileName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::FILE_NAME, $fileName, $comparison);
    }

    /**
     * Filter the query on the copyright column
     *
     * Example usage:
     * <code>
     * $query->filterByCopyright('fooValue');   // WHERE copyright = 'fooValue'
     * $query->filterByCopyright('%fooValue%'); // WHERE copyright LIKE '%fooValue%'
     * </code>
     *
     * @param     string $copyright The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByCopyright($copyright = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($copyright)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $copyright)) {
                $copyright = str_replace('*', '%', $copyright);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::COPYRIGHT, $copyright, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the note_pos column
     *
     * Example usage:
     * <code>
     * $query->filterByNotePos(1234); // WHERE note_pos = 1234
     * $query->filterByNotePos(array(12, 34)); // WHERE note_pos IN (12, 34)
     * $query->filterByNotePos(array('min' => 12)); // WHERE note_pos >= 12
     * $query->filterByNotePos(array('max' => 12)); // WHERE note_pos <= 12
     * </code>
     *
     * @param     mixed $notePos The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByNotePos($notePos = null, $comparison = null)
    {
        if (is_array($notePos)) {
            $useMinMax = false;
            if (isset($notePos['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::NOTE_POS, $notePos['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notePos['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::NOTE_POS, $notePos['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::NOTE_POS, $notePos, $comparison);
    }

    /**
     * Filter the query on the note_neg column
     *
     * Example usage:
     * <code>
     * $query->filterByNoteNeg(1234); // WHERE note_neg = 1234
     * $query->filterByNoteNeg(array(12, 34)); // WHERE note_neg IN (12, 34)
     * $query->filterByNoteNeg(array('min' => 12)); // WHERE note_neg >= 12
     * $query->filterByNoteNeg(array('max' => 12)); // WHERE note_neg <= 12
     * </code>
     *
     * @param     mixed $noteNeg The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByNoteNeg($noteNeg = null, $comparison = null)
    {
        if (is_array($noteNeg)) {
            $useMinMax = false;
            if (isset($noteNeg['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::NOTE_NEG, $noteNeg['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($noteNeg['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::NOTE_NEG, $noteNeg['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::NOTE_NEG, $noteNeg, $comparison);
    }

    /**
     * Filter the query on the nb_views column
     *
     * Example usage:
     * <code>
     * $query->filterByNbViews(1234); // WHERE nb_views = 1234
     * $query->filterByNbViews(array(12, 34)); // WHERE nb_views IN (12, 34)
     * $query->filterByNbViews(array('min' => 12)); // WHERE nb_views >= 12
     * $query->filterByNbViews(array('max' => 12)); // WHERE nb_views <= 12
     * </code>
     *
     * @param     mixed $nbViews The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByNbViews($nbViews = null, $comparison = null)
    {
        if (is_array($nbViews)) {
            $useMinMax = false;
            if (isset($nbViews['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::NB_VIEWS, $nbViews['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbViews['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::NB_VIEWS, $nbViews['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::NB_VIEWS, $nbViews, $comparison);
    }

    /**
     * Filter the query on the want_boost column
     *
     * Example usage:
     * <code>
     * $query->filterByWantBoost(1234); // WHERE want_boost = 1234
     * $query->filterByWantBoost(array(12, 34)); // WHERE want_boost IN (12, 34)
     * $query->filterByWantBoost(array('min' => 12)); // WHERE want_boost >= 12
     * $query->filterByWantBoost(array('max' => 12)); // WHERE want_boost <= 12
     * </code>
     *
     * @param     mixed $wantBoost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByWantBoost($wantBoost = null, $comparison = null)
    {
        if (is_array($wantBoost)) {
            $useMinMax = false;
            if (isset($wantBoost['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::WANT_BOOST, $wantBoost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($wantBoost['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::WANT_BOOST, $wantBoost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::WANT_BOOST, $wantBoost, $comparison);
    }

    /**
     * Filter the query on the published column
     *
     * Example usage:
     * <code>
     * $query->filterByPublished(true); // WHERE published = true
     * $query->filterByPublished('yes'); // WHERE published = true
     * </code>
     *
     * @param     boolean|string $published The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPublished($published = null, $comparison = null)
    {
        if (is_string($published)) {
            $published = in_array(strtolower($published), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PDReactionArchivePeer::PUBLISHED, $published, $comparison);
    }

    /**
     * Filter the query on the published_at column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishedAt('2011-03-14'); // WHERE published_at = '2011-03-14'
     * $query->filterByPublishedAt('now'); // WHERE published_at = '2011-03-14'
     * $query->filterByPublishedAt(array('max' => 'yesterday')); // WHERE published_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $publishedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::PUBLISHED_AT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::PUBLISHED_AT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::PUBLISHED_AT, $publishedAt, $comparison);
    }

    /**
     * Filter the query on the published_by column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishedBy('fooValue');   // WHERE published_by = 'fooValue'
     * $query->filterByPublishedBy('%fooValue%'); // WHERE published_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $publishedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByPublishedBy($publishedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($publishedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $publishedBy)) {
                $publishedBy = str_replace('*', '%', $publishedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::PUBLISHED_BY, $publishedBy, $comparison);
    }

    /**
     * Filter the query on the favorite column
     *
     * Example usage:
     * <code>
     * $query->filterByFavorite(true); // WHERE favorite = true
     * $query->filterByFavorite('yes'); // WHERE favorite = true
     * </code>
     *
     * @param     boolean|string $favorite The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByFavorite($favorite = null, $comparison = null)
    {
        if (is_string($favorite)) {
            $favorite = in_array(strtolower($favorite), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PDReactionArchivePeer::FAVORITE, $favorite, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByOnline($online = null, $comparison = null)
    {
        if (is_string($online)) {
            $online = in_array(strtolower($online), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PDReactionArchivePeer::ONLINE, $online, $comparison);
    }

    /**
     * Filter the query on the homepage column
     *
     * Example usage:
     * <code>
     * $query->filterByHomepage(true); // WHERE homepage = true
     * $query->filterByHomepage('yes'); // WHERE homepage = true
     * </code>
     *
     * @param     boolean|string $homepage The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByHomepage($homepage = null, $comparison = null)
    {
        if (is_string($homepage)) {
            $homepage = in_array(strtolower($homepage), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PDReactionArchivePeer::HOMEPAGE, $homepage, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByModerated($moderated = null, $comparison = null)
    {
        if (is_string($moderated)) {
            $moderated = in_array(strtolower($moderated), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PDReactionArchivePeer::MODERATED, $moderated, $comparison);
    }

    /**
     * Filter the query on the moderated_partial column
     *
     * Example usage:
     * <code>
     * $query->filterByModeratedPartial(true); // WHERE moderated_partial = true
     * $query->filterByModeratedPartial('yes'); // WHERE moderated_partial = true
     * </code>
     *
     * @param     boolean|string $moderatedPartial The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByModeratedPartial($moderatedPartial = null, $comparison = null)
    {
        if (is_string($moderatedPartial)) {
            $moderatedPartial = in_array(strtolower($moderatedPartial), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PDReactionArchivePeer::MODERATED_PARTIAL, $moderatedPartial, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByModeratedAt($moderatedAt = null, $comparison = null)
    {
        if (is_array($moderatedAt)) {
            $useMinMax = false;
            if (isset($moderatedAt['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::MODERATED_AT, $moderatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moderatedAt['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::MODERATED_AT, $moderatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::MODERATED_AT, $moderatedAt, $comparison);
    }

    /**
     * Filter the query on the indexed_at column
     *
     * Example usage:
     * <code>
     * $query->filterByIndexedAt('2011-03-14'); // WHERE indexed_at = '2011-03-14'
     * $query->filterByIndexedAt('now'); // WHERE indexed_at = '2011-03-14'
     * $query->filterByIndexedAt(array('max' => 'yesterday')); // WHERE indexed_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $indexedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByIndexedAt($indexedAt = null, $comparison = null)
    {
        if (is_array($indexedAt)) {
            $useMinMax = false;
            if (isset($indexedAt['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::INDEXED_AT, $indexedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($indexedAt['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::INDEXED_AT, $indexedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::INDEXED_AT, $indexedAt, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::CREATED_AT, $createdAt, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::UPDATED_AT, $updatedAt, $comparison);
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
     * @return PDReactionArchiveQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PDReactionArchivePeer::SLUG, $slug, $comparison);
    }

    /**
     * Filter the query on the tree_left column
     *
     * Example usage:
     * <code>
     * $query->filterByTreeLeft(1234); // WHERE tree_left = 1234
     * $query->filterByTreeLeft(array(12, 34)); // WHERE tree_left IN (12, 34)
     * $query->filterByTreeLeft(array('min' => 12)); // WHERE tree_left >= 12
     * $query->filterByTreeLeft(array('max' => 12)); // WHERE tree_left <= 12
     * </code>
     *
     * @param     mixed $treeLeft The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByTreeLeft($treeLeft = null, $comparison = null)
    {
        if (is_array($treeLeft)) {
            $useMinMax = false;
            if (isset($treeLeft['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::TREE_LEFT, $treeLeft['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($treeLeft['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::TREE_LEFT, $treeLeft['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::TREE_LEFT, $treeLeft, $comparison);
    }

    /**
     * Filter the query on the tree_right column
     *
     * Example usage:
     * <code>
     * $query->filterByTreeRight(1234); // WHERE tree_right = 1234
     * $query->filterByTreeRight(array(12, 34)); // WHERE tree_right IN (12, 34)
     * $query->filterByTreeRight(array('min' => 12)); // WHERE tree_right >= 12
     * $query->filterByTreeRight(array('max' => 12)); // WHERE tree_right <= 12
     * </code>
     *
     * @param     mixed $treeRight The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByTreeRight($treeRight = null, $comparison = null)
    {
        if (is_array($treeRight)) {
            $useMinMax = false;
            if (isset($treeRight['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::TREE_RIGHT, $treeRight['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($treeRight['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::TREE_RIGHT, $treeRight['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::TREE_RIGHT, $treeRight, $comparison);
    }

    /**
     * Filter the query on the tree_level column
     *
     * Example usage:
     * <code>
     * $query->filterByTreeLevel(1234); // WHERE tree_level = 1234
     * $query->filterByTreeLevel(array(12, 34)); // WHERE tree_level IN (12, 34)
     * $query->filterByTreeLevel(array('min' => 12)); // WHERE tree_level >= 12
     * $query->filterByTreeLevel(array('max' => 12)); // WHERE tree_level <= 12
     * </code>
     *
     * @param     mixed $treeLevel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByTreeLevel($treeLevel = null, $comparison = null)
    {
        if (is_array($treeLevel)) {
            $useMinMax = false;
            if (isset($treeLevel['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::TREE_LEVEL, $treeLevel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($treeLevel['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::TREE_LEVEL, $treeLevel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::TREE_LEVEL, $treeLevel, $comparison);
    }

    /**
     * Filter the query on the archived_at column
     *
     * Example usage:
     * <code>
     * $query->filterByArchivedAt('2011-03-14'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt('now'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt(array('max' => 'yesterday')); // WHERE archived_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $archivedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(PDReactionArchivePeer::ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(PDReactionArchivePeer::ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PDReactionArchivePeer::ARCHIVED_AT, $archivedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   PDReactionArchive $pDReactionArchive Object to remove from the list of results
     *
     * @return PDReactionArchiveQuery The current query, for fluid interface
     */
    public function prune($pDReactionArchive = null)
    {
        if ($pDReactionArchive) {
            $this->addUsingAlias(PDReactionArchivePeer::ID, $pDReactionArchive->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
