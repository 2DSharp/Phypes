<?php declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Error\TypeError;
use Phypes\Error\TypeErrorCode;
use Phypes\Result;

class EmailValidator extends AbstractValidator
{
    public function validate($email, $options = []): Result
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->success();
        }

        $error = new TypeError(TypeErrorCode::EMAIL_INVALID, 'The provided email is invalid.');
        return $this->failure($error);
    }
}