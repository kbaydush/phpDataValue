<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */


namespace kbaydush\DataValue;

use Exception;
use kbaydush\DataValue\Exception\GetterWithoutArguments;
use kbaydush\DataValue\Exception\NotSetterNotGetter;
use kbaydush\DataValue\Exception\Property\Bad;
use kbaydush\DataValue\Exception\SetterOneArgument;
use kbaydush\DataValue\Property\PropertyInterface;

/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */
abstract class AbstractDataValue
{
    /**
     * @var PropertyInterface[]
     */
    protected $properties = array();

    final public function __construct(array $fetchRow = null)
    {

        $fields = $this->getInitPropertyList();

        if (is_array($fetchRow)) {
            /** @var PropertyInterface $property */
            foreach ($fields as $property) {

                if (isset($fetchRow[$this->from_camel_case($property->getPropertyName())])) {
                    $value = $fetchRow[$this->from_camel_case($property->getPropertyName())];
                }

                if (!is_null($value)) {
                    $_property = $property->setValue($value);
                    $this->addProperty($property);
                }

            }
        }
    }

    /**
     * @return PropertyInterface[]
     */
    abstract protected function getInitPropertyList();

    /**
     * @param PropertyInterface $value
     *
     * @return AbstractDataValue
     */
    final protected function addProperty(PropertyInterface $value)
    {
        $this->properties[mb_strtolower($value->getPropertyName())] = $value;

        return $this;
    }

    final public function __call($name, array $arguments)
    {
        $name     = mb_strtolower($name);
        $prefix   = mb_substr($name, 0, 3);
        $dataName = mb_substr($name, 3);

        if (!$this->isPropertyExist($dataName)) {
            throw new Bad();
        }

        switch ($prefix) {
            case "set":
                return $this->setter($dataName, $arguments);
                break;
            case "get":
                return $this->getter($dataName, $arguments);
                break;
            default:
                throw new NotSetterNotGetter();
        }
    }

    /**
     * @param string $dataName
     *
     * @return bool
     */
    protected function isPropertyExist($dataName)
    {
        return isset($this->properties[$dataName]);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return $this
     * @throws SetterOneArgument
     */
    protected function setter($name, array $arguments)
    {
        return
            $this->testArguments($arguments, 1, new SetterOneArgument())
                ->addProperty(
                    $this->getProperty($name)
                        ->setValue(current($arguments))
                );
    }

    /**
     * @param array     $arguments
     * @param int       $countArguments
     * @param Exception $errorObject
     *
     * @return $this
     * @throws Exception
     */
    protected function testArguments(array $arguments, $countArguments, Exception $errorObject)
    {
        if (!$this->isArgumentsCount($arguments, $countArguments)) {
            throw $errorObject;
        }

        return $this;
    }

    /**
     * @param array   $arguments
     * @param integer $count
     *
     * @return bool
     */
    protected function isArgumentsCount(array $arguments, $count)
    {
        return count($arguments) === $count;
    }

    /**
     * @param string $name
     *
     * @return PropertyInterface
     */
    protected function getProperty($name)
    {
        return $this->properties[$name];
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     * @throws GetterWithoutArguments
     */
    protected function getter($name, array $arguments)
    {
        return $this->testArguments($arguments, 0, new GetterWithoutArguments())
            ->getProperty($name)->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        $return = get_class($this) . " values:\n";
        /** @var PropertyInterface $property */
        foreach ($this->properties as $property) {
            $return .= "\t" . $property->toString() . ",\n";
        }

        return $return;
    }

    public function to_camel_case($str, $capitalise_first_char = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');

        return preg_replace_callback('/_([a-z])/', $func, $str);
    }

    public function from_camel_case($str)
    {
        $str[0] = strtolower($str[0]);
        $func   = create_function('$c', 'return "_" . strtolower($c[1]);');

        return preg_replace_callback('/([A-Z])/', $func, $str);
    }
}
