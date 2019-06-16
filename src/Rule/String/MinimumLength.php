<?php declare(strict_types=1);

namespace Phypes\Rule\String;

use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result;
use Phypes\Rule\Rule;

class MinimumLength implements Rule
{
    private $minLength;

    public function __construct(int $minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate($data) : Result\Result
    {
        if (mb_strlen($data, 'UTF-8') >= $this->minLength) {
            return new Result\Success();
        }
        else return new Result\Failure(
            new RuleError(RuleErrorCode::LENGTH_ERROR,
            'The supplied string is too short'));
    }
}