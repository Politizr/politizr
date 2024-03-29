<?php

namespace Politizr\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Politizr\Model\PQMandatePeer;
use Politizr\Model\PQOrganizationPeer;
use Politizr\Model\PQTypePeer;
use Politizr\Model\PUMandate;
use Politizr\Model\PUMandatePeer;
use Politizr\Model\PUserPeer;
use Politizr\Model\map\PUMandateTableMap;

abstract class BasePUMandatePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'p_u_mandate';

    /** the related Propel class for this table */
    const OM_CLASS = 'Politizr\\Model\\PUMandate';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Politizr\\Model\\map\\PUMandateTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 11;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 11;

    /** the column name for the id field */
    const ID = 'p_u_mandate.id';

    /** the column name for the uuid field */
    const UUID = 'p_u_mandate.uuid';

    /** the column name for the p_user_id field */
    const P_USER_ID = 'p_u_mandate.p_user_id';

    /** the column name for the p_q_type_id field */
    const P_Q_TYPE_ID = 'p_u_mandate.p_q_type_id';

    /** the column name for the p_q_mandate_id field */
    const P_Q_MANDATE_ID = 'p_u_mandate.p_q_mandate_id';

    /** the column name for the p_q_organization_id field */
    const P_Q_ORGANIZATION_ID = 'p_u_mandate.p_q_organization_id';

    /** the column name for the localization field */
    const LOCALIZATION = 'p_u_mandate.localization';

    /** the column name for the begin_at field */
    const BEGIN_AT = 'p_u_mandate.begin_at';

    /** the column name for the end_at field */
    const END_AT = 'p_u_mandate.end_at';

    /** the column name for the created_at field */
    const CREATED_AT = 'p_u_mandate.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'p_u_mandate.updated_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of PUMandate objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array PUMandate[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. PUMandatePeer::$fieldNames[PUMandatePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Uuid', 'PUserId', 'PQTypeId', 'PQMandateId', 'PQOrganizationId', 'Localization', 'BeginAt', 'EndAt', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'uuid', 'pUserId', 'pQTypeId', 'pQMandateId', 'pQOrganizationId', 'localization', 'beginAt', 'endAt', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (PUMandatePeer::ID, PUMandatePeer::UUID, PUMandatePeer::P_USER_ID, PUMandatePeer::P_Q_TYPE_ID, PUMandatePeer::P_Q_MANDATE_ID, PUMandatePeer::P_Q_ORGANIZATION_ID, PUMandatePeer::LOCALIZATION, PUMandatePeer::BEGIN_AT, PUMandatePeer::END_AT, PUMandatePeer::CREATED_AT, PUMandatePeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'UUID', 'P_USER_ID', 'P_Q_TYPE_ID', 'P_Q_MANDATE_ID', 'P_Q_ORGANIZATION_ID', 'LOCALIZATION', 'BEGIN_AT', 'END_AT', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'uuid', 'p_user_id', 'p_q_type_id', 'p_q_mandate_id', 'p_q_organization_id', 'localization', 'begin_at', 'end_at', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. PUMandatePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Uuid' => 1, 'PUserId' => 2, 'PQTypeId' => 3, 'PQMandateId' => 4, 'PQOrganizationId' => 5, 'Localization' => 6, 'BeginAt' => 7, 'EndAt' => 8, 'CreatedAt' => 9, 'UpdatedAt' => 10, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'uuid' => 1, 'pUserId' => 2, 'pQTypeId' => 3, 'pQMandateId' => 4, 'pQOrganizationId' => 5, 'localization' => 6, 'beginAt' => 7, 'endAt' => 8, 'createdAt' => 9, 'updatedAt' => 10, ),
        BasePeer::TYPE_COLNAME => array (PUMandatePeer::ID => 0, PUMandatePeer::UUID => 1, PUMandatePeer::P_USER_ID => 2, PUMandatePeer::P_Q_TYPE_ID => 3, PUMandatePeer::P_Q_MANDATE_ID => 4, PUMandatePeer::P_Q_ORGANIZATION_ID => 5, PUMandatePeer::LOCALIZATION => 6, PUMandatePeer::BEGIN_AT => 7, PUMandatePeer::END_AT => 8, PUMandatePeer::CREATED_AT => 9, PUMandatePeer::UPDATED_AT => 10, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'UUID' => 1, 'P_USER_ID' => 2, 'P_Q_TYPE_ID' => 3, 'P_Q_MANDATE_ID' => 4, 'P_Q_ORGANIZATION_ID' => 5, 'LOCALIZATION' => 6, 'BEGIN_AT' => 7, 'END_AT' => 8, 'CREATED_AT' => 9, 'UPDATED_AT' => 10, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'uuid' => 1, 'p_user_id' => 2, 'p_q_type_id' => 3, 'p_q_mandate_id' => 4, 'p_q_organization_id' => 5, 'localization' => 6, 'begin_at' => 7, 'end_at' => 8, 'created_at' => 9, 'updated_at' => 10, ),
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
        $toNames = PUMandatePeer::getFieldNames($toType);
        $key = isset(PUMandatePeer::$fieldKeys[$fromType][$name]) ? PUMandatePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(PUMandatePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, PUMandatePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return PUMandatePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. PUMandatePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(PUMandatePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(PUMandatePeer::ID);
            $criteria->addSelectColumn(PUMandatePeer::UUID);
            $criteria->addSelectColumn(PUMandatePeer::P_USER_ID);
            $criteria->addSelectColumn(PUMandatePeer::P_Q_TYPE_ID);
            $criteria->addSelectColumn(PUMandatePeer::P_Q_MANDATE_ID);
            $criteria->addSelectColumn(PUMandatePeer::P_Q_ORGANIZATION_ID);
            $criteria->addSelectColumn(PUMandatePeer::LOCALIZATION);
            $criteria->addSelectColumn(PUMandatePeer::BEGIN_AT);
            $criteria->addSelectColumn(PUMandatePeer::END_AT);
            $criteria->addSelectColumn(PUMandatePeer::CREATED_AT);
            $criteria->addSelectColumn(PUMandatePeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.uuid');
            $criteria->addSelectColumn($alias . '.p_user_id');
            $criteria->addSelectColumn($alias . '.p_q_type_id');
            $criteria->addSelectColumn($alias . '.p_q_mandate_id');
            $criteria->addSelectColumn($alias . '.p_q_organization_id');
            $criteria->addSelectColumn($alias . '.localization');
            $criteria->addSelectColumn($alias . '.begin_at');
            $criteria->addSelectColumn($alias . '.end_at');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
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
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return PUMandate
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = PUMandatePeer::doSelect($critcopy, $con);
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
        return PUMandatePeer::populateObjects(PUMandatePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            PUMandatePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

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
     * @param PUMandate $obj A PUMandate object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            PUMandatePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A PUMandate object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof PUMandate) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PUMandate object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(PUMandatePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return PUMandate Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(PUMandatePeer::$instances[$key])) {
                return PUMandatePeer::$instances[$key];
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
        foreach (PUMandatePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        PUMandatePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to p_u_mandate
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
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
        $cls = PUMandatePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = PUMandatePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PUMandatePeer::addInstanceToPool($obj, $key);
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
     * @return array (PUMandate object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = PUMandatePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = PUMandatePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + PUMandatePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PUMandatePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            PUMandatePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related PUser table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinPUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related PQType table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinPQType(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related PQMandate table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinPQMandate(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related PQOrganization table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinPQOrganization(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

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
     * Selects a collection of PUMandate objects pre-filled with their PUser objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinPUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol = PUMandatePeer::NUM_HYDRATE_COLUMNS;
        PUserPeer::addSelectColumns($criteria);

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PUserPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PUserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PUserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PUserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (PUMandate) to $obj2 (PUser)
                $obj2->addPUMandate($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PUMandate objects pre-filled with their PQType objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinPQType(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol = PUMandatePeer::NUM_HYDRATE_COLUMNS;
        PQTypePeer::addSelectColumns($criteria);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PQTypePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PQTypePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PQTypePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PQTypePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (PUMandate) to $obj2 (PQType)
                $obj2->addPUMandate($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PUMandate objects pre-filled with their PQMandate objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinPQMandate(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol = PUMandatePeer::NUM_HYDRATE_COLUMNS;
        PQMandatePeer::addSelectColumns($criteria);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PQMandatePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PQMandatePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PQMandatePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PQMandatePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (PUMandate) to $obj2 (PQMandate)
                $obj2->addPUMandate($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PUMandate objects pre-filled with their PQOrganization objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinPQOrganization(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol = PUMandatePeer::NUM_HYDRATE_COLUMNS;
        PQOrganizationPeer::addSelectColumns($criteria);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = PQOrganizationPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = PQOrganizationPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PQOrganizationPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    PQOrganizationPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (PUMandate) to $obj2 (PQOrganization)
                $obj2->addPUMandate($obj1);

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
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

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
     * Selects a collection of PUMandate objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol2 = PUMandatePeer::NUM_HYDRATE_COLUMNS;

        PUserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PUserPeer::NUM_HYDRATE_COLUMNS;

        PQTypePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + PQTypePeer::NUM_HYDRATE_COLUMNS;

        PQMandatePeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + PQMandatePeer::NUM_HYDRATE_COLUMNS;

        PQOrganizationPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + PQOrganizationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined PUser rows

            $key2 = PUserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = PUserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = PUserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PUserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (PUMandate) to the collection in $obj2 (PUser)
                $obj2->addPUMandate($obj1);
            } // if joined row not null

            // Add objects for joined PQType rows

            $key3 = PQTypePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = PQTypePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = PQTypePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    PQTypePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (PUMandate) to the collection in $obj3 (PQType)
                $obj3->addPUMandate($obj1);
            } // if joined row not null

            // Add objects for joined PQMandate rows

            $key4 = PQMandatePeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = PQMandatePeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = PQMandatePeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    PQMandatePeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (PUMandate) to the collection in $obj4 (PQMandate)
                $obj4->addPUMandate($obj1);
            } // if joined row not null

            // Add objects for joined PQOrganization rows

            $key5 = PQOrganizationPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = PQOrganizationPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = PQOrganizationPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    PQOrganizationPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (PUMandate) to the collection in $obj5 (PQOrganization)
                $obj5->addPUMandate($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related PUser table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related PQType table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPQType(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related PQMandate table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPQMandate(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related PQOrganization table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPQOrganization(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PUMandatePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

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
     * Selects a collection of PUMandate objects pre-filled with all related objects except PUser.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol2 = PUMandatePeer::NUM_HYDRATE_COLUMNS;

        PQTypePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PQTypePeer::NUM_HYDRATE_COLUMNS;

        PQMandatePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + PQMandatePeer::NUM_HYDRATE_COLUMNS;

        PQOrganizationPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + PQOrganizationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined PQType rows

                $key2 = PQTypePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = PQTypePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = PQTypePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PQTypePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj2 (PQType)
                $obj2->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQMandate rows

                $key3 = PQMandatePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = PQMandatePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = PQMandatePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    PQMandatePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj3 (PQMandate)
                $obj3->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQOrganization rows

                $key4 = PQOrganizationPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = PQOrganizationPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = PQOrganizationPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    PQOrganizationPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj4 (PQOrganization)
                $obj4->addPUMandate($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PUMandate objects pre-filled with all related objects except PQType.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPQType(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol2 = PUMandatePeer::NUM_HYDRATE_COLUMNS;

        PUserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PUserPeer::NUM_HYDRATE_COLUMNS;

        PQMandatePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + PQMandatePeer::NUM_HYDRATE_COLUMNS;

        PQOrganizationPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + PQOrganizationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined PUser rows

                $key2 = PUserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = PUserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = PUserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PUserPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj2 (PUser)
                $obj2->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQMandate rows

                $key3 = PQMandatePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = PQMandatePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = PQMandatePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    PQMandatePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj3 (PQMandate)
                $obj3->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQOrganization rows

                $key4 = PQOrganizationPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = PQOrganizationPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = PQOrganizationPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    PQOrganizationPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj4 (PQOrganization)
                $obj4->addPUMandate($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PUMandate objects pre-filled with all related objects except PQMandate.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPQMandate(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol2 = PUMandatePeer::NUM_HYDRATE_COLUMNS;

        PUserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PUserPeer::NUM_HYDRATE_COLUMNS;

        PQTypePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + PQTypePeer::NUM_HYDRATE_COLUMNS;

        PQOrganizationPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + PQOrganizationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_ORGANIZATION_ID, PQOrganizationPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined PUser rows

                $key2 = PUserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = PUserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = PUserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PUserPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj2 (PUser)
                $obj2->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQType rows

                $key3 = PQTypePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = PQTypePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = PQTypePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    PQTypePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj3 (PQType)
                $obj3->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQOrganization rows

                $key4 = PQOrganizationPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = PQOrganizationPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = PQOrganizationPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    PQOrganizationPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj4 (PQOrganization)
                $obj4->addPUMandate($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of PUMandate objects pre-filled with all related objects except PQOrganization.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of PUMandate objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPQOrganization(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PUMandatePeer::DATABASE_NAME);
        }

        PUMandatePeer::addSelectColumns($criteria);
        $startcol2 = PUMandatePeer::NUM_HYDRATE_COLUMNS;

        PUserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + PUserPeer::NUM_HYDRATE_COLUMNS;

        PQTypePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + PQTypePeer::NUM_HYDRATE_COLUMNS;

        PQMandatePeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + PQMandatePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PUMandatePeer::P_USER_ID, PUserPeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_TYPE_ID, PQTypePeer::ID, $join_behavior);

        $criteria->addJoin(PUMandatePeer::P_Q_MANDATE_ID, PQMandatePeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PUMandatePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PUMandatePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PUMandatePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PUMandatePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined PUser rows

                $key2 = PUserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = PUserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = PUserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    PUserPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj2 (PUser)
                $obj2->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQType rows

                $key3 = PQTypePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = PQTypePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = PQTypePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    PQTypePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj3 (PQType)
                $obj3->addPUMandate($obj1);

            } // if joined row is not null

                // Add objects for joined PQMandate rows

                $key4 = PQMandatePeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = PQMandatePeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = PQMandatePeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    PQMandatePeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (PUMandate) to the collection in $obj4 (PQMandate)
                $obj4->addPUMandate($obj1);

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
        return Propel::getDatabaseMap(PUMandatePeer::DATABASE_NAME)->getTable(PUMandatePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BasePUMandatePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BasePUMandatePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Politizr\Model\map\PUMandateTableMap());
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
        return PUMandatePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a PUMandate or Criteria object.
     *
     * @param      mixed $values Criteria or PUMandate object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from PUMandate object
        }

        if ($criteria->containsKey(PUMandatePeer::ID) && $criteria->keyContainsValue(PUMandatePeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PUMandatePeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a PUMandate or Criteria object.
     *
     * @param      mixed $values Criteria or PUMandate object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(PUMandatePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(PUMandatePeer::ID);
            $value = $criteria->remove(PUMandatePeer::ID);
            if ($value) {
                $selectCriteria->add(PUMandatePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(PUMandatePeer::TABLE_NAME);
            }

        } else { // $values is PUMandate object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the p_u_mandate table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(PUMandatePeer::TABLE_NAME, $con, PUMandatePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PUMandatePeer::clearInstancePool();
            PUMandatePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a PUMandate or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or PUMandate object or primary key or array of primary keys
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
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            PUMandatePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof PUMandate) { // it's a model object
            // invalidate the cache for this single object
            PUMandatePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PUMandatePeer::DATABASE_NAME);
            $criteria->add(PUMandatePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                PUMandatePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(PUMandatePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            PUMandatePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given PUMandate object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param PUMandate $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(PUMandatePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(PUMandatePeer::TABLE_NAME);

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

        return BasePeer::doValidate(PUMandatePeer::DATABASE_NAME, PUMandatePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return PUMandate
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = PUMandatePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(PUMandatePeer::DATABASE_NAME);
        $criteria->add(PUMandatePeer::ID, $pk);

        $v = PUMandatePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return PUMandate[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PUMandatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(PUMandatePeer::DATABASE_NAME);
            $criteria->add(PUMandatePeer::ID, $pks, Criteria::IN);
            $objs = PUMandatePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BasePUMandatePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePUMandatePeer::buildTableMap();

