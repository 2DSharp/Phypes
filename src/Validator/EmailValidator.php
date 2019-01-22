<?php
declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Error\TypeError\TypeError;
use Phypes\Error\TypeError\TypeErrorCode;
use Phypes\Result;
use Phypes\Rule\MinimumLength;

class EmailValidator extends AbstractValidator
{
    public function getResult($email, $options = []): Result
    {
        $this->validated = true;

        $result = (new MinimumLength(4))->validate($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $result->isValid()) {

            return $this->success();
        }

        $errors = new TypeError(TypeErrorCode::EMAIL_INVALID, 'The provided email is invalid.');
        return $this->failure($errors);
    }

}