<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Activity;

use Arnovr\Statistics\Domain\Model\Activity\Activity;
use Arnovr\Statistics\Domain\Model\User;
use Assert\InvalidArgumentException;

class ActivityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldIncrementActivity()
    {
        $activity = Activity::withUserDateActivityCount(
            User::named('test'),
            new \DateTime("2015-12-31 23:50:01"),
            1
        );
        $activity->increaseActivity(10);

        $this->assertSame(11, $activity->activity());
    }

    /**
     * @test
     * @dataProvider getInvalidActivities
     * @param $activityCount
     */
    public function shouldNotAllowCreationWithoutValidActivityCount($activityCount)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        Activity::withUserDateActivityCount(
            User::named('test'),
            new \DateTime("2015-12-31 23:50:01"),
            $activityCount
        );
    }

    public function getInvalidActivities()
    {
        return [
            [''],
            ['sdfsdf'],
            [null],
            [12.3],
        ];
    }
}