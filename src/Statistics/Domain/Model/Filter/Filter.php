<?php

namespace Arnovr\Statistics\Domain\Model\Filter;

use Arnovr\Statistics\Domain\Model\Storage\Storage;

/**
 * Class Filter
 * @package Arnovr\Statistics\Domain\Model\Search
 */
class Filter
{
    /**
     * @var Users
     */
    private $users;

    /**
     * @var DateRange
     */
    private $dateRange;

    /**
     * Filter constructor.
     * @param Users $users
     * @param DateRange $dateRange
     */
    private function __construct(
        Users $users,
        DateRange $dateRange
    ) {
        $this->users = $users;
        $this->dateRange = $dateRange;
    }

    /**
     * @param Users $users
     * @param DateRange $dateRange
     * @return Filter
     */
    public static function create(
        Users $users,
        DateRange $dateRange
    ) {
        return new static($users, $dateRange);
    }

    /**
     * @return DateRange
     */
    public function dateRange()
    {
        return $this->dateRange;
    }

    /**
     * @return Users
     */
    public function users()
    {
        return $this->users;
    }
}
