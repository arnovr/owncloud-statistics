<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\User;

use Arnovr\Statistics\Domain\Model\User;

class UserList
{
    /**
     * @return User[]
     */
    public function allUsers()
    {
        $users = [];
        $systemUsers = \OC_User::getUsers();
        foreach ($systemUsers as $uid) {
            $users[] = User::named($uid);
        }
        return $users;
    }
}
