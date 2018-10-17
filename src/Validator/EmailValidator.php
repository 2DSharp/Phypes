<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

class EmailValidator extends AbstractValidator
{
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
}