<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/23/19
 * Time: 1:53 AM
 */

namespace Phypes\Rule;


use Phypes\Error\RuleError\RuleError;
use Phypes\Error\RuleError\RuleErrorCode;
use Phypes\Result;

class MinimumLength implements Rule
{
    private $minLength;

    public function __construct(int $minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate($data) : Result
    {
        if (mb_strlen($data, 'UTF-8') < $this->minLength) {
            return new Result(true);
        }
        else return new Result(false,
            new RuleError(RuleErrorCode::TOO_SHORT,
            'The supplied string is too short'));
    }
}