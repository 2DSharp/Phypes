<?php

namespace GreenTea\Phypes\Validator;

use GreenTea\Phypes\Exception\PrematureErrorCallException;

abstract class AbstractValidator implements Validator
{
    /**
     * Has this validator been used before?
     * if no, getErrorMessage() will throw an exception
     * @var bool $validated
     */
    protected $validated = false;
    /**
     * @var string|null $error
     * Stores the error message on validation failure
     */
    protected $error;

    /**
     * Return the error message upon validation, null returned if no errors are set
     * @return string $error
     * @throws PrematureErrorCallException
     */
    public function getErrorMessage(): ?string
    {
        /**
         * Extra check to make sure someone doesn't call this method before actually calling isValid()
         */
        if ($this->validated == false) {
            throw new PrematureErrorCallException();
        }

        return $this->error;
    }
}