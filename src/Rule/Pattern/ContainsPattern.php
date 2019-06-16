<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Pattern;


use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Exception\InvalidRuleOption;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

class ContainsPattern implements Rule
{
    const NUMBER = 0;
    const UPPERCASE = 1;
    const LOWERCASE = 2;
    const SPECIAL_CHARS = 3;

    /**
     * @var int $pattern
     */
    private $pattern;
    /**
     * ContainsPattern constructor.
     * @param int $patternType
     * @throws InvalidRuleOption
     */
    public function __construct(int $patternType)
    {
        if ($patternType < 0 || $patternType > 3)
            throw new InvalidRuleOption($patternType);

        $this->pattern = $patternType;
    }

    public function validate($data): Result
    {
        $isValid = true;
        switch ($this->pattern)
        {
            case self::NUMBER:
                $isValid = preg_match('/[\d]/', $data);
                break;
            case self::SPECIAL_CHARS:
                $isValid = preg_match('/[\W]/', $data);
                break;
            case self::LOWERCASE:
                $isValid = preg_match('/[a-z]/', $data);
                break;
            case self::UPPERCASE:
                $isValid = preg_match('/[A-Z]/', $data);
                break;
        }

        if ($isValid)
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::PATTERN_MISMATCH,
                "The string doesn't contain the required pattern"));
    }
}