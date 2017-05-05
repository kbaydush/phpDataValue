<?php
/**
 * author: k.baidush
 *
 * @copyright   Gett
 * @license     Gett
 */

namespace kbaydush\DataValue;

use kbaydush\DataValue\Exception\Property\BadValueType;
use kbaydush\DataValue\Exception\Property\ReadOnly;
use kbaydush\DataValue\Exception\Property\Required;
use kbaydush\DataValue\Property\PropertyInterface;
use TreasureForge\InvoiceBundle\Model\DataValue\dataTypes\Boolean;
use TreasureForge\InvoiceBundle\Model\DataValue\dataTypes\Double;
use TreasureForge\InvoiceBundle\Model\DataValue\dataTypes\Float;
use TreasureForge\InvoiceBundle\Model\DataValue\dataTypes\Integer;

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
     * @var array
     */
    protected $depArray = null;

    /**
     * @return array
     */
    public function getDependencies()
    {
        return $this->depArray;
    }

    /**
     * @param array $array
     */
    public function setDependencies($array)
    {
        $this->depArray = $array;

        return $this;
    }

    /**
     * PropertyAbstract constructor.
     *
     * @param string       $name
     * @param mixed | null $value
     */
    final public function __construct($name, $value = null)
    {
        $this->name  = $name;
        $this->value = $value;
        if (!is_null($value)) {
            $this->isValueSet = true;
        }
    }

    /**
     * @param bool $isRequired
     *
     * @return PropertyInterface
     */
    public function setRequired($isRequired = true)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * @param PropertyInterface $property
     *
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
            echo "Required " . $this->getPropertyName();
            throw  new Required($this->getPropertyName());
        }

        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return PropertyInterface
     * @throws BadValueType
     * @throws ReadOnly
     */
    public function setValue($value)
    {
        if ($this->isReadOnly === true and $this->isValueSet() === true) {
            echo "Read Only - " . $this->getPropertyName();
            throw new ReadOnly();
        }

        if (!is_null($this->valueType)) {

            if ($this->valueType == Integer::class) {
                $value = new Integer($value);
            } elseif ($this->valueType == Float::class) {
                $value = new Float($value);
            } elseif ($this->valueType == Double::class) {
                $value = new Double($value);
            } elseif ($this->valueType == Boolean::class) {
                $value = new Boolean($value);
            }

            if (!is_object($value) or get_class($value) !== $this->valueType) {
                echo "Bad Type " . $this->valueType;
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
     *
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
     *
     * @return $this
     */
    public function setValueType($className)
    {
        $this->valueType = $className;

        return $this;
    }
}
