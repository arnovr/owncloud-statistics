<?php

namespace Arnovr\Statistics\Domain\Model;

use Assert\Assertion;

/**
 * Class User
 * @package Arnovr\Statistics\Domain\Model
 */
class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    private function __construct($name)
    {
        Assertion::notEmpty($name);

        $this->name = $name;
    }

    /**
     * @param $name
     * @return static
     */
    public static function named($name)
    {
        return new static($name);
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
