<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\Storage;

use Arnovr\Statistics\Domain\Model\Storage\Storage;
use Exception;

class CouldNotAddStorage extends Exception
{
    /**
     * @param Storage $storage
     * @return CouldNotAddStorage
     */
    public static function byStorage(Storage $storage)
    {
        return new self("Could not add storage for " . $storage->user()->name());
    }
}
