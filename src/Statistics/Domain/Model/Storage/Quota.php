<?php


namespace Arnovr\Statistics\Domain\Model\Storage;

use Measurements\Bytes\AbleToConvertToBytes;
use Measurements\Bytes\Bytes;

class Quota implements AbleToConvertToBytes
{
    /**
     * @var Bytes
     */
    private $quota;

    /**
     * Quota constructor.
     * @param Bytes $quota
     */
    public function __construct(Bytes $quota)
    {
        $this->quota = $quota;
    }

    /**
     * @param Bytes $bytes
     * @return Quota
     */
    public static function fromBytes(Bytes $bytes)
    {
        return new static($bytes);
    }

    /**
     * @return Bytes
     */
    public function bytes()
    {
        return $this->quota;
    }
}
