<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/23/19
 * Time: 1:53 AM
 */

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

    public function validate($data) : Result
    {
        if (mb_strlen($data, 'UTF-8') >= $this->minLength) {
            return new Result(true);
        }
        else return new Result(false,
            new RuleError(RuleErrorCode::TOO_SHORT,
            'The supplied string is too short'));
    }
}