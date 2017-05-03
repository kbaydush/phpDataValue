<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

namespace kbaydush\DataValue\Example;

use kbaydush\DataValue\AbstractDataValue;
use kbaydush\DataValue\Property;
use kbaydush\DataValue\Property\PropertyInterface;

/**
 * @method Engine setPower(mixed $value)
 * @method mixed getPower()
 * @method Engine setCylinders($value)
 * @method mixed getCylinders()
 */
class Engine extends AbstractDataValue
{

    /**
     * @return PropertyInterface[]
     */
    protected function getInitPropertyList()
    {
        return array(
            new Property("power"),
            new Property("cylinders")
        );
    }
}
