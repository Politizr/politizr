<?php

namespace Politizr\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'p_user_archive' table.
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
class PUserArchiveTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Politizr.Model.map.PUserArchiveTableMap';

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
        $this->setName('p_user_archive');
        $this->setPhpName('PUserArchive');
        $this->setClassname('Politizr\\Model\\PUserArchive');
        $this->setPackage('src.Politizr.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('uuid', 'Uuid', 'VARCHAR', false, 50, null);
        $this->addColumn('p_u_status_id', 'PUStatusId', 'INTEGER', true, null, null);
        $this->addColumn('p_l_city_id', 'PLCityId', 'INTEGER', false, null, null);
        $this->addColumn('provider', 'Provider', 'VARCHAR', false, 255, null);
        $this->addColumn('provider_id', 'ProviderId', 'VARCHAR', false, 255, null);
        $this->addColumn('nickname', 'Nickname', 'VARCHAR', false, 255, null);
        $this->addColumn('realname', 'Realname', 'VARCHAR', false, 255, null);
        $this->addColumn('username', 'Username', 'VARCHAR', false, 255, null);
        $this->addColumn('username_canonical', 'UsernameCanonical', 'VARCHAR', false, 255, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('email_canonical', 'EmailCanonical', 'VARCHAR', false, 255, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('salt', 'Salt', 'VARCHAR', false, 255, null);
        $this->addColumn('password', 'Password', 'VARCHAR', false, 255, null);
        $this->addColumn('last_login', 'LastLogin', 'TIMESTAMP', false, null, null);
        $this->addColumn('locked', 'Locked', 'BOOLEAN', false, 1, false);
        $this->addColumn('expired', 'Expired', 'BOOLEAN', false, 1, false);
        $this->addColumn('expires_at', 'ExpiresAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('confirmation_token', 'ConfirmationToken', 'VARCHAR', false, 255, null);
        $this->addColumn('password_requested_at', 'PasswordRequestedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('credentials_expired', 'CredentialsExpired', 'BOOLEAN', false, 1, false);
        $this->addColumn('credentials_expire_at', 'CredentialsExpireAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('roles', 'Roles', 'ARRAY', false, null, null);
        $this->addColumn('last_activity', 'LastActivity', 'TIMESTAMP', false, null, null);
        $this->addColumn('file_name', 'FileName', 'VARCHAR', false, 150, null);
        $this->addColumn('back_file_name', 'BackFileName', 'VARCHAR', false, 150, null);
        $this->addColumn('copyright', 'Copyright', 'LONGVARCHAR', false, null, null);
        $this->addColumn('gender', 'Gender', 'ENUM', false, null, null);
        $this->getColumn('gender', false)->setValueSet(array (
  0 => 'Madame',
  1 => 'Monsieur',
));
        $this->addColumn('firstname', 'Firstname', 'VARCHAR', false, 150, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 150, null);
        $this->addColumn('birthday', 'Birthday', 'DATE', false, null, null);
        $this->addColumn('subtitle', 'Subtitle', 'LONGVARCHAR', false, null, null);
        $this->addColumn('biography', 'Biography', 'LONGVARCHAR', false, null, null);
        $this->addColumn('website', 'Website', 'VARCHAR', false, 250, null);
        $this->addColumn('twitter', 'Twitter', 'VARCHAR', false, 250, null);
        $this->addColumn('facebook', 'Facebook', 'VARCHAR', false, 250, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 30, null);
        $this->addColumn('newsletter', 'Newsletter', 'BOOLEAN', false, 1, null);
        $this->addColumn('last_connect', 'LastConnect', 'TIMESTAMP', false, null, null);
        $this->addColumn('nb_connected_days', 'NbConnectedDays', 'INTEGER', false, null, 0);
        $this->addColumn('indexed_at', 'IndexedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('nb_views', 'NbViews', 'INTEGER', false, null, null);
        $this->addColumn('organization', 'Organization', 'BOOLEAN', false, 1, false);
        $this->addColumn('qualified', 'Qualified', 'BOOLEAN', false, 1, null);
        $this->addColumn('validated', 'Validated', 'BOOLEAN', false, 1, false);
        $this->addColumn('nb_id_check', 'NbIdCheck', 'INTEGER', false, null, null);
        $this->addColumn('online', 'Online', 'BOOLEAN', false, 1, null);
        $this->addColumn('homepage', 'Homepage', 'BOOLEAN', false, 1, null);
        $this->addColumn('support_group', 'SupportGroup', 'BOOLEAN', false, 1, null);
        $this->addColumn('banned', 'Banned', 'BOOLEAN', false, 1, null);
        $this->addColumn('banned_nb_days_left', 'BannedNbDaysLeft', 'INTEGER', false, null, null);
        $this->addColumn('banned_nb_total', 'BannedNbTotal', 'INTEGER', false, null, null);
        $this->addColumn('abuse_level', 'AbuseLevel', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('slug', 'Slug', 'VARCHAR', false, 255, null);
        $this->addColumn('archived_at', 'ArchivedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // PUserArchiveTableMap
