<?php
declare(strict_types=1);

namespace Phypes\Validator;

class IPAddressValidator extends AbstractValidator
{
    public function isValid($ip, $options = []): bool
    {
        $this->validated = true;

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $this->error = $this->errorCode = null;
            return true;
        }
        $this->errorCode = Error::IP_INVALID;
        $this->error = 'The provided IP Address is invalid.';
        return false;
    }
}