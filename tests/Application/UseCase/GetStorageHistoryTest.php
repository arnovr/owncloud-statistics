<?php

namespace Arnovr\Statistics\Tests\Application\UseCase;


use Arnovr\Statistics\Application\UseCase\GetStorageHistory;
use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\Filter\UnitOfMeasurement;
use Arnovr\Statistics\Domain\Model\Storage\StorageCollection;
use Arnovr\Statistics\Domain\Model\Storage\StorageRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\FilterFactory;
use Arnovr\Statistics\Infrastructure\Owncloud\User\LoggedInUser;
use Mockery;

class GetStorageHistoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function shouldReturnStorageCollection()
    {
        $loggedInUser = Mockery::mock(LoggedInUser::class);
        $loggedInUser->shouldReceive('isAdminUser')->andReturn(true);

        $storageRepository = Mockery::mock(StorageRepository::class);

        $getStorageHistory = new GetStorageHistory(
            $storageRepository,
            new FilterFactory(
                $loggedInUser
            )
        );

        $storageRepository->shouldReceive('find')
            ->with(Mockery::type(Filter::class), Mockery::type(UnitOfMeasurement::class))
            ->andReturn(new StorageCollection())
            ->once();

        $this->assertInstanceOf(
            StorageCollection::class,
            $getStorageHistory->getStorage('admin,test1', date('d-m-Y H:i:s'), date('d-m-Y H:i:s'), 'kb')
        );
    }
}