<?php

namespace Politizr\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'p_u_q_tagged_t' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Politizr.Model.map
 */
class PUQTaggedTTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Politizr.Model.map.PUQTaggedTTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('p_u_q_tagged_t');
        $this->setPhpName('PUQTaggedT');
        $this->setClassname('Politizr\\Model\\PUQTaggedT');
        $this->setPackage('src.Politizr.Model');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('p_u_qualification_id', 'PUQualificationId', 'INTEGER' , 'p_u_qualification', 'id', true, null, null);
        $this->addForeignPrimaryKey('p_tag_id', 'PTagId', 'INTEGER' , 'p_tag', 'id', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PuqTaggedTPUQualification', 'Politizr\\Model\\PUQualification', RelationMap::MANY_TO_ONE, array('p_u_qualification_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('PuqTaggedTPTag', 'Politizr\\Model\\PTag', RelationMap::MANY_TO_ONE, array('p_tag_id' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // PUQTaggedTTableMap
