<?php

namespace Arnovr\Statistics\Domain\Model\Activity;

use Iterator;
use JsonSerializable;

class ActivityCollection implements Iterator, JsonSerializable
{
    /**
     * @var []
     */
    private $list = [];

    /**
     * @param Activity $activity
     */
    public function add(Activity $activity)
    {
        $day = $activity->dateTime()->format('Y-m-d');
        if (empty($this->list[$day]) || !$this->list[$day] instanceof Activity) {
            $this->list[$day] = $activity;
            return;
        }

        $this->list[$day]->increaseActivity($activity->activity());
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
     * return array
     */
    public function jsonSerialize()
    {
        $output = [];
        /** @var Activity $activity */
        $list = array_values($this->list);
        foreach ($list as $activity) {
            $output[] = $activity->jsonSerialize();
        }
        return $output;
    }
}
