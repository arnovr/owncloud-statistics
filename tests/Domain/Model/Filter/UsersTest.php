<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Filter;


use Arnovr\Statistics\Domain\Model\Filter\Users;

class UsersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Users
     */
    private $users;

    public function setUp()
    {
        $this->users = Users::fromCommaSeparatedString('admin,test1,test2');
    }

    /**
     * @test
     */
    public function shouldSucceedWhenUserDoesExist()
    {
        $this->assertTrue(
            $this->users->exists('admin')
        );
        $this->assertTrue(
            $this->users->exists('test1')
        );
        $this->assertTrue(
            $this->users->exists('test2')
        );
    }

    /**
     * @test
     */
    public function shouldFailWhenUserDoesNotExist()
    {

        $this->assertFalse(
            $this->users->exists('admin,')
        );
        $this->assertFalse(
            $this->users->exists('admi')
        );
        $this->assertFalse(
            $this->users->exists('admin,test1,test2')
        );
        $this->assertFalse(
            $this->users->exists('admin,test1')
        );
    }
}