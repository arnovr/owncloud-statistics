<?php

namespace Arnovr\Statistics\Domain\Model\Storage;

use Iterator;
use JsonSerializable;

/**
 * Class StorageCollection
 * @package Arnovr\Statistics\Domain\Model\Storage
 */
class StorageCollection implements Iterator, JsonSerializable
{
    /**
     * @var Storage[]
     */
    private $list = [];

    /**
     * @param Storage $storage
     */
    public function add(Storage $storage)
    {
        $this->list[] = $storage;
    }

    /**
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->list);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->list);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->list);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->list);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->list) !== null;
    }

    /**
     * @return Storage[]
     */
    public function all()
    {
        return $this->list;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $output = [];
        /** @var Storage $storage */
        foreach ($this->all() as $storage) {
            $output[] = $storage->jsonSerialize();
        }
        return $output;
    }
}
