<?php

namespace kbaydush\DataValue\Entity;

class TotalFees {
    /** @var floatValue The Float value being stored */
    public $floatValue = 0;

    /**
     * TotalFees constructor.
     *
     * @param $orderRunInFee
     * @param $orderBookingFee
     * @param $orderHandlingFee
     * @param $orderVatFee
     *
     * @throws Exception
     */
    function __construct($orderRunInFee, $orderBookingFee, $orderHandlingFee, $orderVatFee)
    {
        $input = $orderRunInFee + $orderBookingFee + $orderHandlingFee + $orderVatFee;
        if ( is_null($orderRunInFee) || is_null($orderBookingFee) || is_null($orderHandlingFee) || is_null($orderVatFee) ) throw new Exception('Float constructor requires 4 args');

        $this->floatValue = floatval($input);

    }
    /**
     * Compare two Float objects
     *
     * @param mixed $comparison The Float object to compare this Float to
     * @return bool If $comparison is the same, true is returned.
     */
    public function compareTo( TotalFees $comparison )
    {

        return $this->floatValue === $comparison();

    }
    /**
     * Get the value of the Float
     *
     * Using this invoke method allows the developer to access the float value of an
     * Float without making a longer and more explicit call. This is useful where
     * long arithmatic strings are required.
     *
     * @return float return the value of the Float as a float.
     */
    public function __invoke()
    {

        return (float)$this->floatValue;

    }

    /**
     * Get\Set the value of the Float
     *
     * @param mixed $input The setter value
     * @return float return the value of the floateger as an float.
     */
    public function val( $input = null )
    {

        if ( $input == null ) {
            return (float)$this->floatValue;
        } else {
            $this->floatValue = $input;
        }


    }

    /**
     * Get the value of the Float as a string
     *
     * @return string return the value of the floateger as an string/
     */
    public function __toString()
    {

        return (string)$this->floatValue;

    }
}
