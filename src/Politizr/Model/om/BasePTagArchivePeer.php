<?php

namespace Politizr\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Politizr\Model\PTagArchive;
use Politizr\Model\PTagArchivePeer;
use Politizr\Model\map\PTagArchiveTableMap;

abstract class BasePTagArchivePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'p_tag_archive';

    /** the related Propel class for this table */
    const OM_CLASS = 'Politizr\\Model\\PTagArchive';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Politizr\\Model\\map\\PTagArchiveTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 14;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 14;

    /** the column name for the id field */
    const ID = 'p_tag_archive.id';

    /** the column name for the uuid field */
    const UUID = 'p_tag_archive.uuid';

    /** the column name for the p_t_tag_type_id field */
    const P_T_TAG_TYPE_ID = 'p_tag_archive.p_t_tag_type_id';

    /** the column name for the p_t_parent_id field */
    const P_T_PARENT_ID = 'p_tag_archive.p_t_parent_id';

    /** the column name for the p_user_id field */
    const P_USER_ID = 'p_tag_archive.p_user_id';

    /** the column name for the p_owner_id field */
    const P_OWNER_ID = 'p_tag_archive.p_owner_id';

    /** the column name for the title field */
    const TITLE = 'p_tag_archive.title';

    /** the column name for the moderated field */
    const MODERATED = 'p_tag_archive.moderated';

    /** the column name for the moderated_at field */
    const MODERATED_AT = 'p_tag_archive.moderated_at';

    /** the column name for the online field */
    const ONLINE = 'p_tag_archive.online';

    /** the column name for the created_at field */
    const CREATED_AT = 'p_tag_archive.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'p_tag_archive.updated_at';

    /** the column name for the slug field */
    const SLUG = 'p_tag_archive.slug';

    /** the column name for the archived_at field */
    const ARCHIVED_AT = 'p_tag_archive.archived_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of PTagArchive objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array PTagArchive[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. PTagArchivePeer::$fieldNames[PTagArchivePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Uuid', 'PTTagTypeId', 'PTParentId', 'PUserId', 'POwnerId', 'Title', 'Moderated', 'ModeratedAt', 'Online', 'CreatedAt', 'UpdatedAt', 'Slug', 'ArchivedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'uuid', 'pTTagTypeId', 'pTParentId', 'pUserId', 'pOwnerId', 'title', 'moderated', 'moderatedAt', 'online', 'createdAt', 'updatedAt', 'slug', 'archivedAt', ),
        BasePeer::TYPE_COLNAME => array (PTagArchivePeer::ID, PTagArchivePeer::UUID, PTagArchivePeer::P_T_TAG_TYPE_ID, PTagArchivePeer::P_T_PARENT_ID, PTagArchivePeer::P_USER_ID, PTagArchivePeer::P_OWNER_ID, PTagArchivePeer::TITLE, PTagArchivePeer::MODERATED, PTagArchivePeer::MODERATED_AT, PTagArchivePeer::ONLINE, PTagArchivePeer::CREATED_AT, PTagArchivePeer::UPDATED_AT, PTagArchivePeer::SLUG, PTagArchivePeer::ARCHIVED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'UUID', 'P_T_TAG_TYPE_ID', 'P_T_PARENT_ID', 'P_USER_ID', 'P_OWNER_ID', 'TITLE', 'MODERATED', 'MODERATED_AT', 'ONLINE', 'CREATED_AT', 'UPDATED_AT', 'SLUG', 'ARCHIVED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'uuid', 'p_t_tag_type_id', 'p_t_parent_id', 'p_user_id', 'p_owner_id', 'title', 'moderated', 'moderated_at', 'online', 'created_at', 'updated_at', 'slug', 'archived_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. PTagArchivePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Uuid' => 1, 'PTTagTypeId' => 2, 'PTParentId' => 3, 'PUserId' => 4, 'POwnerId' => 5, 'Title' => 6, 'Moderated' => 7, 'ModeratedAt' => 8, 'Online' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, 'Slug' => 12, 'ArchivedAt' => 13, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'uuid' => 1, 'pTTagTypeId' => 2, 'pTParentId' => 3, 'pUserId' => 4, 'pOwnerId' => 5, 'title' => 6, 'moderated' => 7, 'moderatedAt' => 8, 'online' => 9, 'createdAt' => 10, 'updatedAt' => 11, 'slug' => 12, 'archivedAt' => 13, ),
        BasePeer::TYPE_COLNAME => array (PTagArchivePeer::ID => 0, PTagArchivePeer::UUID => 1, PTagArchivePeer::P_T_TAG_TYPE_ID => 2, PTagArchivePeer::P_T_PARENT_ID => 3, PTagArchivePeer::P_USER_ID => 4, PTagArchivePeer::P_OWNER_ID => 5, PTagArchivePeer::TITLE => 6, PTagArchivePeer::MODERATED => 7, PTagArchivePeer::MODERATED_AT => 8, PTagArchivePeer::ONLINE => 9, PTagArchivePeer::CREATED_AT => 10, PTagArchivePeer::UPDATED_AT => 11, PTagArchivePeer::SLUG => 12, PTagArchivePeer::ARCHIVED_AT => 13, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'UUID' => 1, 'P_T_TAG_TYPE_ID' => 2, 'P_T_PARENT_ID' => 3, 'P_USER_ID' => 4, 'P_OWNER_ID' => 5, 'TITLE' => 6, 'MODERATED' => 7, 'MODERATED_AT' => 8, 'ONLINE' => 9, 'CREATED_AT' => 10, 'UPDATED_AT' => 11, 'SLUG' => 12, 'ARCHIVED_AT' => 13, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'uuid' => 1, 'p_t_tag_type_id' => 2, 'p_t_parent_id' => 3, 'p_user_id' => 4, 'p_owner_id' => 5, 'title' => 6, 'moderated' => 7, 'moderated_at' => 8, 'online' => 9, 'created_at' => 10, 'updated_at' => 11, 'slug' => 12, 'archived_at' => 13, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $toNames = PTagArchivePeer::getFieldNames($toType);
        $key = isset(PTagArchivePeer::$fieldKeys[$fromType][$name]) ? PTagArchivePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(PTagArchivePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, PTagArchivePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return PTagArchivePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. PTagArchivePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(PTagArchivePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(PTagArchivePeer::ID);
            $criteria->addSelectColumn(PTagArchivePeer::UUID);
            $criteria->addSelectColumn(PTagArchivePeer::P_T_TAG_TYPE_ID);
            $criteria->addSelectColumn(PTagArchivePeer::P_T_PARENT_ID);
            $criteria->addSelectColumn(PTagArchivePeer::P_USER_ID);
            $criteria->addSelectColumn(PTagArchivePeer::P_OWNER_ID);
            $criteria->addSelectColumn(PTagArchivePeer::TITLE);
            $criteria->addSelectColumn(PTagArchivePeer::MODERATED);
            $criteria->addSelectColumn(PTagArchivePeer::MODERATED_AT);
            $criteria->addSelectColumn(PTagArchivePeer::ONLINE);
            $criteria->addSelectColumn(PTagArchivePeer::CREATED_AT);
            $criteria->addSelectColumn(PTagArchivePeer::UPDATED_AT);
            $criteria->addSelectColumn(PTagArchivePeer::SLUG);
            $criteria->addSelectColumn(PTagArchivePeer::ARCHIVED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.uuid');
            $criteria->addSelectColumn($alias . '.p_t_tag_type_id');
            $criteria->addSelectColumn($alias . '.p_t_parent_id');
            $criteria->addSelectColumn($alias . '.p_user_id');
            $criteria->addSelectColumn($alias . '.p_owner_id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.moderated');
            $criteria->addSelectColumn($alias . '.moderated_at');
            $criteria->addSelectColumn($alias . '.online');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.slug');
            $criteria->addSelectColumn($alias . '.archived_at');
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
        $criteria->setPrimaryTableName(PTagArchivePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PTagArchivePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(PTagArchivePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return PTagArchive
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = PTagArchivePeer::doSelect($critcopy, $con);
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
        return PTagArchivePeer::populateObjects(PTagArchivePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            PTagArchivePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(PTagArchivePeer::DATABASE_NAME);

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
     * @param PTagArchive $obj A PTagArchive object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            PTagArchivePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A PTagArchive object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof PTagArchive) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PTagArchive object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(PTagArchivePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return PTagArchive Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(PTagArchivePeer::$instances[$key])) {
                return PTagArchivePeer::$instances[$key];
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
        foreach (PTagArchivePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        PTagArchivePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to p_tag_archive
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
        $cls = PTagArchivePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = PTagArchivePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = PTagArchivePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PTagArchivePeer::addInstanceToPool($obj, $key);
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
     * @return array (PTagArchive object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = PTagArchivePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = PTagArchivePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + PTagArchivePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PTagArchivePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            PTagArchivePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        return Propel::getDatabaseMap(PTagArchivePeer::DATABASE_NAME)->getTable(PTagArchivePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BasePTagArchivePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BasePTagArchivePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Politizr\Model\map\PTagArchiveTableMap());
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
        return PTagArchivePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a PTagArchive or Criteria object.
     *
     * @param      mixed $values Criteria or PTagArchive object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from PTagArchive object
        }


        // Set the correct dbName
        $criteria->setDbName(PTagArchivePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a PTagArchive or Criteria object.
     *
     * @param      mixed $values Criteria or PTagArchive object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(PTagArchivePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(PTagArchivePeer::ID);
            $value = $criteria->remove(PTagArchivePeer::ID);
            if ($value) {
                $selectCriteria->add(PTagArchivePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(PTagArchivePeer::TABLE_NAME);
            }

        } else { // $values is PTagArchive object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(PTagArchivePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the p_tag_archive table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(PTagArchivePeer::TABLE_NAME, $con, PTagArchivePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PTagArchivePeer::clearInstancePool();
            PTagArchivePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a PTagArchive or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or PTagArchive object or primary key or array of primary keys
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
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            PTagArchivePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof PTagArchive) { // it's a model object
            // invalidate the cache for this single object
            PTagArchivePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PTagArchivePeer::DATABASE_NAME);
            $criteria->add(PTagArchivePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                PTagArchivePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(PTagArchivePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            PTagArchivePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given PTagArchive object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param PTagArchive $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(PTagArchivePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(PTagArchivePeer::TABLE_NAME);

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

        return BasePeer::doValidate(PTagArchivePeer::DATABASE_NAME, PTagArchivePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return PTagArchive
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = PTagArchivePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(PTagArchivePeer::DATABASE_NAME);
        $criteria->add(PTagArchivePeer::ID, $pk);

        $v = PTagArchivePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return PTagArchive[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PTagArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(PTagArchivePeer::DATABASE_NAME);
            $criteria->add(PTagArchivePeer::ID, $pks, Criteria::IN);
            $objs = PTagArchivePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BasePTagArchivePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePTagArchivePeer::buildTableMap();

