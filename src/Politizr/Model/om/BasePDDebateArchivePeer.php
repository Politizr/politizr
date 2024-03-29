<?php

namespace Politizr\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Politizr\Model\PDDebateArchive;
use Politizr\Model\PDDebateArchivePeer;
use Politizr\Model\map\PDDebateArchiveTableMap;

abstract class BasePDDebateArchivePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'p_d_debate_archive';

    /** the related Propel class for this table */
    const OM_CLASS = 'Politizr\\Model\\PDDebateArchive';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Politizr\\Model\\map\\PDDebateArchiveTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 32;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 32;

    /** the column name for the id field */
    const ID = 'p_d_debate_archive.id';

    /** the column name for the uuid field */
    const UUID = 'p_d_debate_archive.uuid';

    /** the column name for the p_user_id field */
    const P_USER_ID = 'p_d_debate_archive.p_user_id';

    /** the column name for the p_e_operation_id field */
    const P_E_OPERATION_ID = 'p_d_debate_archive.p_e_operation_id';

    /** the column name for the p_l_city_id field */
    const P_L_CITY_ID = 'p_d_debate_archive.p_l_city_id';

    /** the column name for the p_l_department_id field */
    const P_L_DEPARTMENT_ID = 'p_d_debate_archive.p_l_department_id';

    /** the column name for the p_l_region_id field */
    const P_L_REGION_ID = 'p_d_debate_archive.p_l_region_id';

    /** the column name for the p_l_country_id field */
    const P_L_COUNTRY_ID = 'p_d_debate_archive.p_l_country_id';

    /** the column name for the p_c_topic_id field */
    const P_C_TOPIC_ID = 'p_d_debate_archive.p_c_topic_id';

    /** the column name for the fb_ad_id field */
    const FB_AD_ID = 'p_d_debate_archive.fb_ad_id';

    /** the column name for the title field */
    const TITLE = 'p_d_debate_archive.title';

    /** the column name for the file_name field */
    const FILE_NAME = 'p_d_debate_archive.file_name';

    /** the column name for the copyright field */
    const COPYRIGHT = 'p_d_debate_archive.copyright';

    /** the column name for the description field */
    const DESCRIPTION = 'p_d_debate_archive.description';

    /** the column name for the note_pos field */
    const NOTE_POS = 'p_d_debate_archive.note_pos';

    /** the column name for the note_neg field */
    const NOTE_NEG = 'p_d_debate_archive.note_neg';

    /** the column name for the nb_views field */
    const NB_VIEWS = 'p_d_debate_archive.nb_views';

    /** the column name for the want_boost field */
    const WANT_BOOST = 'p_d_debate_archive.want_boost';

    /** the column name for the published field */
    const PUBLISHED = 'p_d_debate_archive.published';

    /** the column name for the published_at field */
    const PUBLISHED_AT = 'p_d_debate_archive.published_at';

    /** the column name for the published_by field */
    const PUBLISHED_BY = 'p_d_debate_archive.published_by';

    /** the column name for the favorite field */
    const FAVORITE = 'p_d_debate_archive.favorite';

    /** the column name for the online field */
    const ONLINE = 'p_d_debate_archive.online';

    /** the column name for the homepage field */
    const HOMEPAGE = 'p_d_debate_archive.homepage';

    /** the column name for the moderated field */
    const MODERATED = 'p_d_debate_archive.moderated';

    /** the column name for the moderated_partial field */
    const MODERATED_PARTIAL = 'p_d_debate_archive.moderated_partial';

    /** the column name for the moderated_at field */
    const MODERATED_AT = 'p_d_debate_archive.moderated_at';

    /** the column name for the indexed_at field */
    const INDEXED_AT = 'p_d_debate_archive.indexed_at';

    /** the column name for the created_at field */
    const CREATED_AT = 'p_d_debate_archive.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'p_d_debate_archive.updated_at';

    /** the column name for the slug field */
    const SLUG = 'p_d_debate_archive.slug';

    /** the column name for the archived_at field */
    const ARCHIVED_AT = 'p_d_debate_archive.archived_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of PDDebateArchive objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array PDDebateArchive[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. PDDebateArchivePeer::$fieldNames[PDDebateArchivePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Uuid', 'PUserId', 'PEOperationId', 'PLCityId', 'PLDepartmentId', 'PLRegionId', 'PLCountryId', 'PCTopicId', 'FbAdId', 'Title', 'FileName', 'Copyright', 'Description', 'NotePos', 'NoteNeg', 'NbViews', 'WantBoost', 'Published', 'PublishedAt', 'PublishedBy', 'Favorite', 'Online', 'Homepage', 'Moderated', 'ModeratedPartial', 'ModeratedAt', 'IndexedAt', 'CreatedAt', 'UpdatedAt', 'Slug', 'ArchivedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'uuid', 'pUserId', 'pEOperationId', 'pLCityId', 'pLDepartmentId', 'pLRegionId', 'pLCountryId', 'pCTopicId', 'fbAdId', 'title', 'fileName', 'copyright', 'description', 'notePos', 'noteNeg', 'nbViews', 'wantBoost', 'published', 'publishedAt', 'publishedBy', 'favorite', 'online', 'homepage', 'moderated', 'moderatedPartial', 'moderatedAt', 'indexedAt', 'createdAt', 'updatedAt', 'slug', 'archivedAt', ),
        BasePeer::TYPE_COLNAME => array (PDDebateArchivePeer::ID, PDDebateArchivePeer::UUID, PDDebateArchivePeer::P_USER_ID, PDDebateArchivePeer::P_E_OPERATION_ID, PDDebateArchivePeer::P_L_CITY_ID, PDDebateArchivePeer::P_L_DEPARTMENT_ID, PDDebateArchivePeer::P_L_REGION_ID, PDDebateArchivePeer::P_L_COUNTRY_ID, PDDebateArchivePeer::P_C_TOPIC_ID, PDDebateArchivePeer::FB_AD_ID, PDDebateArchivePeer::TITLE, PDDebateArchivePeer::FILE_NAME, PDDebateArchivePeer::COPYRIGHT, PDDebateArchivePeer::DESCRIPTION, PDDebateArchivePeer::NOTE_POS, PDDebateArchivePeer::NOTE_NEG, PDDebateArchivePeer::NB_VIEWS, PDDebateArchivePeer::WANT_BOOST, PDDebateArchivePeer::PUBLISHED, PDDebateArchivePeer::PUBLISHED_AT, PDDebateArchivePeer::PUBLISHED_BY, PDDebateArchivePeer::FAVORITE, PDDebateArchivePeer::ONLINE, PDDebateArchivePeer::HOMEPAGE, PDDebateArchivePeer::MODERATED, PDDebateArchivePeer::MODERATED_PARTIAL, PDDebateArchivePeer::MODERATED_AT, PDDebateArchivePeer::INDEXED_AT, PDDebateArchivePeer::CREATED_AT, PDDebateArchivePeer::UPDATED_AT, PDDebateArchivePeer::SLUG, PDDebateArchivePeer::ARCHIVED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'UUID', 'P_USER_ID', 'P_E_OPERATION_ID', 'P_L_CITY_ID', 'P_L_DEPARTMENT_ID', 'P_L_REGION_ID', 'P_L_COUNTRY_ID', 'P_C_TOPIC_ID', 'FB_AD_ID', 'TITLE', 'FILE_NAME', 'COPYRIGHT', 'DESCRIPTION', 'NOTE_POS', 'NOTE_NEG', 'NB_VIEWS', 'WANT_BOOST', 'PUBLISHED', 'PUBLISHED_AT', 'PUBLISHED_BY', 'FAVORITE', 'ONLINE', 'HOMEPAGE', 'MODERATED', 'MODERATED_PARTIAL', 'MODERATED_AT', 'INDEXED_AT', 'CREATED_AT', 'UPDATED_AT', 'SLUG', 'ARCHIVED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'uuid', 'p_user_id', 'p_e_operation_id', 'p_l_city_id', 'p_l_department_id', 'p_l_region_id', 'p_l_country_id', 'p_c_topic_id', 'fb_ad_id', 'title', 'file_name', 'copyright', 'description', 'note_pos', 'note_neg', 'nb_views', 'want_boost', 'published', 'published_at', 'published_by', 'favorite', 'online', 'homepage', 'moderated', 'moderated_partial', 'moderated_at', 'indexed_at', 'created_at', 'updated_at', 'slug', 'archived_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. PDDebateArchivePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Uuid' => 1, 'PUserId' => 2, 'PEOperationId' => 3, 'PLCityId' => 4, 'PLDepartmentId' => 5, 'PLRegionId' => 6, 'PLCountryId' => 7, 'PCTopicId' => 8, 'FbAdId' => 9, 'Title' => 10, 'FileName' => 11, 'Copyright' => 12, 'Description' => 13, 'NotePos' => 14, 'NoteNeg' => 15, 'NbViews' => 16, 'WantBoost' => 17, 'Published' => 18, 'PublishedAt' => 19, 'PublishedBy' => 20, 'Favorite' => 21, 'Online' => 22, 'Homepage' => 23, 'Moderated' => 24, 'ModeratedPartial' => 25, 'ModeratedAt' => 26, 'IndexedAt' => 27, 'CreatedAt' => 28, 'UpdatedAt' => 29, 'Slug' => 30, 'ArchivedAt' => 31, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'uuid' => 1, 'pUserId' => 2, 'pEOperationId' => 3, 'pLCityId' => 4, 'pLDepartmentId' => 5, 'pLRegionId' => 6, 'pLCountryId' => 7, 'pCTopicId' => 8, 'fbAdId' => 9, 'title' => 10, 'fileName' => 11, 'copyright' => 12, 'description' => 13, 'notePos' => 14, 'noteNeg' => 15, 'nbViews' => 16, 'wantBoost' => 17, 'published' => 18, 'publishedAt' => 19, 'publishedBy' => 20, 'favorite' => 21, 'online' => 22, 'homepage' => 23, 'moderated' => 24, 'moderatedPartial' => 25, 'moderatedAt' => 26, 'indexedAt' => 27, 'createdAt' => 28, 'updatedAt' => 29, 'slug' => 30, 'archivedAt' => 31, ),
        BasePeer::TYPE_COLNAME => array (PDDebateArchivePeer::ID => 0, PDDebateArchivePeer::UUID => 1, PDDebateArchivePeer::P_USER_ID => 2, PDDebateArchivePeer::P_E_OPERATION_ID => 3, PDDebateArchivePeer::P_L_CITY_ID => 4, PDDebateArchivePeer::P_L_DEPARTMENT_ID => 5, PDDebateArchivePeer::P_L_REGION_ID => 6, PDDebateArchivePeer::P_L_COUNTRY_ID => 7, PDDebateArchivePeer::P_C_TOPIC_ID => 8, PDDebateArchivePeer::FB_AD_ID => 9, PDDebateArchivePeer::TITLE => 10, PDDebateArchivePeer::FILE_NAME => 11, PDDebateArchivePeer::COPYRIGHT => 12, PDDebateArchivePeer::DESCRIPTION => 13, PDDebateArchivePeer::NOTE_POS => 14, PDDebateArchivePeer::NOTE_NEG => 15, PDDebateArchivePeer::NB_VIEWS => 16, PDDebateArchivePeer::WANT_BOOST => 17, PDDebateArchivePeer::PUBLISHED => 18, PDDebateArchivePeer::PUBLISHED_AT => 19, PDDebateArchivePeer::PUBLISHED_BY => 20, PDDebateArchivePeer::FAVORITE => 21, PDDebateArchivePeer::ONLINE => 22, PDDebateArchivePeer::HOMEPAGE => 23, PDDebateArchivePeer::MODERATED => 24, PDDebateArchivePeer::MODERATED_PARTIAL => 25, PDDebateArchivePeer::MODERATED_AT => 26, PDDebateArchivePeer::INDEXED_AT => 27, PDDebateArchivePeer::CREATED_AT => 28, PDDebateArchivePeer::UPDATED_AT => 29, PDDebateArchivePeer::SLUG => 30, PDDebateArchivePeer::ARCHIVED_AT => 31, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'UUID' => 1, 'P_USER_ID' => 2, 'P_E_OPERATION_ID' => 3, 'P_L_CITY_ID' => 4, 'P_L_DEPARTMENT_ID' => 5, 'P_L_REGION_ID' => 6, 'P_L_COUNTRY_ID' => 7, 'P_C_TOPIC_ID' => 8, 'FB_AD_ID' => 9, 'TITLE' => 10, 'FILE_NAME' => 11, 'COPYRIGHT' => 12, 'DESCRIPTION' => 13, 'NOTE_POS' => 14, 'NOTE_NEG' => 15, 'NB_VIEWS' => 16, 'WANT_BOOST' => 17, 'PUBLISHED' => 18, 'PUBLISHED_AT' => 19, 'PUBLISHED_BY' => 20, 'FAVORITE' => 21, 'ONLINE' => 22, 'HOMEPAGE' => 23, 'MODERATED' => 24, 'MODERATED_PARTIAL' => 25, 'MODERATED_AT' => 26, 'INDEXED_AT' => 27, 'CREATED_AT' => 28, 'UPDATED_AT' => 29, 'SLUG' => 30, 'ARCHIVED_AT' => 31, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'uuid' => 1, 'p_user_id' => 2, 'p_e_operation_id' => 3, 'p_l_city_id' => 4, 'p_l_department_id' => 5, 'p_l_region_id' => 6, 'p_l_country_id' => 7, 'p_c_topic_id' => 8, 'fb_ad_id' => 9, 'title' => 10, 'file_name' => 11, 'copyright' => 12, 'description' => 13, 'note_pos' => 14, 'note_neg' => 15, 'nb_views' => 16, 'want_boost' => 17, 'published' => 18, 'published_at' => 19, 'published_by' => 20, 'favorite' => 21, 'online' => 22, 'homepage' => 23, 'moderated' => 24, 'moderated_partial' => 25, 'moderated_at' => 26, 'indexed_at' => 27, 'created_at' => 28, 'updated_at' => 29, 'slug' => 30, 'archived_at' => 31, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, )
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
        $toNames = PDDebateArchivePeer::getFieldNames($toType);
        $key = isset(PDDebateArchivePeer::$fieldKeys[$fromType][$name]) ? PDDebateArchivePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(PDDebateArchivePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, PDDebateArchivePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return PDDebateArchivePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. PDDebateArchivePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(PDDebateArchivePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(PDDebateArchivePeer::ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::UUID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_USER_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_E_OPERATION_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_L_CITY_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_L_DEPARTMENT_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_L_REGION_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_L_COUNTRY_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::P_C_TOPIC_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::FB_AD_ID);
            $criteria->addSelectColumn(PDDebateArchivePeer::TITLE);
            $criteria->addSelectColumn(PDDebateArchivePeer::FILE_NAME);
            $criteria->addSelectColumn(PDDebateArchivePeer::COPYRIGHT);
            $criteria->addSelectColumn(PDDebateArchivePeer::DESCRIPTION);
            $criteria->addSelectColumn(PDDebateArchivePeer::NOTE_POS);
            $criteria->addSelectColumn(PDDebateArchivePeer::NOTE_NEG);
            $criteria->addSelectColumn(PDDebateArchivePeer::NB_VIEWS);
            $criteria->addSelectColumn(PDDebateArchivePeer::WANT_BOOST);
            $criteria->addSelectColumn(PDDebateArchivePeer::PUBLISHED);
            $criteria->addSelectColumn(PDDebateArchivePeer::PUBLISHED_AT);
            $criteria->addSelectColumn(PDDebateArchivePeer::PUBLISHED_BY);
            $criteria->addSelectColumn(PDDebateArchivePeer::FAVORITE);
            $criteria->addSelectColumn(PDDebateArchivePeer::ONLINE);
            $criteria->addSelectColumn(PDDebateArchivePeer::HOMEPAGE);
            $criteria->addSelectColumn(PDDebateArchivePeer::MODERATED);
            $criteria->addSelectColumn(PDDebateArchivePeer::MODERATED_PARTIAL);
            $criteria->addSelectColumn(PDDebateArchivePeer::MODERATED_AT);
            $criteria->addSelectColumn(PDDebateArchivePeer::INDEXED_AT);
            $criteria->addSelectColumn(PDDebateArchivePeer::CREATED_AT);
            $criteria->addSelectColumn(PDDebateArchivePeer::UPDATED_AT);
            $criteria->addSelectColumn(PDDebateArchivePeer::SLUG);
            $criteria->addSelectColumn(PDDebateArchivePeer::ARCHIVED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.uuid');
            $criteria->addSelectColumn($alias . '.p_user_id');
            $criteria->addSelectColumn($alias . '.p_e_operation_id');
            $criteria->addSelectColumn($alias . '.p_l_city_id');
            $criteria->addSelectColumn($alias . '.p_l_department_id');
            $criteria->addSelectColumn($alias . '.p_l_region_id');
            $criteria->addSelectColumn($alias . '.p_l_country_id');
            $criteria->addSelectColumn($alias . '.p_c_topic_id');
            $criteria->addSelectColumn($alias . '.fb_ad_id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.file_name');
            $criteria->addSelectColumn($alias . '.copyright');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.note_pos');
            $criteria->addSelectColumn($alias . '.note_neg');
            $criteria->addSelectColumn($alias . '.nb_views');
            $criteria->addSelectColumn($alias . '.want_boost');
            $criteria->addSelectColumn($alias . '.published');
            $criteria->addSelectColumn($alias . '.published_at');
            $criteria->addSelectColumn($alias . '.published_by');
            $criteria->addSelectColumn($alias . '.favorite');
            $criteria->addSelectColumn($alias . '.online');
            $criteria->addSelectColumn($alias . '.homepage');
            $criteria->addSelectColumn($alias . '.moderated');
            $criteria->addSelectColumn($alias . '.moderated_partial');
            $criteria->addSelectColumn($alias . '.moderated_at');
            $criteria->addSelectColumn($alias . '.indexed_at');
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
        $criteria->setPrimaryTableName(PDDebateArchivePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PDDebateArchivePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(PDDebateArchivePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return PDDebateArchive
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = PDDebateArchivePeer::doSelect($critcopy, $con);
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
        return PDDebateArchivePeer::populateObjects(PDDebateArchivePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            PDDebateArchivePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(PDDebateArchivePeer::DATABASE_NAME);

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
     * @param PDDebateArchive $obj A PDDebateArchive object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            PDDebateArchivePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A PDDebateArchive object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof PDDebateArchive) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PDDebateArchive object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(PDDebateArchivePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return PDDebateArchive Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(PDDebateArchivePeer::$instances[$key])) {
                return PDDebateArchivePeer::$instances[$key];
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
        foreach (PDDebateArchivePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        PDDebateArchivePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to p_d_debate_archive
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
        $cls = PDDebateArchivePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = PDDebateArchivePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = PDDebateArchivePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PDDebateArchivePeer::addInstanceToPool($obj, $key);
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
     * @return array (PDDebateArchive object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = PDDebateArchivePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = PDDebateArchivePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + PDDebateArchivePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PDDebateArchivePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            PDDebateArchivePeer::addInstanceToPool($obj, $key);
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
        return Propel::getDatabaseMap(PDDebateArchivePeer::DATABASE_NAME)->getTable(PDDebateArchivePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BasePDDebateArchivePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BasePDDebateArchivePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Politizr\Model\map\PDDebateArchiveTableMap());
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
        return PDDebateArchivePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a PDDebateArchive or Criteria object.
     *
     * @param      mixed $values Criteria or PDDebateArchive object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from PDDebateArchive object
        }


        // Set the correct dbName
        $criteria->setDbName(PDDebateArchivePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a PDDebateArchive or Criteria object.
     *
     * @param      mixed $values Criteria or PDDebateArchive object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(PDDebateArchivePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(PDDebateArchivePeer::ID);
            $value = $criteria->remove(PDDebateArchivePeer::ID);
            if ($value) {
                $selectCriteria->add(PDDebateArchivePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(PDDebateArchivePeer::TABLE_NAME);
            }

        } else { // $values is PDDebateArchive object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(PDDebateArchivePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the p_d_debate_archive table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(PDDebateArchivePeer::TABLE_NAME, $con, PDDebateArchivePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PDDebateArchivePeer::clearInstancePool();
            PDDebateArchivePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a PDDebateArchive or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or PDDebateArchive object or primary key or array of primary keys
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
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            PDDebateArchivePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof PDDebateArchive) { // it's a model object
            // invalidate the cache for this single object
            PDDebateArchivePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PDDebateArchivePeer::DATABASE_NAME);
            $criteria->add(PDDebateArchivePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                PDDebateArchivePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(PDDebateArchivePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            PDDebateArchivePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given PDDebateArchive object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param PDDebateArchive $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(PDDebateArchivePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(PDDebateArchivePeer::TABLE_NAME);

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

        return BasePeer::doValidate(PDDebateArchivePeer::DATABASE_NAME, PDDebateArchivePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return PDDebateArchive
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = PDDebateArchivePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(PDDebateArchivePeer::DATABASE_NAME);
        $criteria->add(PDDebateArchivePeer::ID, $pk);

        $v = PDDebateArchivePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return PDDebateArchive[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PDDebateArchivePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(PDDebateArchivePeer::DATABASE_NAME);
            $criteria->add(PDDebateArchivePeer::ID, $pks, Criteria::IN);
            $objs = PDDebateArchivePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BasePDDebateArchivePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePDDebateArchivePeer::buildTableMap();

