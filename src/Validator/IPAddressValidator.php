<?php
declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Error\TypeError\TypeError;
use Phypes\Error\TypeError\TypeErrorCode;
use Phypes\Result;

class IPAddressValidator extends AbstractValidator
{

    public function validate($type, $options = []): Result
    {
        if (filter_var($type, FILTER_VALIDATE_IP)) {

            return $this->success();
        }
        $errors = new TypeError(TypeErrorCode::IP_INVALID, 'The provided IP address is invalid');
        return $this->failure($errors);
    }
}