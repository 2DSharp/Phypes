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

use Phypes\Result\Result;
use Phypes\Rule\Aggregate\ForAll;
use Phypes\Rule\Chartype\AlphaNumeric;
use Phypes\Rule\String\MaximumLength;
use Phypes\Rule\String\MinimumLength;

class UsernameValidator implements Validator
{
    /**
     * @var integer $minLength
     */
    private $minLength;
    /**
     * @var integer $maxLength
     */
    private $maxLength;
    /**
     * @var array $allowedChars
     */
    private $allowedSpecialChars = [];

    public function __construct(int $minLength = 4, int $maxLength = 12, $allowedSpecialChars = [])
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->allowedSpecialChars = $allowedSpecialChars;
    }

    /**
     * @param $username
     * @return Result
     * @throws \Phypes\Exception\InvalidAggregateRule
     */
    public function validate($username): Result
    {
        $rule = new ForAll(
            new AlphaNumeric($this->allowedSpecialChars),
            new MinimumLength($this->minLength),
            new MaximumLength($this->maxLength));

        return $rule->validate($username);

    }
}