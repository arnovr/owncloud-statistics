<?php

namespace Arnovr\Statistics\Tests\Application\Handler;


use Arnovr\Statistics\Application\Command\AddStorage;
use Arnovr\Statistics\Application\Handler\AddStorageHandler;
use Arnovr\Statistics\Domain\Model\Storage\StorageRepository;
use Assert\InvalidArgumentException;
use Mockery;

class AddStorageHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface|StorageRepository
     */
    private $storageRepository;

    /**
     * @var AddStorageHandler
     */
    private $addStorageHandler;

    public function setUp()
    {
        $this->storageRepository = Mockery::mock(StorageRepository::class);
        $this->addStorageHandler = new AddStorageHandler(
            $this->storageRepository
        );
    }

    /**
     * @test
     */
    public function shouldAddStorageToHistory()
    {
        $this->storageRepository->shouldReceive('add')->once();
        $addStorage = new AddStorage();
        $addStorage->name = 'username';
        $addStorage->quota = 100;
        $addStorage->storage = 34234234;
        $this->addStorageHandler->add($addStorage);
    }

    /**
     * @test
     */
    public function shouldNotAddStorageOnMissingUsername() {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->storageRepository->shouldReceive('add')->never();
        $addStorage = new AddStorage();
        $addStorage->quota = 100;
        $addStorage->storage = 34234234;
        $this->addStorageHandler->add($addStorage);
    }

    /**
     * @test
     */
    public function shouldNotAddStorageOnMissingQuota() {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->storageRepository->shouldReceive('add')->never();
        $addStorage = new AddStorage();
        $addStorage->name = 'username';
        $addStorage->storage = 34234234;
        $this->addStorageHandler->add($addStorage);
    }

    /**
     * @test
     */
    public function shouldNotAddStorageOnMissingStorage() {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->storageRepository->shouldReceive('add')->never();
        $addStorage = new AddStorage();
        $addStorage->name = 'username';
        $addStorage->quota = 100;
        $this->addStorageHandler->add($addStorage);
    }
}