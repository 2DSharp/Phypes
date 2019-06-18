<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Primitive;

use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

class StringType implements Rule
{
    public function validate($data): Result
    {
        if (is_string($data))
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::NOT_STRING, 'Input value is not a string'));
    }
}