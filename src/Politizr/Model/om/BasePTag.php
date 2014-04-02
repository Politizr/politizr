<?php

namespace Politizr\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Politizr\Model\PDDTaggedT;
use Politizr\Model\PDDTaggedTQuery;
use Politizr\Model\PDDebate;
use Politizr\Model\PDDebateQuery;
use Politizr\Model\PTTagType;
use Politizr\Model\PTTagTypeQuery;
use Politizr\Model\PTag;
use Politizr\Model\PTagPeer;
use Politizr\Model\PTagQuery;
use Politizr\Model\PUQTaggedT;
use Politizr\Model\PUQTaggedTQuery;
use Politizr\Model\PUQualification;
use Politizr\Model\PUQualificationQuery;

abstract class BasePTag extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Politizr\\Model\\PTagPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        PTagPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the p_t_tag_type_id field.
     * @var        int
     */
    protected $p_t_tag_type_id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the online field.
     * @var        boolean
     */
    protected $online;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * The value for the slug field.
     * @var        string
     */
    protected $slug;

    /**
     * @var        PTTagType
     */
    protected $aPTTagType;

    /**
     * @var        PropelObjectCollection|PUQTaggedT[] Collection to store aggregation of PUQTaggedT objects.
     */
    protected $collPuqTaggedTPTags;
    protected $collPuqTaggedTPTagsPartial;

    /**
     * @var        PropelObjectCollection|PDDTaggedT[] Collection to store aggregation of PDDTaggedT objects.
     */
    protected $collPddTaggedTPTags;
    protected $collPddTaggedTPTagsPartial;

    /**
     * @var        PropelObjectCollection|PUQualification[] Collection to store aggregation of PUQualification objects.
     */
    protected $collPuqTaggedTPUQualifications;

    /**
     * @var        PropelObjectCollection|PDDebate[] Collection to store aggregation of PDDebate objects.
     */
    protected $collPddTaggedTPDDebates;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $puqTaggedTPUQualificationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pddTaggedTPDDebatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $puqTaggedTPTagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pddTaggedTPTagsScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [p_t_tag_type_id] column value.
     *
     * @return int
     */
    public function getPTTagTypeId()
    {
        return $this->p_t_tag_type_id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [online] column value.
     *
     * @return boolean
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = null)
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [slug] column value.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return PTag The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = PTagPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [p_t_tag_type_id] column.
     *
     * @param int $v new value
     * @return PTag The current object (for fluent API support)
     */
    public function setPTTagTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->p_t_tag_type_id !== $v) {
            $this->p_t_tag_type_id = $v;
            $this->modifiedColumns[] = PTagPeer::P_T_TAG_TYPE_ID;
        }

        if ($this->aPTTagType !== null && $this->aPTTagType->getId() !== $v) {
            $this->aPTTagType = null;
        }


        return $this;
    } // setPTTagTypeId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return PTag The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = PTagPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Sets the value of the [online] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return PTag The current object (for fluent API support)
     */
    public function setOnline($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->online !== $v) {
            $this->online = $v;
            $this->modifiedColumns[] = PTagPeer::ONLINE;
        }


        return $this;
    } // setOnline()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return PTag The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = PTagPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return PTag The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = PTagPeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [slug] column.
     *
     * @param string $v new value
     * @return PTag The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[] = PTagPeer::SLUG;
        }


        return $this;
    } // setSlug()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->p_t_tag_type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->title = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->online = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
            $this->created_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->updated_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->slug = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = PTagPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating PTag object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aPTTagType !== null && $this->p_t_tag_type_id !== $this->aPTTagType->getId()) {
            $this->aPTTagType = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(PTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = PTagPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPTTagType = null;
            $this->collPuqTaggedTPTags = null;

            $this->collPddTaggedTPTags = null;

            $this->collPuqTaggedTPUQualifications = null;
            $this->collPddTaggedTPDDebates = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(PTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = PTagQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(PTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            // sluggable behavior

            if ($this->isColumnModified(PTagPeer::SLUG) && $this->getSlug()) {
                $this->setSlug($this->makeSlugUnique($this->getSlug()));
            } elseif ($this->isColumnModified(PTagPeer::TITLE)) {
                $this->setSlug($this->createSlug());
            } elseif (!$this->getSlug()) {
                $this->setSlug($this->createSlug());
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(PTagPeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(PTagPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(PTagPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PTagPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPTTagType !== null) {
                if ($this->aPTTagType->isModified() || $this->aPTTagType->isNew()) {
                    $affectedRows += $this->aPTTagType->save($con);
                }
                $this->setPTTagType($this->aPTTagType);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->puqTaggedTPUQualificationsScheduledForDeletion !== null) {
                if (!$this->puqTaggedTPUQualificationsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->puqTaggedTPUQualificationsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    PuqTaggedTPTagQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->puqTaggedTPUQualificationsScheduledForDeletion = null;
                }

                foreach ($this->getPuqTaggedTPUQualifications() as $puqTaggedTPUQualification) {
                    if ($puqTaggedTPUQualification->isModified()) {
                        $puqTaggedTPUQualification->save($con);
                    }
                }
            } elseif ($this->collPuqTaggedTPUQualifications) {
                foreach ($this->collPuqTaggedTPUQualifications as $puqTaggedTPUQualification) {
                    if ($puqTaggedTPUQualification->isModified()) {
                        $puqTaggedTPUQualification->save($con);
                    }
                }
            }

            if ($this->pddTaggedTPDDebatesScheduledForDeletion !== null) {
                if (!$this->pddTaggedTPDDebatesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->pddTaggedTPDDebatesScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    PddTaggedTPTagQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->pddTaggedTPDDebatesScheduledForDeletion = null;
                }

                foreach ($this->getPddTaggedTPDDebates() as $pddTaggedTPDDebate) {
                    if ($pddTaggedTPDDebate->isModified()) {
                        $pddTaggedTPDDebate->save($con);
                    }
                }
            } elseif ($this->collPddTaggedTPDDebates) {
                foreach ($this->collPddTaggedTPDDebates as $pddTaggedTPDDebate) {
                    if ($pddTaggedTPDDebate->isModified()) {
                        $pddTaggedTPDDebate->save($con);
                    }
                }
            }

            if ($this->puqTaggedTPTagsScheduledForDeletion !== null) {
                if (!$this->puqTaggedTPTagsScheduledForDeletion->isEmpty()) {
                    PUQTaggedTQuery::create()
                        ->filterByPrimaryKeys($this->puqTaggedTPTagsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->puqTaggedTPTagsScheduledForDeletion = null;
                }
            }

            if ($this->collPuqTaggedTPTags !== null) {
                foreach ($this->collPuqTaggedTPTags as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pddTaggedTPTagsScheduledForDeletion !== null) {
                if (!$this->pddTaggedTPTagsScheduledForDeletion->isEmpty()) {
                    PDDTaggedTQuery::create()
                        ->filterByPrimaryKeys($this->pddTaggedTPTagsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pddTaggedTPTagsScheduledForDeletion = null;
                }
            }

            if ($this->collPddTaggedTPTags !== null) {
                foreach ($this->collPddTaggedTPTags as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = PTagPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PTagPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PTagPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(PTagPeer::P_T_TAG_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`p_t_tag_type_id`';
        }
        if ($this->isColumnModified(PTagPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(PTagPeer::ONLINE)) {
            $modifiedColumns[':p' . $index++]  = '`online`';
        }
        if ($this->isColumnModified(PTagPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(PTagPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }
        if ($this->isColumnModified(PTagPeer::SLUG)) {
            $modifiedColumns[':p' . $index++]  = '`slug`';
        }

        $sql = sprintf(
            'INSERT INTO `p_tag` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`p_t_tag_type_id`':
                        $stmt->bindValue($identifier, $this->p_t_tag_type_id, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`online`':
                        $stmt->bindValue($identifier, (int) $this->online, PDO::PARAM_INT);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                    case '`slug`':
                        $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPTTagType !== null) {
                if (!$this->aPTTagType->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aPTTagType->getValidationFailures());
                }
            }


            if (($retval = PTagPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collPuqTaggedTPTags !== null) {
                    foreach ($this->collPuqTaggedTPTags as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPddTaggedTPTags !== null) {
                    foreach ($this->collPddTaggedTPTags as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = PTagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getPTTagTypeId();
                break;
            case 2:
                return $this->getTitle();
                break;
            case 3:
                return $this->getOnline();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
                return $this->getUpdatedAt();
                break;
            case 6:
                return $this->getSlug();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['PTag'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PTag'][$this->getPrimaryKey()] = true;
        $keys = PTagPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPTTagTypeId(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getOnline(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getUpdatedAt(),
            $keys[6] => $this->getSlug(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aPTTagType) {
                $result['PTTagType'] = $this->aPTTagType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPuqTaggedTPTags) {
                $result['PuqTaggedTPTags'] = $this->collPuqTaggedTPTags->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPddTaggedTPTags) {
                $result['PddTaggedTPTags'] = $this->collPddTaggedTPTags->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = PTagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPTTagTypeId($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $this->setOnline($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
                $this->setUpdatedAt($value);
                break;
            case 6:
                $this->setSlug($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = PTagPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPTTagTypeId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setOnline($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSlug($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PTagPeer::DATABASE_NAME);

        if ($this->isColumnModified(PTagPeer::ID)) $criteria->add(PTagPeer::ID, $this->id);
        if ($this->isColumnModified(PTagPeer::P_T_TAG_TYPE_ID)) $criteria->add(PTagPeer::P_T_TAG_TYPE_ID, $this->p_t_tag_type_id);
        if ($this->isColumnModified(PTagPeer::TITLE)) $criteria->add(PTagPeer::TITLE, $this->title);
        if ($this->isColumnModified(PTagPeer::ONLINE)) $criteria->add(PTagPeer::ONLINE, $this->online);
        if ($this->isColumnModified(PTagPeer::CREATED_AT)) $criteria->add(PTagPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(PTagPeer::UPDATED_AT)) $criteria->add(PTagPeer::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(PTagPeer::SLUG)) $criteria->add(PTagPeer::SLUG, $this->slug);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(PTagPeer::DATABASE_NAME);
        $criteria->add(PTagPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of PTag (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPTTagTypeId($this->getPTTagTypeId());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setOnline($this->getOnline());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setSlug($this->getSlug());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getPuqTaggedTPTags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPuqTaggedTPTag($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPddTaggedTPTags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPddTaggedTPTag($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return PTag Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return PTagPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new PTagPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a PTTagType object.
     *
     * @param             PTTagType $v
     * @return PTag The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPTTagType(PTTagType $v = null)
    {
        if ($v === null) {
            $this->setPTTagTypeId(NULL);
        } else {
            $this->setPTTagTypeId($v->getId());
        }

        $this->aPTTagType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the PTTagType object, it will not be re-added.
        if ($v !== null) {
            $v->addPTag($this);
        }


        return $this;
    }


    /**
     * Get the associated PTTagType object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return PTTagType The associated PTTagType object.
     * @throws PropelException
     */
    public function getPTTagType(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPTTagType === null && ($this->p_t_tag_type_id !== null) && $doQuery) {
            $this->aPTTagType = PTTagTypeQuery::create()->findPk($this->p_t_tag_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPTTagType->addPTags($this);
             */
        }

        return $this->aPTTagType;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PuqTaggedTPTag' == $relationName) {
            $this->initPuqTaggedTPTags();
        }
        if ('PddTaggedTPTag' == $relationName) {
            $this->initPddTaggedTPTags();
        }
    }

    /**
     * Clears out the collPuqTaggedTPTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return PTag The current object (for fluent API support)
     * @see        addPuqTaggedTPTags()
     */
    public function clearPuqTaggedTPTags()
    {
        $this->collPuqTaggedTPTags = null; // important to set this to null since that means it is uninitialized
        $this->collPuqTaggedTPTagsPartial = null;

        return $this;
    }

    /**
     * reset is the collPuqTaggedTPTags collection loaded partially
     *
     * @return void
     */
    public function resetPartialPuqTaggedTPTags($v = true)
    {
        $this->collPuqTaggedTPTagsPartial = $v;
    }

    /**
     * Initializes the collPuqTaggedTPTags collection.
     *
     * By default this just sets the collPuqTaggedTPTags collection to an empty array (like clearcollPuqTaggedTPTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPuqTaggedTPTags($overrideExisting = true)
    {
        if (null !== $this->collPuqTaggedTPTags && !$overrideExisting) {
            return;
        }
        $this->collPuqTaggedTPTags = new PropelObjectCollection();
        $this->collPuqTaggedTPTags->setModel('PUQTaggedT');
    }

    /**
     * Gets an array of PUQTaggedT objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this PTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PUQTaggedT[] List of PUQTaggedT objects
     * @throws PropelException
     */
    public function getPuqTaggedTPTags($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPuqTaggedTPTagsPartial && !$this->isNew();
        if (null === $this->collPuqTaggedTPTags || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPuqTaggedTPTags) {
                // return empty collection
                $this->initPuqTaggedTPTags();
            } else {
                $collPuqTaggedTPTags = PUQTaggedTQuery::create(null, $criteria)
                    ->filterByPuqTaggedTPTag($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPuqTaggedTPTagsPartial && count($collPuqTaggedTPTags)) {
                      $this->initPuqTaggedTPTags(false);

                      foreach($collPuqTaggedTPTags as $obj) {
                        if (false == $this->collPuqTaggedTPTags->contains($obj)) {
                          $this->collPuqTaggedTPTags->append($obj);
                        }
                      }

                      $this->collPuqTaggedTPTagsPartial = true;
                    }

                    $collPuqTaggedTPTags->getInternalIterator()->rewind();
                    return $collPuqTaggedTPTags;
                }

                if($partial && $this->collPuqTaggedTPTags) {
                    foreach($this->collPuqTaggedTPTags as $obj) {
                        if($obj->isNew()) {
                            $collPuqTaggedTPTags[] = $obj;
                        }
                    }
                }

                $this->collPuqTaggedTPTags = $collPuqTaggedTPTags;
                $this->collPuqTaggedTPTagsPartial = false;
            }
        }

        return $this->collPuqTaggedTPTags;
    }

    /**
     * Sets a collection of PuqTaggedTPTag objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $puqTaggedTPTags A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return PTag The current object (for fluent API support)
     */
    public function setPuqTaggedTPTags(PropelCollection $puqTaggedTPTags, PropelPDO $con = null)
    {
        $puqTaggedTPTagsToDelete = $this->getPuqTaggedTPTags(new Criteria(), $con)->diff($puqTaggedTPTags);

        $this->puqTaggedTPTagsScheduledForDeletion = unserialize(serialize($puqTaggedTPTagsToDelete));

        foreach ($puqTaggedTPTagsToDelete as $puqTaggedTPTagRemoved) {
            $puqTaggedTPTagRemoved->setPuqTaggedTPTag(null);
        }

        $this->collPuqTaggedTPTags = null;
        foreach ($puqTaggedTPTags as $puqTaggedTPTag) {
            $this->addPuqTaggedTPTag($puqTaggedTPTag);
        }

        $this->collPuqTaggedTPTags = $puqTaggedTPTags;
        $this->collPuqTaggedTPTagsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PUQTaggedT objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PUQTaggedT objects.
     * @throws PropelException
     */
    public function countPuqTaggedTPTags(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPuqTaggedTPTagsPartial && !$this->isNew();
        if (null === $this->collPuqTaggedTPTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPuqTaggedTPTags) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPuqTaggedTPTags());
            }
            $query = PUQTaggedTQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPuqTaggedTPTag($this)
                ->count($con);
        }

        return count($this->collPuqTaggedTPTags);
    }

    /**
     * Method called to associate a PUQTaggedT object to this object
     * through the PUQTaggedT foreign key attribute.
     *
     * @param    PUQTaggedT $l PUQTaggedT
     * @return PTag The current object (for fluent API support)
     */
    public function addPuqTaggedTPTag(PUQTaggedT $l)
    {
        if ($this->collPuqTaggedTPTags === null) {
            $this->initPuqTaggedTPTags();
            $this->collPuqTaggedTPTagsPartial = true;
        }
        if (!in_array($l, $this->collPuqTaggedTPTags->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPuqTaggedTPTag($l);
        }

        return $this;
    }

    /**
     * @param	PuqTaggedTPTag $puqTaggedTPTag The puqTaggedTPTag object to add.
     */
    protected function doAddPuqTaggedTPTag($puqTaggedTPTag)
    {
        $this->collPuqTaggedTPTags[]= $puqTaggedTPTag;
        $puqTaggedTPTag->setPuqTaggedTPTag($this);
    }

    /**
     * @param	PuqTaggedTPTag $puqTaggedTPTag The puqTaggedTPTag object to remove.
     * @return PTag The current object (for fluent API support)
     */
    public function removePuqTaggedTPTag($puqTaggedTPTag)
    {
        if ($this->getPuqTaggedTPTags()->contains($puqTaggedTPTag)) {
            $this->collPuqTaggedTPTags->remove($this->collPuqTaggedTPTags->search($puqTaggedTPTag));
            if (null === $this->puqTaggedTPTagsScheduledForDeletion) {
                $this->puqTaggedTPTagsScheduledForDeletion = clone $this->collPuqTaggedTPTags;
                $this->puqTaggedTPTagsScheduledForDeletion->clear();
            }
            $this->puqTaggedTPTagsScheduledForDeletion[]= clone $puqTaggedTPTag;
            $puqTaggedTPTag->setPuqTaggedTPTag(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PTag is new, it will return
     * an empty collection; or if this PTag has previously
     * been saved, it will retrieve related PuqTaggedTPTags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PTag.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PUQTaggedT[] List of PUQTaggedT objects
     */
    public function getPuqTaggedTPTagsJoinPuqTaggedTPUQualification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PUQTaggedTQuery::create(null, $criteria);
        $query->joinWith('PuqTaggedTPUQualification', $join_behavior);

        return $this->getPuqTaggedTPTags($query, $con);
    }

    /**
     * Clears out the collPddTaggedTPTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return PTag The current object (for fluent API support)
     * @see        addPddTaggedTPTags()
     */
    public function clearPddTaggedTPTags()
    {
        $this->collPddTaggedTPTags = null; // important to set this to null since that means it is uninitialized
        $this->collPddTaggedTPTagsPartial = null;

        return $this;
    }

    /**
     * reset is the collPddTaggedTPTags collection loaded partially
     *
     * @return void
     */
    public function resetPartialPddTaggedTPTags($v = true)
    {
        $this->collPddTaggedTPTagsPartial = $v;
    }

    /**
     * Initializes the collPddTaggedTPTags collection.
     *
     * By default this just sets the collPddTaggedTPTags collection to an empty array (like clearcollPddTaggedTPTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPddTaggedTPTags($overrideExisting = true)
    {
        if (null !== $this->collPddTaggedTPTags && !$overrideExisting) {
            return;
        }
        $this->collPddTaggedTPTags = new PropelObjectCollection();
        $this->collPddTaggedTPTags->setModel('PDDTaggedT');
    }

    /**
     * Gets an array of PDDTaggedT objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this PTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PDDTaggedT[] List of PDDTaggedT objects
     * @throws PropelException
     */
    public function getPddTaggedTPTags($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPddTaggedTPTagsPartial && !$this->isNew();
        if (null === $this->collPddTaggedTPTags || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPddTaggedTPTags) {
                // return empty collection
                $this->initPddTaggedTPTags();
            } else {
                $collPddTaggedTPTags = PDDTaggedTQuery::create(null, $criteria)
                    ->filterByPddTaggedTPTag($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPddTaggedTPTagsPartial && count($collPddTaggedTPTags)) {
                      $this->initPddTaggedTPTags(false);

                      foreach($collPddTaggedTPTags as $obj) {
                        if (false == $this->collPddTaggedTPTags->contains($obj)) {
                          $this->collPddTaggedTPTags->append($obj);
                        }
                      }

                      $this->collPddTaggedTPTagsPartial = true;
                    }

                    $collPddTaggedTPTags->getInternalIterator()->rewind();
                    return $collPddTaggedTPTags;
                }

                if($partial && $this->collPddTaggedTPTags) {
                    foreach($this->collPddTaggedTPTags as $obj) {
                        if($obj->isNew()) {
                            $collPddTaggedTPTags[] = $obj;
                        }
                    }
                }

                $this->collPddTaggedTPTags = $collPddTaggedTPTags;
                $this->collPddTaggedTPTagsPartial = false;
            }
        }

        return $this->collPddTaggedTPTags;
    }

    /**
     * Sets a collection of PddTaggedTPTag objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pddTaggedTPTags A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return PTag The current object (for fluent API support)
     */
    public function setPddTaggedTPTags(PropelCollection $pddTaggedTPTags, PropelPDO $con = null)
    {
        $pddTaggedTPTagsToDelete = $this->getPddTaggedTPTags(new Criteria(), $con)->diff($pddTaggedTPTags);

        $this->pddTaggedTPTagsScheduledForDeletion = unserialize(serialize($pddTaggedTPTagsToDelete));

        foreach ($pddTaggedTPTagsToDelete as $pddTaggedTPTagRemoved) {
            $pddTaggedTPTagRemoved->setPddTaggedTPTag(null);
        }

        $this->collPddTaggedTPTags = null;
        foreach ($pddTaggedTPTags as $pddTaggedTPTag) {
            $this->addPddTaggedTPTag($pddTaggedTPTag);
        }

        $this->collPddTaggedTPTags = $pddTaggedTPTags;
        $this->collPddTaggedTPTagsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PDDTaggedT objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PDDTaggedT objects.
     * @throws PropelException
     */
    public function countPddTaggedTPTags(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPddTaggedTPTagsPartial && !$this->isNew();
        if (null === $this->collPddTaggedTPTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPddTaggedTPTags) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPddTaggedTPTags());
            }
            $query = PDDTaggedTQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPddTaggedTPTag($this)
                ->count($con);
        }

        return count($this->collPddTaggedTPTags);
    }

    /**
     * Method called to associate a PDDTaggedT object to this object
     * through the PDDTaggedT foreign key attribute.
     *
     * @param    PDDTaggedT $l PDDTaggedT
     * @return PTag The current object (for fluent API support)
     */
    public function addPddTaggedTPTag(PDDTaggedT $l)
    {
        if ($this->collPddTaggedTPTags === null) {
            $this->initPddTaggedTPTags();
            $this->collPddTaggedTPTagsPartial = true;
        }
        if (!in_array($l, $this->collPddTaggedTPTags->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPddTaggedTPTag($l);
        }

        return $this;
    }

    /**
     * @param	PddTaggedTPTag $pddTaggedTPTag The pddTaggedTPTag object to add.
     */
    protected function doAddPddTaggedTPTag($pddTaggedTPTag)
    {
        $this->collPddTaggedTPTags[]= $pddTaggedTPTag;
        $pddTaggedTPTag->setPddTaggedTPTag($this);
    }

    /**
     * @param	PddTaggedTPTag $pddTaggedTPTag The pddTaggedTPTag object to remove.
     * @return PTag The current object (for fluent API support)
     */
    public function removePddTaggedTPTag($pddTaggedTPTag)
    {
        if ($this->getPddTaggedTPTags()->contains($pddTaggedTPTag)) {
            $this->collPddTaggedTPTags->remove($this->collPddTaggedTPTags->search($pddTaggedTPTag));
            if (null === $this->pddTaggedTPTagsScheduledForDeletion) {
                $this->pddTaggedTPTagsScheduledForDeletion = clone $this->collPddTaggedTPTags;
                $this->pddTaggedTPTagsScheduledForDeletion->clear();
            }
            $this->pddTaggedTPTagsScheduledForDeletion[]= clone $pddTaggedTPTag;
            $pddTaggedTPTag->setPddTaggedTPTag(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this PTag is new, it will return
     * an empty collection; or if this PTag has previously
     * been saved, it will retrieve related PddTaggedTPTags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in PTag.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PDDTaggedT[] List of PDDTaggedT objects
     */
    public function getPddTaggedTPTagsJoinPddTaggedTPDDebate($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PDDTaggedTQuery::create(null, $criteria);
        $query->joinWith('PddTaggedTPDDebate', $join_behavior);

        return $this->getPddTaggedTPTags($query, $con);
    }

    /**
     * Clears out the collPuqTaggedTPUQualifications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return PTag The current object (for fluent API support)
     * @see        addPuqTaggedTPUQualifications()
     */
    public function clearPuqTaggedTPUQualifications()
    {
        $this->collPuqTaggedTPUQualifications = null; // important to set this to null since that means it is uninitialized
        $this->collPuqTaggedTPUQualificationsPartial = null;

        return $this;
    }

    /**
     * Initializes the collPuqTaggedTPUQualifications collection.
     *
     * By default this just sets the collPuqTaggedTPUQualifications collection to an empty collection (like clearPuqTaggedTPUQualifications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPuqTaggedTPUQualifications()
    {
        $this->collPuqTaggedTPUQualifications = new PropelObjectCollection();
        $this->collPuqTaggedTPUQualifications->setModel('PUQualification');
    }

    /**
     * Gets a collection of PUQualification objects related by a many-to-many relationship
     * to the current object by way of the p_u_q_tagged_t cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this PTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|PUQualification[] List of PUQualification objects
     */
    public function getPuqTaggedTPUQualifications($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collPuqTaggedTPUQualifications || null !== $criteria) {
            if ($this->isNew() && null === $this->collPuqTaggedTPUQualifications) {
                // return empty collection
                $this->initPuqTaggedTPUQualifications();
            } else {
                $collPuqTaggedTPUQualifications = PUQualificationQuery::create(null, $criteria)
                    ->filterByPuqTaggedTPTag($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collPuqTaggedTPUQualifications;
                }
                $this->collPuqTaggedTPUQualifications = $collPuqTaggedTPUQualifications;
            }
        }

        return $this->collPuqTaggedTPUQualifications;
    }

    /**
     * Sets a collection of PUQualification objects related by a many-to-many relationship
     * to the current object by way of the p_u_q_tagged_t cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $puqTaggedTPUQualifications A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return PTag The current object (for fluent API support)
     */
    public function setPuqTaggedTPUQualifications(PropelCollection $puqTaggedTPUQualifications, PropelPDO $con = null)
    {
        $this->clearPuqTaggedTPUQualifications();
        $currentPuqTaggedTPUQualifications = $this->getPuqTaggedTPUQualifications();

        $this->puqTaggedTPUQualificationsScheduledForDeletion = $currentPuqTaggedTPUQualifications->diff($puqTaggedTPUQualifications);

        foreach ($puqTaggedTPUQualifications as $puqTaggedTPUQualification) {
            if (!$currentPuqTaggedTPUQualifications->contains($puqTaggedTPUQualification)) {
                $this->doAddPuqTaggedTPUQualification($puqTaggedTPUQualification);
            }
        }

        $this->collPuqTaggedTPUQualifications = $puqTaggedTPUQualifications;

        return $this;
    }

    /**
     * Gets the number of PUQualification objects related by a many-to-many relationship
     * to the current object by way of the p_u_q_tagged_t cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related PUQualification objects
     */
    public function countPuqTaggedTPUQualifications($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collPuqTaggedTPUQualifications || null !== $criteria) {
            if ($this->isNew() && null === $this->collPuqTaggedTPUQualifications) {
                return 0;
            } else {
                $query = PUQualificationQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPuqTaggedTPTag($this)
                    ->count($con);
            }
        } else {
            return count($this->collPuqTaggedTPUQualifications);
        }
    }

    /**
     * Associate a PUQualification object to this object
     * through the p_u_q_tagged_t cross reference table.
     *
     * @param  PUQualification $pUQualification The PUQTaggedT object to relate
     * @return PTag The current object (for fluent API support)
     */
    public function addPuqTaggedTPUQualification(PUQualification $pUQualification)
    {
        if ($this->collPuqTaggedTPUQualifications === null) {
            $this->initPuqTaggedTPUQualifications();
        }
        if (!$this->collPuqTaggedTPUQualifications->contains($pUQualification)) { // only add it if the **same** object is not already associated
            $this->doAddPuqTaggedTPUQualification($pUQualification);

            $this->collPuqTaggedTPUQualifications[]= $pUQualification;
        }

        return $this;
    }

    /**
     * @param	PuqTaggedTPUQualification $puqTaggedTPUQualification The puqTaggedTPUQualification object to add.
     */
    protected function doAddPuqTaggedTPUQualification($puqTaggedTPUQualification)
    {
        $pUQTaggedT = new PUQTaggedT();
        $pUQTaggedT->setPuqTaggedTPUQualification($puqTaggedTPUQualification);
        $this->addPuqTaggedTPTag($pUQTaggedT);
    }

    /**
     * Remove a PUQualification object to this object
     * through the p_u_q_tagged_t cross reference table.
     *
     * @param PUQualification $pUQualification The PUQTaggedT object to relate
     * @return PTag The current object (for fluent API support)
     */
    public function removePuqTaggedTPUQualification(PUQualification $pUQualification)
    {
        if ($this->getPuqTaggedTPUQualifications()->contains($pUQualification)) {
            $this->collPuqTaggedTPUQualifications->remove($this->collPuqTaggedTPUQualifications->search($pUQualification));
            if (null === $this->puqTaggedTPUQualificationsScheduledForDeletion) {
                $this->puqTaggedTPUQualificationsScheduledForDeletion = clone $this->collPuqTaggedTPUQualifications;
                $this->puqTaggedTPUQualificationsScheduledForDeletion->clear();
            }
            $this->puqTaggedTPUQualificationsScheduledForDeletion[]= $pUQualification;
        }

        return $this;
    }

    /**
     * Clears out the collPddTaggedTPDDebates collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return PTag The current object (for fluent API support)
     * @see        addPddTaggedTPDDebates()
     */
    public function clearPddTaggedTPDDebates()
    {
        $this->collPddTaggedTPDDebates = null; // important to set this to null since that means it is uninitialized
        $this->collPddTaggedTPDDebatesPartial = null;

        return $this;
    }

    /**
     * Initializes the collPddTaggedTPDDebates collection.
     *
     * By default this just sets the collPddTaggedTPDDebates collection to an empty collection (like clearPddTaggedTPDDebates());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initPddTaggedTPDDebates()
    {
        $this->collPddTaggedTPDDebates = new PropelObjectCollection();
        $this->collPddTaggedTPDDebates->setModel('PDDebate');
    }

    /**
     * Gets a collection of PDDebate objects related by a many-to-many relationship
     * to the current object by way of the p_d_d_tagged_t cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this PTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|PDDebate[] List of PDDebate objects
     */
    public function getPddTaggedTPDDebates($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collPddTaggedTPDDebates || null !== $criteria) {
            if ($this->isNew() && null === $this->collPddTaggedTPDDebates) {
                // return empty collection
                $this->initPddTaggedTPDDebates();
            } else {
                $collPddTaggedTPDDebates = PDDebateQuery::create(null, $criteria)
                    ->filterByPddTaggedTPTag($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collPddTaggedTPDDebates;
                }
                $this->collPddTaggedTPDDebates = $collPddTaggedTPDDebates;
            }
        }

        return $this->collPddTaggedTPDDebates;
    }

    /**
     * Sets a collection of PDDebate objects related by a many-to-many relationship
     * to the current object by way of the p_d_d_tagged_t cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pddTaggedTPDDebates A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return PTag The current object (for fluent API support)
     */
    public function setPddTaggedTPDDebates(PropelCollection $pddTaggedTPDDebates, PropelPDO $con = null)
    {
        $this->clearPddTaggedTPDDebates();
        $currentPddTaggedTPDDebates = $this->getPddTaggedTPDDebates();

        $this->pddTaggedTPDDebatesScheduledForDeletion = $currentPddTaggedTPDDebates->diff($pddTaggedTPDDebates);

        foreach ($pddTaggedTPDDebates as $pddTaggedTPDDebate) {
            if (!$currentPddTaggedTPDDebates->contains($pddTaggedTPDDebate)) {
                $this->doAddPddTaggedTPDDebate($pddTaggedTPDDebate);
            }
        }

        $this->collPddTaggedTPDDebates = $pddTaggedTPDDebates;

        return $this;
    }

    /**
     * Gets the number of PDDebate objects related by a many-to-many relationship
     * to the current object by way of the p_d_d_tagged_t cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related PDDebate objects
     */
    public function countPddTaggedTPDDebates($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collPddTaggedTPDDebates || null !== $criteria) {
            if ($this->isNew() && null === $this->collPddTaggedTPDDebates) {
                return 0;
            } else {
                $query = PDDebateQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByPddTaggedTPTag($this)
                    ->count($con);
            }
        } else {
            return count($this->collPddTaggedTPDDebates);
        }
    }

    /**
     * Associate a PDDebate object to this object
     * through the p_d_d_tagged_t cross reference table.
     *
     * @param  PDDebate $pDDebate The PDDTaggedT object to relate
     * @return PTag The current object (for fluent API support)
     */
    public function addPddTaggedTPDDebate(PDDebate $pDDebate)
    {
        if ($this->collPddTaggedTPDDebates === null) {
            $this->initPddTaggedTPDDebates();
        }
        if (!$this->collPddTaggedTPDDebates->contains($pDDebate)) { // only add it if the **same** object is not already associated
            $this->doAddPddTaggedTPDDebate($pDDebate);

            $this->collPddTaggedTPDDebates[]= $pDDebate;
        }

        return $this;
    }

    /**
     * @param	PddTaggedTPDDebate $pddTaggedTPDDebate The pddTaggedTPDDebate object to add.
     */
    protected function doAddPddTaggedTPDDebate($pddTaggedTPDDebate)
    {
        $pDDTaggedT = new PDDTaggedT();
        $pDDTaggedT->setPddTaggedTPDDebate($pddTaggedTPDDebate);
        $this->addPddTaggedTPTag($pDDTaggedT);
    }

    /**
     * Remove a PDDebate object to this object
     * through the p_d_d_tagged_t cross reference table.
     *
     * @param PDDebate $pDDebate The PDDTaggedT object to relate
     * @return PTag The current object (for fluent API support)
     */
    public function removePddTaggedTPDDebate(PDDebate $pDDebate)
    {
        if ($this->getPddTaggedTPDDebates()->contains($pDDebate)) {
            $this->collPddTaggedTPDDebates->remove($this->collPddTaggedTPDDebates->search($pDDebate));
            if (null === $this->pddTaggedTPDDebatesScheduledForDeletion) {
                $this->pddTaggedTPDDebatesScheduledForDeletion = clone $this->collPddTaggedTPDDebates;
                $this->pddTaggedTPDDebatesScheduledForDeletion->clear();
            }
            $this->pddTaggedTPDDebatesScheduledForDeletion[]= $pDDebate;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->p_t_tag_type_id = null;
        $this->title = null;
        $this->online = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->slug = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collPuqTaggedTPTags) {
                foreach ($this->collPuqTaggedTPTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPddTaggedTPTags) {
                foreach ($this->collPddTaggedTPTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPuqTaggedTPUQualifications) {
                foreach ($this->collPuqTaggedTPUQualifications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPddTaggedTPDDebates) {
                foreach ($this->collPddTaggedTPDDebates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aPTTagType instanceof Persistent) {
              $this->aPTTagType->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collPuqTaggedTPTags instanceof PropelCollection) {
            $this->collPuqTaggedTPTags->clearIterator();
        }
        $this->collPuqTaggedTPTags = null;
        if ($this->collPddTaggedTPTags instanceof PropelCollection) {
            $this->collPddTaggedTPTags->clearIterator();
        }
        $this->collPddTaggedTPTags = null;
        if ($this->collPuqTaggedTPUQualifications instanceof PropelCollection) {
            $this->collPuqTaggedTPUQualifications->clearIterator();
        }
        $this->collPuqTaggedTPUQualifications = null;
        if ($this->collPddTaggedTPDDebates instanceof PropelCollection) {
            $this->collPddTaggedTPDDebates->clearIterator();
        }
        $this->collPddTaggedTPDDebates = null;
        $this->aPTTagType = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PTagPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     PTag The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = PTagPeer::UPDATED_AT;

        return $this;
    }

    // sluggable behavior

    /**
     * Create a unique slug based on the object
     *
     * @return string The object slug
     */
    protected function createSlug()
    {
        $slug = $this->createRawSlug();
        $slug = $this->limitSlugSize($slug);
        $slug = $this->makeSlugUnique($slug);

        return $slug;
    }

    /**
     * Create the slug from the appropriate columns
     *
     * @return string
     */
    protected function createRawSlug()
    {
        return '' . $this->cleanupSlugPart($this->gettitle()) . '';
    }

    /**
     * Cleanup a string to make a slug of it
     * Removes special characters, replaces blanks with a separator, and trim it
     *
     * @param     string $slug        the text to slugify
     * @param     string $replacement the separator used by slug
     * @return    string               the slugified text
     */
    protected static function cleanupSlugPart($slug, $replacement = '-')
    {
        // transliterate
        if (function_exists('iconv')) {
            $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
        }

        // lowercase
        if (function_exists('mb_strtolower')) {
            $slug = mb_strtolower($slug);
        } else {
            $slug = strtolower($slug);
        }

        // remove accents resulting from OSX's iconv
        $slug = str_replace(array('\'', '`', '^'), '', $slug);

        // replace non letter or digits with separator
        $slug = preg_replace('/\W+/', $replacement, $slug);

        // trim
        $slug = trim($slug, $replacement);

        if (empty($slug)) {
            return 'n-a';
        }

        return $slug;
    }


    /**
     * Make sure the slug is short enough to accomodate the column size
     *
     * @param    string $slug                   the slug to check
     * @param    int    $incrementReservedSpace the number of characters to keep empty
     *
     * @return string                            the truncated slug
     */
    protected static function limitSlugSize($slug, $incrementReservedSpace = 3)
    {
        // check length, as suffix could put it over maximum
        if (strlen($slug) > (255 - $incrementReservedSpace)) {
            $slug = substr($slug, 0, 255 - $incrementReservedSpace);
        }

        return $slug;
    }


    /**
     * Get the slug, ensuring its uniqueness
     *
     * @param    string $slug            the slug to check
     * @param    string $separator       the separator used by slug
     * @param    int    $alreadyExists   false for the first try, true for the second, and take the high count + 1
     * @return   string                   the unique slug
     */
    protected function makeSlugUnique($slug, $separator = '-', $alreadyExists = false)
    {
        if (!$alreadyExists) {
            $slug2 = $slug;
        } else {
            $slug2 = $slug . $separator;
        }

        $query = PTagQuery::create('q')
            ->where('q.Slug ' . ($alreadyExists ? 'REGEXP' : '=') . ' ?', $alreadyExists ? '^' . $slug2 . '[0-9]+$' : $slug2)
            ->prune($this)
        ;

        if (!$alreadyExists) {
            $count = $query->count();
            if ($count > 0) {
                return $this->makeSlugUnique($slug, $separator, true);
            }

            return $slug2;
        }

        // Already exists
        $object = $query
            ->addDescendingOrderByColumn('LENGTH(slug)')
            ->addDescendingOrderByColumn('slug')
        ->findOne();

        // First duplicate slug
        if (null == $object) {
            return $slug2 . '1';
        }

        $slugNum = substr($object->getSlug(), strlen($slug) + 1);
        if (0 == $slugNum[0]) {
            $slugNum[0] = 1;
        }

        return $slug2 . ($slugNum + 1);
    }

}
