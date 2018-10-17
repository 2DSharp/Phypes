<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

use GreenTea\Phypes\Exception\PrematureErrorCallException;

class EmailValidator implements Validator
{
    /**
     * @var string|null $error
     * Stores the error message on validation failure
     */
    private $error;
    private $validated = false;

    public function isValid($email, $options = []): bool
    {
        $this->validated = true;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = null;
            return true;
        }
        $this->error = 'The provided email is invalid.';
        return false;
    }

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