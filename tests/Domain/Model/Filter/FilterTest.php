<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Filter;

use Arnovr\Statistics\Domain\Model\Filter\DateFrom;
use Arnovr\Statistics\Domain\Model\Filter\DateRange;
use Arnovr\Statistics\Domain\Model\Filter\DateTo;
use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\Filter\Users;
use Assert\InvalidArgumentException;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateFilter()
    {
        $this->assertInstanceOf(
            Filter::class,
            Filter::create(
                Users::fromCommaSeparatedString('admin'),
                DateRange::from(
                    DateFrom::fromString(date('d-m-Y H:i:s')),
                    DateTo::fromString(date('d-m-Y H:i:s'))
                )
            )
        );
    }

    /**
     * @test
     */
    public function shouldFailOnEmptyUsers()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        Filter::create(
            Users::fromCommaSeparatedString(''),
            DateRange::from(
                DateFrom::fromString(''),
                DateTo::fromString('')
            )
        );
    }

    /**
     * @test
     */
    public function shouldFailOnEmptyDateFrom()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        Filter::create(
            Users::fromCommaSeparatedString('admin'),
            DateRange::from(
                DateFrom::fromString(''),
                DateTo::fromString(date('d-m-Y H:i:s'))
            )
        );
    }

    /**
     * @test
     */
    public function shouldFailOnEmptyDateTo()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        Filter::create(
            Users::fromCommaSeparatedString('admin'),
            DateRange::from(
                DateFrom::fromString(date('d-m-Y H:i:s')),
                DateTo::fromString('')
            )
        );
    }
}
