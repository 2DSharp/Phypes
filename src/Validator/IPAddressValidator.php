<?php
declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Error\TypeError;
use Phypes\Error\TypeErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;

class IPAddressValidator implements Validator
{
    public function validate($type): Result
    {
        if (filter_var($type, FILTER_VALIDATE_IP)) {
            return new Success();
        }

        $errors = new TypeError(TypeErrorCode::IP_INVALID, 'The provided IP address is invalid');
        return new Failure($errors);
    }
}