<?php

namespace Khill\Lavacharts\Tests;


use Illuminate\Support\Collection;

abstract class ProvidersTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Partial DataTable for use throughout various tests
     */
    protected $partialDataTable;

    protected $columnTypes = [
        'boolean',
        'number',
        'string',
        'date',
        'datetime',
        'timeofday'
    ];

    public function setUp()
    {
        parent::setUp();

        $this->partialDataTable = \Mockery::mock('Khill\Lavacharts\DataTables\DataTable')->makePartial();
    }

    /**
     * Uses reflection to retrieve private member variables from objects.
     *
     * @param  object $obj
     * @param  string $prop
     * @return mixed
     */
    public function getPrivateProperty($obj, $prop)
    {
        $refObj = new \ReflectionClass($obj);
        $refProp = $refObj->getProperty($prop);
        $refProp->setAccessible(true);

        return $refProp->getValue($obj);
    }

    public function columnTypeProvider()
    {
        return array_map(function ($columnType) {
            return [$columnType];
        }, $this->columnTypes);
    }

    public function nonIntOrPercentProvider()
    {
        return [
            [3.2],
            [true],
            [false],
            [[]],
            [new \stdClass],
        ];
    }

    public function nonCarbonOrDateStringProvider()
    {
        return [
            [9],
            [14.6342],
            [true],
            [false],
            [new \stdClass()],
        ];
    }

    public function nonCarbonOrDateOrEmptyArrayProvider()
    {
        return [
            ['cheese'],
            [9],
            [14.6342],
            [true],
            [false],
            [new \stdClass()],
        ];
    }

    public function nonConfigObjectProvider()
    {
        return [
            ['stringy'],
            [9],
            [1.2],
            [true],
            [false],
            [[]],
            [new \stdClass()],
        ];
    }

    public function nonStringProvider()
    {
        return [
            [9],
            [1.2],
            [true],
            [false],
            [null],
            [[]],
            [new \stdClass()],
        ];
    }

    public function validStringProvider()
    {
        return [
            ['Im not empty!'],
            [new TestClassWithToString()],
        ];
    }

    public function nonBoolProvider()
    {
        return [
            ['Imastring'],
            [9],
            [1.2],
            [[]],
            [new \stdClass()],
        ];
    }

    public function nonIntProvider()
    {
        return [
            ['Imastring'],
            [1.2],
            [true],
            [false],
            [[]],
            [new \stdClass()],
        ];
    }

    public function nonFloatProvider()
    {
        return [
            ['Imastring'],
            [9],
            [true],
            [false],
            [[]],
            [new \stdClass()],
        ];
    }

    public function nonNumericProvider()
    {
        return [
            ['Imastring'],
            [true],
            [false],
            [[]],
            [new \stdClass()],
        ];
    }

    public function nonArrayProvider()
    {
        return [
            ['Imastring'],
            [9],
            [1.2],
            [true],
            [false],
            [new \stdClass()],
        ];
    }

    public function traversableProvider()
    {
        $collection = new Collection([
            ['IAmAString'],
            ['IAmASecondString'],
            ['IAmAThirdString'],
        ]);

        return [
            [$collection],
        ];
    }

    public function arrayAccessProvider()
    {
        $arrayAccessArray = [
            [new Collection(['IAmAString'])],
            [new Collection(['IAmASecondString'])],
            [new Collection(['IAmAThirdString'])]
        ];

        return [
            [$arrayAccessArray],
        ];
    }

    public function iterableWithStrings()
    {
        $stringsArray = [
            'IAmAString',
            'IAmASecondString',
            'IAmAThirdString',
        ];
        $stringsCollection = new Collection($stringsArray);

        $objectsArray = [
            new TestClassWithToString('IAmAString'),
            new TestClassWithToString('IAmASecondString'),
            new TestClassWithToString('IAmAThirdString'),
        ];
        $objectsCollection = new Collection($objectsArray);

        return [
            [$stringsArray],
            [$objectsArray],
            [$stringsCollection],
            [$objectsCollection],
        ];
    }

    public function iterableInArrayWithGoodData()
    {
        $stringsArray = [
            'IAmAString',
            'IAmASecondString',
            'IAmAThirdString',
        ];
        $stringsCollection = new Collection($stringsArray);

        $objectsArray = [
            new TestClassWithToString('IAmAString'),
            new TestClassWithToString('IAmASecondString'),
            new TestClassWithToString('IAmAThirdString'),
        ];
        $objectsCollection = new Collection($objectsArray);

        return [
            [$stringsArray],
            [$objectsArray],
            [$stringsCollection],
            [$objectsCollection],
        ];
    }

    public function iterableInArrayWithBadData()
    {
        $stringsArray = [
            'IAmAString',
            'IAmASecondString',
            'IAmAThirdString',
        ];
        $stringsCollection = new Collection($stringsArray);

        $objectsArray = [
            new TestClassWithToString('IAmAString'),
            new TestClassWithToString('IAmASecondString'),
            new TestClassWithToString('IAmAThirdString'),
        ];
        $objectsCollection = new Collection($objectsArray);

        return [
            [$stringsArray, 'nonExisting'],
            [$objectsArray, 'nonExisting'],
            [$stringsCollection, 'nonExisting'],
            [$objectsCollection, 'nonExisting'],
        ];
    }
}
