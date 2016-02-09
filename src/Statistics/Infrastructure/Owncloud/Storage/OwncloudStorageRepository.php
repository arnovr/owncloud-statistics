<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\Storage;

use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\Filter\UnitOfMeasurement;
use Arnovr\Statistics\Domain\Model\Storage\Storage;
use Arnovr\Statistics\Domain\Model\Storage\StorageCollection;
use Arnovr\Statistics\Domain\Model\Storage\StorageRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\Storage\Persistence\Persistence;

class OwncloudStorageRepository implements StorageRepository
{
    /**
     * @var StorageRepository
     */
    private $repository;

    /**
     * OwncloudStorageRepository constructor.
     * @param StorageRepository $repository
     */
    public function __construct(StorageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Storage $storage
     * @return void
     */
    public function add(Storage $storage)
    {
        $this->repository->add($storage);
    }

    /**
     * @param Filter $filter
     * @param UnitOfMeasurement $unitOfMeasurement
     * @return StorageCollection
     */
    public function find(Filter $filter, UnitOfMeasurement $unitOfMeasurement)
    {
        return $this->repository->find($filter, $unitOfMeasurement);
    }
}
