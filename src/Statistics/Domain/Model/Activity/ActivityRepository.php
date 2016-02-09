<?php

namespace Arnovr\Statistics\Domain\Model\Activity;

use Arnovr\Statistics\Domain\Model\Filter\Filter;

interface ActivityRepository
{
    /**
     * @param Filter $filter
     * @return ActivityCollection
     */
    public function find(Filter $filter);
}
