<?php

namespace Arnovr\Statistics\Domain\Model\Filter;

use Assert\Assertion;
use DateTime;

class DateFrom
{
    /**
     * @var DateTime
     */
    private $dateFrom;

    /**
     * DateFrom constructor.
     *
     * @param DateTime $dateTime
     */
    private function __construct(DateTime $dateTime)
    {
        $this->dateFrom = $dateTime;
    }

    /**
     * @param string $date
     * @return DateFrom
     */
    public static function fromString($date)
    {
        Assertion::notEmpty($date);
        return new static(
            DateTime::createFromFormat(
                "d-m-Y H:i:s",
                date("d-m-Y H:i:s", strtotime($date))
            )
        );
    }

    /**
     * @return DateTime
     */
    public function dateTime()
    {
        return $this->dateFrom;
    }
}
