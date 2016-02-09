<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Storage;

use Arnovr\Statistics\Domain\Model\Storage\Quota;
use Arnovr\Statistics\Domain\Model\Storage\Storage;
use Arnovr\Statistics\Domain\Model\Storage\StorageCollection;
use Arnovr\Statistics\Domain\Model\User;
use Measurements\Bytes\Bytes;

class StorageCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnMultiDimensionalArrayOfStorages()
    {
        $collection = new StorageCollection();
        $this->addStorageToCollection($collection, 'test1');
        $this->addStorageToCollection($collection, 'test2');
        $this->addStorageToCollection($collection, 'test3');
        $this->addStorageToCollection($collection, 'test4');
        $this->addStorageToCollection($collection, 'test5');

        $serializedCollection = $collection->jsonSerialize();

        $this->assertCount(5, $serializedCollection);
        $this->assertSame('test1', $serializedCollection[0]['username']);
        $this->assertSame('test2', $serializedCollection[1]['username']);
        $this->assertSame('test3', $serializedCollection[2]['username']);
        $this->assertSame('test4', $serializedCollection[3]['username']);
        $this->assertSame('test5', $serializedCollection[4]['username']);

    }

    /**
     * @param StorageCollection $collection
     * @param string $username
     */
    private function addStorageToCollection(StorageCollection $collection, $username)
    {
        $collection->add(
            Storage::withUserDateUsageQuota(
                User::named($username),
                new \DateTime("2015-12-31 23:50:01"),
                Bytes::allocateUnits(0),
                Quota::fromBytes(
                    Bytes::allocateUnits(1)
                )
            )
        );
    }

    /**
     * @test
     */
    public function shouldIterateThroughStorages()
    {
        $collection = new StorageCollection();
        $this->addStorageToCollection($collection, 'test1');
        $this->addStorageToCollection($collection, 'test2');
        $this->addStorageToCollection($collection, 'test3');
        $this->addStorageToCollection($collection, 'test4');
        $this->addStorageToCollection($collection, 'test5');

        $i = 0;
        foreach($collection as $key => $storage)
        {
            $this->assertSame($key, $i);
            $this->assertInstanceOf(Storage::class, $storage);
            $i++;
        }
        $this->assertSame(5, $i);
    }
}