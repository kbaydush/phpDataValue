<?php

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

namespace kbaydush\DataValue\Tests\DataValue;

use kbaydush\DataValue\AbstractDataValue;
use kbaydush\DataValue\Example\Car;
use kbaydush\DataValue\Example\Engine;
use kbaydush\DataValue\Property;

class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractDataValue */
    protected $param;

    /** @expectedException kbaydush\DataValue\Exception\NotSetterNotGetter */
    public function testBadMethod()
    {
        $this->param->tesEngine();
    }

    /** @expectedException  kbaydush\DataValue\Exception\SetterOneArgument */
    public function testSetterNullArgumentsException()
    {
        $this->param->setEngine();
    }

    /** @expectedException  kbaydush\DataValue\Exception\SetterOneArgument */
    public function testSetterMoreOneArgumentsException()
    {
        $this->param->setEngine("1", "2");
    }

    /** @expectedException  kbaydush\DataValue\Exception\GetterWithoutArguments */
    public function testGetterNotNUllArgumentsException()
    {
        $this->param->getEngine("1");
    }

    /** @expectedException  kbaydush\DataValue\Exception\Property\Bad */
    public function testBadGetterException()
    {
        $this->param->getException();
    }

    /** @expectedException  kbaydush\DataValue\Exception\Property\Bad */
    public function testBadSetterException()
    {
        $this->param->setException("S");
    }

    /**
     * Test upper case of getter
     *
     */
    public function testGetterUpperCase()
    {
        $this->param->setEngine(new Engine());
        $this->param->getEngine();
        $this->param->getengine();
        $this->param->Getengine();
        $this->param->GetEngine();
    }

    /**
     * Test upper case of setter
     *
     */
    public function testSetterUpperCase()
    {
        $engine = new Engine();
        $this->param->setEngine($engine);
        $this->param->setengine($engine);
        $this->param->Setengine($engine);
        $this->param->SetEngine($engine);
    }

    public function testSetterReturn()
    {
        $this->assertInstanceOf(
            'kbaydush\DataValue\AbstractDataValue',
            $this->param->setEngine(new Engine())
        );
    }

    public function testGetter()
    {
        $engine = (new Engine())->setPower(100);

        $this->assertEquals(
            $engine,
            $this->param->setEngine($engine)
                ->getEngine()
        );
    }

    public function testToString()
    {
        $this->param->setColor("red");

        $this->assertEquals(
            'kbaydush\DataValue\Example\Car values:' . "\n\tengine: ,\n\tcolor: red,\n",
            $this->param->toString()
        );
    }

    public function testEngineCar()
    {
        $this->assertEquals(
            100,
            $this->param
                ->setEngine(
                    (new Engine())->setPower(100)
                )
                ->getEngine()
                ->getPower()
        );
    }

    /** @expectedException kbaydush\DataValue\Exception\Property\BadValueType */
    public function testBadTypeOfSetter()
    {
        $this->param->setEngine("bad");
    }

    protected function setUp()
    {
        parent::setUp();
        $this->param = new Car();
    }
}
