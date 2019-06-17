<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Validator;


use Phypes\Error\TypeError;
use Phypes\Error\TypeErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Aggregate\ForAll;
use Phypes\Rule\CharType\Alpha;
use Phypes\Rule\String\MaximumLength;
use Phypes\Rule\String\MinimumLength;

class NameValidator implements Validator
{
    /**
     * @var int $minLength
     */
    private $minLength;
    /**
     * @var int $maxLength
     */
    private $maxLength;
    /**
     * @var array $allowedChars
     */
    private $allowedChars = [];

    /**
     * NameValidator constructor.
     * Supply parameters depending on domain specific name requirements
     * @param int $minLength
     * @param int $maxLength
     * @param array $allowedChars
     */
    public function __construct(int $minLength = 1, int $maxLength = 255, $allowedChars = ["\'", "-", ".", " "])
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->allowedChars = $allowedChars;
    }

    /**
     * @param $name
     * @return Result
     * @throws \Phypes\Exception\InvalidAggregateRule
     */
    public function validate($name): Result
    {
        $rule = new ForAll(
            new MinimumLength($this->minLength),
            new MaximumLength($this->maxLength),
            new Alpha($this->allowedChars)
        );

        $result = $rule->validate($name);

        if ($result->isValid())
            return new Success();
        /**
         * @var Failure $result
         */
        return new Failure(new TypeError(TypeErrorCode::NAME_INVALID, 'Invalid name format'),
            $result->getErrors());
    }
}