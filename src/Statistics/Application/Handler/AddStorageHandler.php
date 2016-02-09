<?php

namespace Arnovr\Statistics\Application\Handler;

use Arnovr\Statistics\Application\Command\AddStorage;
use Arnovr\Statistics\Domain\Model\Storage\Quota;
use Arnovr\Statistics\Domain\Model\Storage\Storage;
use Arnovr\Statistics\Domain\Model\Storage\StorageRepository;
use Arnovr\Statistics\Domain\Model\User;
use Assert\Assertion;
use Measurements\Bytes\Bytes;

class AddStorageHandler
{
    /**
     * @var StorageRepository
     */
    private $storageRepository;

    /**
     * AddStorageHandler constructor.
     * @param StorageRepository $storageRepository
     */
    public function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    /**
     * @param AddStorage $addStorage
     */
    public function add(AddStorage $addStorage)
    {
        Assertion::integer($addStorage->storage);
        Assertion::integer($addStorage->quota);

        $storage = Storage::withUserDateUsageQuota(
            User::named($addStorage->name),
            new \DateTime(),
            Bytes::allocateUnits((int) $addStorage->storage),
            Quota::fromBytes(
                Bytes::allocateUnits((int) $addStorage->quota)
            )
        );

        $this->storageRepository->add($storage);
    }
}
