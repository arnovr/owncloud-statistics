<?php

namespace Arnovr\Statistics\Domain\Model\Filter;

use Assert\Assertion;
use DateTime;

class DateTo
{
    /**
     * @var DateTime
     */
    private $dateTo;

    /**
     * DateFrom constructor.
     * @param DateTime $dateTime
     */
    private function __construct(DateTime $dateTime)
    {
        $this->dateTo = $dateTime;
    }

    /**
     * @param string $date
     * @return DateTo
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
        return $this->dateTo;
    }
}
