<?php

namespace Arnovr\Statistics\Domain\Model\Storage;

use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\Filter\UnitOfMeasurement;

/**
 * Interface StorageRepository
 * @package Arnovr\Statistics\Domain\Model\Storage
 */
interface StorageRepository
{
    /**
     * @param Storage $storage
     * @return void
     */
    public function add(Storage $storage);

    /**
     * @param Filter $filter
     * @param UnitOfMeasurement $unitOfMeasurement
     * @return StorageCollection
     */
    public function find(Filter $filter, UnitOfMeasurement $unitOfMeasurement);
}
