<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

class IPAddressValidator implements Validator
{
    public function isValid($ip, $options = []): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        }

        return false;
    }
}