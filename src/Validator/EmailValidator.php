<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

use GreenTea\Phypes\Exception\PrematureErrorCallException;

class EmailValidator implements Validator
{
    /**
     * @var string $error
     * Stores the error message on validation failure
     */
    private $error;
    private $validated = false;

    public function isValid($email, $options = []): bool
    {
        $this->validated = true;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = '';
            return true;
        }
        $this->error = 'The provided email is invalid.';
        return false;
    }

    /**
     * Return the error message upon validation, empty string returned if no errors are set
     * @return string $error
     * @throws PrematureErrorCallException
     */
    public function getErrorMessage(): string
    {
        /**
         * Extra check to make sure someone doesn't call this method before actually calling isValid()
         */
        if ($this->validated == false) {
            throw new PrematureErrorCallException();
        }
        if (is_null($this->error)) {
            return '';
        }
        return $this->error;
    }
}