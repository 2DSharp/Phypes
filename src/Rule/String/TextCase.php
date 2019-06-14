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
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

class TextCase implements Rule
{
    const NONE_CAPS = 0;
    const ALL_CAPS = 1;
    const MIXED = 2;

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
     * @throws \InvalidArgumentException
     * @param int $caseType
     * @param bool $strictCheck
     */
    public function __construct(int $caseType, bool $strictCheck = false)
    {
        if ($caseType > 2 || $caseType < 0)
            throw new \InvalidArgumentException('Case Type ' . $caseType . ' is invalid. 
            Check the class constants available to be used as caseTypes');

        $this->caseType = $caseType;
        $this->strictCheck = $strictCheck;
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

    private function isAllCaps(string $text) : bool
    {
        if ($this->strictCheck)
            return ctype_upper($text);
        else
            return !preg_match('/[a-z]/', $text) && preg_match('/[A-Z]/', $text);
            
    }

    private function isNoneCaps(string $text) : bool
    {
        if ($this->strictCheck)
            return ctype_lower($text);
        else
            return preg_match('/[a-z]/', $text) && !preg_match('/[A-Z]/', $text);
    }

    public function validate($data): Result
    {
        $isValid = false;

        switch ($this->caseType) {
            case self::MIXED:
                $isValid = $this->isMixed($data);
                break;
            case self::ALL_CAPS:
                $isValid = $this->isAllCaps($data);
                break;

            case self::NONE_CAPS:
                $isValid = $this->isNoneCaps($data);
                break;
        }

        if ($isValid)
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::CASING_MISMATCH,
                "The given string doesn't match the required case"));
    }
}