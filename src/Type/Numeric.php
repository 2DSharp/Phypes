<?php
namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Type\Type;

/**
 * Numeric class validates supplied input is indeed a numeric value.
 * @author Mangopeaches <https://github.com/mangopeaches>
 */
class Numeric extends Type
{
    /**
     * Validate the type is as we expect and return the outcome.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (!is_numeric($this->value)) {
            $this->error = sprintf("The supplied value (%s) was not numeric.", $this->value);
            return false;
        }
        return true;
    }
}