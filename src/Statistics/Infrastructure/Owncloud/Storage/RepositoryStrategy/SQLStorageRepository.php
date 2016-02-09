<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\Storage\RepositoryStrategy;

use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\Filter\UnitOfMeasurement;
use Arnovr\Statistics\Domain\Model\Storage\Quota;
use Arnovr\Statistics\Domain\Model\Storage\Storage;
use Arnovr\Statistics\Domain\Model\Storage\StorageCollection;
use Arnovr\Statistics\Domain\Model\Storage\StorageRepository;
use Arnovr\Statistics\Domain\Model\User;
use Arnovr\Statistics\Infrastructure\Owncloud\Storage\CouldNotAddStorage;
use Measurements\Bytes\Bytes;
use OCP\AppFramework\Db\Mapper;
use OCP\IDb;

class SQLStorageRepository extends Mapper implements StorageRepository
{
    /**
     * SQLStorageRepository constructor.
     * @param IDb $db
     */
    public function __construct(IDb $db)
    {
        parent::__construct($db, 'uc_storageusage', null);
    }

    /**
     * @param Storage $storage
     * @return void
     *
     * @throws CouldNotAddStorage
     */
    public function add(Storage $storage)
    {
        $query = $this->db->prepareQuery(
            'INSERT INTO *PREFIX*uc_storageusage (created, username, `usage`, maximumusage) VALUES (?,?,?,?)'
        );
        $result = $query->execute(
            [
                $storage->dateTime()->format('Y-m-d H:i:s'),
                $storage->user()->name(),
                $storage->bytes()->numberOfBytes(),
                $storage->quota()->bytes()->numberOfBytes()
            ]
        );
        /*
         * $query->execute could return integer or OC_DB_StatementWrapper or false
         * I am expecting an integer with number 1
         */
        if (!is_int($result) || $result !== 1) {
            throw CouldNotAddStorage::byStorage($storage);
        }
    }

    /**
     * @return Storage[]
     */
    public function all()
    {
        $sql = 'SELECT created, username, `usage`, maximumusage FROM `*PREFIX*uc_storageusage` WHERE `usage` > 0';
        $query = $this->db->prepareQuery($sql);
        $result = $query->execute();

        $storageList = [];
        while ($row = $result->fetch()) {
            $storageList[] = $this->mapStorageUsageRowToStorage($row);
        }
        return $storageList;
    }

    /**
     * @param Filter $filter
     * @param UnitOfMeasurement $unitOfMeasurement
     * @return StorageCollection
     */
    public function find(Filter $filter, UnitOfMeasurement $unitOfMeasurement)
    {
        $qMarks = str_repeat('?,', count($filter->users()->asArray()) - 1) . '?';

        $sql = 'SELECT created, username, `usage`, maximumusage FROM `*PREFIX*uc_storageusage`
WHERE `usage` > 0 AND created > ? AND created < ? AND username in (' . $qMarks . ')';
        $query = $this->db->prepareQuery($sql);

        $params = array_merge(
            [
                $filter->dateRange()->dateFrom()->dateTime()->format('Y-m-d H:i:s'),
                $filter->dateRange()->dateTo()->dateTime()->format('Y-m-d H:i:s'),
            ],
            $filter->users()->asArray()
        );
        $result = $query->execute(
            $params
        );

        return $this->parseResultIntoCollection($result, $unitOfMeasurement);
    }

    /**
     * @param $result
     * @param UnitOfMeasurement $unitOfMeasurement
     * @return StorageCollection
     */
    private function parseResultIntoCollection($result, UnitOfMeasurement $unitOfMeasurement)
    {
        $storageCollection = new StorageCollection();
        while ($row = $result->fetch()) {
            $storageCollection->add(
                $this->mapStorageUsageRowToStorage($row, $unitOfMeasurement->type())
            );
        }
        return $storageCollection;
    }

    /**
     * @param array $row
     * @param string $unitOfMeasurement
     * @return Storage
     */
    private function mapStorageUsageRowToStorage($row, $unitOfMeasurement = 'b')
    {
        $bytes = Bytes::allocateUnits((int)$row['usage']);

        switch ($unitOfMeasurement) {
            case 'gb':
                $bytes = $bytes->gigaBytes();
                break;
            case 'mb':
                $bytes = $bytes->megaBytes();
                break;
            case 'kb':
                $bytes = $bytes->kiloBytes();
                break;
        }

        return Storage::withUserDateUsageQuota(
            User::named($row['username']),
            \DateTime::createFromFormat("Y-m-d H:i:s", $row['created']),
            $bytes,
            Quota::fromBytes(
                Bytes::allocateUnits((int) $row['maximumusage'])
            )
        );
    }
}
