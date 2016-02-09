<?php

namespace Arnovr\Statistics\Tests\Infrastructure\Owncloud;

use Arnovr\Statistics\Infrastructure\Owncloud\FilterFactory;
use Arnovr\Statistics\Infrastructure\Owncloud\User\LoggedInUser;
use Mockery;

class FilterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggedInUser|\Mockery\MockInterface
     */
    private $loggedInUser;

    /**
     * @var FilterFactory
     */
    private $filterFactory;

    public function setUp()
    {
        $this->loggedInUser = Mockery::mock(LoggedInUser::class);

        $this->filterFactory = new FilterFactory($this->loggedInUser);
    }

    /**
     * @test
     */
    public function shouldReturnAllUsersInFilterWhenHavingAdminRights()
    {
        $this->loggedInUser->shouldReceive('isAdminUser')->andReturn(true);
        $this->loggedInUser->shouldReceive('username')->andReturn('admin');

        $filter = $this->filterFactory->createFrom(
            'admin,elton,test1',
            date('d-m-Y H:i:s'),
            date('d-m-Y H:i:s')
        );

        $this->assertSame(
            ['admin', 'elton', 'test1'],
            $filter->users()->asArray()
        );
    }

    /**
     * @test
     */
    public function shouldReturnOwnUserFilterWhenNotHavingAdminRights()
    {
        $this->loggedInUser->shouldReceive('isAdminUser')->andReturn(false);
        $this->loggedInUser->shouldReceive('username')->andReturn('test1');

        $filter = $this->filterFactory->createFrom(
            'admin,elton,test1',
            date('d-m-Y H:i:s'),
            date('d-m-Y H:i:s')
        );

        $this->assertSame(
            ['test1'],
            $filter->users()->asArray()
        );
    }
}