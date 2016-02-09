<?php

namespace Arnovr\Statistics\Domain\Model\Activity;

use Arnovr\Statistics\Domain\Model\User;
use Assert\Assertion;

class Activity implements \JsonSerializable
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var integer
     */
    private $activities;

    /**
     * ActivityTest constructor.
     * @param User      $user
     * @param \DateTime $created
     * @param integer   $activities
     */
    public function __construct(User $user, \DateTime $created, $activities)
    {
        Assertion::integer($activities);
        Assertion::notEmpty($created);

        $this->dateTime = $created;
        $this->activities = $activities;
        $this->user = $user;
    }

    /**
     * @param User      $user
     * @param \DateTime $created
     * @param integer   $activities
     * @return Activity
     */
    public static function withUserDateActivityCount(User $user, \DateTime $created, $activities)
    {
        return new Activity($user, $created, $activities);
    }

    /**
     * @return \DateTime
     */
    public function dateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return integer
     */
    public function activity()
    {
        return $this->activities;
    }

    /**
     * @param integer $addTo
     */
    public function increaseActivity($addTo)
    {
        Assertion::integer($addTo);

        $this->activities += $addTo;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->user->name();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'day' => $this->dateTime()->format('d'),
            'month' => $this->dateTime()->format('m'),
            'year' => $this->dateTime()->format('Y'),
            'username' => $this->username(),
            'activities' => $this->activity()
        ];
    }
}
