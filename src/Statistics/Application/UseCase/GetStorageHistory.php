<?php

namespace Arnovr\Statistics\Application\UseCase;

use Arnovr\Statistics\Domain\Model\Filter\UnitOfMeasurement;
use Arnovr\Statistics\Domain\Model\Storage\StorageRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\FilterFactory;

class GetStorageHistory
{
    /**
     * @var FilterFactory
     */
    private $filterFactory;

    /**
     * @var StorageRepository
     */
    private $storageRepository;

    /**
     * GetStorageHistory constructor.
     * @param StorageRepository $storageRepository
     * @param FilterFactory     $filterFactory
     */
    public function __construct(
        StorageRepository $storageRepository,
        FilterFactory $filterFactory
    ) {
        $this->storageRepository = $storageRepository;
        $this->filterFactory = $filterFactory;
    }

    /**
     * @param string $users
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $unit
     * @return \JsonSerializable
     */
    public function getStorage($users, $dateFrom, $dateTo, $unit)
    {
        return $this->storageRepository->find(
            $this->filterFactory->createFrom(
                $users,
                $dateFrom,
                $dateTo
            ),
            UnitOfMeasurement::fromString($unit)
        );
    }
}
