<?php declare(strict_types=1);

namespace Phypes\Rule\String;


use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result;
use Phypes\Rule\Rule;

class MaximumLength implements Rule
{
    private $maxLength;

    public function __construct(int $maxLength)
    {
        $this->maxLength = $maxLength;
    }
    public function validate($data) : Result
    {
        if (mb_strlen($data, 'UTF-8') <= $this->maxLength) {
            return new Result(true);
        }
        else return new Result(false,
            new RuleError(RuleErrorCode::TOO_LONG,
                'The supplied string is too long'));
    }
}