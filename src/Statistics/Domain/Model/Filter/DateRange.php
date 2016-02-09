<?php

namespace Arnovr\Statistics\Domain\Model\Filter;

class DateRange
{
    /**
     * @var DateFrom
     */
    private $from;

    /**
     * @var DateTo
     */
    private $to;

    /**
     * DateRange constructor.
     * @param DateFrom $from
     * @param DateTo $to
     */
    private function __construct(DateFrom $from, DateTo $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param DateFrom $from
     * @param DateTo $to
     * @return DateRange
     */
    public static function from(DateFrom $from, DateTo $to)
    {
        return new static($from, $to);
    }

    /**
     * @return DateFrom
     */
    public function dateFrom()
    {
        return $this->from;
    }

    /**
     * @return DateTo
     */
    public function dateTo()
    {
        return $this->to;
    }
}
