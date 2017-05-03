<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

namespace kbaydush\DataValue\Tests\DataValue;

use kbaydush\DataValue\Example\Car;
use kbaydush\DataValue\Example\Engine;
use kbaydush\DataValue\Property;
use kbaydush\DataValue\Property\PropertyInterface;

class PropertyTest extends \PHPUnit_Framework_TestCase
{
    const PROPERTY_NAME = "test";
    /** @var  PropertyInterface */
    protected $property;

    public function testValue()
    {
        $this->property = $this->property->setValue("1");
        $this->assertEquals("1", $this->property->getValue());
    }

    public function testSetterReturnValue()
    {
        $this->assertInstanceOf('kbaydush\DataValue\Property\PropertyInterface', $this->property->setValue("1"));
    }

    public function testReadOnlyReturnValue()
    {
        $this->assertInstanceOf('kbaydush\DataValue\Property\PropertyInterface', $this->property->setReadOnly());
    }

    public function testRequiredReturnValue()
    {
        $this->assertInstanceOf('kbaydush\DataValue\Property\PropertyInterface', $this->property->setRequired());
    }

    public function testSetterReadOnly()
    {
        $this->property->setReadOnly();
        $this->assertFalse($this->property->isValueSet());

        $this->property = $this->property->setValue("1");
        $this->assertTrue($this->property->isValueSet());
    }

    /** @expectedException kbaydush\DataValue\Exception\Property\ReadOnly */
    public function testFailOnSettingReadOnly()
    {
        $this->property->setReadOnly();
        $this->property = $this->property->setValue("1");
        $this->property = $this->property->setValue("2");
    }

    public function testReadOnly()
    {
        $this->property = $this->property
            ->setReadOnly()
            ->setValue("1");

        $this->assertEquals("1", $this->property->getValue());
        $this->assertEquals("1", $this->property->getValue());
    }

    public function testReadOnlyValue()
    {
        $this->property = $this->property
            ->setReadOnly()
            ->setValue("1");
        try {
            $this->property = $this->property->setValue("2");
        } catch (\Exception $e) {
        }

        $this->assertEquals("1", $this->property->getValue());
    }

    /** @expectedException kbaydush\DataValue\Exception\Property\Required */
    public function testRequiredFail()
    {
        $this->property->setRequired();
        $this->property->getValue();
    }

    public function testRequired()
    {
        $this->assertEquals(
            "1",
            $this->property->setRequired()
                ->setValue("1")
                ->getValue()
        );
    }

    public function testToString()
    {
        $this->property = $this->property->setValue("test value");
        $this->assertEquals("test: test value", $this->property->toString());
    }

    public function testConstructorWithData()
    {
        $this->property = new Property(self::PROPERTY_NAME, "1");
        $this->assertEquals("1", $this->property->getValue());
    }

    public function testValueObjectPattern()
    {
        $oldObjectHash = spl_object_hash($this->property);
        $this->assertNotEquals($oldObjectHash, spl_object_hash($this->property->setValue("1")));
    }

    public function testIsValueSetByConstructor()
    {
        $this->property = new Property(self::PROPERTY_NAME, "1");
        $this->assertTrue($this->property->isValueSet());
    }


    /**
     * @param $expected
     * @param PropertyInterface $firstProperty
     * @param PropertyInterface $secondProperty
     * @dataProvider providerEqualTest
     */
    public function testEqual($expected, PropertyInterface $firstProperty, PropertyInterface $secondProperty)
    {
        $this->assertEquals($expected, $firstProperty->equal($secondProperty));
    }

    /**
     * @return array
     */
    public function providerEqualTest()
    {
        return array(
            array(true, new Property('first'), new Property("first")),
            array(false, new Property('first'), new Property("second")),

            array(
                true,
                (new Property('first'))
                    ->setValue("2"),
                (new Property("first"))
                    ->setValue("2")
            ),
            array(
                false,
                (new Property('first')),
                (new Property("first"))
                    ->setValue("2")
            ),
            array(
                true,
                (new Property('first'))
                    ->setReadOnly(),
                (new Property("first"))
                    ->setReadOnly()
            ),
            array(
                false,
                (new Property('first')),
                (new Property("first"))
                    ->setReadOnly()
            ),
            array(
                true,
                (new Property('first'))
                    ->setRequired()
                    ->setValue("1"),
                (new Property("first"))
                    ->setRequired()
                    ->setValue("1")
            ),
            array(
                false,
                (new Property('first'))
                    ->setValue("1"),
                (new Property("first"))
                    ->setRequired()
                    ->setValue("1")
            ),
            array(
                true,
                (new Property('first', '1'))
                    ->setRequired()
                    ->setReadOnly(),
                (new Property("first"))
                    ->setRequired()
                    ->setReadOnly()
                    ->setValue("1")
            ),
            array(
                true,
                (new Property('first', '1'))
                    ->setRequired(),
                (new Property("first"))
                    ->setRequired()
                    ->setValue("1")
            ),
            array(
                true,
                (new Property('second', '2')),
                (new Property("second"))->setValue("2")
            ),
        );
    }

    public function testRequiredSetter()
    {
        $this->property->setRequired(false);
        $this->assertFalse($this->property->isRequired());
        $this->property->setRequired(true);
        $this->assertTrue($this->property->isRequired());
    }

    public function testReadOnlySetter()
    {
        $this->property->setReadOnly(false);
        $this->assertFalse($this->property->isReadOnly());
        $this->property->setReadOnly(true);
        $this->assertTrue($this->property->isReadOnly());
    }

    public function testGoodValueType()
    {
        $this->property->setValueType(Car::class)
            ->setValue(new Car());
    }

    /** @expectedException kbaydush\DataValue\Exception\Property\BadValueType */
    public function testBadValueType()
    {
        $this->property->setValueType(Engine::class)
            ->setValue(new Car());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->property = new Property(self::PROPERTY_NAME);
    }
}
