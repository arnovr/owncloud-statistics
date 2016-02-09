<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud;

use Arnovr\Statistics\Domain\Model\Filter\DateFrom;
use Arnovr\Statistics\Domain\Model\Filter\DateRange;
use Arnovr\Statistics\Domain\Model\Filter\DateTo;
use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\Filter\Users;
use Arnovr\Statistics\Infrastructure\Owncloud\User\LoggedInUser;

class FilterFactory
{
    /**
     * @var LoggedInUser
     */
    private $loggedInUser;

    /**
     * FilterFactory constructor.
     *
     * @param LoggedInUser $loggedInUser
     */
    public function __construct(LoggedInUser $loggedInUser)
    {
        $this->loggedInUser = $loggedInUser;
    }

    /**
     * @param string $users
     * @param string $dateFrom
     * @param string $dateTo
     * @return Filter
     */
    public function createFrom($users, $dateFrom, $dateTo)
    {
        $users = $this->extractUsersFromRequest($users);

        return Filter::create(
            Users::fromCommaSeparatedString(
                $users
            ),
            DateRange::from(
                DateFrom::fromString(
                    urldecode($dateFrom)
                ),
                DateTo::fromString(
                    urldecode($dateTo)
                )
            )
        );
    }

    /**
     * @param string $users
     * @return string
     */
    private function extractUsersFromRequest($users)
    {
        if ($this->isAllowedToViewOtherUsers()) {
            return $users;
        }

        return $this->loggedInUser->username();
    }

    /**
     * @return boolean
     */
    private function isAllowedToViewOtherUsers()
    {
        return $this->loggedInUser->isAdminUser();
    }
}
