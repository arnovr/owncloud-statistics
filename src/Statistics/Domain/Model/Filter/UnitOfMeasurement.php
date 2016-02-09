<?php

namespace Arnovr\Statistics\Domain\Model\Filter;

use Assert\Assertion;

class UnitOfMeasurement
{
    /**
     * @var string
     */
    private $type;

    /**
     * UnitOfMeasurement constructor.
     * @param string $type
     */
    private function __construct($type)
    {
        Assertion::inArray(
            $type,
            ['tb', 'gb', 'mb', 'kb', 'b']
        );
        $this->type = $type;
    }

    /**
     * @param $type
     * @return UnitOfMeasurement
     */
    public static function fromString($type)
    {
        return new static($type);
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }
}
