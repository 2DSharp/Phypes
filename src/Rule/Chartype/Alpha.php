<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Chartype;


use Phypes\Error\RuleError;
use Phypes\Error\RuleErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

class Alpha extends Chartype implements Rule
{
    public function validate($data): Result
    {
        if (ctype_alpha(str_replace($this->allowedSpecialChars, '', $data)))
            return new Success();
        else
            return new Failure(new RuleError(RuleErrorCode::NOT_ALPHA, 'String is not Alphabetic.'));
    }
}