<?php

namespace Politizr\Constant;

/**
 *
 * @author Lionel Bouzonville
 */
class EmailConstants
{
    // ******************************************************** //
    //                   EMAIL NOTIFS TYPES                     //
    // ******************************************************** //
    const TYPE_EMAIL = 1;
    const TYPE_EMAIL_TXT = 2;
    const TYPE_EMAIL_SUBJECT = 3;

    // ******************************************************** //
    //                   EMAILING TYPES                         //
    // ******************************************************** //
    const ID_ADMIN_MSG = 1;
    const ID_PROFILE_SUMMARY = 2;
    const ID_ACTIVITY_SUMMARY = 3;

    /**
     * Return array of default notif ids for email subscribtion
     *
     * @return array
     */
    public static function getDefaultNotificationSubscribeIds()
    {
        return [
            EmailConstants::ID_ADMIN_MSG,
            EmailConstants::ID_PROFILE_SUMMARY,
            EmailConstants::ID_ACTIVITY_SUMMARY
        ];
    }
}
