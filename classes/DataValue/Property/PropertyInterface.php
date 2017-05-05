<?php
/**
 * {license_notice}
 *
 * @copyright   {copyright}
 * @license     {license_link}
 */

namespace kbaydush\DataValue\Property;

interface PropertyInterface
{

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return PropertyInterface
     */
    public function setValue($value);

    /**
     * @param bool $isReadOnly
     * @return PropertyInterface
     */
    public function setReadOnly($isReadOnly = true);

    /** @return  boolean */
    public function isValueSet();

    /**
     * @param bool $isRequired
     * @return PropertyInterface
     */
    public function setRequired($isRequired = true);

    /** @return string */
    public function getPropertyName();

    /** @return string */
    public function toString();

    /**
     * @param PropertyInterface $property
     * @return boolean
     */
    public function equal(PropertyInterface $property);

    /**
     * @return boolean
     */
    public function isReadOnly();

    /**
     * @return boolean
     */
    public function isRequired();

    /**
     * @param string $className
     * @return $this
     */
    public function setValueType($className);

    public function getDependencies();

    public function setDependencies($array);
}
