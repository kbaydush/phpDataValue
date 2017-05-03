<?php

namespace kbaydush\DataValue\Entity;

class TotalFare
{
    /** @var floatValue The Float value being stored */
    public $floatValue = 0;


    /**
     * TotalFare constructor.
     *
     * @param $order_taxi_meter
     * @param $order_waiting_time_cost
     * @param $order_additional_cost
     * @param $order_extras_cost
     * @param $order_cancellation_cost
     * @param $order_stop_point_cost
     * @param $order_gratuity_cost
     *
     * @throws Exception
     */
    function __construct(
        $order_taxi_meter,
        $order_waiting_time_cost,
        $order_additional_cost,
        $order_extras_cost,
        $order_cancellation_cost,
        $order_stop_point_cost,
        $order_gratuity_cost)
    {
        $input = $order_taxi_meter +
            $order_waiting_time_cost +
            $order_additional_cost +
            $order_extras_cost +
            $order_cancellation_cost +
            $order_stop_point_cost +
            $order_gratuity_cost;

        if (is_null($order_taxi_meter) ||
            is_null($order_taxi_meter) ||
            is_null($order_taxi_meter) ||
            is_null($order_taxi_meter) ||
            is_null($order_taxi_meter) ||
            is_null($order_taxi_meter) ||
            is_null($order_taxi_meter)
        )
            throw new Exception('Float constructor requires seven args');

        $this->floatValue = floatval($input);

    }

    /**
     * Compare two Float objects
     *
     * @param mixed $comparison The Float object to compare this Float to
     *
     * @return bool If $comparison is the same, true is returned.
     */
    public function compareTo(TotalFare $comparison)
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
     *
     * @return float return the value of the floateger as an float.
     */
    public function val($input = null)
    {

        if ($input == null) {
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
