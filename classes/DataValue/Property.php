<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */


namespace kbaydush\DataValue;

use kbaydush\DataValue\Exception\Property\BadValueType;
use kbaydush\DataValue\Exception\Property\ReadOnly;
use kbaydush\DataValue\Exception\Property\Required;
use kbaydush\DataValue\Property\PropertyInterface;

final class Property implements PropertyInterface
{
    /** @var  mixed */
    protected $value;
    /** @var  string */
    protected $name;
    /** @var boolean */
    protected $isValueSet = false;
    /** @var  boolean */
    protected $isReadOnly = false;
    /** @var  boolean */
    protected $isRequired = false;
    /** @var  string */
    protected $valueType = null;

    /**
     * PropertyAbstract constructor.
     * @param string $name
     * @param mixed | null $value
     */
    final public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
        if (!is_null($value)) {
            $this->isValueSet = true;
        }
    }

    /**
     * @param bool $isRequired
     * @return PropertyInterface
     */
    public function setRequired($isRequired = true)
    {
        $this->isRequired = $isRequired;
        return $this;
    }

    /**
     * @param PropertyInterface $property
     * @return boolean
     */
    public function equal(PropertyInterface $property)
    {
        return
            ($this->getPropertyName() === $property->getPropertyName())
            and ($this->getValue() === $property->getValue())
            and ($this->isReadOnly() === $property->isReadOnly())
            and ($this->isRequired() === $property->isRequired());
    }

    /**
     * @return mixed
     */
    public function getPropertyName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     * @throws Required
     */
    public function getValue()
    {
        if ($this->isRequired === true and $this->isValueSet() !== true) {
            throw  new Required();
        }
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return PropertyInterface
     * @throws BadValueType
     * @throws ReadOnly
     */
    public function setValue($value)
    {
        if ($this->isReadOnly === true and $this->isValueSet() === true) {
            throw new ReadOnly();
        }

        if (!is_null($this->valueType)) {
            if (!is_object($value) or get_class($value) !== $this->valueType) {
                throw new BadValueType();
            }
        }
        $return = new Property($this->getPropertyName(), $value);
        $return->setReadOnly($this->isReadOnly())
            ->setRequired($this->isRequired());
        return $return;
    }

    /** @return  boolean */
    public function isValueSet()
    {
        return ($this->isValueSet);
    }

    /**
     * @return boolean
     */
    public function isReadOnly()
    {
        return $this->isReadOnly;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param bool $isReadOnly
     * @return PropertyInterface
     */
    public function setReadOnly($isReadOnly = true)
    {
        $this->isReadOnly = $isReadOnly;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return  string
     */
    public function toString()
    {
        return $this->getPropertyName() . ": " . $this->getValue();
    }

    /**
     * @param string $className
     * @return $this
     */
    public function setValueType($className)
    {
        $this->valueType = $className;
        return $this;
    }
}
