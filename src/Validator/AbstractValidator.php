<?php

namespace Phypes\Validator;

use Phypes\Exception\PrematureErrorCallException;
use Phypes\ErrorCode\Result;

abstract class AbstractValidator implements Validator
{
    /**
     * Has this validator been used before?
     * if no, getErrorMessage() will throw an exception
     * @var bool $validated
     */
    protected $validated = false;
    /**
     * Stores the error message on validation failure
     * @var string|null $error
     */
    protected $error;
    /**
     * Error code to allow for search with int rather than string
     * @var integer $errorCode
     */
    protected $errorCode;
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

    /**
     * Probably doesn't need to be included in the interface
     * @return int|null
     * @throws PrematureErrorCallException
     */
    public function getErrorCode() : ?int
    {
        if ($this->validated == false) {
            throw new PrematureErrorCallException();
        }

        return $this->errorCode;
    }

    protected function success()
    {
        return new Result(true);
    }
    protected function failure($errors = []) {
        return new Result(false, $errors);
    }
}