<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Storage;

use Arnovr\Statistics\Domain\Model\Storage\Quota;
use Arnovr\Statistics\Domain\Model\Storage\Storage;
use Arnovr\Statistics\Domain\Model\User;
use Measurements\Bytes\Bytes;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnDateSeparatelyOnJsonSerialize()
    {
        $dateTime = new \DateTime("2015-12-31 23:50:01");
        $storage = Storage::withUserDateUsageQuota(
            User::named('username'),
            $dateTime,
            Bytes::allocateUnits(0),
            Quota::fromBytes(
                Bytes::allocateUnits(1)
            )
        );

        $serializedStorage = $storage->jsonSerialize();
        $this->assertSame('2015', $serializedStorage['year']);
        $this->assertSame('12', $serializedStorage['month']);
        $this->assertSame('31', $serializedStorage['day']);
        $this->assertSame('23', $serializedStorage['hour']);
        $this->assertSame('50', $serializedStorage['minute']);
    }
}