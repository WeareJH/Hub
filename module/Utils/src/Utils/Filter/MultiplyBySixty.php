<?php

namespace Utils\Filter;

use Zend\Filter\FilterInterface;

/**
 * Class MultiplyBySixty
 * @package Utils\Filter
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class MultiplyBySixty implements FilterInterface
{

    /**
     * Multiple a number by 60
     *
     * @param mixed $value
     * @return mixed
     */
    public function filter($value)
    {
        return $value * 60;
    }
}
