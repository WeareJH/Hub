<?php

namespace Utils\Filter;

use Zend\Filter\DateTimeFormatter as ZfDateTimeFormatter;
use DateTime;

/**
 * Class DateTimeFormatter
 * @package Utils\Filter
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class DateTimeFormatter extends ZfDateTimeFormatter
{

    /**
     * Filter a datetime string by normalizing it to the filters specified format
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        try {
            $result = $this->normalizeDateTime($value);
        } catch (\Exception $e) {
            // DateTime threw an exception, an invalid date string was provided
            //just return original input - this is what other filters do
            return $value;
        }

        return $result;
    }

    /**
     * Return a DateTime object
     *
     * @param  string|int|DateTime $value
     * @return string
     */
    protected function normalizeDateTime($value)
    {
        if ($value === '' || $value === null) {
            return $value;
        } elseif (is_int($value)) {
            $value = new DateTime('@' . $value);
        } elseif (!$value instanceof DateTime) {
            $value = new DateTime($value);
        }

        return $value;
    }
}
