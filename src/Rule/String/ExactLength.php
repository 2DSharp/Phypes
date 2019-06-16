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

class ExactLength implements Rule
{
    /**
     * @var int $length
     */
    private $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }
    public function validate($data) : Result
    {
        if (mb_strlen($data, 'UTF-8') >= $this->length) {
            return new Success();
        }
        else return new Failure(
            new RuleError(RuleErrorCode::LENGTH_ERROR,
                'The supplied string is not of correct length'));
    }
}