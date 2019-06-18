<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phypes\Rule\String;

use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Exception\InvalidRuleOption;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Primitive\StringType;
use Phypes\Rule\Rule;

class TextCase implements Rule
{
    const ALL_LOWER = 0;
    const ALL_UPPER = 1;
    const MIXED = 2;
    const SOME_UPPER = 3;
    const SOME_LOWER = 4;
    
    const LEVEL_STRICT = 0;
    const LEVEL_TOLERANT = 1;
    /**
     * @var integer $caseType
     */
    private $caseType;

    /**
     * @var bool $strictCheck
     */
    private $strictCheck;

    /**
     * TextCase constructor.
     * @throws InvalidRuleOption
     * @param int $caseType
     * @param bool $allowSpecialChars
     */
    public function __construct(int $caseType, bool $allowSpecialChars = true)
    {
        if ($caseType > 4 || $caseType < 0)
            throw new InvalidRuleOption($caseType, TextCase::class);

        $this->caseType = $caseType;
        $this->strictCheck = !$allowSpecialChars;
    }

    /**
     * @param string $text
     * @return bool
     */
    private function isMixed(string $text) : bool
    {
        if ($this->strictCheck) {
            if (preg_match("/^[a-zA-Z]+$/", $text))
                return preg_match('/[a-z]/', $text) && preg_match('/[A-Z]/', $text);
            else
                return false;
        }

        return preg_match('/[a-z]/', $text) && preg_match('/[A-Z]/', $text);
    }

    private function isAllUpper(string $text) : bool
    {
        if ($this->strictCheck)
            return ctype_upper($text);
        else
            return !preg_match('/[a-z]/', $text) && preg_match('/[A-Z]/', $text);
            
    }

    private function isAllLower(string $text) : bool
    {
        if ($this->strictCheck)
            return ctype_lower($text);
        else
            return preg_match('/[a-z]/', $text) && !preg_match('/[A-Z]/', $text);
    }

    private function isSomeLower(string $text) : bool
    {
        $containsLower = (bool) preg_match('/[a-z]/', $text);

        if ($this->strictCheck)
           return !preg_match('/[\W]/', $text) && $containsLower;
        else
            return $containsLower;
    }

    private function isSomeUpper(string $text) : bool
    {
        $containsUpper = (bool) preg_match('/[A-Z]/', $text);

        if ($this->strictCheck)
            return !preg_match('/[\W]/', $text) && $containsUpper;
        else
            return $containsUpper;
    }

    public function validate($data): Result
    {
        $result = (new StringType())->validate($data);

        if (!$result->isValid())
            return new $result;

        $isValid = false;

        switch ($this->caseType) {
            case self::MIXED:
                $isValid = $this->isMixed($data);
                break;
            case self::ALL_UPPER:
                $isValid = $this->isAllUpper($data);
                break;
            case self::ALL_LOWER:
                $isValid = $this->isAllLower($data);
                break;
            case self::SOME_LOWER:
                $isValid = $this->isSomeLower($data);
                break;
            case self::SOME_UPPER:
                $isValid = $this->isSomeUpper($data);
                break;
        }

        if ($isValid)
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::CASING_MISMATCH,
                "The given string doesn't match the required case"));
    }
}