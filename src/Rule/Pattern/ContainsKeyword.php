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
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

class ContainsKeyword implements Rule
{
    /**
     * @var string $keyword
     */
    private $keyword;

    public function __construct(string $keyword)
    {
        $this->keyword = $keyword;
    }

    public function validate($data): Result
    {
        if (strpos($data, $this->keyword) !== false)
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::PATTERN_MISMATCH, "String does not contain keyword"));
    }
}