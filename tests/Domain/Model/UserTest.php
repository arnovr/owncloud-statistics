<?php

namespace Arnovr\Statistics\Tests\Domain\Model;

use Arnovr\Statistics\Domain\Model\User;
use Assert\InvalidArgumentException;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateUserNamed()
    {
        $user = User::named('hello');
        $this->assertInstanceOf(
            User::class,
            $user
        );
        $this->assertSame(
            'hello',
            $user->name()
        );
    }
    /**
     * @test
     */
    public function shouldFailOnEmptyUsername()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        User::named('');
    }
}
