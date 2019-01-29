<?php declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Error\TypeError;
use Phypes\Error\TypeErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;

class EmailValidator implements Validator
{
    public function validate($email, $options = []): Result
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Success();
        }

        $error = new TypeError(TypeErrorCode::EMAIL_INVALID, 'The provided email is invalid.');
        return new Failure($error);
    }
}