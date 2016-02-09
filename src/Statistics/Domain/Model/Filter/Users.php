<?php

namespace Arnovr\Statistics\Domain\Model\Filter;

use Assert\Assertion;

class Users
{
    /**
     * @var array
     */
    private $users;

    /**
     * Users constructor.
     * @param array $users
     */
    private function __construct(array $users)
    {
        Assertion::isArray($users);

        $this->users = $users;
    }

    /**
     * @param string $users
     * @return Users
     */
    public static function fromCommaSeparatedString($users)
    {
        Assertion::notEmpty($users);

        return new static(explode(',', $users));
    }

    /**
     * @param $username
     * @return boolean
     */
    public function exists($username)
    {
        return in_array($username, $this->users);
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return $this->users;
    }
}
