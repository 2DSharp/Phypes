<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 8/31/18
 * Time: 1:17 AM
 */

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Type\Type;

class Email extends Type
{
    /**
     * Validates the email value and returns the outcome.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->error = sprintf("The provided email address (%s) was not valid.", $this->value);
            return false;
        }
        return true;
    }
}
