<?php

namespace Politizr\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Politizr\Model\PRBadge;
use Politizr\Model\PRBadgeFamilyPeer;
use Politizr\Model\PRBadgePeer;
use Politizr\Model\PRBadgeQuery;
use Politizr\Model\PRMetalTypePeer;
use Politizr\Model\PUBadgePeer;
use Politizr\Model\map\PRBadgeTableMap;

abstract class BasePRBadgePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'p_r_badge';

    /** the related Propel class for this table */
    const OM_CLASS = 'Politizr\\Model\\PRBadge';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Politizr\\Model\\map\\PRBadgeTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 11;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 11;

    /** the column name for the id field */
    const ID = 'p_r_badge.id';

    /** the column name for the uuid field */
    const UUID = 'p_r_badge.uuid';

    /** the column name for the p_r_metal_type_id field */
    const P_R_METAL_TYPE_ID = 'p_r_badge.p_r_metal_type_id';

    /** the column name for the p_r_badge_family_id field */
    const P_R_BADGE_FAMILY_ID = 'p_r_badge.p_r_badge_family_id';

    /** the column name for the title field */
    const TITLE = 'p_r_badge.title';

    /** the column name for the file_name field */
    const FILE_NAME = 'p_r_badge.file_name';

    /** the column name for the online field */
    const ONLINE = 'p_r_badge.online';

    /** the column name for the created_at field */
    const CREATED_AT = 'p_r_badge.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'p_r_badge.updated_at';

    /** the column name for the slug field */
    const SLUG = 'p_r_badge.slug';

    /** the column name for the sortable_rank field */
    const SORTABLE_RANK = 'p_r_badge.sortable_rank';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of PRBadge objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array PRBadge[]
     */
    public static $instances = array();


    // sortable behavior

    /**
     * rank column
     */
    const RANK_COL = 'p_r_badge.sortable_rank';

    /**
     * Scope column for the set
     */
    const SCOPE_COL = 'p_r_badge.p_r_badge_family_id';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. PRBadgePeer::$fieldNames[PRBadgePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Uuid', 'PRMetalTypeId', 'PRBadgeFamilyId', 'Title', 'FileName', 'Online', 'CreatedAt', 'UpdatedAt', 'Slug', 'SortableRank', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'uuid', 'pRMetalTypeId', 'pRBadgeFamilyId', 'title', 'fileName', 'online', 'createdAt', 'updatedAt', 'slug', 'sortableRank', ),
        BasePeer::TYPE_COLNAME => array (PRBadgePeer::ID, PRBadgePeer::UUID, PRBadgePeer::P_R_METAL_TYPE_ID, PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgePeer::TITLE, PRBadgePeer::FILE_NAME, PRBadgePeer::ONLINE, PRBadgePeer::CREATED_AT, PRBadgePeer::UPDATED_AT, PRBadgePeer::SLUG, PRBadgePeer::SORTABLE_RANK, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'UUID', 'P_R_METAL_TYPE_ID', 'P_R_BADGE_FAMILY_ID', 'TITLE', 'FILE_NAME', 'ONLINE', 'CREATED_AT', 'UPDATED_AT', 'SLUG', 'SORTABLE_RANK', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'uuid', 'p_r_metal_type_id', 'p_r_badge_family_id', 'title', 'file_name', 'online', 'created_at', 'updated_at', 'slug', 'sortable_rank', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. PRBadgePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Uuid' => 1, 'PRMetalTypeId' => 2, 'PRBadgeFamilyId' => 3, 'Title' => 4, 'FileName' => 5, 'Online' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, 'Slug' => 9, 'SortableRank' => 10, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'uuid' => 1, 'pRMetalTypeId' => 2, 'pRBadgeFamilyId' => 3, 'title' => 4, 'fileName' => 5, 'online' => 6, 'createdAt' => 7, 'updatedAt' => 8, 'slug' => 9, 'sortableRank' => 10, ),
        BasePeer::TYPE_COLNAME => array (PRBadgePeer::ID => 0, PRBadgePeer::UUID => 1, PRBadgePeer::P_R_METAL_TYPE_ID => 2, PRBadgePeer::P_R_BADGE_FAMILY_ID => 3, PRBadgePeer::TITLE => 4, PRBadgePeer::FILE_NAME => 5, PRBadgePeer::ONLINE => 6, PRBadgePeer::CREATED_AT => 7, PRBadgePeer::UPDATED_AT => 8, PRBadgePeer::SLUG => 9, PRBadgePeer::SORTABLE_RANK => 10, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'UUID' => 1, 'P_R_METAL_TYPE_ID' => 2, 'P_R_BADGE_FAMILY_ID' => 3, 'TITLE' => 4, 'FILE_NAME' => 5, 'ONLINE' => 6, 'CREATED_AT' => 7, 'UPDATED_AT' => 8, 'SLUG' => 9, 'SORTABLE_RANK' => 10, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'uuid' => 1, 'p_r_metal_type_id' => 2, 'p_r_badge_family_id' => 3, 'title' => 4, 'file_name' => 5, 'online' => 6, 'created_at' => 7, 'updated_at' => 8, 'slug' => 9, 'sortable_rank' => 10, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = PRBadgePeer::getFieldNames($toType);
        $key = isset(PRBadgePeer::$fieldKeys[$fromType][$name]) ? PRBadgePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(PRBadgePeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, PRBadgePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return PRBadgePeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. PRBadgePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(PRBadgePeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PRBadgePeer::ID);
            $criteria->addSelectColumn(PRBadgePeer::UUID);
            $criteria->addSelectColumn(PRBadgePeer::P_R_METAL_TYPE_ID);
            $criteria->addSelectColumn(PRBadgePeer::P_R_BADGE_FAMILY_ID);
            $criteria->addSelectColumn(PRBadgePeer::TITLE);
            $criteria->addSelectColumn(PRBadgePeer::FILE_NAME);
            $criteria->addSelectColumn(PRBadgePeer::ONLINE);
            $criteria->addSelectColumn(PRBadgePeer::CREATED_AT);
            $criteria->addSelectColumn(PRBadgePeer::UPDATED_AT);
            $criteria->addSelectColumn(PRBadgePeer::SLUG);
            $criteria->addSelectColumn(PRBadgePeer::SORTABLE_RANK);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.uuid');
            $criteria->addSelectColumn($alias . '.p_r_metal_type_id');
            $criteria->addSelectColumn($alias . '.p_r_badge_family_id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.file_name');
            $criteria->addSelectColumn($alias . '.online');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.slug');
            $criteria->addSelectColumn($alias . '.sortable_rank');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PRBadgePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return PRBadge
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = PRBadgePeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return PRBadgePeer::populateObjects(PRBadgePeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            PRBadgePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param PRBadge $obj A PRBadge object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            PRBadgePeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A PRBadge object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof PRBadge) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PRBadge object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(PRBadgePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return PRBadge Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(PRBadgePeer::$instances[$key])) {
                return PRBadgePeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (PRBadgePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        PRBadgePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to p_r_badge
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in PUBadgePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PUBadgePeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = PRBadgePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = PRBadgePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = PRBadgePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PRBadgePeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (PRBadge object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = PRBadgePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = PRBadgePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + PRBadgePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PRBadgePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            PRBadgePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related PRMetalType table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinPRMetalType(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PRBadgePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PRBadgePeer::P_R_METAL_TYPE_ID, PRMetalTypePeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related PRBadgeFamily table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinPRBadgeFamily(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PRBadgePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgeFamilyPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of PRBadge objects pre-filled with their PRMetalType objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PRBadge objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinPRMetalType(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PRBadgePeer::DATABASE_NAME);
        }

        PRBadgePeer::addSelectColumns($criteria);
        $startcol = PRBadgePeer::NUM_HYDRATE_COLUMNS;
        PRMetalTypePeer::addSelectColumns($criteria);

        $criteria->addJoin(PRBadgePeer::P_R_METAL_TYPE_ID, PRMetalTypePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PRBadgePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PRBadgePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PRBadgePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PRBadgePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PRMetalTypePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PRMetalTypePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PRMetalTypePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PRMetalTypePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (PRBadge) to $obj2 (PRMetalType)
                $obj2->addPRBadge($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PRBadge objects pre-filled with their PRBadgeFamily objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PRBadge objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinPRBadgeFamily(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PRBadgePeer::DATABASE_NAME);
        }

        PRBadgePeer::addSelectColumns($criteria);
        $startcol = PRBadgePeer::NUM_HYDRATE_COLUMNS;
        PRBadgeFamilyPeer::addSelectColumns($criteria);

        $criteria->addJoin(PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgeFamilyPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PRBadgePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PRBadgePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PRBadgePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PRBadgePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PRBadgeFamilyPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PRBadgeFamilyPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PRBadgeFamilyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PRBadgeFamilyPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (PRBadge) to $obj2 (PRBadgeFamily)
                $obj2->addPRBadge($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PRBadgePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PRBadgePeer::P_R_METAL_TYPE_ID, PRMetalTypePeer::ID, $join_behavior);

        $criteria->addJoin(PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgeFamilyPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of PRBadge objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PRBadge objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PRBadgePeer::DATABASE_NAME);
        }

        PRBadgePeer::addSelectColumns($criteria);
        $startcol2 = PRBadgePeer::NUM_HYDRATE_COLUMNS;

        PRMetalTypePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PRMetalTypePeer::NUM_HYDRATE_COLUMNS;

        PRBadgeFamilyPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + PRBadgeFamilyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PRBadgePeer::P_R_METAL_TYPE_ID, PRMetalTypePeer::ID, $join_behavior);

        $criteria->addJoin(PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgeFamilyPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PRBadgePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PRBadgePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PRBadgePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PRBadgePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined PRMetalType rows

            $key2 = PRMetalTypePeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = PRMetalTypePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PRMetalTypePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PRMetalTypePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (PRBadge) to the collection in $obj2 (PRMetalType)
                $obj2->addPRBadge($obj1);
            } // if joined row not null

            // Add objects for joined PRBadgeFamily rows

            $key3 = PRBadgeFamilyPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = PRBadgeFamilyPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = PRBadgeFamilyPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    PRBadgeFamilyPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (PRBadge) to the collection in $obj3 (PRBadgeFamily)
                $obj3->addPRBadge($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related PRMetalType table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPRMetalType(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PRBadgePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgeFamilyPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related PRBadgeFamily table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPRBadgeFamily(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PRBadgePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PRBadgePeer::P_R_METAL_TYPE_ID, PRMetalTypePeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of PRBadge objects pre-filled with all related objects except PRMetalType.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PRBadge objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPRMetalType(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PRBadgePeer::DATABASE_NAME);
        }

        PRBadgePeer::addSelectColumns($criteria);
        $startcol2 = PRBadgePeer::NUM_HYDRATE_COLUMNS;

        PRBadgeFamilyPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PRBadgeFamilyPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PRBadgePeer::P_R_BADGE_FAMILY_ID, PRBadgeFamilyPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PRBadgePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PRBadgePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PRBadgePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PRBadgePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined PRBadgeFamily rows

                $key2 = PRBadgeFamilyPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = PRBadgeFamilyPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = PRBadgeFamilyPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PRBadgeFamilyPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (PRBadge) to the collection in $obj2 (PRBadgeFamily)
                $obj2->addPRBadge($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PRBadge objects pre-filled with all related objects except PRBadgeFamily.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PRBadge objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPRBadgeFamily(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PRBadgePeer::DATABASE_NAME);
        }

        PRBadgePeer::addSelectColumns($criteria);
        $startcol2 = PRBadgePeer::NUM_HYDRATE_COLUMNS;

        PRMetalTypePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PRMetalTypePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PRBadgePeer::P_R_METAL_TYPE_ID, PRMetalTypePeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PRBadgePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PRBadgePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PRBadgePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PRBadgePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined PRMetalType rows

                $key2 = PRMetalTypePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = PRMetalTypePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = PRMetalTypePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PRMetalTypePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (PRBadge) to the collection in $obj2 (PRMetalType)
                $obj2->addPRBadge($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(PRBadgePeer::DATABASE_NAME)->getTable(PRBadgePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BasePRBadgePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BasePRBadgePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Politizr\Model\map\PRBadgeTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return PRBadgePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a PRBadge or Criteria object.
     *
     * @param      mixed $values Criteria or PRBadge object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from PRBadge object
        }

        if ($criteria->containsKey(PRBadgePeer::ID) && $criteria->keyContainsValue(PRBadgePeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PRBadgePeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a PRBadge or Criteria object.
     *
     * @param      mixed $values Criteria or PRBadge object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(PRBadgePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(PRBadgePeer::ID);
            $value = $criteria->remove(PRBadgePeer::ID);
            if ($value) {
                $selectCriteria->add(PRBadgePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(PRBadgePeer::TABLE_NAME);
            }

        } else { // $values is PRBadge object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the p_r_badge table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(PRBadgePeer::TABLE_NAME, $con, PRBadgePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PRBadgePeer::clearInstancePool();
            PRBadgePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a PRBadge or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or PRBadge object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            PRBadgePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof PRBadge) { // it's a model object
            // invalidate the cache for this single object
            PRBadgePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PRBadgePeer::DATABASE_NAME);
            $criteria->add(PRBadgePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                PRBadgePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(PRBadgePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            PRBadgePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given PRBadge object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param PRBadge $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(PRBadgePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(PRBadgePeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(PRBadgePeer::DATABASE_NAME, PRBadgePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return PRBadge
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = PRBadgePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(PRBadgePeer::DATABASE_NAME);
        $criteria->add(PRBadgePeer::ID, $pk);

        $v = PRBadgePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return PRBadge[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(PRBadgePeer::DATABASE_NAME);
            $criteria->add(PRBadgePeer::ID, $pks, Criteria::IN);
            $objs = PRBadgePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

    // sortable behavior

    /**
     * Get the highest rank
     *
     * @param      int $scope		Scope to determine which suite to consider
     * @param     PropelPDO optional connection
     *
     * @return    integer highest position
     */
    public static function getMaxRank($scope = null, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME);
        }
        // shift the objects with a position lower than the one of object
        $c = new Criteria();
        $c->addSelectColumn('MAX(' . PRBadgePeer::RANK_COL . ')');
        PRBadgePeer::sortableApplyScopeCriteria($c, $scope);
        $stmt = PRBadgePeer::doSelectStmt($c, $con);

        return $stmt->fetchColumn();
    }

    /**
     * Get an item from the list based on its rank
     *
     * @param     integer   $rank rank
     * @param      int $scope		Scope to determine which suite to consider
     * @param     PropelPDO $con optional connection
     *
     * @return PRBadge
     */
    public static function retrieveByRank($rank, $scope = null, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME);
        }

        $c = new Criteria;
        $c->add(PRBadgePeer::RANK_COL, $rank);
        PRBadgePeer::sortableApplyScopeCriteria($c, $scope);

        return PRBadgePeer::doSelectOne($c, $con);
    }

    /**
     * Reorder a set of sortable objects based on a list of id/position
     * Beware that there is no check made on the positions passed
     * So incoherent positions will result in an incoherent list
     *
     * @param     array     $order id => rank pairs
     * @param     PropelPDO $con   optional connection
     *
     * @return    boolean true if the reordering took place, false if a database problem prevented it
     */
    public static function reorder(array $order, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $ids = array_keys($order);
            $objects = PRBadgePeer::retrieveByPKs($ids);
            foreach ($objects as $object) {
                $pk = $object->getPrimaryKey();
                if ($object->getSortableRank() != $order[$pk]) {
                    $object->setSortableRank($order[$pk]);
                    $object->save($con);
                }
            }
            $con->commit();

            return true;
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    }

    /**
     * Return an array of sortable objects ordered by position
     *
     * @param     Criteria  $criteria  optional criteria object
     * @param     string    $order     sorting order, to be chosen between Criteria::ASC (default) and Criteria::DESC
     * @param     PropelPDO $con       optional connection
     *
     * @return    array list of sortable objects
     */
    public static function doSelectOrderByRank(Criteria $criteria = null, $order = Criteria::ASC, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME);
        }

        if ($criteria === null) {
            $criteria = new Criteria();
        } elseif ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
        }

        $criteria->clearOrderByColumns();

        if ($order == Criteria::ASC) {
            $criteria->addAscendingOrderByColumn(PRBadgePeer::RANK_COL);
        } else {
            $criteria->addDescendingOrderByColumn(PRBadgePeer::RANK_COL);
        }

        return PRBadgePeer::doSelect($criteria, $con);
    }

    /**
     * Return an array of sortable objects in the given scope ordered by position
     *
     * @param     mixed     $scope  the scope of the list
     * @param     string    $order  sorting order, to be chosen between Criteria::ASC (default) and Criteria::DESC
     * @param     PropelPDO $con    optional connection
     *
     * @return    array list of sortable objects
     */
    public static function retrieveList($scope, $order = Criteria::ASC, PropelPDO $con = null)
    {
        $c = new Criteria();
        PRBadgePeer::sortableApplyScopeCriteria($c, $scope);

        return PRBadgePeer::doSelectOrderByRank($c, $order, $con);
    }

    /**
     * Return the number of sortable objects in the given scope
     *
     * @param     mixed     $scope  the scope of the list
     * @param     PropelPDO $con    optional connection
     *
     * @return    array list of sortable objects
     */
    public static function countList($scope, PropelPDO $con = null)
    {
        $c = new Criteria();
        PRBadgePeer::sortableApplyScopeCriteria($c, $scope);

        return PRBadgePeer::doCount($c, $con);
    }

    /**
     * Deletes the sortable objects in the given scope
     *
     * @param     mixed     $scope  the scope of the list
     * @param     PropelPDO $con    optional connection
     *
     * @return    int number of deleted objects
     */
    public static function deleteList($scope, PropelPDO $con = null)
    {
        $c = new Criteria();
        PRBadgePeer::sortableApplyScopeCriteria($c, $scope);

        return PRBadgePeer::doDelete($c, $con);
    }

    /**
     * Applies all scope fields to the given criteria.
     *
     * @param  Criteria $criteria Applies the values directly to this criteria.
     * @param  mixed    $scope    The scope value as scalar type or array($value1, ...).
     * @param  string   $method   The method we use to apply the values.
     *
     */
    public static function sortableApplyScopeCriteria(Criteria $criteria, $scope, $method = 'add')
    {

        $criteria->$method(PRBadgePeer::P_R_BADGE_FAMILY_ID, $scope, Criteria::EQUAL);

    }

    /**
     * Adds $delta to all Rank values that are >= $first and <= $last.
     * '$delta' can also be negative.
     *
     * @param      int $delta Value to be shifted by, can be negative
     * @param      int $first First node to be shifted
     * @param      int $last  Last node to be shifted
     * @param      mixed $scope Scope to use for the shift. Scalar value (single scope) or array
     * @param      PropelPDO $con Connection to use.
     */
    public static function shiftRank($delta, $first = null, $last = null, $scope = null, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PRBadgePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $whereCriteria = PRBadgeQuery::create();
        if (null !== $first) {
            $whereCriteria->add(PRBadgePeer::RANK_COL, $first, Criteria::GREATER_EQUAL);
        }
        if (null !== $last) {
            $whereCriteria->addAnd(PRBadgePeer::RANK_COL, $last, Criteria::LESS_EQUAL);
        }
        PRBadgePeer::sortableApplyScopeCriteria($whereCriteria, $scope);

        $valuesCriteria = new Criteria(PRBadgePeer::DATABASE_NAME);
        $valuesCriteria->add(PRBadgePeer::RANK_COL, array('raw' => PRBadgePeer::RANK_COL . ' + ?', 'value' => $delta), Criteria::CUSTOM_EQUAL);

        BasePeer::doUpdate($whereCriteria, $valuesCriteria, $con);
        PRBadgePeer::clearInstancePool();
    }

} // BasePRBadgePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePRBadgePeer::buildTableMap();

