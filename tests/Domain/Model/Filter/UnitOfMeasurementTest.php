<?php

namespace Arnovr\Statistics\Tests\Domain\Model\Filter;

use Arnovr\Statistics\Domain\Model\Filter\UnitOfMeasurement;
use Assert\InvalidArgumentException;

class UnitOfMeasurementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     *
     * @dataProvider correctUnitsOfMeasurement
     *
     * @param $unitOfMeasurement
     */
    public function shouldAllowUnitsOfMeasurement($unitOfMeasurement)
    {
        $this->assertInstanceOf(
            UnitOfMeasurement::class,
            UnitOfMeasurement::fromString($unitOfMeasurement)
        );
    }

    public function correctUnitsOfMeasurement()
    {
        return [
            ['b'],
            ['kb'],
            ['mb'],
            ['gb'],
            ['tb']
        ];
    }


    /**
     * @test
     *
     * @dataProvider incorrectUnitsOfMeasurement
     *
     * @param $unitOfMeasurement
     */
    public function shouldNotAllowInvalidUnitsOfMeasurement($unitOfMeasurement)
    {
        $this->setExpectedException(InvalidArgumentException::class);
        UnitOfMeasurement::fromString($unitOfMeasurement);
    }

    public function incorrectUnitsOfMeasurement()
    {
        return [
            [''],
            ['1'],
            ['GB'],
            ['Tb'],
            ['LB'],
            ['GBTB'],
        ];
    }
}