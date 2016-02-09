<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\User;

class LoggedInUser
{
    /**
     * @return string
     */
    public function username()
    {
        return \OCP\User::getUser();
    }

    /**
     * @return boolean
     */
    public function isAdminUser()
    {
        return \OC_User::isAdminUser(
            $this->username()
        );
    }
}
