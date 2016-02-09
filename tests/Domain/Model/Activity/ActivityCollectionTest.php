<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Activity;

use Arnovr\Statistics\Domain\Model\Activity\Activity;
use Arnovr\Statistics\Domain\Model\Activity\ActivityCollection;
use Arnovr\Statistics\Domain\Model\User;

class ActivityCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ActivityCollection
     */
    private $activityCollection;

    public function setUp()
    {
        $this->activityCollection = new ActivityCollection();
    }

    public function shouldMergeActivitiesWhenActivityHappenOnTheSameDay()
    {
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-30 23:50:01"),
                1
            )
        );
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-31 23:50:01"),
                1
            )
        );
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-31 23:50:01"),
                1
            )
        );
        $serialized = $this->activityCollection->jsonSerialize();
        $this->assertCount(2, $serialized);
    }

    /**
     * @test
     */
    public function shouldIncrementActivitiesWhenActivityHappenOnTheSameDay()
    {
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-30 23:50:01"),
                1
            )
        );
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-31 23:50:01"),
                1
            )
        );
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-31 23:50:01"),
                1
            )
        );
        $serialized = $this->activityCollection->jsonSerialize();
        $this->assertSame(1, $serialized[0]['activities']);
        $this->assertSame(2, $serialized[1]['activities']);
    }


    /**
     * @test
     */
    public function shouldIterateThroughStorages()
    {
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-30 23:50:01"),
                1
            )
        );
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-31 23:50:01"),
                1
            )
        );
        $this->activityCollection->add(
            Activity::withUserDateActivityCount(
                User::named('test'),
                new \DateTime("2015-12-31 23:50:01"),
                1
            )
        );

        $dates = [
            '2015-12-30',
            '2015-12-31'
        ];
        $i = 0;
        foreach($this->activityCollection as $day => $activity)
        {
            $this->assertSame($dates[$i], $day);
            $this->assertInstanceOf(Activity::class, $activity);
            $i++;
        }
        $this->assertSame(2, $i);
    }
}