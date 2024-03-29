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
use Politizr\Model\POEmail;
use Politizr\Model\POEmailQuery;
use Politizr\Model\POPaymentState;
use Politizr\Model\POPaymentStatePeer;
use Politizr\Model\POPaymentStateQuery;
use Politizr\Model\POrder;
use Politizr\Model\POrderQuery;

abstract class BasePOPaymentState extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Politizr\\Model\\POPaymentStatePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        POPaymentStatePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

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
     * @var        PropelObjectCollection|POrder[] Collection to store aggregation of POrder objects.
     */
    protected $collPOrders;
    protected $collPOrdersPartial;

    /**
     * @var        PropelObjectCollection|POEmail[] Collection to store aggregation of POEmail objects.
     */
    protected $collPOEmails;
    protected $collPOEmailsPartial;

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
    protected $pOrdersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pOEmailsScheduledForDeletion = null;

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
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {

        return $this->description;
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
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = POPaymentStatePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [title] column.
     *
     * @param  string $v new value
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = POPaymentStatePeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = POPaymentStatePeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = POPaymentStatePeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = POPaymentStatePeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

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
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->created_at = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->updated_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 5; // 5 = POPaymentStatePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating POPaymentState object", $e);
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
            $con = Propel::getConnection(POPaymentStatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = POPaymentStatePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPOrders = null;

            $this->collPOEmails = null;

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
            $con = Propel::getConnection(POPaymentStatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = POPaymentStateQuery::create()
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
            $con = Propel::getConnection(POPaymentStatePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(POPaymentStatePeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(POPaymentStatePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(POPaymentStatePeer::UPDATED_AT)) {
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
                POPaymentStatePeer::addInstanceToPool($this);
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

            if ($this->pOrdersScheduledForDeletion !== null) {
                if (!$this->pOrdersScheduledForDeletion->isEmpty()) {
                    foreach ($this->pOrdersScheduledForDeletion as $pOrder) {
                        // need to save related object because we set the relation to null
                        $pOrder->save($con);
                    }
                    $this->pOrdersScheduledForDeletion = null;
                }
            }

            if ($this->collPOrders !== null) {
                foreach ($this->collPOrders as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pOEmailsScheduledForDeletion !== null) {
                if (!$this->pOEmailsScheduledForDeletion->isEmpty()) {
                    foreach ($this->pOEmailsScheduledForDeletion as $pOEmail) {
                        // need to save related object because we set the relation to null
                        $pOEmail->save($con);
                    }
                    $this->pOEmailsScheduledForDeletion = null;
                }
            }

            if ($this->collPOEmails !== null) {
                foreach ($this->collPOEmails as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(POPaymentStatePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(POPaymentStatePeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(POPaymentStatePeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(POPaymentStatePeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(POPaymentStatePeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `p_o_payment_state` (%s) VALUES (%s)',
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
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

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
        $pos = POPaymentStatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getTitle();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
                return $this->getUpdatedAt();
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
        if (isset($alreadyDumpedObjects['POPaymentState'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['POPaymentState'][$this->getPrimaryKey()] = true;
        $keys = POPaymentStatePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collPOrders) {
                $result['POrders'] = $this->collPOrders->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPOEmails) {
                $result['POEmails'] = $this->collPOEmails->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = POPaymentStatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setTitle($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
                $this->setUpdatedAt($value);
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
        $keys = POPaymentStatePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUpdatedAt($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(POPaymentStatePeer::DATABASE_NAME);

        if ($this->isColumnModified(POPaymentStatePeer::ID)) $criteria->add(POPaymentStatePeer::ID, $this->id);
        if ($this->isColumnModified(POPaymentStatePeer::TITLE)) $criteria->add(POPaymentStatePeer::TITLE, $this->title);
        if ($this->isColumnModified(POPaymentStatePeer::DESCRIPTION)) $criteria->add(POPaymentStatePeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(POPaymentStatePeer::CREATED_AT)) $criteria->add(POPaymentStatePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(POPaymentStatePeer::UPDATED_AT)) $criteria->add(POPaymentStatePeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(POPaymentStatePeer::DATABASE_NAME);
        $criteria->add(POPaymentStatePeer::ID, $this->id);

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
     * @param object $copyObj An object of POPaymentState (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getPOrders() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPOrder($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPOEmails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPOEmail($relObj->copy($deepCopy));
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
     * @return POPaymentState Clone of current object.
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
     * @return POPaymentStatePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new POPaymentStatePeer();
        }

        return self::$peer;
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
        if ('POrder' == $relationName) {
            $this->initPOrders();
        }
        if ('POEmail' == $relationName) {
            $this->initPOEmails();
        }
    }

    /**
     * Clears out the collPOrders collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return POPaymentState The current object (for fluent API support)
     * @see        addPOrders()
     */
    public function clearPOrders()
    {
        $this->collPOrders = null; // important to set this to null since that means it is uninitialized
        $this->collPOrdersPartial = null;

        return $this;
    }

    /**
     * reset is the collPOrders collection loaded partially
     *
     * @return void
     */
    public function resetPartialPOrders($v = true)
    {
        $this->collPOrdersPartial = $v;
    }

    /**
     * Initializes the collPOrders collection.
     *
     * By default this just sets the collPOrders collection to an empty array (like clearcollPOrders());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPOrders($overrideExisting = true)
    {
        if (null !== $this->collPOrders && !$overrideExisting) {
            return;
        }
        $this->collPOrders = new PropelObjectCollection();
        $this->collPOrders->setModel('POrder');
    }

    /**
     * Gets an array of POrder objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this POPaymentState is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|POrder[] List of POrder objects
     * @throws PropelException
     */
    public function getPOrders($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPOrdersPartial && !$this->isNew();
        if (null === $this->collPOrders || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPOrders) {
                // return empty collection
                $this->initPOrders();
            } else {
                $collPOrders = POrderQuery::create(null, $criteria)
                    ->filterByPOPaymentState($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPOrdersPartial && count($collPOrders)) {
                      $this->initPOrders(false);

                      foreach ($collPOrders as $obj) {
                        if (false == $this->collPOrders->contains($obj)) {
                          $this->collPOrders->append($obj);
                        }
                      }

                      $this->collPOrdersPartial = true;
                    }

                    $collPOrders->getInternalIterator()->rewind();

                    return $collPOrders;
                }

                if ($partial && $this->collPOrders) {
                    foreach ($this->collPOrders as $obj) {
                        if ($obj->isNew()) {
                            $collPOrders[] = $obj;
                        }
                    }
                }

                $this->collPOrders = $collPOrders;
                $this->collPOrdersPartial = false;
            }
        }

        return $this->collPOrders;
    }

    /**
     * Sets a collection of POrder objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pOrders A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setPOrders(PropelCollection $pOrders, PropelPDO $con = null)
    {
        $pOrdersToDelete = $this->getPOrders(new Criteria(), $con)->diff($pOrders);


        $this->pOrdersScheduledForDeletion = $pOrdersToDelete;

        foreach ($pOrdersToDelete as $pOrderRemoved) {
            $pOrderRemoved->setPOPaymentState(null);
        }

        $this->collPOrders = null;
        foreach ($pOrders as $pOrder) {
            $this->addPOrder($pOrder);
        }

        $this->collPOrders = $pOrders;
        $this->collPOrdersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related POrder objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related POrder objects.
     * @throws PropelException
     */
    public function countPOrders(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPOrdersPartial && !$this->isNew();
        if (null === $this->collPOrders || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPOrders) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPOrders());
            }
            $query = POrderQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPOPaymentState($this)
                ->count($con);
        }

        return count($this->collPOrders);
    }

    /**
     * Method called to associate a POrder object to this object
     * through the POrder foreign key attribute.
     *
     * @param    POrder $l POrder
     * @return POPaymentState The current object (for fluent API support)
     */
    public function addPOrder(POrder $l)
    {
        if ($this->collPOrders === null) {
            $this->initPOrders();
            $this->collPOrdersPartial = true;
        }

        if (!in_array($l, $this->collPOrders->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPOrder($l);

            if ($this->pOrdersScheduledForDeletion and $this->pOrdersScheduledForDeletion->contains($l)) {
                $this->pOrdersScheduledForDeletion->remove($this->pOrdersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	POrder $pOrder The pOrder object to add.
     */
    protected function doAddPOrder($pOrder)
    {
        $this->collPOrders[]= $pOrder;
        $pOrder->setPOPaymentState($this);
    }

    /**
     * @param	POrder $pOrder The pOrder object to remove.
     * @return POPaymentState The current object (for fluent API support)
     */
    public function removePOrder($pOrder)
    {
        if ($this->getPOrders()->contains($pOrder)) {
            $this->collPOrders->remove($this->collPOrders->search($pOrder));
            if (null === $this->pOrdersScheduledForDeletion) {
                $this->pOrdersScheduledForDeletion = clone $this->collPOrders;
                $this->pOrdersScheduledForDeletion->clear();
            }
            $this->pOrdersScheduledForDeletion[]= $pOrder;
            $pOrder->setPOPaymentState(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POrders from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POrder[] List of POrder objects
     */
    public function getPOrdersJoinPUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POrderQuery::create(null, $criteria);
        $query->joinWith('PUser', $join_behavior);

        return $this->getPOrders($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POrders from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POrder[] List of POrder objects
     */
    public function getPOrdersJoinPOOrderState($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POrderQuery::create(null, $criteria);
        $query->joinWith('POOrderState', $join_behavior);

        return $this->getPOrders($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POrders from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POrder[] List of POrder objects
     */
    public function getPOrdersJoinPOPaymentType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POrderQuery::create(null, $criteria);
        $query->joinWith('POPaymentType', $join_behavior);

        return $this->getPOrders($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POrders from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POrder[] List of POrder objects
     */
    public function getPOrdersJoinPOSubscription($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POrderQuery::create(null, $criteria);
        $query->joinWith('POSubscription', $join_behavior);

        return $this->getPOrders($query, $con);
    }

    /**
     * Clears out the collPOEmails collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return POPaymentState The current object (for fluent API support)
     * @see        addPOEmails()
     */
    public function clearPOEmails()
    {
        $this->collPOEmails = null; // important to set this to null since that means it is uninitialized
        $this->collPOEmailsPartial = null;

        return $this;
    }

    /**
     * reset is the collPOEmails collection loaded partially
     *
     * @return void
     */
    public function resetPartialPOEmails($v = true)
    {
        $this->collPOEmailsPartial = $v;
    }

    /**
     * Initializes the collPOEmails collection.
     *
     * By default this just sets the collPOEmails collection to an empty array (like clearcollPOEmails());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPOEmails($overrideExisting = true)
    {
        if (null !== $this->collPOEmails && !$overrideExisting) {
            return;
        }
        $this->collPOEmails = new PropelObjectCollection();
        $this->collPOEmails->setModel('POEmail');
    }

    /**
     * Gets an array of POEmail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this POPaymentState is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|POEmail[] List of POEmail objects
     * @throws PropelException
     */
    public function getPOEmails($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPOEmailsPartial && !$this->isNew();
        if (null === $this->collPOEmails || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPOEmails) {
                // return empty collection
                $this->initPOEmails();
            } else {
                $collPOEmails = POEmailQuery::create(null, $criteria)
                    ->filterByPOPaymentState($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPOEmailsPartial && count($collPOEmails)) {
                      $this->initPOEmails(false);

                      foreach ($collPOEmails as $obj) {
                        if (false == $this->collPOEmails->contains($obj)) {
                          $this->collPOEmails->append($obj);
                        }
                      }

                      $this->collPOEmailsPartial = true;
                    }

                    $collPOEmails->getInternalIterator()->rewind();

                    return $collPOEmails;
                }

                if ($partial && $this->collPOEmails) {
                    foreach ($this->collPOEmails as $obj) {
                        if ($obj->isNew()) {
                            $collPOEmails[] = $obj;
                        }
                    }
                }

                $this->collPOEmails = $collPOEmails;
                $this->collPOEmailsPartial = false;
            }
        }

        return $this->collPOEmails;
    }

    /**
     * Sets a collection of POEmail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pOEmails A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return POPaymentState The current object (for fluent API support)
     */
    public function setPOEmails(PropelCollection $pOEmails, PropelPDO $con = null)
    {
        $pOEmailsToDelete = $this->getPOEmails(new Criteria(), $con)->diff($pOEmails);


        $this->pOEmailsScheduledForDeletion = $pOEmailsToDelete;

        foreach ($pOEmailsToDelete as $pOEmailRemoved) {
            $pOEmailRemoved->setPOPaymentState(null);
        }

        $this->collPOEmails = null;
        foreach ($pOEmails as $pOEmail) {
            $this->addPOEmail($pOEmail);
        }

        $this->collPOEmails = $pOEmails;
        $this->collPOEmailsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related POEmail objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related POEmail objects.
     * @throws PropelException
     */
    public function countPOEmails(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPOEmailsPartial && !$this->isNew();
        if (null === $this->collPOEmails || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPOEmails) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPOEmails());
            }
            $query = POEmailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPOPaymentState($this)
                ->count($con);
        }

        return count($this->collPOEmails);
    }

    /**
     * Method called to associate a POEmail object to this object
     * through the POEmail foreign key attribute.
     *
     * @param    POEmail $l POEmail
     * @return POPaymentState The current object (for fluent API support)
     */
    public function addPOEmail(POEmail $l)
    {
        if ($this->collPOEmails === null) {
            $this->initPOEmails();
            $this->collPOEmailsPartial = true;
        }

        if (!in_array($l, $this->collPOEmails->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPOEmail($l);

            if ($this->pOEmailsScheduledForDeletion and $this->pOEmailsScheduledForDeletion->contains($l)) {
                $this->pOEmailsScheduledForDeletion->remove($this->pOEmailsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	POEmail $pOEmail The pOEmail object to add.
     */
    protected function doAddPOEmail($pOEmail)
    {
        $this->collPOEmails[]= $pOEmail;
        $pOEmail->setPOPaymentState($this);
    }

    /**
     * @param	POEmail $pOEmail The pOEmail object to remove.
     * @return POPaymentState The current object (for fluent API support)
     */
    public function removePOEmail($pOEmail)
    {
        if ($this->getPOEmails()->contains($pOEmail)) {
            $this->collPOEmails->remove($this->collPOEmails->search($pOEmail));
            if (null === $this->pOEmailsScheduledForDeletion) {
                $this->pOEmailsScheduledForDeletion = clone $this->collPOEmails;
                $this->pOEmailsScheduledForDeletion->clear();
            }
            $this->pOEmailsScheduledForDeletion[]= $pOEmail;
            $pOEmail->setPOPaymentState(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POEmails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POEmail[] List of POEmail objects
     */
    public function getPOEmailsJoinPOrder($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POEmailQuery::create(null, $criteria);
        $query->joinWith('POrder', $join_behavior);

        return $this->getPOEmails($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POEmails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POEmail[] List of POEmail objects
     */
    public function getPOEmailsJoinPOOrderState($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POEmailQuery::create(null, $criteria);
        $query->joinWith('POOrderState', $join_behavior);

        return $this->getPOEmails($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POEmails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POEmail[] List of POEmail objects
     */
    public function getPOEmailsJoinPOPaymentType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POEmailQuery::create(null, $criteria);
        $query->joinWith('POPaymentType', $join_behavior);

        return $this->getPOEmails($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this POPaymentState is new, it will return
     * an empty collection; or if this POPaymentState has previously
     * been saved, it will retrieve related POEmails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in POPaymentState.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|POEmail[] List of POEmail objects
     */
    public function getPOEmailsJoinPOSubscription($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = POEmailQuery::create(null, $criteria);
        $query->joinWith('POSubscription', $join_behavior);

        return $this->getPOEmails($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->title = null;
        $this->description = null;
        $this->created_at = null;
        $this->updated_at = null;
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
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collPOrders) {
                foreach ($this->collPOrders as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPOEmails) {
                foreach ($this->collPOEmails as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collPOrders instanceof PropelCollection) {
            $this->collPOrders->clearIterator();
        }
        $this->collPOrders = null;
        if ($this->collPOEmails instanceof PropelCollection) {
            $this->collPOEmails->clearIterator();
        }
        $this->collPOEmails = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(POPaymentStatePeer::DEFAULT_STRING_FORMAT);
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
     * @return     POPaymentState The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = POPaymentStatePeer::UPDATED_AT;

        return $this;
    }

}
