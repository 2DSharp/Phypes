<?php declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Result;

abstract class AbstractValidator implements Validator
{
    protected function success()
    {
        return new Result(true);
    }
    protected function failure($errors = []) {
        return new Result(false, $errors);
    }
}