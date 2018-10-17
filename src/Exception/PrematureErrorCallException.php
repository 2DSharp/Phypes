<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 10/17/18
 * Time: 8:03 PM
 */

namespace GreenTea\Phypes\Exception;


class PrematureErrorCallException extends \Exception
{
    public function __construct()
    {
        // Do not allow error messages to be displayed before validating
        parent::__construct("Attempting to get error message before validation.", 23000);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}