<?php

namespace Arnovr\Statistics\Tests\Application\UseCase;


use Arnovr\Statistics\Application\UseCase\GetActivityHistory;
use Arnovr\Statistics\Domain\Model\Activity\ActivityCollection;
use Arnovr\Statistics\Domain\Model\Activity\ActivityRepository;
use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Infrastructure\Owncloud\FilterFactory;
use Arnovr\Statistics\Infrastructure\Owncloud\User\LoggedInUser;
use Mockery;

class GetActivityHistoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnActivityCollection()
    {
        $loggedInUser = Mockery::mock(LoggedInUser::class);
        $loggedInUser->shouldReceive('isAdminUser')->andReturn(true);

        $activityRepository = Mockery::mock(ActivityRepository::class);

        $getActivityHistory = new GetActivityHistory(
            $activityRepository,
            new FilterFactory(
                $loggedInUser
            )
        );

        $activityRepository->shouldReceive('find')
            ->with(Mockery::type(Filter::class))
            ->andReturn(new ActivityCollection())
            ->once();

        $this->assertInstanceOf(
            ActivityCollection::class,
            $getActivityHistory->getActivity('admin,test1', date('d-m-Y H:i:s'), date('d-m-Y H:i:s'))
        );
    }
}
