<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

namespace kbaydush\DataValue\Exception\Property;

class Required extends \Exception
{
    public function __construct($message = null, $code = null, \Exception $previous = null)
    {
        parent::__construct("This property $message do not exist.", $code, $previous);
    }
}
