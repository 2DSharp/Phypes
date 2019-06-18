<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Number;


use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Primitive\NumericType;
use Phypes\Rule\Rule;

class Equals implements Rule
{
    /**
     * @var float $expected
     */
    private $expected;

    public function __construct(float $expected)
    {
        $this->expected = $expected;
    }

    public function validate($value): Result
    {
        $numericResult = (new NumericType())->validate($value);

        if (!$numericResult->isValid())
            return new $numericResult;

        if ($value == $this->expected)
            return new Success();

        return new Failure(new RuleError(RuleErrorCode::LESS_THAN_MINIMUM,
            'The supplied number is less than the expectedimum value'));
    }
}