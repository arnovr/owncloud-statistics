<?php

namespace Arnovr\Statistics\Domain\Model\Storage;

use Arnovr\Statistics\Domain\Model\User;
use Measurements\Bytes\Bytes;

class Storage implements \JsonSerializable
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
     * @var Bytes
     */
    private $bytes;

    /**
     * @var Quota
     */
    private $quota;

    /**
     * @param User      $user
     * @param \DateTime $dateTime
     * @param Bytes     $bytes
     * @param Quota     $quota
     */
    private function __construct(User $user, \DateTime $dateTime, Bytes $bytes, Quota $quota)
    {
        $this->user = $user;
        $this->dateTime = $dateTime;
        $this->bytes = $bytes;
        $this->quota = $quota;
    }

    /**
     * @param User      $user
     * @param \DateTime $dateTime
     * @param Bytes     $bytes
     * @param Quota     $quota
     * @return static
     */
    public static function withUserDateUsageQuota(User $user, \DateTime $dateTime, Bytes $bytes, Quota $quota)
    {
        return new static($user, $dateTime, $bytes, $quota);
    }

    /**
     * @return Bytes
     */
    public function bytes()
    {
        return $this->bytes;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function dateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return Quota
     */
    public function quota()
    {
        return $this->quota;
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
            'hour' => $this->dateTime()->format('H'),
            'minute' => $this->dateTime()->format('i'),
            'username' => $this->user()->name(),
            'usage' => $this->bytes()->units()
        ];
    }
}
