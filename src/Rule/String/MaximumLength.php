<?php declare(strict_types=1);

namespace Phypes\Rule\String;

use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Primitive\StringType;
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
        $result = (new StringType())->validate($data);

        if (!$result->isValid())
            return new $result;

        if (mb_strlen($data, 'UTF-8') <= $this->maxLength) {
            return new Success();
        }
        else return new Failure(
            new RuleError(RuleErrorCode::LENGTH_ERROR,
                'The supplied string is too long'));
    }
}